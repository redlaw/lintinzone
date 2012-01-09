<?php
$this->breadcrumbs=array(
	'Shipmarket Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShipmarketItem', 'url'=>array('index')),
	array('label'=>'Manage ShipmarketItem', 'url'=>array('admin')),
);
?>

<h1>Create ShipmarketItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>