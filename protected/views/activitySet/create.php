<?php
/* @var $this ActivitySetController */
/* @var $model ActivitySet */

$this->breadcrumbs=array(
	'Activity Sets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ActivitySet', 'url'=>array('index')),
	array('label'=>'Manage ActivitySet', 'url'=>array('admin')),
);
?>

<h1>Create ActivitySet</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>