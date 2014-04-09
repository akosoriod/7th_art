<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
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
		<?php echo $form->labelEx($model,'secondsToCheck'); ?>
		<?php echo $form->textField($model,'secondsToCheck'); ?>
		<?php echo $form->error($model,'secondsToCheck'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'person'); ?>
		<?php echo $form->textField($model,'person'); ?>
		<?php echo $form->error($model,'person'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fontSize'); ?>
		<?php echo $form->textField($model,'fontSize'); ?>
		<?php echo $form->error($model,'fontSize'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'blackAndWhite'); ?>
		<?php echo $form->textField($model,'blackAndWhite'); ?>
		<?php echo $form->error($model,'blackAndWhite'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->