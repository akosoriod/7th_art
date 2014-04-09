<?php
/* @var $this ObjectListController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Object Lists',
);

$this->menu=array(
	array('label'=>'Create ObjectList', 'url'=>array('create')),
	array('label'=>'Manage ObjectList', 'url'=>array('admin')),
);
?>

<h1>Object Lists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
