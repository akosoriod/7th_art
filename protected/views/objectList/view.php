<?php
/* @var $this ObjectListController */
/* @var $model ObjectList */

$this->breadcrumbs=array(
	'Object Lists'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ObjectList', 'url'=>array('index')),
	array('label'=>'Create ObjectList', 'url'=>array('create')),
	array('label'=>'Update ObjectList', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ObjectList', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ObjectList', 'url'=>array('admin')),
);
?>

<h1>View ObjectList #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'static',
		'connected',
		'exercise',
	),
)); ?>
