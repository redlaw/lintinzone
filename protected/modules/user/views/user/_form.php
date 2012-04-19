<div class="form">

<?php
	$this->pageTitle = 'LintinZone - ' . UserModule::t('Register');
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'registration-form',
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'focus' => array($model, 'username')
	));
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<!--<?php echo $form->errorSummary($model); ?>-->

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'username'); ?>
		<p class="hint">
			<?php echo UserModule::t('Minimal username length is 6 characters.'); ?>
		</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			<?php echo UserModule::t('Minimal password length is 8 characters.'); ?>
		</p>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'password_repeat'); ?>
		<?php echo $form->passwordField($model,'password_repeat',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<?php if (UserModule::doCaptcha('registration')): ?>
		<div class="row">
			<?php echo $form->labelEx($model, 'verification_code'); ?>
			<?php $this->widget('CCaptcha'); ?>
			<?php echo $form->textField($model, 'verification_code'); ?>
			<?php echo $form->error($model, 'verification_code'); ?>
			<p class="hint">
				<?php echo UserModule::t('Please enter the letters as they are shown in the image above.'); ?><br/>
				<?php echo UserModule::t('Letters are not case-sensitive.'); ?>
			</p>
		</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form register-->