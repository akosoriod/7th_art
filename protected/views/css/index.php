<?php
/* @var $this CssController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Csses',
);

$this->menu=array(
	array('label'=>'Create CSS', 'url'=>array('create')),
	array('label'=>'Manage CSS', 'url'=>array('admin')),
);
?>

<h1>Csses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
