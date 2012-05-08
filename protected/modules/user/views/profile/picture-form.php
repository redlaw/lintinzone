<div class="form">

	<?php
		$form = $this->beginWidget('CActiveForm', array(
			'id' => 'picture-form',
			'enableAjaxValidation' => true,
			'enableClientValidation' => true,
			'focus' => array($model, 'username')
		));
	?>
	
	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'picture'); ?>
		<?php echo $form->fileField($model, 'picture'); ?>
		<?php echo $form->error($model, 'picture'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'title'); ?>
		<?php //echo $form->dropDownList($model, 'title', array('male' => 'Male', 'female' => 'Female', 'other' => 'Other')); ?>
		<?php echo $form->textField($model, 'title'); ?>
		<?php echo $form->error($model, 'title'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'description'); ?>
		<?php echo $form->textField($model, 'description'); ?>
		<?php echo $form->error($model, 'description'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>
	
	<?php $this->endWidget(); ?>
</div><!-- form -->
