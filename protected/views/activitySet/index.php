<?php
/* @var $this ActivitySetController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Activity Sets',
);

$this->menu=array(
	array('label'=>'Create ActivitySet', 'url'=>array('create'))
);
?>

<h1>Activity Sets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
