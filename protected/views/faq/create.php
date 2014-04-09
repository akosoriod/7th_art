<?php
/* @var $this FaqController */
/* @var $model FAQ */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FAQ', 'url'=>array('index')),
	array('label'=>'Manage FAQ', 'url'=>array('admin')),
);
?>

<h1>Create FAQ</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>