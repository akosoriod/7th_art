<?php
/* @var $this ActivitySetController */
/* @var $model ActivitySet */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
?>


<main class="admin_page create_activity_set">
    <?php
    $this->breadcrumbs=array(
            'Activity Sets'=>array('index'),
            'Create',
    );

//    $this->menu=array(
//            array('label'=>'List ActivitySet', 'url'=>array('index'))
//    );
    ?>
    
    <div id="container">
        <div id="activitySets" class="section">
            <h3 class="section_title">Crear Set de Actividades</h3>
            <div class="buttons">
                <?php echo CHtml::link("Volver al inicio", array('admin')); ?>
            </div>
            <div class="list">
                <?php $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</main>