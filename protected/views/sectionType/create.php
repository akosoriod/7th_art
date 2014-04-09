<?php
/* @var $this SectionTypeController */
/* @var $model SectionType */

$this->breadcrumbs=array(
	'Section Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SectionType', 'url'=>array('index')),
	array('label'=>'Manage SectionType', 'url'=>array('admin')),
);
?>

<h1>Create SectionType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>