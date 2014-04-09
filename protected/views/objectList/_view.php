<?php
/* @var $this ObjectListController */
/* @var $data ObjectList */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('static')); ?>:</b>
	<?php echo CHtml::encode($data->static); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('connected')); ?>:</b>
	<?php echo CHtml::encode($data->connected); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exercise')); ?>:</b>
	<?php echo CHtml::encode($data->exercise); ?>
	<br />


</div>