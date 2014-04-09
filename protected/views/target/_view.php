<?php
/* @var $this TargetController */
/* @var $data Target */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('previousText')); ?>:</b>
	<?php echo CHtml::encode($data->previousText); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_div')); ?>:</b>
	<?php echo CHtml::encode($data->id_div); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exercise')); ?>:</b>
	<?php echo CHtml::encode($data->exercise); ?>
	<br />


</div>