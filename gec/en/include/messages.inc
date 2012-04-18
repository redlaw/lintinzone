<ul id="messages">
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
