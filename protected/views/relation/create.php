<?php
/* @var $this RelationController */
/* @var $model Relation */

$this->breadcrumbs=array(
	'Relations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Relation', 'url'=>array('index')),
	array('label'=>'Manage Relation', 'url'=>array('admin')),
);
?>

<h1>Create Relation</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>