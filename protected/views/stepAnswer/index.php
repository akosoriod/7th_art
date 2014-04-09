<?php
/* @var $this StepAnswerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Step Answers',
);

$this->menu=array(
	array('label'=>'Create StepAnswer', 'url'=>array('create')),
	array('label'=>'Manage StepAnswer', 'url'=>array('admin')),
);
?>

<h1>Step Answers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
