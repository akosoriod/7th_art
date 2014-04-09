<?php
/* @var $this FileTypeController */
/* @var $data FileType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extension')); ?>:</b>
	<?php echo CHtml::encode($data->extension); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mime')); ?>:</b>
	<?php echo CHtml::encode($data->mime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('maxSize')); ?>:</b>
	<?php echo CHtml::encode($data->maxSize); ?>
	<br />


</div>