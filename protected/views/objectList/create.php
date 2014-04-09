<?php
/* @var $this ObjectListController */
/* @var $model ObjectList */

$this->breadcrumbs=array(
	'Object Lists'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ObjectList', 'url'=>array('index')),
	array('label'=>'Manage ObjectList', 'url'=>array('admin')),
);
?>

<h1>Create ObjectList</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>