<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'secondsToCheck'); ?>
		<?php echo $form->textField($model,'secondsToCheck'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'person'); ?>
		<?php echo $form->textField($model,'person'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fontSize'); ?>
		<?php echo $form->textField($model,'fontSize'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'blackAndWhite'); ?>
		<?php echo $form->textField($model,'blackAndWhite'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->