<?php
require_once(dirname(__FILE__) . '/../util/LogWriter.php');

/**
 * Creates a wrapper class to handle database operations.
 * Warning: this is an unsecure implementation. Later implementation would fix the secure holes. For now, use it carefully.
 * @author tungtt
 */
class Dbconnection
{
	/**
	 * Define host name.
	 * @var string
	 */
	private $_host;
	
	/**
	 * Defines username used to connect to database.
	 * @var string
	 */
	private $_username;
	
	/**
	 * Defines password used to connect to database.
	 * @var string
	 */
	private $_password;
	
	/**
	 * Defines database name to connect to.
	 * @var string
	 */
	private $_dbname;
	
	/**
	 * The connection to database.
	 */
	private $_conn;
	
	/**
	 * Defines path to log file.
	 * @var string
	 */
	private $_logPath;
	
	/**
	 * Handles logging operations.
	 * @var LogWriter
	 */
	private $_log;
	
	/**
	 * Creates a connection to database.
	 */
	function __construct()
	{
		// Initialize variables to connect to database.
		require_once 'config.php';
		$this->_host = $db_config['host'];
		$this->_username = $db_config['username'];
		$this->_password = $db_config['password'];
		$this->_dbname = $db_config['dbname'];
		$this->_logPath = $log_config['filepath'];
		$this->_log = null;
		
		// Create a connection to test.
		$this->connect();
		// Close connection.
		$this->disconnect();
	}
	
	/**
	 * Frees resource.
	 */
	function __destruct()
	{
		$this->disconnect();
	}
	
	/**
	 * Connects to database.
	 * @return true|false
	 */
	public function connect()
	{
		// If there is an active connection, return.
		if (is_resource($this->_conn))
			return true;
		
		$this->_conn = mysqli_connect($this->_host, $this->_username, $this->_password);
		if (!$this->_conn)
			return $this->throwException('Cannot connect to database.');
			
		if (mysqli_select_db($this->_conn, $this->_dbname) == false)
			return $this->throwException();
		//mysqli_query("set names utf8", $this->_conn);
		mysqli_set_charset($this->_conn, 'utf8');
		return true;
	}
	
	/**
	 * Forces the connection to close.
	 * @return true
	 */
	public function disconnect()
	{
		if ($this->_conn)
		{
			mysqli_commit($this->_conn);
			mysqli_close($this->_conn);
		}
		$this->_conn = null;
		$this->_log = null;
		return true;
	}
	
	/**
	 * Checks whether the database is connected or not.
	 * @return true|false
	 */
	public function isConnected()
	{
		return is_resource($this->_conn);
	}
	
	/**
	 * Logs exception and return false to mark operation has failed.
	 * @param string $message A message to write into log
	 * @return false
	 */
	protected function throwException($message = '')
	{
		if ($this->_log === null)
			$this->_log = new LogWriter($this->_logPath);
			
		if (mysqli_connect_errno())
			$message = '(' . mysqli_connect_errno() . ') ' . mysqli_connect_error() . ': ' . $message;
		elseif (mysqli_errno($this->_conn))
			$message = '(' . mysqli_errno($this->_conn) . ') ' . mysqli_error($this->_conn) . ': ' . $message;
			
		if ($message)
			$this->_log->log($message);
		return false;
	}
	
	/**
	 * Executes a query (except delete statement).
	 * @param string $sqlStatement A sql statement to execute
	 * @return array|false
	 * @see mysqli_query
	 */
	protected function query($sqlStatement)
	{
		// Open the connection if it is currently closed.
		if (!is_resource($this->_conn))
			$this->connect();
		// Check the connection.
		if (mysqli_connect_errno())
			return $this->throwException('Connect failed');
			
		// General check the sql query.
		$sqlStatement = trim($sqlStatement);
		
		if (empty($sqlStatement))
			return false;
		// 'Delete' queries are disabled in this implementation.
		if (strpos($sqlStatement, 'delete') === 0
			|| strpos($sqlStatement, 'drop') === 0)
			return false;
		
		// Query.
		$result = mysqli_query($this->_conn, $sqlStatement);
		if (!$result)
			return $this->throwException('Execute the statement: ' . $sqlStatement);
		return $result;
	}
	
	/**
	 * Fetches all rows into an array and return it.
	 * @param array $result An object returned by the 'query' function
	 * @return array
	 * @see mysqli_fetch_all
	 */
	public function fetchAll($result)
	{
		return mysqli_fetch_all($result);
	}
	
	/**
	 * Fetches one row of the result set of data and return it as an enumerated array. Each subsequent call will return the next row within the result set, or NULL if there are no more rows.
	 * @param array $result An object returned by the 'query' function
	 * @return array|null
	 * @see mysqli_fetch_row
	 */
	public function fetchRow($result)
	{
		return mysqli_fetch_row($result);
	}
	
