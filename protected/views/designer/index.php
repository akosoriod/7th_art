<?php
/* @var $this DesignerController */

$this->breadcrumbs=array(
	'Designer',
);


Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/editor.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/colorpicker/spectrum.css');
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/colorpicker/spectrum.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/Editor.js');
?>
<script type="text/javascript">
            $( document ).ready(function(){
                $(".site-url").empty().append('<div class="icon"> </div> 7 <sup>th</sup> @rt Designer');
                
                
                var editor=new Editor();
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
            Perfume
            <ul>
                <li>                  
                    Film Credits
                </li>
                <li>
                    Film Activity Credits
                </li>
                <li>
                    Synopsis
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Pre-Viewing
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Who's Who in...?
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Film-Based
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Spidermap
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    After-Viewing
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    The Expert Says...
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Did you know that...?
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
                <li>
                    Acknoledgements
                    <ul>
                        <li>version 1</li>
                        <li>version 2</li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="area">
            <div id="editor">
                <div id="toolbar">
                    <div class="button object" id="button-object" title="Arrastrar un objeto"></div>
<!--                    <div class="button" id="button1" title="I'm a prototype"></div>
                    <div class="button" id="button2" title="I'm a prototype"></div>
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
                            <label for="borders">Bordes</label>
                            <input type="text" name="borders" id="borders" value="#000" class="text ui-widget-content ui-corner-all">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>