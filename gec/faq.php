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
			$url = "en/faq.php?lang=en";
			header("Location: $url");
			ob_end_flush();
		}
	}
	// If user directly requests to see this page in Vietnamese
	elseif ($_SESSION['lang'] === 'en')
	{
		$url = "en/faq.php?lang=en";
		header("Location: $url");
		ob_end_flush();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>LintinZone - Câu hỏi</title>
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
		<meta itemprop="description" content="LintinZone là một cộng đồng những cá nhân cùng tham gia và giúp đỡ nhau trong việc vận chuyển các sản phẩm giữa hai địa điểm trên toàn thế giới. Dựa vào những mối liên hệ của bạn cùng sự hỗ trợ của cộng đồng LintinZone, bạn có thể tìm được giải pháp chuyển hàng ít tốn kém nhất (thậm chí là miễn phí, nếu may mắn :-) và nhanh nhất.">
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
			<h3>1. LintinZone là gì?</h3>
			<p>
				LintinZone là một cộng đồng những cá nhân cùng tham gia và giúp đỡ nhau trong việc vận chuyển các sản phẩm giữa hai địa điểm trên toàn thế giới.
				Dựa vào những mối liên hệ của bạn cùng sự hỗ trợ của cộng đồng LintinZone, bạn có thể tìm được giải pháp chuyển hàng ít tốn kém nhất (thậm chí là miễn phí, nếu may mắn :-) và nhanh nhất.
			</p>
			<h3>2. Ai là người chuyển hàng cho tôi?</h3>
			<p>
				<img class="right" src="public/images/lintinzone-circles.png" alt="Tại sao lại có người sẵn sàng chuyển hàng giúp tôi?" title="Người chuyển hàng cho bạn" width="300" height="267" />
				&nbsp;&nbsp;&nbsp;&nbsp;Bạn của bạn, bạn của bạn của bạn, thành viên trong các nhóm mà bạn tham gia và những thành viên khác trong cộng đồng LintinZone sẽ giúp bạn.
			</p>
			<h3>3. Tại sao lại có người muốn chuyển hàng giúp tôi?</h3>
			<p>
				&nbsp;&nbsp;&nbsp;&nbsp;Có rất nhiều lí do để một người giúp bạn chuyển một món hàng cho bạn, dù là giữa hai địa điểm cách nhau nửa vòng Trái Đất.
				Để thực sự thấy được những lí do này, bạn hãy đặt trường hợp mình là một người chuyển hàng (<span class="italic">shipper</span>) để xem những lí do
				bạn sẵn sàng chuyển hàng cho các thành viên khác tại LintinZone: <a href="lintinzone-and-shipper.php" target="_blank"><span class="italic">Shipper</span> - Hãy đến với LintinZone!</a>
			</p>
			<h3>4. Phải chăng LintinZone là một Amazon Việt Nam?</h3>
			<p>
				<img class="left" src="public/images/amazon-vs-lintinzone.png" alt="LintinZone không phải là một Amazon mới" title="LintinZone KHÔNG bán hàng" width="272" height="101" />
				&nbsp;&nbsp;&nbsp;&nbsp;Ý tưởng thật tuyệt vời! Nhưng LintinZone hoàn toàn không phải là một Amazon Việt Nam, cũng như LintinZone không hề đi theo mô hình của Amazon.<br />
				&nbsp;&nbsp;&nbsp;&nbsp;Sự khác biệt rõ nét nhất giữa LintinZone và Amazon là LintinZone không bán hàng cho bạn.
				Amazon bán hàng và vận chuyển chuyển hàng đến cho bạn (dĩ nhiên với một cái giá khá đắt nếu địa điểm cần chuyển đến nằm ngoài Mỹ và Canada).
				LintinZone hoàn toàn không đi theo con đường đó. Ý tưởng của nhóm phát triển LintinZone rất đơn giản. Bạn phải tự giải quyết vấn đề mua hàng của mình.
				Khi đã có món hàng đó nhưng lại gặp khó khăn trong khâu vận chuyển, hãy tìm đến LintinZone!<br />
				&nbsp;&nbsp;&nbsp;&nbsp;Chúng tôi lấy một ví dụ để so sánh sự khác biệt giữa Amazon và LintinZone. Bạn mua hàng từ Amazon và cần chuyển về Việt Nam.Tuy nhiên, chi phí vận chuyển từ Mỹ về Việt Nam lại khá đắt hay trong một số trường hợp không vận chuyển về được (Amazon chỉ đồng ý chuyển một số loại mặt hàng nhất định về Việt Nam). Và thế là bạn tìm đến LintinZone để có được một giải pháp chuyển hàng với chi phí rẻ hơn rất nhiều.<br />
				&nbsp;&nbsp;&nbsp;&nbsp;Xin được khẳng định, LintinZone KHÔNG phải là một trang web bán hàng!
			</p>
			<h3>5. Vậy LintinZone là một trang rao vặt giống như 5giay?</h3>
			<p>
				&nbsp;&nbsp;&nbsp;&nbsp;LintinZone cũng KHÁC 5giay ở nhiều điểm!
				Chúng tôi xin được liệt kê ra những điểm chính:
				<img class="right" src="public/images/lintinzone-global-vs-local.jpg" alt="LintinZone và 5giay" title="Ưu thế của LintinZone so với 5giay" width="247" height="145" />
			</p>
			<ol>
				<li>
					Các món hàng mua được thông qua 5giay phải có mặt tại Việt Nam! Trong khi đó, sử dụng LintinZone, bạn hoàn toàn chủ động về vấn đề mua hàng.
					Bạn có thể mua những sản phẩm chưa có ở Việt Nam. LintinZone chỉ giải quyết giúp bạn phần giải pháp vận chuyển.
				</li>
				<li>
					5giay giúp người dùng quảng cáo cho các cửa hàng của họ. Trong rất nhiều trường hợp sử dụng 5giay, bạn tìm được một cửa hàng ưng ý và phải đến được cửa hàng đó để mua đồ.
					LintinZone thì khác. Bạn sẽ không bao giờ cần sử dụng LintinZone nếu như bạn có thể trực tiếp đến cửa hàng để mua món hàng!
					LintinZone xác định lợi thế của mình là ở chỗ nó giúp bạn mua được món hàng ở những địa điểm mà bạn không đến được vào khoảng thời gian bạn cần mua món hàng đó.
				</li>
				<li>
					Sử dụng 5giay, bạn rất có thể sẽ phải đối mặt với nhiều rủi ro khi giao dịch, đặc biệt khi bạn không phải "dân chuyên".
					LintinZone giúp bạn HẠN CHẾ bớt những rủi ro này! Thứ nhất, bạn là người chủ động chọn và mua hàng.
					Bạn hoàn toàn được quyền yêu cầu người chuyển hàng đáp ứng các yêu cầu về chất lượng món hàng của bạn.
					Thứ hai, LintinZone sử dụng các mối quan hệ của bạn cùng các thuật toán thông minh để giúp bạn tìm ra những người giao hàng phù hợp.
				</li>
			</ol>
			<h3>6. Như vậy, LintinZone chính là một công ty vận chuyển?</h3>
			<p>
				<img class="right" src="public/images/lintinzone-not-transport.jpg" alt="LintinZone không vận chuyển hàng hóa cho bạn!" title="LintinZone không phải là một công ty vận chuyển hàng hóa!" width="300" height="199" />
				&nbsp;&nbsp;&nbsp;&nbsp;Hoàn toàn KHÔNG PHẢI. Nếu bạn nghĩ LintinZone như là DHL hay VietLink Cargo, bạn hoàn toàn SAI.
				LintinZone không vận chuyển hàng hóa cho bạn! Nhiệm vụ của LintinZone là tìm cho bạn một người vận chuyển phù hợp. HẾT!<br />
				Nếu bạn cần chuyển hàng, LintinZone đem lại cho bạn những lợi ích sau đây:
			</p>
			<ol>
				<li>
					LintinZone giúp bạn tìm được một người chuyển hàng phù hợp với yêu cầu của bạn.
				</li>
				<li>
					LintinZone giúp bạn chủ động đề nghị người chuyển hàng mà bạn tin tưởng cũng như giúp bạn quản lý đề nghị từ những người chuyển hàng khác.
				</li>
				<li>
					LintinZone giúp bạn thống nhất các điều kiện giao dịch một cách rõ ràng. Như vậy, dù bạn chưa có kinh nghiệm, bạn cũng sẽ tự tin rằng mình không bỏ lỡ bất kỳ điều kiện quan trọng nào.
				</li>
				<li>
					LintinZone giúp bạn biết được quá trình vận chuyển từng mặt hàng của bạn.
				</li>
				<li>
					LintinZone xây dựng một cộng đồng lớn gồm nhiều người vận chuyển thường xuyên đi lại giữa nhiều quốc gia.
					Do đó, thời gian đợi chờ để có được thứ bạn muốn sẽ bớt "đau đớn" hơn!!!
				</li>
				<li>...</li>
			</ol>
			<p>
				&nbsp;&nbsp;&nbsp;&nbsp;Và còn rất nhiều lợi ích khác mà chúng tôi đem lại. Hãy thử và khám phá các giá trị của LintinZone!
			</p>
			<h3>7. Quyền riêng tư như thế nào?</h3>
			<p>
				<img class="left" src="public/images/lintinzone-values-your-privacy.jpg" alt="LintinZone tôn trọng quyền riêng tư của khách hàng!" title="LintinZone tôn trọng quyền riêng tư của khách hàng" width="255" height="169" />
				&nbsp;&nbsp;&nbsp;&nbsp;LintinZone tuyệt đối tôn trọng quyền riêng tư của bạn.<br />
				&nbsp;&nbsp;&nbsp;&nbsp;LintinZone được hoạt động dựa trên sự tin tưởng. Do đó, để tham gia LintinZone, bạn cần cung cấp cho chúng tôi một số thông tin cá nhân của bạn.
				Điều mà chúng tôi đảm bảo với bạn là, các thông tin này chỉ được xem bởi những nhóm người do bạn quyết định. Chúng tôi cũng đảm bảo những thông tin
				này không bao giờ xuất hiện trong các kết quả tìm kiếm từ LintinZone (trừ khi bạn muốn như vậy).<br />
				Các thông tin cá nhân của bạn cũng sẽ không bị bán cho bất cứ bên thứ ba nào. Đó là cam kết của LintinZone.<br />
				&nbsp;&nbsp;&nbsp;&nbsp;Các hoạt động của bạn trên LintinZone cũng được kiểm soát chặt chẽ. Chỉ những nhóm người bạn cho phép mới thấy được những hoạt động này.
			</p>
			<p>
				Để hiểu rõ hơn về cách thức LintinZone giúp bạn, hãy xem phần
				<a href="how-it-works.php">cách thức hoạt động</a>.
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
