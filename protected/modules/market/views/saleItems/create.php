<?php
$this->breadcrumbs=array(
	'Sale Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SaleItem', 'url'=>array('index')),
	array('label'=>'Manage SaleItem', 'url'=>array('admin')),
);
?>

<h1>Create SaleItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>