<?php
/* @var $this StepAnswerController */
/* @var $data StepAnswer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('step')); ?>:</b>
	<?php echo CHtml::encode($data->step); ?>
	<br />


</div>