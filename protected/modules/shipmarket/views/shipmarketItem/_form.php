<?php  
$urlScript = Yii::app()->assetManager->publish(Yii::getPathOfAlias('shipmarket').'/js/shipmarketitemform.js', false, -1, true);
 Yii::app()->getClientScript()->registerScriptFile($urlScript, CClientScript::POS_HEAD);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shipmarket-item-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'size'); ?>
		<?php echo $form->textField($model,'size',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'get_before'); ?>
		<?php echo $form->textField($model,'get_before', array('class'=>'dateinput')); ?>
		<?php echo $form->error($model,'get_before'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->dropDownList($model,'country_id',Country::getCountryList(), array('class'=>'countryinput'));?>
		<?php echo $form->error($model,'country_id'); ?>		
	</div>
	
	
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php $this->widget('application.extensions.tinymce.ETinyMce', array('name'=>'ShipmarketItem[description]','value'=>$model->description,'mode'=>'html','editorTemplate'=>'full')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	
	
	<!-- 
	<div class="row">
		<?php echo $form->labelEx($model,'owner_id'); ?>
		<?php echo $form->textField($model,'owner_id'); ?>
		<?php echo $form->error($model,'owner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creation_date'); ?>
		<?php echo $form->textField($model,'creation_date'); ?>
		<?php echo $form->error($model,'creation_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
	 -->
	 
	<div class="clear"></div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="row">
	<ul>
		<?php
			$photos = $model->getPhotos(); 
			foreach ($photos as $photo):
		?>
		<li><img src="<?php echo $photo->getUrl()?>"/></li>
		<?php endforeach;?>
		
	</ul>
		<?php echo $form->labelEx($model,'img'); ?>
		<?php 
			Yii::import("ext.xupload.models.XUploadForm");
			$js = <<<EOD
js:function (files, index) {
return $('<tr><td><input type="radio" name="main_image" /><\/td>'+
'<td>'+files.name+'<\/td>' +
'<td class="file_upload_progress"><div><\/div><\/td>' +
'<td class="filesize">'+files.size+'</td>' +
'<td class="filesize"><img src="'+files.url+'" width="100px",height="100px"\/><\/td>'+
'<td class="file_upload_cancel">' +
'<button class="ui-state-default ui-corner-all" title="Cancel">' +
'<span class="ui-icon ui-icon-cancel">Cancel<\/span>' +
'<\/button><\/td><\/tr>');
}
EOD;
			$this->widget('ext.xupload.XUploadWidget', array(
                    'url' => Yii::app()->createUrl("shipmarket/UploadItemImage/upload",array("parent_id" => 1)),
                    'model' => new ItemImageForm(),
                    'attribute' => 'file',
					'multiple' => true,
					'options'=>array('buildDownloadRow'=>$js)
							
					
			));
		?>
	</div>
<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
</div>