<?php
/* @var $this ActivitySetController */
/* @var $data ActivitySet */
?>

<div class="activitySet">
        <div class='poster'>
        <?php
            echo CHtml::image(Yii::app()->baseUrl.'/'.$data->poster,"Póster");
        ?>
        </div>
        <br />
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('director')); ?>:</b>
	<?php echo CHtml::encode($data->director); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('year')); ?>:</b>
	<?php echo CHtml::encode($data->year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_id')); ?>:</b>
	<?php echo $data->statusSpanish(); ?>
	<br />

	<!--<b><?php // echo CHtml::encode($data->getAttributeLabel('publication')); ?>:</b>-->
	<?php // echo CHtml::encode($data->publication); ?>
	<!--<br />-->

	<!--<b><?php // echo CHtml::encode($data->getAttributeLabel('tagline')); ?>:</b>-->
	<?php // echo CHtml::encode($data->tagline); ?>
	<!--<br />-->

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('soundtrack_id')); ?>:</b>
	<?php echo CHtml::encode($data->soundtrack_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_id')); ?>:</b>
	<?php echo CHtml::encode($data->image_id); ?>
	<br />
        */ ?>
        
	<?php /* echo CHtml::encode($data->getAttributeLabel('operator_id')); ?>:</b>
	<?php echo CHtml::encode($data->operator->name." ".$data->operator->lastname); */ ?>
        
	<?php echo CHtml::link("Editar Datos Generales", array('activitySet/update','id'=>$data->id)); ?>
	<br />
	<?php echo CHtml::link("Editar Secciones", array('designer/index','activitySet'=>$data->name)); ?>
	<!-- <?php echo CHtml::link("Editar Set de Actividades", array('edit')); ?> -->
	<br />

</div>
