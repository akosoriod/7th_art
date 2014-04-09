<?php
/* @var $this ExerciseTypeController */
/* @var $model ExerciseType */

$this->breadcrumbs=array(
	'Exercise Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ExerciseType', 'url'=>array('index')),
	array('label'=>'Manage ExerciseType', 'url'=>array('admin')),
);
?>

<h1>Create ExerciseType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>