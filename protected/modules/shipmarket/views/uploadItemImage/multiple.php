<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Multiple file upload example</h1>

<?php
$this->widget('ext.xupload.XUploadWidget', array(
					'url' => Yii::app()->createUrl("site/upload", array("parent_id" => 1)),
                    'model' => $model,
                    'attribute' => 'file',
					'multiple' => true,
));
?>
