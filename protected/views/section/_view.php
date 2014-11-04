<?php
/* @var $this SectionController */
/* @var $data Section */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('section_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->section_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activity_set_id')); ?>:</b>
	<?php echo CHtml::encode($data->activity_set_id); ?>
	<br />


</div>