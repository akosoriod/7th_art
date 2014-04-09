<?php
/* @var $this OperatorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Operators',
);

$this->menu=array(
	array('label'=>'Create Operator', 'url'=>array('create')),
	array('label'=>'Manage Operator', 'url'=>array('admin')),
);
?>

<h1>Operators</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
