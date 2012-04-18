<?php
	session_start();
	ob_start();
	// Check the request, index.php?lang=vi
	if (isset($_REQUEST['lang']))
	{
		if ($_REQUEST['lang'] === 'vi')
			$_SESSION['lang'] = 'vi';
		else
			$_SESSION['lang'] = 'en';
	}
	
	// If no explicit request is made
	if (!isset($_SESSION['lang']))
	{
		// Detect the browser language to decide which language should be displayed.
		$browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		if ($browserLang === 'vi')
		{
			$url = "../how-it-works.php?lang=vi";
			header("Location: $url");
			ob_end_flush();
		}
	}
	// If user directly requests to see this page in Vietnamese
	elseif ($_SESSION['lang'] === 'vi')
	{
		$url = "../how-it-works.php?lang=vi";
		header("Location: $url");
		ob_end_flush();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>LintinZone</title>
		<meta name="author" content="LintinZone team" />
		<meta name="description" content="LintinZone is the world first social shipping network. By joining LintinZone, you can get cheapest shipping services from all over the world." />
		<meta name="keywords" content="lintinzone, cheap shipping, international shipping, shipping community, global shipping community, social shipping network, Vietnam social shipping network,world social shipping network, international social shipping network, trusted social network" />
		<meta http-equiv="Content-Language" content="vi" />
		<link rel="shortcut icon" href="../public/images/lintinzone-favicon.png" type="image/x-icon" />
		<link rel="icon" href="../public/images/lintinzone-favicon.png" type="image/x-icon" />
		<script type="text/javascript" src="../public/scripts/mootools/mootools-core-1.4.0-full-compat-yc.js"></script>
		<link href="../public/css/layout.css" media="screen" rel="stylesheet" type="text/css" />
		<!-- Google Analysis -->
		<meta itemprop="name" content="LintinZone">
		<meta itemprop="description" content="LintinZone is the world first social shipping network. By joining LintinZone, you can get cheapest shipping services from all over the world." />
		<meta itemprop="image" content="http://lintinzone.com/public/images/lintinzone-logo.png">
		<!-- Facebook Insights -->
		<meta property="fb:admins" content="100001301010590" />
	</head>
	<body>
		<div class="hidden">
			<h2>LintinZone - the world first Social Shipping Network</h2>
			<p>
				LintinZone is the world first social shipping network. By joining LintinZone, you can get cheapest shipping services from all over the world.
			</p>
			<h3>
				lintinzone, cheap shipping, international shipping, shipping community, global shipping community, social shipping network, Vietnam social shipping network,world social shipping network, international social shipping network, trusted social network
			</h3>
		</div>
		<div class="header">
			<?php include 'include/header.inc'; ?>
		</div>
		<div class="announcement">
			<?php include 'include/messages.inc'; ?>
			<?php include 'include/comming-soon.inc'; ?>
		</div>
		<div class="menu">
			<?php include 'include/menu.inc'; ?>
		</div>
		<div class="content">
			<div class="social-plugins">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style ">
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
					<a class="addthis_counter addthis_pill_style"></a>
				</div>
				<!-- AddThis Button END -->
			</div>
			<h3>Ordering Process</h3>
			<ol>
				<li>
					You post the items that need to be shipped on LintinZone.<br />
					<img src="../public/images/lintinzone-order-en-1.png" width="453" height="67" title="Ordering process - Step 1" alt="Step 1, post your items." />
				</li>
				<li>
					LintinZone suggests shippers who can ship them.<br />
					<img src="../public/images/lintinzone-order-en-2.png" width="453" height="91" title="Ordering process - Step 2" alt="Step 2, LintinZone suggests shippers." />
				</li>
				<li>
					You contact shippers for detail. If an agreement is established, the transaction gets started.
				</li>
				<li>
					You receive the items and pay fee to the shipper. The transaction is done successfully.
				</li>
			</ol>
			<h3>Shipping Process</h3>
			<ol>
				<li>
					You post your trips on LintinZone.<br />
					<img src="../public/images/lintinzone-ship-en-1.png" width="453" height="65" title="Shipping process - Step 1" alt="Step 1, post your trip." />
				</li>
				<li>
					LintinZone suggests recipients who have items that need to be shipped.<br />
					<img src="../public/images/lintinzone-ship-en-2.png" width="453" height="91" title="Shipping process - Step 2" alt="Step 2, LintinZone suggests recipients." >
				</li>
				<li>
					You contact recipients for detail. If agreement is established, the transaction gets started.
				</li>
				<li>
					You ship the items to the recipients and get paid. The transaction is done successfully.
				</li>
			</ol>
			<div class="social-plugins">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style ">
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
					<a class="addthis_counter addthis_pill_style"></a>
				</div>
				<!-- AddThis Button END -->
			</div>
		</div>
		<div class="footer">
			<?php include 'include/footer.inc'; ?>
		</div>
	</body>
</html>
<?php
	ob_end_flush();
?>
