<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'active'); ?>
		<?php echo $form->textField($model,'active'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'online'); ?>
		<?php echo $form->textField($model,'online'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modified_date'); ?>
		<?php echo $form->textField($model,'modified_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_visited_date'); ?>
		<?php echo $form->textField($model,'last_visited_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_visited_ip'); ?>
		<?php echo $form->textField($model,'last_visited_ip',array('size'=>23,'maxlength'=>23)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_visited_loc_id'); ?>
		<?php echo $form->textField($model,'last_visited_loc_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->