	/**
	 * Fetches one row of the result set of data and return it as an associative array. Each subsequent call will return the next row within the result set, or NULL if there are no more rows.
	 * @param array $result An object returned by the 'query' function
	 * @return array|null
	 * @see mysqli_fetch_assoc
	 */
	public function fetchAssoc($result)
	{
		return mysqli_fetch_assoc($result);
	}
	
	/**
	 * Fetches the first column of the first row of the result set.
	 * @param array $result An object returned by the 'query' function
	 * @return array|null
	 */
	public function fetchOne($result)
	{
		$firstRow = mysqli_fetch_row($result);
		if (null === $firstRow)
			return null;
		return $firstRow[0];
	}
	
	/**
	 * Gets the number of affected rows by an insert, update or delete query.
	 * @param array $result An object returned by the 'query' function
	 * @return int
	 */
	public function getAffectedRow($result)
	{
		return mysqli_affected_rows($result);
	}
	
	/**
	 * Gets the number of rows will be returned by a select query.
	 * @param array $result An object returned by the query function
	 * @return int
	 */
	public function getNumRows($result)
	{
		return mysqli_num_rows($result);
	}
	
	/**
	 * Frees the result set data.
	 * @param array $result An object returned by the 'query' function
	 */
	public function freeResult($result)
	{
		mysqli_free_result($result);
	}
	
	public function rollback()
	{
		mysqli_rollback($this->_conn);
	}
	
	/**
	 * Adds new subscriber.
	 * @param string $email Email of the subscriber
	 * @param string $name Name of the subscriber
	 * @return false Error|0 Email subscribed and confirmed|1 New email added
	 */
	public function insertSubscriber($email, $name = '')
	{
		if (empty($email))
			return false;
		$email = mysqli_real_escape_string($this->_conn, $email);
		if (!empty($name))
			$name = mysqli_real_escape_string($this->_conn, $name);
		else
			$name = '';
		$subscribedStatus = $this->checkSubscriber($email);
		
		if ($subscribedStatus === false)
			return false;
		
		if ($subscribedStatus === 0)
		{
			$sqlStatement = "insert into `subscribers`(`subscriber_email`, `subscriber_name`, `created_date`, `modified_date`) values ('";
			$sqlStatement .= $email . "', '";
			$sqlStatement .= $name . "', '";
			$sqlStatement .= date('c') . "', '" . date('c') . "')";
			return ($this->query($sqlStatement) === false) ? false : 1;
		}
		
		if ($subscribedStatus === 1)
			return 0;
		
		if ($subscribedStatus === -1)
			return ($this->updateSubscriber($email) === false) ? false : 1;
		
		return false;
	}
	
	/**
	 * Resends the subscription email.
	 * @param string $email
	 * @return true|false
	 */
	protected function updateSubscriber($email)
	{
		if (empty($email))
			return false;
		$email = mysqli_real_escape_string($this->_conn, $email);
		$sqlStatement = "update `subscribers` set `subscribed` = 1, `confirmed` = 0, `deleted` = 0, `modified_date` = '" . date('c') . "' where `subscriber_email` = '" . $email . "'";
		return $this->query($sqlStatement);
	}
	
	/**
	 * Adds a verification key for each subscriber.
	 * @param string $email Email of the subscriber
	 * @param string $key The key to add
	 * @return true|false
	 */
	public function sendVerification($email, $key)
	{
		if (empty($email) || empty($key))
			return false;
		$email = mysqli_real_escape_string($this->_conn, $email);
		$key = mysqli_real_escape_string($this->_conn, $key);
		
		$sqlStatement = "insert into `email_verification`(`email_verify`, `verification_key`, `sent_date`) values (";
		$sqlStatement .= "'" . $email . "', '" . $key . "', '" . date('c') . "')";
		return $this->query($sqlStatement);
	}
	
	/**
	 * Marks an email failed to be sent.
	 * @param string $email
	 * @param string $subject
	 * @param string $header
	 * @param string $message
	 * @return true|false
	 */
	public function failedToSendMail($email, $subject, $header, $message, $key)
	{
		if (empty($email))
			return false;
		
		$email = mysqli_real_escape_string($this->_conn, $email);
		$subject = mysqli_real_escape_string($this->_conn, $subject);
		$header = mysqli_real_escape_string($this->_conn, $header);
		$message = mysqli_real_escape_string($this->_conn, $message);
		$key = mysqli_real_escape_string($this->_conn, $key);
		
		// Deactivate the failed verification key
		$sqlStatement = "update `email_verification` set `active` = 0 where `email_verify` = '" . $email . "' and `verification_key` = '" . $key . "'";
		if (!$this->query($sqlStatement))
			return false;
		
		// Log the failed mail
		$sqlStatement = "insert into `email_failure`(`email_to`, `email_subject`, `email_headers`, `email_message`, `created_date`, `modified_date`) values ('";
		$sqlStatement .= $email . "', '" . $subject . "', '" . $header . "', '" . $message . "', '";
		$sqlStatement .= date('c') . "', '" . date('c') . "')";
		return $this->query($sqlStatement);
	}
	
