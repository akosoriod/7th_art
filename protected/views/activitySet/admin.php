<?php
/* @var $this ActivitySetController */
/* @var $activitySets ActivitySet */
/* @var $currentUser User */
/* @var $users User */
$this->breadcrumbs=array(
	'Administrador',
);

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/admin/admin.js');
?>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $( document ).ready(function(){
//        $(".site-url").empty().append('<div class="icon"> </div> 7 <sup>th</sup> @rt Administator');
        var appUrl="<?php // echo Yii::app()->baseUrl."/"; ?>";
        $( function() {
            $( "#container" ).tabs();
        } );
    });
</script>
<main id="admin_page" class="admin_page">
    <?php
    $this->breadcrumbs=array(
	'Activity Sets',
    );
    ?>
    <div id="container">
        <ul>
            <li><a href="#activitySets">Sets de actividades</a></li>
            <li><a href="#users">Administradores y Operadores</a></li>
            <li><a href="#settings">Ajustes Generales</a></li>
            <li><a href="#faq">Preguntas Frecuentes</a></li>
        </ul> 
        <div id="activitySets" class="section">
            <h3 class="section_title">Sets de actividades</h3>
            <div class="buttons">
                <?php echo CHtml::link("Crear Set de Actividades", array('create')); ?>
            </div>
            <div class="list">
                <?php
                    foreach ($activitySets as $activitySet) {
                        $this->renderPartial('_admin_view',array('data'=>$activitySet));
                    }
                ?>
            </div>
        </div>
        <div id="users" class="section">
            <h3 class="section_title">Administradores y Operadores</h3>
            <div class="buttons">
                <?php echo CHtml::link("Crear Administrador/Operador", array('/user/create')); ?>
            </div>
            <div>&nbsp;</div>
            <div class="list">
                <?php
                    foreach ($users as $user) {
                        if($currentUser->id!=$user->id&&$user->roles[0]->name!="user"){
                            $this->renderPartial('/user/_view',array('data'=>$user));
                        }
                    }
                ?>
            </div>
        </div>
        <!-- Preguntas Frecuentes -->
        <div id="settings" class="section">
            <div class="panel panel-default">
                <div class="panel-heading">Opciones del Wall</div>
                <div class="panel-body">
                    <h4>Última fecha de restauración: <span id="clear-wall-date">13 Nov 2016</span></h4> 
                    <div class="text-right">
                        <button id="clear-wall" type="button" class="btn btn-default">Limpiar Comentarios del Wall</button>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- Preguntas Frecuentes -->
        <div id="faq" class="section">
            <h3 class="section_title">Preguntas Frecuentes</h3>
            <div class="buttons">
                <?php echo CHtml::link("Crear Pregunta/Respuesta", array('/faq/create')); ?>
            </div>
            <div>&nbsp;</div>
            <div class="list">
                <?php
                    foreach ($faqs as $faq) {
                        $this->renderPartial('/faq/_view',array('data'=>$faq));
                    }
                ?>
            </div>
        </div>
    </div>
</main>