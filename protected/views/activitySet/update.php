<?php
/* @var $this ActivitySetController */
/* @var $model ActivitySet */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
?>
<main class="admin_page" id="update_activity_set">
    <?php
    $this->breadcrumbs=array(
        'Activity Sets'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
    );
    ?>
    <div id="container">
        <div id="activitySets" class="section">
            <h3 class="section_title">Actualizando Set de Actividades: <?php echo $model->title; ?></h3>
            <div class="buttons">
                <?php echo CHtml::link("Volver al inicio", array('admin')); ?>
            </div>
            <div class="data">
                <?php $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</main>