<?php
/* @var $this OperatorController */
/* @var $model Operator */

$this->breadcrumbs=array(
	'Operators'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Operator', 'url'=>array('index')),
	array('label'=>'Manage Operator', 'url'=>array('admin')),
);
?>

<h1>Create Operator</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>