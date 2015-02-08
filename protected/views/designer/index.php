<?php
/* @var $this DesignerController */
/* @var $activitySet ActivitySet */

$this->breadcrumbs=array(
	'Designer',
);


Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/editor.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/colorpicker/spectrum.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/tabelizer/tabelizer.min.css');
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/colorpicker/spectrum.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/tinymce/jquery.tinymce.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/tabelizer/jquery.tabelizer.min.js');
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
            <div class="activityset_name">
                <?php echo $activitySet->title; ?>
            </div>
            <div class="activityset_sections">
                <table id="sections_tree" class="controller">
                    <?php
                        $letter="a";
                        foreach ($activitySet->sections as $section) {
                            echo '<tr data-level="1" id="level_1_'.$letter.'"><td>'.$section->sectionType->label.'</td></tr>';
                            foreach ($section->versions as $version) {
                                echo '<tr data-level="2" id="level_2_'.$letter.'"><td>'.$version->name.'</td></tr>';
                                $count=0;
                                foreach ($version->activities as $activity) {
                                    $count++;
                                    echo '<tr data-level="3" id="level_3_'.$letter.'"><td>Actividad '.$count.'</td></tr>';
                                    $countSteps=0;
                                    foreach ($activity->steps as $step) {
                                        $countSteps++;
                                        echo '<tr class="step" data-level="4" id="level_4_'.$letter.'" '
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
                                        .'><td>Paso '.$countSteps.'</td></tr>';
                                    }
                                }
                            }
                            $letter++;
                        }
                    ?> 
                </table>
            </div>
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
                        <span id="message"><?php echo $activitySet->title; ?></span>
                    </div>
                    <div id="states_bar">
                        <div class="state_button state_selected" id="state_passive" title="Ver ejercicio en estado pasivo" data-state="passive">P</div>
                        <div class="state_button" id="state_active" title="Ver ejercicio en estado activo" data-state="active">A</div>
                        <div class="state_button" id="state_solved" title="Ver ejercicio en estado resuelto" data-state="solved">R</div>
                        <div class="state_button" id="state_right" title="Ver ejercicio en estado correcto" data-state="right">C</div>
                        <div class="state_button" id="state_wrong" title="Ver ejercicio en estado incorrecto" data-state="wrong">I</div>
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
                        <div class="action_buttons">
                            <div class="action_button copy_passive" title="Copiar el contenido del estado pasivo a los demás estados">Replicar contenido del estado pasivo</div>
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