<?php
/* @var $this SessionController */
/* @var $model Session */
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
		<?php echo $form->label($model,'sessionId'); ?>
		<?php echo $form->textField($model,'sessionId',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'timeIni'); ?>
		<?php echo $form->textField($model,'timeIni'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'timeEnd'); ?>
		<?php echo $form->textField($model,'timeEnd'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ip'); ?>
		<?php echo $form->textField($model,'ip',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'person'); ?>
		<?php echo $form->textField($model,'person'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'activitySet'); ?>
		<?php echo $form->textField($model,'activitySet'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->