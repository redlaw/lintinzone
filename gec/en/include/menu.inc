<?php
	$index = false;
	$about = false;
	$contact = false;
	$work = false;
	$faq = false;
	if (strpos($_SERVER['REQUEST_URI'], 'index.php') != false
		|| $_SERVER['REQUEST_URI'] === '/'
		|| empty($_SERVER['REQUEST_URI']))
		$index = true;
	elseif (strpos($_SERVER['REQUEST_URI'], 'about-us.php') != false)
		$about = true;
	elseif (strpos($_SERVER['REQUEST_URI'], 'contact.php') != false)
		$contact = true;
	elseif (strpos($_SERVER['REQUEST_URI'], 'how-it-works.php') != false)
		$work = true;
	elseif (strpos($_SERVER['REQUEST_URI'], 'faq.php') != false)
		$faq = true;
?>
<ul id="main-nav" style="width: 450px;">
	<li id="main-nav-index" <?php echo ($index === true) ? 'class="current-page"' : ''; ?>>
		<a name="home" href="index.php" title="Home">Home</a>
	</li>
	<li id="main-nav-how-it-work" <?php echo ($work === true) ? 'class="current-page"' : ''; ?>>
		<a name="howitwork" href="how-it-works.php" title="How LintinZone works?">How it works</a>
	</li>
	<li id="main-nav-faq" <?php echo ($faq === true) ? 'class="current-page"' : ''; ?>>
		<a name="faq" href="faq.php" title="Frequently Asked Questions">FAQ</a>
	</li>
	<li id="main-nav-about-us" <?php echo ($about === true) ? 'class="current-page"' : ''; ?>>
		<a name="contact" href="about-us.php" title="About us">About us</a>
	</li>
	<li id="main-nav-contact" <?php echo ($contact === true) ? 'class="current-page"' : ''; ?>>
		<a name="contact" href="contact.php" title="Contact us">Contact</a>
	</li>
</ul>
	<a href="?lang=vi">
		<img width="24" height="24" src="../public/images/vi_inactive.gif" alt="Ti?ng Vi?t Nam" title="Ti?ng Vi?t Nam" />
	</a>
	<a href="?lang=en">
		<img width="24" height="24" src="../public/images/en_active.gif" alt="English" title="You are now viewing this page in English." />
	</a>
<script type="text/javascript">
	var overtextHandle = function()
	{
		$$('.overtext').each(function(overtext){
			var preControl = overtext.getPrevious();
			overtext.addEvent('click', function(event){
				event.stop();
				overtext.setStyle('display', 'none');
				preControl.focus();
			});
			preControl.addEvent('focus', function(event){
				overtext.setStyle('display', 'none');
				preControl.focus();
			});
			preControl.addEvent('blur', function(event){
				if (preControl.get('html') == ''
					&& preControl.get('value') == '')
					overtext.setStyle('display', 'block');
			});
		});
	};
	window.addEvent('domready', function(){
		overtextHandle();
	});
</script>
