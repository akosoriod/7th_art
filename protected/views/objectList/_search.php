<?php
/* @var $this ObjectListController */
/* @var $model ObjectList */
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
		<?php echo $form->label($model,'static'); ?>
		<?php echo $form->textField($model,'static'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'connected'); ?>
		<?php echo $form->textField($model,'connected'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'exercise'); ?>
		<?php echo $form->textField($model,'exercise'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->