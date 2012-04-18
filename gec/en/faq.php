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
			$url = "../faq.php?lang=vi";
			header("Location: $url");
			ob_end_flush();
		}
	}
	// If user directly requests to see this page in Vietnamese
	elseif ($_SESSION['lang'] === 'vi')
	{
		$url = "../faq.php?lang=vi";
		header("Location: $url");
		ob_end_flush();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>LintinZone - FAQ</title>
		<meta name="author" content="LintinZone team" />
		<meta name="description" content="LintinZone is the world first social shipping network. By joining LintinZone, you can get cheapest shipping services from all over the world." />
		<meta name="keywords" content="lintinzone, cheap shipping, international shipping, shipping community, global shipping community, social shipping network, Vietnam social shipping network,world social shipping network, international social shipping network, trusted social network" />
		<meta http-equiv="Content-Language" content="en" />
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
			<h3>1. What is LintinZone?</h3>
			<p>
				LintinZone is a community of individuals joined in and help each other shipping goods between two locations worldwide.
				Based on your relations, together with the support of LintinZone community, you could have the least expensive shipping solutions (or even free, if you get luck :-).
			</p>
			<h3>2. Who are the shippers for me?</h3>
			<p>
				<img class="right" src="../public/images/lintinzone-circles-en.png" alt="Who are the shippers?" title="Shippers" width="300" height="267" />
				&nbsp;&nbsp;&nbsp;&nbsp;Your friends, your friends of friends, members in your groups and other members of LintinZone are willing to be your shippers.
			</p>
			<h3>3. Why are people willing to ship goods for me?</h3>
			<p>
				&nbsp;&nbsp;&nbsp;&nbsp;There are a lot of reasons for a person to help you shipping goods, even between two remote locations halfway around the Earth.
				To see these reasons, put yourself in the position of a shipper: <a href="lintinzone-and-shipper.php" target="_blank"><span class="italic">Shipper</span> - Join LintinZone!</a>
			</p>
			<h3>4. Is LintinZone a Vietnamese version of Amazon?</h3>
			<p>
				<img class="left" src="../public/images/amazon-vs-lintinzone.png" alt="LintinZone is not a Vietnamese version of Amazon" title="LintinZone does NOT sell things" width="272" height="101" />
				&nbsp;&nbsp;&nbsp;&nbsp;A great idea! But LintinZone is completely different from Amazon.<br />
				&nbsp;&nbsp;&nbsp;&nbsp;The most obvious distinction between LintinZone and Amazon is LintinZone does NOT sell goods to you.
				Amazon sells things and ship them to you (with an expensive price if the target locations are outside the America or Canada).
				LintinZone does not go that way. The idea of LintinZone is very simple. You have to purchase the item first.
				Then, when you purchased it, but having trouble in the delivery, visit LintinZone!<br />
				&nbsp;&nbsp;&nbsp;&nbsp;Let us take an example. You purchased items from Amazon and need to ship them to Vietnam.
				However, the shipping cost is quite expensive (sometimes, it's even more expensive than the value of your items) or in some situations, it cannot be delivered to Vietname (due to Amazon policies, Amazon only delivers certain types of goods to Vietnam).
				So, you come to ask LintinZone to have a less expensive solution, I mean, much cheaper solution.<br />
			</p>
			<h3>5. So, is LintinZone a free online advertising site, like 5giay?</h3>
			<p>
				&nbsp;&nbsp;&nbsp;&nbsp;LintinZone is also different to <a href="http://5giay.vn" target="_blank" title="5giay - The most crowded e-commerce site in Vietnam">5giay</a> (means 5 seconds - A site that can be compared to Craigslist)!
				Here are the main differences:
				<img class="right" src="../public/images/lintinzone-global-vs-local.jpg" alt="LintinZone and 5giay" title="The advantages of LintinZone in comparison to 5giay" width="247" height="145" />
			</p>
			<ol>
				<li>
					Firstly, 5giay does business locally. It means, all the goods advertised must be sold in your country (in the case of 5giay, it's Vietnam)!
					Meanwhile, LintinZone offers you the freedom to buy goods from anywhere in this world.
					Therefore, you can buy things that do not have in your country. LintinZone will help you find the best shipping solution.
				</li>
				<li>
					5giay advertises local businesses. In most situations when using 5giay, you should be able to get to the store that has things you need.
					LintinZone is different. You won't never use LintinZone if you can get directly to the store you want!
					One of the first LintinZone's advantage is that, we help you buying things from locations that you could not go to at the time you want to buy them.
				</li>
				<li>
					Using 5giay, you will probably face lots of risks when doing businesses, especially when you're not a PRO.
					LintinZone helps you to REDUCE these risks! Firstly, you are the one who choose and decide which item to buy and where to buy it.
					You have the rights to request the shipper to meet the quality requirements of your item.
					Secondly, LintinZone uses your relationship, together with intelligent algorithms to help you find the best shippers.
				</li>
			</ol>
			<h3>6. Ok then, is LintinZone a transportation company?</h3>
			<p>
				<img class="right" src="../public/images/lintinzone-not-transport.jpg" alt="LintinZone does NOT deliver the goods to you!" title="LintinZone is not a transportation company!" width="300" height="199" />
				&nbsp;&nbsp;&nbsp;&nbsp;Absolutely NOT. If you think LintinZone as DHL or VietLink Cargo, you're WRONG!
				LintinZone does NOT deliver the goods to you. The job of LintinZone is to help you find the right shipper. And that's it!<br />
				So, the main advantages that LintinZone brings you are:
			</p>
			<ol>
				<li>
					LintinZone helps you find the right shipper for you.
				</li>
				<li>
					LintinZone makes it easy for you to choose your trusted shippers and manage offers from the other shippers.
				</li>
				<li>
					LintinZone helps you to make a clear, consistent and secure aggreement with your shipper.
					Eventhough you haven't had any experiences, you will be confident that you won't miss any important conditions.
				</li>
				<li>
					LintinZone helps you to track your items on the go.
				</li>
				<li>
					LintinZone tries to build a large community of shippers that travel regularly between many countries.
					So the waiting time to get what you want does not hurt you much.
				</li>
				<li>...</li>
			</ol>
			<p>
				&nbsp;&nbsp;&nbsp;&nbsp;And there are much more advantages that LintinZone will brings to you. Try and discover the values of LintinZone!
			</p>
			<h3>7. How about my privacy?</h3>
			<p>
				<img class="left" src="../public/images/lintinzone-values-your-privacy.jpg" alt="LintinZone values your privacy the most!" title="LintinZone values your privacy the most!" width="255" height="169" />
				&nbsp;&nbsp;&nbsp;&nbsp;LintinZone values your privacy the most!<br />
				&nbsp;&nbsp;&nbsp;&nbsp;LintinZone operates based on trustness. So, to be a part of LintinZone, you need to give us some of your information.
				The more and trusted information you give us, the more chance you get to the top of the recommendation list.
				What we always make SURE is, these information will only be SEEN by those you allowed them to see.
				We also ensures that, these information will NEVER shows up in any search results from any search engines (unless you want them to be).<br />
				LintinZone commits that your information will NEVER be sold to any third-parties. That's our commitment!<br />
				&nbsp;&nbsp;&nbsp;&nbsp;Your activities are also protected carefully. Only members that you allowed could see your activities.
			</p>
			<p>
				To understand about LintinZone process, please visit 
				<a href="how-it-works.php">How LintinZone works</a>.
			</p>
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
