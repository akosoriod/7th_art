<?php
/* @var $this ObjectController */
/* @var $model Object */

$this->breadcrumbs=array(
	'Objects'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Object', 'url'=>array('index')),
	array('label'=>'Manage Object', 'url'=>array('admin')),
);
?>

<h1>Create Object</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>