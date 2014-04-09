<?php
/* @var $this TargetController */
/* @var $model Target */

$this->breadcrumbs=array(
	'Targets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Target', 'url'=>array('index')),
	array('label'=>'Manage Target', 'url'=>array('admin')),
);
?>

<h1>Create Target</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>