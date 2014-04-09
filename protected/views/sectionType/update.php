<?php
/* @var $this SectionTypeController */
/* @var $model SectionType */

$this->breadcrumbs=array(
	'Section Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SectionType', 'url'=>array('index')),
	array('label'=>'Create SectionType', 'url'=>array('create')),
	array('label'=>'View SectionType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SectionType', 'url'=>array('admin')),
);
?>

<h1>Update SectionType <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>