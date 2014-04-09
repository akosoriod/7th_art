<?php
/* @var $this PrizeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Prizes',
);

$this->menu=array(
	array('label'=>'Create Prize', 'url'=>array('create')),
	array('label'=>'Manage Prize', 'url'=>array('admin')),
);
?>

<h1>Prizes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
