<?php
/* @var $this FaqController */
/* @var $model FAQ */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FAQ', 'url'=>array('index')),
	array('label'=>'Create FAQ', 'url'=>array('create')),
	array('label'=>'Update FAQ', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FAQ', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FAQ', 'url'=>array('admin')),
);
?>

<h1>View FAQ #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'question',
		'answer',
	),
)); ?>
