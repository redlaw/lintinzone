<?php
$this->breadcrumbs=array(
	'Sale Items',
);

$this->menu=array(
	array('label'=>'Create SaleItem', 'url'=>array('create')),
	array('label'=>'Manage SaleItem', 'url'=>array('admin')),
);
?>

<h1>Sale Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
