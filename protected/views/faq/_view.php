<div class="view faq">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('/faq/view', 'id'=>$data->id)); ?>
	<br />

	<b>
	<?php
	print CHtml::link(
				'Borrar',
				'#',
				array('submit'=>array('/faq/delete','id'=>$data->id),
					'confirm' => 'Desea borrar este registro?')
			);
	?>
	</b>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question')); ?>:</b>
	<?php echo CHtml::encode($data->question); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer')); ?>:</b>
	<?php echo CHtml::encode($data->answer); ?>
	<br />


</div>
<br />