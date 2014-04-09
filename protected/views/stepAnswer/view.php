<?php
/* @var $this StepAnswerController */
/* @var $model StepAnswer */

$this->breadcrumbs=array(
	'Step Answers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List StepAnswer', 'url'=>array('index')),
	array('label'=>'Create StepAnswer', 'url'=>array('create')),
	array('label'=>'Update StepAnswer', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete StepAnswer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage StepAnswer', 'url'=>array('admin')),
);
?>

<h1>View StepAnswer #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'step',
	),
)); ?>
