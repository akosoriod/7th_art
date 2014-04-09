<?php
/* @var $this StepController */
/* @var $data Step */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instruction')); ?>:</b>
	<?php echo CHtml::encode($data->instruction); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activity')); ?>:</b>
	<?php echo CHtml::encode($data->activity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('css')); ?>:</b>
	<?php echo CHtml::encode($data->css); ?>
	<br />


</div>