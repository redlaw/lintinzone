<?php
ob_start();
// Only a valid post request can execute functions in this page.
if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
	header('Location: ./forbidden.html');
	ob_end_flush();
	die;
}

// If no subscribers have found, redirect users to home page.
if (empty($_POST['subscribers']))
{
	header("Location: ./index.php");
	ob_end_flush();
	die;
}

// Take data.
$subscribers = array();
$subscribers = $_POST['subscribers'];

// Establish a connection
require_once './model/Dbconnection.php';
session_start();
if (!isset($_SESSION['dbconn']))
	$_SESSION['dbconn'] = new Dbconnection(); // If not, establish one.
$dbconn = $_SESSION['dbconn'];
$dbconn->connect(); // Connect to database.

// Query
$sqlStatement = "update `subscribers` set `confirmed` = 1, `modified_date` = '" .  date('c') . "', `confirmed_date` = '" . date('c') . "' where `subscriber_email` = ";
$result = false;
$failSub = array();

foreach ($subscribers as $subscriber)
{
	$result = $dbconn->query($sqlStatement . "'" . mysql_real_escape_string($subscriber) . "'");
	if (!$result)
		$failSub[] = $subscriber;
}

// Close connection.
$dbconn->disconnect();

if (count($failSub) == 0)
{
	$content = count($subscribers);
	$content .= (count($subscribers) == 1) ? ' email has been approved.' : ' emails have been approved.';
	$message = array(
		'content' => $content,
		'type' => 'success'
	);
}
else
{
	$content = count($subscribers) - count($failSub);
	$content .= (count($subscribers) - count($failSub) == 1) ? ' email has been approved.' : ' emails have been approved.';
	$message = array(
		'content' => $content,
		'type' => 'success'
	);
	$content = count($failSub);
	$content .= (count($failSub) == 1) ? ' email has failed to be approved.' : ' emails have failed to be approved.';
	$message_err = array(
		'content' => $content,
		'type' => 'error'
	);
}

if (!isset($_SESSION['messages']))
	$_SESSION['messages'] = array();
array_push($_SESSION['messages'], $message);
if (count($failSub) > 0)
	array_push($_SESSION['messages'], $message_err);
	
header("Location: view-subscribers.php");
ob_end_flush();
