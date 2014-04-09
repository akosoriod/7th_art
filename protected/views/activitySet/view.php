<?php
/* @var $this ActivitySetController */
/* @var $model ActivitySet */

$this->breadcrumbs=array(
	'Activity Sets'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List ActivitySet', 'url'=>array('index')),
	array('label'=>'Create ActivitySet', 'url'=>array('create')),
	array('label'=>'Update ActivitySet', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ActivitySet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ActivitySet', 'url'=>array('admin')),
);
?>

<h1>View ActivitySet #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'status',
		'publication',
		'tagline',
		'director',
		'year',
		'operator',
		'soundtrack',
		'image',
	),
)); ?>
