<?php
/* @var $this ActivitySetController */
/* @var $model ActivitySet */

$this->breadcrumbs=array(
	'Activity Sets'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ActivitySet', 'url'=>array('index')),
	array('label'=>'Create ActivitySet', 'url'=>array('create')),
	array('label'=>'View ActivitySet', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ActivitySet', 'url'=>array('admin')),
);
?>

<h1>Update ActivitySet <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>