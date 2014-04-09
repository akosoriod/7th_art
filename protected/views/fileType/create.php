<?php
/* @var $this FileTypeController */
/* @var $model FileType */

$this->breadcrumbs=array(
	'File Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FileType', 'url'=>array('index')),
	array('label'=>'Manage FileType', 'url'=>array('admin')),
);
?>

<h1>Create FileType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>