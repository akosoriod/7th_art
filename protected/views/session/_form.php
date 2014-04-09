<?php
/* @var $this SessionController */
/* @var $model Session */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'session-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sessionId'); ?>
		<?php echo $form->textField($model,'sessionId',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'sessionId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timeIni'); ?>
		<?php echo $form->textField($model,'timeIni'); ?>
		<?php echo $form->error($model,'timeIni'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timeEnd'); ?>
		<?php echo $form->textField($model,'timeEnd'); ?>
		<?php echo $form->error($model,'timeEnd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ip'); ?>
		<?php echo $form->textField($model,'ip',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'ip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'person'); ?>
		<?php echo $form->textField($model,'person'); ?>
		<?php echo $form->error($model,'person'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activitySet'); ?>
		<?php echo $form->textField($model,'activitySet'); ?>
		<?php echo $form->error($model,'activitySet'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->