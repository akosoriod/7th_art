<?php
/* @var $this ObjectController */
/* @var $model Object */

$this->breadcrumbs=array(
	'Objects'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Object', 'url'=>array('index')),
	array('label'=>'Create Object', 'url'=>array('create')),
	array('label'=>'Update Object', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Object', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Object', 'url'=>array('admin')),
);
?>

<h1>View Object #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'text',
		'objectList',
	),
)); ?>
