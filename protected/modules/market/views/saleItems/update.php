<?php
$this->breadcrumbs=array(
	'Sale Items'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SaleItem', 'url'=>array('index')),
	array('label'=>'Create SaleItem', 'url'=>array('create')),
	array('label'=>'View SaleItem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SaleItem', 'url'=>array('admin')),
);
?>

<h1>Update SaleItem <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>