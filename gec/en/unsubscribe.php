<?php
ob_start();
require_once(dirname(__FILE__) . '/../model/Dbconnection.php');
require_once(dirname(__FILE__) . '/../util/MailSender.php');
session_start();

$email = !empty($_GET['email']) ? $email : '';
$key = !empty($_GET['key']) ? $key : '';
$unsubscribe = substr($key, 41);
$key = substr($key, 0, 40);

if (empty($email) || empty($key) || empty($unsubscribe))
{
	$message = array(
		'content' => 'Invalid request!',
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

$result = $dbconn->unsubscribe($email, $key, $unsubscribe);
if ($result === false)
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
}
if ($result === 0)
{
	$dbconn->disconnect();
	$message = array(
		'content' => 'The address ' . $email . ' has not been subscribed.',
		'type' => 'warning'
	);
	if (!isset($_SESSION['messages']))
		$_SESSION['messages'] = array();
	array_push($_SESSION['messages'], $message);
	
	// Redirect user to home page
	header("Location: index.php");
	ob_end_flush();
	die;
}
if ($result === -1)
{
	$dbconn->disconnect();
	$message = array(
		'content' => 'Invalid request!',
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
	'subject' => 'LintinZone: Stop receiving subscriptions :-(',
	'message' => array(
		'{receiver}' => $dbconn->getContactName($email),
		'{home_link}' => 'http://' . $_SERVER['SERVER_NAME'] . '/en/index.php',
		'{support_link}' => 'http://' . $_SERVER['SERVER_NAME'] . '/en/contact.php'
	)/*,
	'header' => array(
		'from' => 'lintinzone@lintinzone.com',
		'replyto' => 'lintinzone@lintinzone.com'
	)*/
);
$sender = new MailSender($dbconn);
$sender->send($mailParams, 'unsubscribe-en', 'html');
$dbconn->disconnect();
$message = array(
	'content' => 'You have stopped receiving subscriptions from LintinZone :-(.',
	'type' => 'success'
);
if (!isset($_SESSION['messages']))
	$_SESSION['messages'] = array();
array_push($_SESSION['messages'], $message);
header("Location: index.php");
ob_end_flush();
