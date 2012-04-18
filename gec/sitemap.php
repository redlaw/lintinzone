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
		if ($browserLang !== 'vi')
		{
			$url = "en/sitemap.php?lang=en";
			header("Location: $url");
			ob_end_flush();
		}
	}
	// If user directly requests to see this page in Vietnamese
	elseif ($_SESSION['lang'] === 'en')
	{
		$url = "en/sitemap.php?lang=en";
		header("Location: $url");
		ob_end_flush();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" itemscope itemtype="http://schema.org/LocalBusiness">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>LintinZone</title>
		<meta name="author" content="LintinZone team" />
		<meta name="description" content="LintinZone là một cộng đồng những cá nhân cùng tham gia và giúp đỡ nhau trong việc vận chuyển các sản phẩm giữa hai địa điểm trên toàn thế giới. Dựa vào những mối liên hệ của bạn cùng sự hỗ trợ của cộng đồng LintinZone, bạn có thể tìm được giải pháp chuyển hàng ít tốn kém nhất (thậm chí là miễn phí, nếu may mắn :-) và nhanh nhất." />
		<meta name="keywords" content="lintinzone, giao hàng giá rẻ, giao hàng trên toàn thế giới, giao hàng toàn cầu, cộng đồng giao hàng trên toàn thế giới, cộng đồng giao hàng toàn cầu, cộng đồng giao hàng Việt Nam, mạng xã hội giao hàng Việt Nam, mạng xã hội giao hàng trên toàn thế giới, mạng xã hội giao hàng toàn cầu, cộng đồng giao hàng tin tưởng, mạng xã hội giao hàng tin tưởng" />
		<meta http-equiv="Content-Language" content="vi" />
		<link rel="shortcut icon" href="public/images/lintinzone-favicon.png" type="image/x-icon" />
		<link rel="icon" href="public/images/lintinzone-favicon.png" type="image/x-icon" />
		<script type="text/javascript" src="public/scripts/mootools/mootools-core-1.4.0-full-compat-yc.js"></script>
		<link href="public/css/layout.css" media="screen" rel="stylesheet" type="text/css" />
		<!-- Google Analysis -->
		<meta itemprop="name" content="LintinZone">
		<meta itemprop="description" content="LintinZone là một cộng đồng những cá nhân cùng tham gia và giúp đỡ nhau trong việc vận chuyển các sản phẩm giữa hai địa điểm trên toàn thế giới. Dựa vào những mối liên hệ của bạn cùng sự hỗ trợ của cộng đồng LintinZone, bạn có thể tìm được giải pháp chuyển hàng ít tốn kém nhất (thậm chí là miễn phí, nếu may mắn :-) và nhanh nhất." />
		<meta itemprop="image" content="http://lintinzone.com/public/images/lintinzone-logo.png">
		<!-- Facebook Insights -->
		<meta property="fb:admins" content="100001301010590" />
	</head>
	<body>
		<div class="hidden">
			<h2>LintinZone - mạng xã hội chuyển hàng đầu tiên trên thế giới</h2>
			<p>
				LintinZone là một cộng đồng những cá nhân cùng tham gia và giúp đỡ nhau trong việc vận chuyển các sản phẩm giữa hai địa điểm trên toàn thế giới. Dựa vào những mối liên hệ của bạn cùng sự hỗ trợ của cộng đồng LintinZone, bạn có thể tìm được giải pháp chuyển hàng ít tốn kém nhất (thậm chí là miễn phí, nếu may mắn :-) và nhanh nhất.
			</p>
			<h3>
				lintinzone, giao hàng giá rẻ, giao hàng trên toàn thế giới, giao hàng toàn cầu, cộng đồng giao hàng trên toàn thế giới, cộng đồng giao hàng toàn cầu, cộng đồng giao hàng Việt Nam, mạng xã hội giao hàng Việt Nam, mạng xã hội giao hàng trên toàn thế giới, mạng xã hội giao hàng toàn cầu, cộng đồng giao hàng tin tưởng, mạng xã hội giao hàng tin tưởng
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
			<p>
				&nbsp;&nbsp;&nbsp;&nbsp;LintinZone là một cộng đồng những cá nhân cùng tham gia và giúp đỡ nhau trong việc vận chuyển các sản phẩm giữa hai địa điểm trên toàn thế giới.
				Dựa vào những mối liên hệ của bạn cùng sự hỗ trợ của cộng đồng LintinZone, bạn có thể tìm được giải pháp chuyển hàng ít tốn kém nhất (thậm chí là miễn phí, nếu may mắn :-) và nhanh nhất.
			</p>
			<ul class="sitemap">
				<li>
					<a href="index.php" title="LintinZone - Trang chủ">Trang chủ</a>
					<ul>
						<li>
							<a href="why-lintinzone.php" title="Tại sao bạn nên chọn LintinZone?">Tại sao bạn nên chọn LintinZone?</a>
						</li>
						<li>
							<a href="lintinzone-and-shipper.php" title="Shipper - Hãy gia nhập LintinZone!"><span class="italic">Shipper</span> - Hãy gia nhập LintinZone!</a>
						</li>
						<li>
							<a href="common-misunderstanding.php" title="Những ngộ nhận thường gặp về LintinZone">Những ngộ nhận thường gặp về LintinZone.</a>
						</li>
						<li>
							<a href="lintinzone-values-privacy.php" title="LintinZone tuyệt đối tôn trọng quyền riêng tư">LintinZone tuyệt đối tôn trọng quyền riêng tư của các thành viên.</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="about-us.php" title="Nhóm chúng tôi">Nhóm chúng tôi</a>
				</li>
				<li>
					<a href="contact.php" title="Liên hệ">Liên hệ</a>
				</li>
				<li>
					<a href="how-it-works.php" title="Cách thức làm việc">Cách thức làm việc</a>
				</li>
				<li>
					<a href="faq.php" title="Những câu hỏi thường gặp">Những câu hỏi thường gặp</a>
				</li>
				<li>
					<a href="blog/" title="LintinZone blog"><span class="italic">Blog</span></a>
				</li>
			</ul>
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
