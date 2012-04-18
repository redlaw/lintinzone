<div id="comming-soon">
	<form id="remind-form" method="post" action="subscribe.php">
		<div class="input-holder">
			<input type="text" value="" id="txtEmail" name="email" title="Để lại địa chỉ thư để nhận tin tức cập nhật mới nhất về dự án" />
			<span class="overtext">Mời bạn để lại địa chỉ thư để nhận cập nhật</span>
		</div>
		<input type="button" value="Đăng ký" id="btnShowName" name="showname" title="Đăng ký" />
		<div class="input-holder hidden">
			<input type="text" value="" id="txtName" name="contactName" title="Tên của bạn để chúng tôi tiện liên hệ" />
			<span class="overtext">Tên liên hệ của bạn</span>
		</div>
		<input class="hidden" type="submit" value="Đăng ký" id="btnSubscribe" name="subscribe" title="Đăng ký" />
	</form>
</div>

<script type="text/javascript">
	var displayContactName = function()
	{
		$('btnShowName').addEvent('click', function(event){
			event.stop();
			if ($('txtEmail').get('value') == '')
				return;
			var inputHolder = $('txtName').getParent();
			inputHolder.removeClass('hidden');
			inputHolder.getNext().removeClass('hidden');
			this.addClass('hidden');
		});
	};
	window.addEvent('domready', function(){
		displayContactName();
	});
</script>
