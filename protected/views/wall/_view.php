<div class="view wall">

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user->name).' '.CHtml::encode($data->user->lastname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

</div>
<br />