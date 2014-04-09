<?php
/* @var $this SessionController */
/* @var $data Session */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sessionId')); ?>:</b>
	<?php echo CHtml::encode($data->sessionId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeIni')); ?>:</b>
	<?php echo CHtml::encode($data->timeIni); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timeEnd')); ?>:</b>
	<?php echo CHtml::encode($data->timeEnd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip')); ?>:</b>
	<?php echo CHtml::encode($data->ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person')); ?>:</b>
	<?php echo CHtml::encode($data->person); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activitySet')); ?>:</b>
	<?php echo CHtml::encode($data->activitySet); ?>
	<br />


</div>