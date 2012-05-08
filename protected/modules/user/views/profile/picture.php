<div id="profile-picture-box">
	<div class="picture-border">
		<img id="profile-picture" src="<?php echo $img['path']; ?>" alt="<?php echo $img['alt']; ?>" title="<?php echo $img['title']; ?>" width="<?php echo $img['width']; ?>" height="<?php echo $img['height']; ?>" />
	</div>
	<?php echo $this->renderPartial('/profile/picture-form', array('model' => $model)); ?>
	<span><?php echo UserModule::t('OR'); ?></span>
	<a href="javascript:void(0);" title="<?php echo UserModule::t('Use your webcam to take a picture'); ?>"><?php echo UserModule::t('Take a picture'); ?></a>
</div>
