<?php
/* @var $this AudioController */
/* @var $data Audio */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('path')); ?>:</b>
	<?php echo CHtml::encode($data->path); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('voicedBy')); ?>:</b>
	<?php echo CHtml::encode($data->voicedBy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fileType')); ?>:</b>
	<?php echo CHtml::encode($data->fileType); ?>
	<br />


</div>