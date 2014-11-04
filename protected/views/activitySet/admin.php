<?php
/* @var $this ActivitySetController */
/* @var $activitySets ActivitySet */
/* @var $currentUser User */
/* @var $users User */
$this->breadcrumbs=array(
	'Administrador',
);

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
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
    </div>
</main>