<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>LintinZone</title>
		<meta http-equiv="Content-Language" content="en" />
		<meta name="robots" content="noindex,nofollow,noarchive,nocache" />
		<script type="text/javascript" src="../public/scripts/mootools/mootools-core-1.4.0-full-compat-yc.js"></script>
		<script type="text/javascript" src="../public/scripts/view-subscribers.js"></script>
		<link href="../public/css/layout.css" media="screen" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<noscript>Javascript is disabled on this page! Please turn javascript on to let this page functions properly.</noscript>
		<ul id="messages_admin">
			<?php
				if (isset($_SESSION['messages'])):
					foreach ($_SESSION['messages'] as $message):
			?>
				<li class="message_<?php echo $message['type']; ?>"><?php echo $message['content']?></li>
			<?php
					endforeach;
					$_SESSION['messages'] = array();
				endif;
			?>
		</ul>
		<div class="clearboth"></div>
		<div id="page-content"></div>
	</body>
</html>
