<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('secondsToCheck')); ?>:</b>
	<?php echo CHtml::encode($data->secondsToCheck); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person')); ?>:</b>
	<?php echo CHtml::encode($data->person); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fontSize')); ?>:</b>
	<?php echo CHtml::encode($data->fontSize); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('blackAndWhite')); ?>:</b>
	<?php echo CHtml::encode($data->blackAndWhite); ?>
	<br />


</div>