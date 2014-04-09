<?php
/* @var $this StepAnswerController */
/* @var $model StepAnswer */

$this->breadcrumbs=array(
	'Step Answers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List StepAnswer', 'url'=>array('index')),
	array('label'=>'Manage StepAnswer', 'url'=>array('admin')),
);
?>

<h1>Create StepAnswer</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>