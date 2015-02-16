<?php
/* @var $this ActivitySetController */
/* @var $model ActivitySet */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'activity-set-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="field">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

        <?php 
            if(!$model->isNewRecord){
                echo '<div class="field">';
                echo $form->labelEx($model,'status');
                echo CHtml::dropDownList('status',$model->status_id,Status::model()->getStatusList());
		echo $form->error($model,'status');
                echo '</div>';
            }
        ?>

	<!--<div class="field">-->
		<?php // echo $form->labelEx($model,'publication'); ?>
		<?php // echo $form->textField($model,'publication',array('size'=>45,'maxlength'=>45)); ?>
		<?php // echo $form->error($model,'publication'); ?>
	<!--</div>-->

	<div class="field">
		<?php echo $form->labelEx($model,'tagline'); ?>
		<?php echo $form->textField($model,'tagline',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'tagline'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'director'); ?>
		<?php echo $form->textField($model,'director',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'director'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'year'); ?>
		<?php echo $form->textField($model,'year'); ?>
		<?php echo $form->error($model,'year'); ?>
	</div>
<!--
	<div class="field">
            <?php
                echo $form->labelEx($model, 'poster');
                echo $form->fileField($model, 'poster',array('accept'=>'image/*'));
                echo $form->error($model, 'poster');
            ?>
	</div>

	<div class="field">
            <?php
                echo $form->labelEx($model, 'background');
                echo $form->fileField($model, 'background',array('accept'=>'image/*'));
                echo $form->error($model, 'background');
            ?>
	</div>
	
        <div class="field">
            <?php
                echo $form->labelEx($model, 'paralax_1');
                echo $form->fileField($model, 'paralax_1',array('accept'=>'image/*'));
                echo $form->error($model, 'paralax_1');
            ?>
	</div>
	
        <div class="field">
            <?php
                echo $form->labelEx($model, 'paralax_2');
                echo $form->fileField($model, 'paralax_2',array('accept'=>'image/*'));
                echo $form->error($model, 'paralax_2');
            ?>
	</div>
	
        <div class="field">
            <?php
                echo $form->labelEx($model, 'paralax_3');
                echo $form->fileField($model, 'paralax_3',array('accept'=>'image/*'));
                echo $form->error($model, 'paralax_3');
            ?>
	</div>
        
        <div class="field">
		<?php echo $form->labelEx($model,'soundtrack'); ?>
                <?php echo CHtml::activeFileField($model, 'soundtrack',array('accept'=>'audio/*')); ?>
		<?php echo $form->error($model,'soundtrack'); ?>
	</div>
-->
        <div class="field">
            <?php echo $form->labelEx($model, 'operator_id'); ?>
            <?php echo $form->dropDownList($model, 'operator_id',User::model()->getUserSelect(2)); ?>
            <?php echo $form->error($model, 'operator_id'); ?>
        </div>

	<div class="field">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar',array("id"=>"saveButton")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->