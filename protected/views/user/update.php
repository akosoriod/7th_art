<?php
/* @var $this UserController */
/* @var $model User */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
?>

<main class="admin_page" id="update_activity_set">
<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage User', 'url'=>array('admin')),
);*/
?>

<div id="container">
        <div id="activitySets" class="section">
            <h3 class="section_title">Actualizar Administrador/Operador: <?php print $model->id; ?></h3>
            <div class="buttons">
                <?php echo CHtml::link("Volver al inicio", array('/activitySet/admin')); ?>
            </div>
            <div class="data">
				<?php print $this->renderPartial('_form_update', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</main>