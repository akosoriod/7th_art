<?php
/* @var $this CssController */
/* @var $model CSS */

$this->breadcrumbs=array(
	'Csses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CSS', 'url'=>array('index')),
	array('label'=>'Manage CSS', 'url'=>array('admin')),
);
?>

<h1>Create CSS</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>