	/**
	 * Checks whether an email has been in subscribed list.
	 * @param string $email
	 * @return false Error|-1 Email existed but not confirmed or not subscribed or be deleted|0 New email|1 Email subscribed and confirmed
	 */
	public function checkSubscriber($email)
	{
		if (empty($email))
			return false;
		
		$email = mysqli_real_escape_string($this->_conn, $email);
		$sqlStatement = "select `subscriber_email`, `subscribed`, `confirmed`, `deleted` from `subscribers`";
		$sqlStatement .= " where `subscriber_email` = '" . $email . "'";
		$result = $this->query($sqlStatement);
		
		// Connection failed
		if ($result === false)
			return false;
		
		// No such email found in database
		if ($this->getNumRows($result) === 0)
			return 0;
		
		$subscriber = array();
		$subscriber = $this->fetchAssoc($result);
		if ($subscriber['subscribed'] == 0
			|| $subscriber['confirmed'] == 0
			|| $subscriber['deleted'] == 1)
			return -1;
		return 1;
	}
	
	/**
	 * Confirms an email address.
	 * @param string $email The email to confirm
	 * @param string $key The confirmation key
	 * @param string $unsubscribe A key used for user to unsubscribe
	 * @return false|true
	 */
	public function confirmEmail($email, $key, $unsubscribe)
	{
		if (empty($email) || empty($key) || empty($unsubscribe))
			return false;
		
		$email = mysqli_real_escape_string($this->_conn, $email);
		$key = mysqli_real_escape_string($this->_conn, $key);
		$unsubscribe = mysqli_real_escape_string($this->_conn, $unsubscribe);
		
		$sqlStatement = "update `email_verification` set `active` = 0, `verified_date` = '" . date('c') . "', `unsubscribe_key` = '" . $unsubscribe . "'";
		$sqlStatement .= " where `email_verify` = '" . $email . "' and `verification_key` = '" . $key . "' and `active` = 1";
		if ($this->query($sqlStatement) === false)
			return false;
		
		$sqlStatement = "update `subscribers` set `confirmed` = 1, `confirmed_date` = '" . date('c') . "', `modified_date` = '" . date('c') . "'";
		$sqlStatement .= " where `subscriber_email` = '" . $email . "'";
		if ($this->query($sqlStatement) === false)
		{
			$this->throwException('Error update subscriber');
			$this->rollback();
			return false;
		}
		return true;
	}
	
	/**
	 * Gets the contact name of an email
	 * @param string $email
	 * @return false|string
	 */
	public function getContactName($email)
	{
		if (empty($email))
			return false;
		
		$email = mysqli_real_escape_string($this->_conn, $email);
		$sqlStatement = "select `subscriber_name` from `subscribers` where `subscriber_email` = '" . $email . "'";
		$result = $this->query($sqlStatement);
		if ($result === false)
			return false;
		$subscriber = array();
		$subscriber = $this->fetchAssoc($result);
		return $subscriber['subscriber_name'];
	}
	
	/**
	 * Unsubsribes updates from LintinZone
	 * @param string $email The email to unsubscribe
	 * @param string $key The confirmation key
	 * @param string $unsubscribe The unsubscribe key
	 * @return false Error|0 Nothing to unsubscribe|1 Unsubscribed successfully|-1 Invalid key or unsubscribe key
	 */
	public function unsubscribe($email, $key, $unsubscribe)
	{
		if (empty($email) || empty($key) || empty($unsubscribe))
			return false;
		
		$email = mysqli_real_escape_string($this->_conn, $email);
		$key = mysqli_real_escape_string($this->_conn, $key);
		$unsubscribe = mysqli_real_escape_string($this->_conn, $unsubscribe);
		
		$sqlStatement = "select `subscriber_email` from `subscribers`";
		$sqlStatement .= " where `subscriber_email` = '" . $email . "' and `subscribed` = 1 and `confirmed` = 1 and `deleted` = 0";
		$result = $this->query($sqlStatement);
		if ($result === false)
			return false;
		if ($this->getNumRows($result) < 1)
			return 0;
		
		$sqlStatement = "select `email_verify` from `email_verification`";
		$sqlStatement .= " where `email_verify` = '" . $email . "' and `verification_key` = '" . $key . "' and `unsubscribe_key` = '" . $unsubscribe . "'";
		$result = $this->query($sqlStatement);
		if ($result === false)
			return false;
		if ($this->getNumRows($result) < 1)
			return -1;
		
		$sqlStatement = "update `subscribers` set `subscribed` = 0, `modified_date` = '" . date('c') . "'";
		$sqlStatement .= " where `subscriber_email` = '" . $email . "'";
		$result = $this->query($sqlStatement);
		if ($result === false)
			return false;
		/*if ($this->getAffectedRow($result) == 1)
			return 1;
		return false;*/
		return 1;
	}
}
