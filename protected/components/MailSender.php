<?php

require_once(dirname(__FILE__) . '/../extensions/phpmailer/class.phpmailer.php');

class MailSender
{
	/**
	 * Handles mailing job.
	 * @var PHPMailer
	 */
	private static $_mailer = null;
	
	/**
	 * Initializes the PHPMailer.
	 * @return true
	 */
	private static function initPHPMailer()
	{
		self::$_mailer = new PHPMailer();
		self::$_mailer->IsSMTP();
		self::$_mailer->Host     = Yii::app()->params['mailHost'];
		self::$_mailer->SMTPAuth = true;
		self::$_mailer->Username = Yii::app()->params['adminEmail'];
		self::$_mailer->Password = Yii::app()->params['mailPassword'];
		self::$_mailer->WordWrap = 70;
		return true;
	}
	
	/**
	 * Replaces reserved tokens in mail template with given data.
	 * @param array $data Data to replace tokens
	 * @param string $template Template name
	 * @param string $format The format of the mail template (text/plain or text/html)
	 * @return string|false 
	 */
	private static function formatEmail(array $data, $template, $format)
	{
		// Choose file format corresponding to the format.
		if ($format === 'text/plain')
			$format = 'txt';
		elseif ($format === 'text/html')
			$format = 'html';
		else
			return false;
		
		//TODO: dynamically change template path according to current theme and current language.
		if ($format === 'html')
			$template = realpath(dirname(__FILE__) . '/../../themes/classic/mail-templates/vi/classic-' . $template . '-vi.html');
		else
			$template = realpath(dirname(__FILE__) . '/../mail-templates/vi/' . $template . '-vi.txt');
		if (empty($template)) // The template doesn't exist.
			return false;
		
		// Get the template content.
		$body = file_get_contents($template);
		// Replace holder token with user's data.
		foreach ($data as $token => $value)
			$body = str_replace($token, $value, $body);
		// Ensure that each line has at max 70 characters.
		Yii::log($body, 'warning', 'system.web.CController');
		Yii::log(wordwrap($body, 70), 'warning', 'system.web.CController');
		return wordwrap($body, 70);
	}
	
	/**
	 * Sends an email using SMTP.
	 * @param array $mailParams Parameters of the email (from, fromName, to, cc, bcc, subject, body, attachment)
	 * @param string $template The template to use (name only, NO file extension)
	 * @param string $format The format of the mail template to use (The default value is "text/plain")
	 * @return true|false
	 */
	public static function sendSMTP(array $mailParams, $template, $format = 'text/plain')
	{
		// Check for required parameters
		if (empty($mailParams['to'])
			|| empty($mailParams['subject'])
			|| empty($mailParams['body']))
			return false;
			
		// To whom
		$to = $mailParams['to'];
		/*if (!empty($mailParams['toName']))
			$toName = $mailParams['toName'];
		else
			$toName = '';*/
		// From who
		if (empty($mailParams['from']))
		{
			$from = Yii::app()->params['adminEmail'];
			$from = 'LintinZone';
		}
		else
			$from = $mailParams['from'];
		if (!empty($mailParams['fromName']))
			$fromName = $mailParams['fromName'];
		else
			$fromName = '';
		// Subject
		$subject = $mailParams['subject'];
		// CC
		if (!empty($mailParams['cc']))
			$cc = $mailParams['cc'];
		else
			$cc = '';
		// BCC
		if (!empty($mailParams['bcc']))
			$bcc = $mailParams['bcc'];
		else
			$bcc = '';
		
		// Mail format (text/plain or text/html)
		if ($format !== 'text/plain' && $format !== 'text/html')
			return false;
			
		// Mail body
		$body = $mailParams['body'];
		$alt = '';
		if (is_array($body)) // an array
		{
			// Check the template
			if (empty($template))
				return false;
			// Format the body
			if ($format === 'text/plain')
			{
				$body = self::formatEmail($body, $template, $format);
				$alt = $body;
			}
			else
			{
				$alt = self::formatEmail($body, $template, 'text/plain');
				if (!$alt)
				{
					Yii::log('Unable to format message using template ' . $template . ' in format text/plain', 'error', 'system.web.CController');
					return false;
				}
				$body = self::formatEmail($body, $template, 'text/html');
			}
			if (!$body)
			{
				Yii::log('Unable to format message using template ' . $template . ' in format ' . $format, 'error', 'system.web.CController');
				return false;
			}
		}
		else // string
		{
			$format = 'text/plain';
			$body = strip_tags($body);
			Yii::log('strip_tags body ' . $body, 'warning', 'system.web.CController');
			$alt = $body;
		}

		// Check mailer
		if (self::$_mailer === null)
			self::initPHPMailer();
		// To
		self::$_mailer->AddAddress($to);
		// From
		self::$_mailer->From = $from;
		self::$_mailer->FromName = $fromName;
		// Subject
		self::$_mailer->Subject = $subject;
		// CC
		if (!empty($cc))
			self::$_mailer->AddCC($cc);
		// BCC
		if (!empty($bcc))
			self::$_mailer->AddBCC($bcc);
		// Body
		self::$_mailer->Body = $body;
		// Alt body (text/plain)
		self::$_mailer->AltBody = $alt;
		// Format
		if ($format === 'text/html')
			self::$_mailer->IsHTML(true);
		else
			self::$_mailer->IsHTML(false);
		
		// Send mail
		try
		{
			if (!self::$_mailer->Send()) // Mail failed to be sent
			{
				Yii::log('Failed to send mail to ' . $to . ' (from ' . $from . ') with the body:' . PHP_EOL . $alt . PHP_EOL . self::$_mailer->ErrorInfo, 'error', 'system.web.CController');
				return false;
			}
			else
			{
				Yii::log('Sent successfully', 'warning', 'system.web.CController');
			}
		}
		catch (Exception $exc)
		{
			Yii::log('Failed to send mail to ' . $to . ' (from ' . $from . ')' . PHP_EOL . $exc->getMessage() . ' (' . $exc->getCode() . '):' . PHP_EOL . $exc->getTrace(), 'error', 'system.web.CController');
			return false;
		}
		return true;
	}
}
