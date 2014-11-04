<?php
/* @var $this ActivitySetController */
$this->breadcrumbs=array(
	'Administrador',
);


//Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/colorpicker/spectrum.css');
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/jqueryte/jquery-te-1.4.0.css');
//Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/colorpicker/spectrum.js');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/tinymce/jquery.tinymce.min.js');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/Objeto.js');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/Editor.js');
?>
<script type="text/javascript">
    $( document ).ready(function(){
//        $(".site-url").empty().append('<div class="icon"> </div> 7 <sup>th</sup> @rt Administator');
        var appUrl="<?php // echo Yii::app()->baseUrl."/"; ?>";
//        var editor=new Editor({
//            appUrl:appUrl
//        });
//        editor.init();
//
//        var sections=$("#navigation").children("ul");
//        sections.click(function(){
//            alert("only a prototype");
//        });
    });
</script>
<main id="admin_page" class="admin_page">
    <?php
    $this->breadcrumbs=array(
	'Activity Sets',
    );
    ?>
    <div id="container">
        
        
        
        <div id="activitySets">
            <h3>Sets de actividades</h3>
            <div id="list">
                <?php
                    foreach ($activitySets as $activitySet) {
                        $this->renderPartial('_admin_view',array('data'=>$activitySet));
                    }
                ?>
            </div>
        </div>
    </div>
</main>