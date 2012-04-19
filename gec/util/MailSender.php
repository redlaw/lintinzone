<?php
require_once(dirname(__FILE__) . '/../model/Dbconnection.php');
require_once 'LogWriter.php';
require 'class.phpmailer.php';

/**
 * Provides a wrapper to handle mail operations.
 * @author tungtt
 *
 */
class MailSender
{
	/**
	 * Connection to database
	 * @var Dbconnection
	 */
	private $_dbconn;
	
	/**
	 * Handles logging operations.
	 * @var LogWriter
	 */
	private $_log;
	
	/**
	 * Handles mailing job.
	 * @var PHPMailer
	 */
	private $_mailer;
	
	/**
	 * Defines a connection to database to store mail info.
	 * @param Dbconnection $dbconn Connection to target database
	 */
	function __construct($dbconn)
	{
		if (!$dbconn instanceof Dbconnection)
			die('Invalid parameter');
		$this->_dbconn = $dbconn;
		$this->_mailer = null;
	}
	
	/**
	 * Initializes the PHPMailer.
	 * @return true|false
	 */
	private function initPHPMailer()
	{
		$this->_mailer = new PHPMailer();
		$this->_mailer->IsSMTP();
		$this->_mailer->Host     = 'mail.lintinzone.com';
		$this->_mailer->SMTPAuth = true;
		$this->_mailer->Username = 'info@lintinzone.com';
		$this->_mailer->Password = 'l1nTInte@m';
		
		$this->_mailer->From     = 'info@lintinzone.com';
		$this->_mailer->FromName = 'LintinZone';
		$this->_mailer->WordWrap = 70;
		return false;
	}
	
	/**
	 * Replaces reserved tokens in mail template with given data.
	 * @param array $data Data to replace tokens
	 * @param string $template Template name
	 * @param string $format The format of the mail template
	 * @return string|false
	 */
	protected function formatEmail($data = array(), $template, $format)
	{
		$template = realpath(dirname(__FILE__) . '/templates/' . $template . '.' . $format);
		if (empty($template)) // The template doesn't exist.
			return false;
		
		$message = file_get_contents($template);
		foreach ($data as $token => $value)
			$message = str_replace($token, $value, $message);
		// Ensure that each line has at max 70 characters.
		return wordwrap($message, 70);
	}
	
	/**
	 * Sends an email.
	 * @param array $mailParams Parameters of the email
	 * @param string $template The template to use
	 * @param string $format The format of the mail template to use.
	 * @return true|false
	 */
	public function send($mailParams, $template, $format)
	{
		if (empty($mailParams['to'])
			|| empty($mailParams['subject']))
			return false;
			
		//$to = mysql_real_escape_string($mailParams['to']); // List of receivers
		$to = $mailParams['to'];
		//$subject = mysql_real_escape_string($mailParams['subject']); // Subject of the mail
		$subject = $mailParams['subject'];
		
		// Mail header.
		/*$header = '';
		if (isset($mailParams['header']))
		{
			if (is_string($mailParams['header']))
				//$header = mysql_real_escape_string($mailParams['header']);
				$header = $mailParams['header'];
			elseif (is_array($mailParams['header']))
			{
				$headers = $mailParams['header'];
				if (!empty($headers['from']))
					//$header = 'From: ' . mysql_real_escape_string($headers['from']) . "\r\n";
					$header = 'From: ' . $headers['from'] . "\r\n";
				if (!empty($headers['replyto']))
					$header .= 'Reply-To: ' . $headers['replyto'] . "\r\n";
				$header .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
				$header .= 'MIME-Version: 1.0' . "\r\n";
		 		if ($format === 'html' || $format === 'htm')
					$header .= 'Content-type: text/html; charset=utf-8';
		 		else
		 			$header .= 'Content-type: text/plain; charset=utf-8';
			}
		}*/
		
		// Mail content.
		if (!empty($mailParams['message']))
		{
			$message = $mailParams['message'];
			if (is_array($message))
			{
				$message = $this->formatEmail($message, $template, $format);
				if (!$message)
				{
					$params = array(
						'message' => $message,
						'template' => $template,
						'format' => $format
					);
					return $this->throwException('Unable to format message', null, $params);
				}
			}
		}
		else
			return false;
			
		try
		{
			//@todo mail queue
			/*if (!empty($header))
				$sent = mail($to, $subject, $message, $header);
			else
				$sent = mail($to, $subject, $message);*/
			if ($this->_mailer === NULL)
				$this->initPHPMailer();
			$this->_mailer->AddAddress($to);
			$this->_mailer->AddBCC('info@lintinzone.com', 'LintinZone Info');
			//$this->_mailer->AddReplyTo("info@site.com","Information");
			//$this->_mailer->AddAttachment("/var/tmp/file.tar.gz");
			//$this->_mailer->AddAttachment("/tmp/image.jpg", "new.jpg");
			if ($format === 'html' || $format === 'htm')
				$this->_mailer->IsHTML(true);
			else
				$this->_mailer->IsHTML(false);
			
			$this->_mailer->Subject  =  $subject;
			$this->_mailer->Body     =  $message;
			$this->_mailer->AltBody  =  'LintinZone - Best shipping solution';
			$sent = $this->_mailer->Send();
			
			// If mail cannot be sent...
			if (!$sent)
			{
				$this->_mailer = null;
				// Log this into database.
				if (!$this->_dbconn->isConnected())
				{
					$this->_dbconn->connect(); // Connect to database.
					$closeConn = true; // Mark that this connection should be closed after executing query.
				}
				else
					$closeConn = false; // Mark that this connection would be closed by another function.

				// Prepare data to insert
				$result = $this->_dbconn->failedToSendMail($to, $subject, $header, $message);
				
				if ($closeConn)
					$this->_dbconn->disconnect(); // Disconnect after executing query.
				
				// Log this attempt.
				$params = array(
					'to' => $to,
					'subject' => $subject,
					//'header' => $header,
					'message' => $message
				);
				return $this->throwException($this->_mailer->ErrorInfo, null, $params);
			}
		}
		catch (Exception $exc)
		{
			$params = array(
				'to' => $to,
				'subject' => $subject,
				//'header' => $header,
				'message' => $message
			);
			return $this->throwException($this->_mailer->ErrorInfo, $exc, $params);
		}
		return true;
	}
	
	/**
	 * Logs exception and return false to mark operation has failed.
	 * @param string $message A message to write into log
	 * @param Exception $exc The exception occurs while executing the function
	 * @param array $params An array of parameters passed to the 'mail' function (to, subject, message, header)
	 * @return false
	 */
	protected function throwException($message = '', $exc = null, $params = array())
	{
		if ($this->_log === null)
			$this->_log = new LogWriter(realpath(dirname(__FILE__) . '/../logs') . DIRECTORY_SEPARATOR . 'mail.log');
			
		if ($exc)
			$message = '(' .$exc->getCode() . ') ' . $exc->getMessage() . ': ' . $message;
		foreach ($params as $pName => $pValue)
			$message .= PHP_EOL . $pName . ': ' . $pValue;
			
		if ($message)
			$this->_log->log($message);
		return false;
	}
	
	/**
	 * Sends mail parameters to database.
	 * Mails are not sent immediately after users invoke send mail function.
	 * @param array $mail_params Parameters of an email
	 * @return true|false
	 * @see mail
	 */
	protected function queue($mail_params = array())
	{
		
	}
	
	/**
	 * Gets a number of emails form queue in database.
	 * @param int $count The number of mails to get.
	 * @return array
	 */
	public function getQueue($count)
	{
		
	}
}
