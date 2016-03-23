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
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/uploader/uploader.css');
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/colorpicker/spectrum.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/tinymce/jquery.tinymce.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/tabelizer/jquery.tabelizer.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/uploader/uploader.js');
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
<main id="editor_page" class="editor_main_space" data-last-step-id="<?php echo User::getCurrentUser()->last_step_id; ?>" data-activity-set-name="<?php echo $activitySet->name; ?>">
    <?php
    $this->breadcrumbs=array(
	'Activity Sets',
    );
    ?>
    <div id="container">
        <nav id="navigation">
            <div id="ql_activity_set_title" class="activityset_name activity_set_title">
                <?php echo $activitySet->title; ?>
            </div>
            <div class="activityset_sections">
                <table id="sections_tree" class="controller">
                    <?php
                        $letter="a";
                        foreach ($activitySet->sections as $section) {
                            echo '<tr class="section" data-level="1" id="level_1_'.$letter.'" data-section-id="'.$section->id.'"><td>'.$section->sectionType->label.'</td></tr>';
                            foreach ($section->versions as $version) {
                                echo '<tr class="version" data-level="2" id="level_2_'.$letter.'" data-version-id="'.$version->id.'"><td>'.$version->name.'</td></tr>';
                                $count=0;
                                foreach ($version->activities as $activity) {
                                    $count++;
                                    echo '<tr class="activity" data-activity-id="'.$activity->id.'" data-level="3" id="level_3_'.$letter.'"><td><div class="name">Actividad '.$count.'</div><div class="navbutton add_step" title="Agregar un paso">+</div></td></tr>';
                                    $countSteps=0;
                                    foreach ($activity->steps as $step) {
                                        $countSteps++;
                                        echo '<tr class="step" data-level="4" id="level_4_'.$letter.'" '
                                            . 'data-step-id="'.$step->id.'" '
                                            . 'data-step-name="'.$step->name.'" '
                                            . 'data-activity-id="'.$activity->id.'" '
                                            . 'data-activity-name="Actividad '.$count.'" '
                                            . 'data-version-id="'.$version->id.'" '
                                            . 'data-version-name="'.$version->name.'" '
                                            . 'data-section-id="'.$section->id.'" '
                                            . 'data-section-name="'.$section->sectionType->label.'" '
                                            . 'data-activity-set-id="'.$activitySet->id.'" '
                                            . 'data-activity-set-title="'.$activitySet->title.'" '
                                            . 'data-instruction="'.$step->instruction.'" '
                                        .'><td><div class="name">'.$step->name.'</div><div class="navbutton instruction" title="Cambiar la instrucción de este paso">i</div><div class="navbutton delete" title="Eliminar este paso">x</div></td></tr>';
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
<!--                    <div class="button button-config pointer" title="Configurar set de actividades"></div>
                    <div class="separator"></div>-->
                    <div class="button button-basic" title="Entidad"></div>
                    <div class="button button-dragdrop" title="Entidad drag and drop"></div>
                    <div class="button button-list" title="Entidad de listas ordenables"></div>
                    <div class="button button-audio" title="Entidad de audio"></div>
                    <div class="button button-record" title="Entidad de grabación"></div>
                    <div class="button button-style" title="Entidad de hoja de estilos (CSS)"></div>
                    <div class="button button-script" title="Entidad de scripts (JS)"></div>
                    <div class="button button-check" title="Entidad Calificar"></div>
                    <div class="button button-answers" title="Entidad Ver respuestas"></div>
                    <div class="separator"></div>
                    <div class="button" title="Cambiar el ajuste a la grilla">
                        <input id="toggle_snap" type="checkbox" checked><label for="toggle_snap" id="label_toggle_snap">Ajuste a la grilla</label>
                    </div>
                    <div class="separator"></div>
                    <div class="button undo pointer" id="button-undo" title="Deshacer"></div>
                    <div class="button pointer" id="save" title="Guardar actividad"></div>
                    <div id="editing_path">
                        <span id="message"><?php echo $activitySet->title; ?></span>
                    </div>
                    <div id="states_bar">
                        <div class="state_button state_selected" id="state_passive" title="Ver ejercicio en estado pasivo" data-state="passive">P</div>
<!--                        <div class="state_button" id="state_active" title="Ver ejercicio en estado activo" data-state="active">A</div>
                        <div class="state_button" id="state_solved" title="Ver ejercicio en estado resuelto" data-state="solved">R</div>-->
                        <div class="state_button" id="state_right" title="Ver ejercicio en estado correcto" data-state="right">C</div>
                        <div class="state_button" id="state_wrong" title="Ver ejercicio en estado incorrecto" data-state="wrong">I</div>
                    </div>
                </div>
                <div id="workspace" class="droppable yui3-cssreset"></div>
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
                            <button class="state_button passive selected" data-state="passive" title="Estado inicial de la entidad, como se mostrará antes de iniciar el ejercicio">Pasivo (por defecto)</button>
<!--                            <button class="state_button active" data-state="active" title="Como se verá cuando el estudiante esté modificando la entidad">Activo</button>
                            <button class="state_button solved" data-state="solved" title="Como se verá después de que el estudiante haya modificado la entidad">Resuelto</button>-->
                            <button class="state_button right" data-state="right" title="Como se verá si al verificar la respuesta es correcta">Correcto</button>
                            <button class="state_button wrong" data-state="wrong" title="Como se verá si al verificar la respuesta es incorrecta">Incorrecto</button>
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
                        <select class="selection" id="select-optional">
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
        
        <div id="list_elements" title="Cantidad de elementos en la lista">
            <p>Seleccione la cantidad de elementos en la lista ordenable</p>
            <select class="selection">
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
        </div>
    </div>
    
    <!--Div para almacenar temporalmente los contenidos de los estados e identificar los elementos-->
    <div id="elementsIdentificator"></div>
</main>