<?php
/* @var $this SectionTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Section Types',
);

$this->menu=array(
	array('label'=>'Create SectionType', 'url'=>array('create')),
	array('label'=>'Manage SectionType', 'url'=>array('admin')),
);
?>

<h1>Section Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
