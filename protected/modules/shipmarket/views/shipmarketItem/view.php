<?php
$this->breadcrumbs=array(
	'Shipmarket Items'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ShipmarketItem', 'url'=>array('index')),
	array('label'=>'Create ShipmarketItem', 'url'=>array('create')),
	array('label'=>'Update ShipmarketItem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ShipmarketItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShipmarketItem', 'url'=>array('admin')),
);
?>

<h1>View ShipmarketItem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'size',
		'weight',
		'get_before',
		array('name'=>'country_id','value'=>Country::getCountryName($model->country_id)),
		array('name'=>'description','value'=>$model->description,'type'=>'raw'),
		array('name'=>'owner_id','value'=>CHtml::encode($model->owner->username)),
		'creation_date',
		'status',
	),
)); ?>
