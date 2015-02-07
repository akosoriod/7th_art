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
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/State.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/Entity.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/Workspace.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/Editor.js');
?>
<script type="text/javascript">

    $( document ).ready(function(){
        $(".site-url").empty().append('<div class="icon"> </div> 7 <sup>th</sup> @rt Designer');
        var appUrl="<?php echo Yii::app()->baseUrl."/"; ?>";
        window.editor=new Editor({
            appUrl:appUrl
        });
        editor.init();
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
                                                echo '<li class="step" '
                                                    . 'data-step-id="'.$step->id.'" '
                                                    . 'data-step-name="Paso '.$countSteps.'" '
                                                    . 'data-activity-id="'.$activity->id.'" '
                                                    . 'data-activity-name="Actividad '.$count.'" '
                                                    . 'data-version-id="'.$version->id.'" '
                                                    . 'data-version-name="'.$version->name.'" '
                                                    . 'data-section-id="'.$section->id.'" '
                                                    . 'data-section-name="'.$section->sectionType->label.'" '
                                                    . 'data-activity-set-id="'.$activitySet->id.'" '
                                                    . 'data-activity-set-title="'.$activitySet->title.'" '
                                                .'>Paso '.$countSteps.'</li>';
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
                    <div class="button single" id="button-entity" title="Arrastrar una entidad"></div>
                    <!--<div class="button" id="button-entity-list" title="Arrastrar una lista de entidades"></div>-->
                    <div class="button true_false" id="button-true-false" title="True-False"></div>
                    <div class="button fill" id="button-fill" title="Llenar"></div>
                    <div class="button multi-single" id="button-multi-single" title="Opción Múltiple, única respuesta"></div>
                    <div class="button multi-multi" id="button-multi-multi" title="Opción Múltiple, múltiple respuesta"></div>
                    <!--<div class="button redo" id="button-redo" title="Rehacer"></div> TODO: Arreglar el comportamiento de redo-->
                    <div class="button undo" id="button-undo" title="Deshacer"></div>
                    <div class="button" id="save" title="Guardar actividad"></div>
                    <div id="editing_path">
                        Editando: <span id="message"><?php echo $activitySet->title; ?></span>
                    </div>
                </div>
                <div id="workspace" class="droppable"></div>


<!--                <div id="properties" title="Propiedades">
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
                </div>-->
            </div>
        </div>
    </div>
    
    
    
    <div id="dialogs">
        <div id="edit_entity" title="Editando entidad">
            <div id="tabs">
                <ul>
                    <li><a href="#design">Diseño</a></li>
                    <li><a href="#options">Opciones</a></li>
                </ul>
                <div id="design">
                    <div class="navigator">
                        <div class="state_buttons">
                            <div class="state_button passive selected" data-state="passive" title="Estado inicial de la entidad, como se mostrará antes de iniciar el ejercicio">Pasivo (por defecto)</div>
                            <div class="state_button active" data-state="active" title="Como se verá cuando el estudiante esté modificando la entidad">Activo</div>
                            <div class="state_button solved" data-state="solved" title="Como se verá después de que el estudiante haya modificado la entidad">Resuelto</div>
                            <div class="state_button right" data-state="right" title="Como se verá si al verificar la respuesta es correcta">Correcto</div>
                            <div class="state_button wrong" data-state="wrong" title="Como se verá si al verificar la respuesta es incorrecta">Incorrecto</div>
                        </div>
                    </div>
                    <div class="state_container"></div>
                </div>
                <div id="options">
                    <div class="field">
                        <div class="title">¿Es obligatorio resolver?</div>
                        <div class="description">Indica si el estudiante debe dar una respuesta para el ejercicio o si puede terminar sin resolver.</div>
                        <select class="selection">
                            <option value="true">Es obligatorio resolver</option>
                            <option value="false">No es obligatorio resolver</option>
                        </select>
                    </div>
                    <div class="field">
                        <div class="title">¿Contar en los resultados?</div>
                        <div class="description">Permite que una entidad se cuente dentro de los resultados del ejercicio.</div>
                        <select class="selection">
                            <option value="true">Contar dentro del cálculo de resultados</option>
                            <option value="false">No contar dentro del cálculo de resultados</option>
                        </select>
                    </div>
                    <div class="field">
                        <div class="title">Peso en el ejercicio</div>
                        <div class="description">Define cuanta importancia tiene una entidad en la solución del ejercicio. Un mayor número denota mayor importancia.</div>
                        <select class="selection">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>