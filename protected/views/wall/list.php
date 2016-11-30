<?php
// list.php
// Lista los comentarios publicados por los usuarios en el Wall.

$model = new Comment;

// Ref: http://www.tomdeater.com/jquery/character_counter/
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.charcounter.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/walltest.js');
?>

<div class="errorMessage" id="formResult" name="formResult"></div>

<?php
// Ref: http://demo.bsourcecode.com/yiiframework/cjuitabs
// Ref: http://stackoverflow.com/questions/9584916/ajax-tab-in-zii-tab-widget

$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs' => array(
        'Forum' => array('content' => '', 'id' => 'tabForum', 'title'=> 'Title'),
        'Comments and Suggestions' => array('content' => '', 'id' => 'tabCAS'),
    ),
    // additional javascript options for the tabs plugin
    'options' => array(
        'collapsible' => false,
        'selected' => isset(Yii::app()->session['tabid']) ? Yii::app()->session['tabid'] : 0,
        'select' => 'js:selectTab	
				
		',
        'activate' => 'js:function(event, ui) {	
				$("#formResult").html("");
		}',
    ),
    'id' => 'Tab-Menu-Wall',
));
?>

<div id="divFormCreateComment" class="section">
    <div class="form">
        <div class=""> 
            <textarea id="taComment" rows="2" class="form-control" placeholder="Write a comment..."></textarea>
        </div>

    </div><!-- form -->
<!--    <div class="text-right">
        <button id="btnCrearComentario2" class="btn btn-success">Post comment</button>
    </div>-->

</div>
<script type='text/javascript'>
    $(document).ready(function () {
        $("#taComment").charCounter(140, {
            format: "%1 symbols left!"
        });
    });
</script>