<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
?>
<main class="admin_page" id="create_activity_set">
	<?php
	$this->breadcrumbs=array(
		'Faqs'=>array('index'),
		'Create',
	);
	
	/*$this->menu=array(
		array('label'=>'List Faq', 'url'=>array('index')),
		array('label'=>'Manage Faq', 'url'=>array('admin')),
	);*/
	?>
	<div id="container">
        <div id="activitySets" class="section">
            <h3 class="section_title">Crear Pregunta/Respuesta</h3>
            <div class="buttons">
                <?php echo CHtml::link("Volver al inicio", array('/activitySet/admin')); ?>
            </div>
            <div class="data">
				<?php print $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</main>