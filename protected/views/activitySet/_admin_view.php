<?php
/* @var $this ActivitySetController */
/* @var $data ActivitySet */
?>

<div class="activitySet">
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php echo $data->statusSpanish(); ?>
	<br />

	<!--<b><?php // echo CHtml::encode($data->getAttributeLabel('publication')); ?>:</b>-->
	<?php // echo CHtml::encode($data->publication); ?>
	<!--<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('tagline')); ?>:</b>
	<?php echo CHtml::encode($data->tagline); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('director')); ?>:</b>
	<?php echo CHtml::encode($data->director); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('year')); ?>:</b>
	<?php echo CHtml::encode($data->year); ?>
	<br />
        
        

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('soundtrack_id')); ?>:</b>
	<?php echo CHtml::encode($data->soundtrack_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_id')); ?>:</b>
	<?php echo CHtml::encode($data->image_id); ?>
	<br />
        */ ?>
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('operator_id')); ?>:</b>
	<?php echo CHtml::encode($data->operator->name." ".$data->operator->lastname); ?>
	<br />

	

</div>