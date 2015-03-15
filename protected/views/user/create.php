<?php
/* @var $this UserController */
/* @var $model User */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
?>
<main class="admin_page" id="create_activity_set">
	<?php
	$this->breadcrumbs=array(
		'Users'=>array('index'),
		'Create',
	);
	
	/*$this->menu=array(
		array('label'=>'List User', 'url'=>array('index')),
		array('label'=>'Manage User', 'url'=>array('admin')),
	);*/
	?>
	<div id="container">
        <div id="users" class="section">
            <h3 class="section_title">Crear Administrador/Operador</h3>
            <div class="buttons">
                <?php echo CHtml::link("Volver al inicio", array('/activitySet/admin')); ?>
            </div>
            <div class="data">
				<?php $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</main>