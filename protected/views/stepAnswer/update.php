<?php
/* @var $this StepAnswerController */
/* @var $model StepAnswer */

$this->breadcrumbs=array(
	'Step Answers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StepAnswer', 'url'=>array('index')),
	array('label'=>'Create StepAnswer', 'url'=>array('create')),
	array('label'=>'View StepAnswer', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StepAnswer', 'url'=>array('admin')),
);
?>

<h1>Update StepAnswer <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>