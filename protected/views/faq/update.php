<?php
/* @var $this FaqController */
/* @var $model FAQ */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FAQ', 'url'=>array('index')),
	array('label'=>'Create FAQ', 'url'=>array('create')),
	array('label'=>'View FAQ', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FAQ', 'url'=>array('admin')),
);
?>

<h1>Update FAQ <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>