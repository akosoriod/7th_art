<?php
/* @var $this AdministratorController */
/* @var $data Administrator */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person')); ?>:</b>
	<?php echo CHtml::encode($data->person); ?>
	<br />


</div>