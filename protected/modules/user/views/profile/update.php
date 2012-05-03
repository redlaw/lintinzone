<div class="form">

<?php
	$this->pageTitle = 'LintinZone - ' . UserModule::t('Update profile');
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'profile-form',
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'focus' => array($model, 'first_name')
	));
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php foreach($model->getAllFieldTypes() as $fieldName => $fieldType): ?>
		<?php echo $fieldName . ' ' . $fieldType; ?>
		<div class="row">
			<?php echo $form->labelEx($model, $fieldName); ?>
			<?php echo $form->$fieldType($model, $fieldName); ?>
			<?php echo $form->error($model, $fieldName); ?>
		</div>
	<?php endforeach; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton(UserModule::t('Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form profile -->
