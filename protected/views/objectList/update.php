<?php
/* @var $this ObjectListController */
/* @var $model ObjectList */

$this->breadcrumbs=array(
	'Object Lists'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ObjectList', 'url'=>array('index')),
	array('label'=>'Create ObjectList', 'url'=>array('create')),
	array('label'=>'View ObjectList', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ObjectList', 'url'=>array('admin')),
);
?>

<h1>Update ObjectList <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>