<?php
/* @var $this DesignerController */
/* @var $activitySet ActivitySet */

$this->breadcrumbs=array(
	'Designer',
);


Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/editor.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/colorpicker/spectrum.css');
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/jqueryte/jquery-te-1.4.0.css');
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/colorpicker/spectrum.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/tinymce/jquery.tinymce.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/Objeto.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/Editor.js');
?>
<script type="text/javascript">

    $( document ).ready(function(){
        $(".site-url").empty().append('<div class="icon"> </div> 7 <sup>th</sup> @rt Designer');
        var appUrl="<?php echo Yii::app()->baseUrl."/"; ?>";
        var editor=new Editor({
            appUrl:appUrl
        });
        editor.init();

        var sections=$("#navigation").children("ul");
        sections.click(function(){
            alert("only a prototype");
        });
    });
</script>
<main id="editor_page">
    <?php
    $this->breadcrumbs=array(
	'Activity Sets',
    );
    ?>
    <div id="container">
        <nav id="navigation">
            <?php echo $activitySet->title; ?>
            <ul>
            <?php
                foreach ($activitySet->sections as $section) {
                    echo '<li>'.$section->sectionType->label;
                        echo '<ul>';
                            foreach ($section->versions as $version) {
                                echo '<li>'.$version->name.'</li>';
                                echo '<ul>';
                                    $count=0;
                                    foreach ($version->activities as $activity) {
                                        $count++;
                                        echo '<li>Actividad '.$count.'</li>';
                                        echo '<ul>';
                                            $countSteps=0;
                                            foreach ($activity->steps as $step) {
                                                $countSteps++;
                                                echo '<li>Paso '.$countSteps.'</li>';
                                            }
                                        echo '</ul>';
                                    }
                                echo '</ul>';
                            }
                        echo '</ul>';
                    echo '</li>';
                }
            ?> 
            </ul>
        </nav>
        <div id="area">
            <div id="editor">
                <div id="toolbar">
                    <div class="button object" id="button-object" title="Arrastrar un objeto"></div>
                    <div class="button" id="button-object-list" title="Arrastrar una lista de objetos"></div>
<!--                    <div class="button" id="button2" title="I'm a prototype"></div>
                    <div class="button" id="button3" title="I'm a prototype"></div>-->
                    <div class="button" id="save" title="Guardar actividad"></div>
                </div>
                <div id="workspace" class="droppable"></div>


                <div id="properties" title="Propiedades">
                    <form>
                        <fieldset>
                            <label for="id">Identificador</label>
                            <div name="id" id="id">0</div>
                            <label for="background">Fondo</label>
                            <input type="text" name="background" id="background" value="#000" class="text ui-widget-content ui-corner-all">
                            <br><br>
                            <label for="borders">Bordes</label>
                            <input type="text" name="borders" id="borders" value="#000" class="text ui-widget-content ui-corner-all">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>