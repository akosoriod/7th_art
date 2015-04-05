<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
if(isset($model->authAssignment->itemname)) {
	$selectedItem = $model->authAssignment->itemname;
} else {
	$selectedItem = 'operator';
}
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

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="field">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>
        
        <div class="field">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->dropDownList($model,'active',
			array('1'=>'Activo', '0'=>'Inactivo')
		); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="field">
		<?php echo $form->labelEx($model,'Rol'); ?>
		<?php echo CHtml::dropDownList('rol', 'rol', 
		   array('administrator'=>'Administrador', 'operator'=>'Operador'),
		   array('options' => array($selectedItem=>array('selected'=>true)))
		); ?>
		<?php echo $form->error($model,'Rol'); ?>
	</div>

	<div class="field">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->