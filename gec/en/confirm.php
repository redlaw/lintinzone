<?php
ob_start();
require_once(dirname(__FILE__) . '/../model/Dbconnection.php');
require_once(dirname(__FILE__) . '/../util/MailSender.php');
session_start();

$email = !empty($_GET['email']) ? $email : '';
$key = !empty($_GET['key']) ? $key : '';

if (empty($email) || empty($key))
{
	$message = array(
		'content' => 'Yêu cầu không hợp lệ!',
		'type' => 'error'
	);
	// Add new message to messages pool.
	if (!isset($_SESSION['messages']))
		$_SESSION['messages'] = array();
	array_push($_SESSION['messages'], $message);
	
	// Redirect user to home page
	header("Location: index.php");
	ob_end_flush();
}

// Check whether a connection is established or not.
if (!isset($_SESSION['dbconn']))
	$_SESSION['dbconn'] = new Dbconnection(); // If not, establish one.
$dbconn = $_SESSION['dbconn'];
$dbconn->connect(); // Connect to database.

$subscribedStatus = $dbconn->checkSubscriber($email);
// Error
if ($subscribedStatus === false)
{
	$dbconn->disconnect();
	$message = array(
		'content' => 'Oops, an error has occurred! Please try again',
		'type' => 'error'
	);
	if (!isset($_SESSION['messages']))
		$_SESSION['messages'] = array();
	array_push($_SESSION['messages'], $message);
	
	// Redirect user to home page
	header("Location: index.php");
	ob_end_flush();
}

// No such email existed
if ($subscribedStatus === 0)
{
	$dbconn->disconnect();
	$message = array(
		'content' => 'The address ' . $email . ' has not been subscribed.',
		'type' => 'error'
	);
	if (!isset($_SESSION['messages']))
		$_SESSION['messages'] = array();
	array_push($_SESSION['messages'], $message);
	
	// Redirect user to home page
	header("Location: index.php");
	ob_end_flush();
	die;
}

// Email already subscribed and confirmed
if ($subscribedStatus === 1)
{
	$dbconn->disconnect();
	$message = array(
		'content' => 'The address ' . $email . ' has already confirmed.',
		'type' => 'success'
	);
	if (!isset($_SESSION['messages']))
		$_SESSION['messages'] = array();
	array_push($_SESSION['messages'], $message);
	
	// Redirect user to home page
	header("Location: index.php");
	ob_end_flush();
	die;
}

$unsubscribe = sha1(uniqid(rand()));
if (!$dbconn->confirmEmail($email, $key, $unsubscribe))
{
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
	die;
}

// Send mail
$mailParams = array(
	'to' => $email,
	'subject' => 'LintinZone: Welcome you to LintinZone',
	'message' => array(
		'{receiver}' => $dbconn->getContactName($email),
		'{unsubscribe_link}' => 'http://' . $_SERVER['SERVER_NAME'] . '/en/unsubscribe.php?key=' . $key . '|' . $unsubscribe . '&email=' . $email . '&lang=en',
		'{support_link}' => 'http://' . $_SERVER['SERVER_NAME'] . '/en/contact.php',
		'{home_link}' => 'http://' . $_SERVER['SERVER_NAME'] . '/en/index.php'
	)/*,
	'header' => array(
		'from' => 'lintinzone@lintinzone.com',
		'replyto' => 'lintinzone@lintinzone.com'
	)*/
);
$sender = new MailSender($dbconn);
$sender->send($mailParams, 'greeting-en', 'html');
$dbconn->disconnect();
$message = array(
	'content' => 'Welcome you to LintinZone.',
	'type' => 'success'
);
if (!isset($_SESSION['messages']))
	$_SESSION['messages'] = array();
array_push($_SESSION['messages'], $message);
header("Location: index.php");
ob_end_flush();
