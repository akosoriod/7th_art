<?php
// list.php
// Lista los comentarios publicados por los usuarios en el Wall.

$model = new Comment;

// Ref: http://www.tomdeater.com/jquery/character_counter/
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.charcounter.js');
?>

<div class="errorMessage" id="formResult" name="formResult"></div>

<?php
// Ref: http://demo.bsourcecode.com/yiiframework/cjuitabs
// Ref: http://stackoverflow.com/questions/9584916/ajax-tab-in-zii-tab-widget

$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
		'Recording'=>array('id'=>'tabRecording','ajax'=>$this->createUrl('comment/showCommentsOnTab',array('tab'=>Category::RECORDING))),
		'Writing'=>array('id'=>'tabWriting','ajax'=>$this->createUrl('comment/showCommentsOnTab',array('tab'=>Category::WRITING))),
		'Grammar'=>array('id'=>'tabGrammar','ajax'=>$this->createUrl('comment/showCommentsOnTab',array('tab'=>Category::GRAMMAR))),
		'Comments and Suggestions'=>array('id'=>'tabComAndSug','ajax'=>$this->createUrl('comment/showCommentsOnTab',array('tab'=>Category::COMMENTSANDSUGGESTIONS)))
    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>true,
		'selected'=>isset(Yii::app()->session['tabid'])?Yii::app()->session['tabid']:0,
		'select'=>'js:function(event, ui) {	
				var index=ui.index;
				$.ajax({
					"url":"'.Yii::app()->createUrl('comment/tabidsession').'",
					"data":"tab="+index,
				});
		}',
		'activate'=>'js:function(event, ui) {	
				$("#formResult").html("");
		}',
    ),
    'id'=>'Tab-Menu-Wall',
));
?>

<div id="divFormCreateComment" class="section">
	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'wall-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
	)); ?>

		<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

		<?php echo $form->errorSummary($model); ?>

		<div class="field">
			<?php echo $form->labelEx($model,'comment'); ?>
			<?php echo $form->textArea($model,'comment',array('rows'=>2, 'cols'=>55, 'style' => 'resize:none; word-wrap:break-word;', 'id'=>'taComment')); ?>
			<?php echo $form->error($model,'comment'); ?>
		</div>

		<div class="buttons">
			<?php //Ref: http://stackoverflow.com/questions/6348581/yii-ajaxsubmitbutton-with-fields-validation ?>
			<?php echo CHtml::ajaxSubmitButton('Crear Comentario',
									CHtml::normalizeUrl(array('comment/create')),
									array('type'=>'POST',
											'dataType'=>'json',
											'success'=>'function(data) {
												if(data.status=="success"){
													$("#formResult").html("Tu comentario se ha registrado.");
													$("#wall-form")[0].reset();
												} else if (data.status=="error") {
													$("#formResult").html("Tu comentario no se ha registrado.");
												} else{
													$.each(data, function(key, val) {
														$("#wall-form #"+key+"_em_").text(val);
														$("#wall-form #"+key+"_em_").show();
													});
												}
											}',
											'beforeSend' => "function(request) {
												// load your image here
											}",
											'complete' => "function(request) {
												// remove your image here
											}",
											'error' => "function(data) {
												// handle return data
												alert('error: '+data);
											}",
											'update' => '#formResult'
									),
									array('id' => 'btnCrearComentario', 'class' => 'btn btn-success')
								);
			?>
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
</div>
<script type='text/javascript'>
$(document).ready(function() {
	$("#taComment").charCounter(140, {
			format: "%1 caracteres restantes!"
		});
});
</script>