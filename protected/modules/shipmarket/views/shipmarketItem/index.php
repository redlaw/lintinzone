<?php
$this->breadcrumbs=array(
	'Shipmarket Items',
);

$this->menu=array(
	array('label'=>'Create ShipmarketItem', 'url'=>array('create')),
	array('label'=>'Manage ShipmarketItem', 'url'=>array('admin')),
);
?>

<h1>Shipmarket Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
