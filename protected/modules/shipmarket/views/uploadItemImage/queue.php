<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Single queued files upload example</h1>

<?php
$this->widget('ext.xupload.XUploadWidget', array(
					'url' => Yii::app()->createUrl("site/upload", array("parent_id" => 1)),
                    'model' => $model,
                    'attribute' => 'file',
					'options' => array(
						'beforeSend' => 'js:function (event, files, index, xhr, handler, callBack) {
					        handler.uploadRow.find(".file_upload_start button").click(callBack);
					    }'
					),
));
?>
<button id="start_uploads" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary">
	<span class="ui-button-icon-primary ui-icon ui-icon-circle-arrow-e"></span>
	<span class="ui-button-text">Start Uploads</span>
</button>
<script type="text/javascript">
$('#start_uploads').click(function () {
    $('.file_upload_start button').click();
});
</script>