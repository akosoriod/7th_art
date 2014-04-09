<?php
/* @var $this CssController */
/* @var $model CSS */

$this->breadcrumbs=array(
	'Csses'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CSS', 'url'=>array('index')),
	array('label'=>'Create CSS', 'url'=>array('create')),
	array('label'=>'View CSS', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CSS', 'url'=>array('admin')),
);
?>

<h1>Update CSS <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>