<?php
/* @var $this AnswerController */
/* @var $data Answer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
	<?php echo CHtml::encode($data->text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('correct')); ?>:</b>
	<?php echo CHtml::encode($data->correct); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('defaultText')); ?>:</b>
	<?php echo CHtml::encode($data->defaultText); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exercise')); ?>:</b>
	<?php echo CHtml::encode($data->exercise); ?>
	<br />


</div>