<?php
/* @var $this TargetController */
/* @var $model Target */

$this->breadcrumbs=array(
	'Targets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Target', 'url'=>array('index')),
	array('label'=>'Create Target', 'url'=>array('create')),
	array('label'=>'Update Target', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Target', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Target', 'url'=>array('admin')),
);
?>

<h1>View Target #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'previousText',
		'id_div',
		'exercise',
	),
)); ?>
