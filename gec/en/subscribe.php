<?php
ob_start();
require_once(dirname(__FILE__) . '/../model/Dbconnection.php');
require_once(dirname(__FILE__) . '/../util/MailSender.php');
session_start();

// Check for valid email address.
if (isset($_POST['email']))
{
	//$email = mysql_real_escape_string($_POST['email']);
	$email = $_POST['email'];
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
}
else
	$email = '';

// If no email has been provided, back to index.php
if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($email))
{
	$message = array(
		'content' => 'Please provide your email address!',
		'type' => 'error'
	);
	// Add new message to messages pool.
	if (!isset($_SESSION['messages']))
		$_SESSION['messages'] = array();
	array_push($_SESSION['messages'], $message);
	
	// Redirect user to home page
	header("Location: index.php");
	ob_end_flush();
	die;
}

// Check whether a connection is established or not.
if (!isset($_SESSION['dbconn']))
	$_SESSION['dbconn'] = new Dbconnection(); // If not, establish one.
$dbconn = $_SESSION['dbconn'];
$dbconn->connect(); // Connect to database.

// Prepare data to insert
if (!empty($_POST['contactName']))
	$name = $_POST['contactName'];
else
	$name = 'my friend';
$result = $dbconn->insertSubscriber($email, $name);

// If cannot insert new email
if ($result === false)
{
	$dbconn->rollback();
	$dbconn->disconnect();
	$message = array(
		'content' => 'Oops, an error has occurred! Please try again.',
		'type' => 'error'
	);
	if (!isset($_SESSION['messages']))
		$_SESSION['messages'] = array();
	array_push($_SESSION['messages'], $message);
	
	// Redirect user to home page
	header("Location: index.php");
	ob_end_flush();
}
elseif ($result === 0)
{
	$dbconn->disconnect();
	$message = array(
		'content' => 'This email address has subscribed.',
		'type' => 'warning'
	);
	if (!isset($_SESSION['messages']))
		$_SESSION['messages'] = array();
	array_push($_SESSION['messages'], $message);
	
	// Redirect user to home page
	header("Location: index.php");
	ob_end_flush();
}

// Generate an unique key for email confirmation.
$key = sha1(uniqid(rand())); // 40 characters
$result = $dbconn->sendVerification($email, $key);
// Send mail
$mailParams = array(
	'to' => $email,
	'subject' => 'LintinZone: Comfirm email subscription',
	'message' => array(
		'{receiver}' => (!empty($name)) ? $name : 'my friend',
		'{confirm_link}' => 'http://' . $_SERVER['SERVER_NAME'] . '/en/confirm.php?key=' . $key . '&email=' . $email . '&lang=en',
		'{support_link}' => 'http://' . $_SERVER['SERVER_NAME'] . '/en/contact.php',
		'{home_link}' => 'http://' . $_SERVER['SERVER_NAME'] . '/en/index.php'
	)/*,
	'header' => array(
		'from' => 'lintinzone@lintinzone.com',
		'replyto' => 'lintinzone@lintinzone.com'
	)*/
);
$sender = new MailSender($dbconn);
$sender->send($mailParams, 'confirm-en', 'html');

// If verification key is stored...
if ($result)
{
	$_SESSION['email'] = $email;
	$message = array(
		'content' => 'An email confirmation has been sent to your email address.',
		'type' => 'success'
	);
}
else // If it's not, rollback...
{
	$dbconn->rollback();
	$message = array(
		'content' => 'Oops, an error has occurred! Please try again.',
		'type' => 'error'
	);
}

// Disconnect after executing query.
$dbconn->disconnect();
// Push message to message holder.
if (!isset($_SESSION['messages']))
	$_SESSION['messages'] = array();
array_push($_SESSION['messages'], $message);

header("Location: index.php");
ob_end_flush();
