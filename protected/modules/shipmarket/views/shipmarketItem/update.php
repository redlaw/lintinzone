<?php
$this->breadcrumbs=array(
	'Shipmarket Items'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShipmarketItem', 'url'=>array('index')),
	array('label'=>'Create ShipmarketItem', 'url'=>array('create')),
	array('label'=>'View ShipmarketItem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ShipmarketItem', 'url'=>array('admin')),
);
?>

<h1>Update ShipmarketItem <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>