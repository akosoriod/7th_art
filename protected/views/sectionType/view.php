<?php
/* @var $this SectionTypeController */
/* @var $model SectionType */

$this->breadcrumbs=array(
	'Section Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List SectionType', 'url'=>array('index')),
	array('label'=>'Create SectionType', 'url'=>array('create')),
	array('label'=>'Update SectionType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SectionType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SectionType', 'url'=>array('admin')),
);
?>

<h1>View SectionType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'weigh',
	),
)); ?>
