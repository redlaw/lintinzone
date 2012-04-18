<?php
ob_start();
require_once 'model/Dbconnection.php';
require_once 'util/MailSender.php';
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
		'content' => 'Xin hãy cung cấp địa chỉ thư của bạn!',
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
	$name = 'bạn';
$result = $dbconn->insertSubscriber($email, $name);

// If cannot insert new email
if ($result === false)
{
	$dbconn->rollback();
	$dbconn->disconnect();
	$message = array(
		'content' => 'Quá trình xử lý xảy ra lỗi! Xin vui lòng thử lại.',
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
elseif ($result === 0)
{
	$dbconn->disconnect();
	$message = array(
		'content' => 'Địa chỉ thư đã được đăng ký.',
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

// Generate an unique key for email confirmation.
$key = sha1(uniqid(rand())); // 40 characters
$result = $dbconn->sendVerification($email, $key);
// Send mail
$mailParams = array(
	'to' => $email,
	'subject' => 'LintinZone: Xác nhận đăng ký tin tức',
	'message' => array(
		'{receiver}' => (!empty($name)) ? $name : 'bạn',
		'{confirm_link}' => 'http://' . $_SERVER['SERVER_NAME'] . '/confirm.php?key=' . $key . '&email=' . $email . '&lang=vi',
		'{support_link}' => 'http://' . $_SERVER['SERVER_NAME'] . '/contact.php',
		'{home_link}' => 'http://' . $_SERVER['SERVER_NAME'] . '/index.php'
	)/*,
	'header' => array(
		'from' => 'lintinzone@lintinzone.com',
		'replyto' => 'lintinzone@lintinzone.com'
	)*/
);
$sender = new MailSender($dbconn);
$sender->send($mailParams, 'confirm-vi', 'html');

// If verification key is stored...
if ($result)
{
	$_SESSION['email'] = $email;
	$message = array(
		'content' => 'Thư xác nhận đăng ký đã được gửi tới địa chỉ thư của bạn.',
		'type' => 'success'
	);
}
else // If it's not, rollback...
{
	$dbconn->rollback();
	$message = array(
		'content' => 'Quá trình xử lý bị lỗi! Xin vui lòng thử lại.',
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
