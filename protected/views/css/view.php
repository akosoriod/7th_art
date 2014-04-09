<?php
/* @var $this CssController */
/* @var $model CSS */

$this->breadcrumbs=array(
	'Csses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CSS', 'url'=>array('index')),
	array('label'=>'Create CSS', 'url'=>array('create')),
	array('label'=>'Update CSS', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CSS', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CSS', 'url'=>array('admin')),
);
?>

<h1>View CSS #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'path',
	),
)); ?>
