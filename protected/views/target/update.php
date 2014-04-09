<?php
/* @var $this TargetController */
/* @var $model Target */

$this->breadcrumbs=array(
	'Targets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Target', 'url'=>array('index')),
	array('label'=>'Create Target', 'url'=>array('create')),
	array('label'=>'View Target', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Target', 'url'=>array('admin')),
);
?>

<h1>Update Target <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>