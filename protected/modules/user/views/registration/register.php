<!-- Begin breadcrumb -->	
<div id="breadcrumbs" class="span-18">
<?php if(isset($this->breadcrumbs)):?>
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->
<?php endif?>
This is for breadcrumbs
</div>
<!-- End  breadcrumb-->

<hr style="border: 1px solid #000;"/>

<!--Begin control_panel-->
<div id="control_panel" class="span-18">
	<input id="button" type="button" value="New Order">
	<input id="button" type="button" value="New Trip">
</div>
<!---->
<hr style="border: 1px solid #000;" />
<!-- Begin content -->
<div id="content" class="span-18 box">
<h1><?php echo UserModule::t("It's free to join"); ?></h1>
<?php echo $this->renderPartial('/user/_form', array('model' => $model)); ?>
</div>
<!-- End content -->
