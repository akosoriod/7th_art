<?php
/* @var $this ExerciseTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Exercise Types',
);

$this->menu=array(
	array('label'=>'Create ExerciseType', 'url'=>array('create')),
	array('label'=>'Manage ExerciseType', 'url'=>array('admin')),
);
?>

<h1>Exercise Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
