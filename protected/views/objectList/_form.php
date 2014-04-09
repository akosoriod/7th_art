<?php
/* @var $this ObjectListController */
/* @var $model ObjectList */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'object-list-form',
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
		<?php echo $form->labelEx($model,'static'); ?>
		<?php echo $form->textField($model,'static'); ?>
		<?php echo $form->error($model,'static'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'connected'); ?>
		<?php echo $form->textField($model,'connected'); ?>
		<?php echo $form->error($model,'connected'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exercise'); ?>
		<?php echo $form->textField($model,'exercise'); ?>
		<?php echo $form->error($model,'exercise'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->