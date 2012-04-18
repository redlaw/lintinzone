<div id="comming-soon">
	<form id="remind-form" method="post" action="subscribe.php">
		<div class="input-holder">
			<input type="text" value="" id="txtEmail" name="email" title="Leave your email for updates" />
			<span class="overtext">Leave your email for updates</span>
		</div>
		<input type="button" value="Submit" id="btnShowName" name="showname" title="Submit" />
		<div class="input-holder hidden">
			<input type="text" value="" id="txtName" name="contactName" title="Your contact name" />
			<span class="overtext">Your contact name</span>
		</div>
		<input class="hidden" type="submit" value="Submit" id="btnSubscribe" name="subscribe" title="Submit" />
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
