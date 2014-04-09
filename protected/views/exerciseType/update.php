<?php
/* @var $this ExerciseTypeController */
/* @var $model ExerciseType */

$this->breadcrumbs=array(
	'Exercise Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ExerciseType', 'url'=>array('index')),
	array('label'=>'Create ExerciseType', 'url'=>array('create')),
	array('label'=>'View ExerciseType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ExerciseType', 'url'=>array('admin')),
);
?>

<h1>Update ExerciseType <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>