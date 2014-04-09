<?php
/* @var $this ExerciseTypeController */
/* @var $model ExerciseType */

$this->breadcrumbs=array(
	'Exercise Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ExerciseType', 'url'=>array('index')),
	array('label'=>'Create ExerciseType', 'url'=>array('create')),
	array('label'=>'Update ExerciseType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ExerciseType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ExerciseType', 'url'=>array('admin')),
);
?>

<h1>View ExerciseType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'template',
	),
)); ?>
