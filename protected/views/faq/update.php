<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
?>
<main class="admin_page" id="update_activity_set">
    <?php
	$this->breadcrumbs=array(
		'Faqs'=>array('index'),
		$model->id=>array('view','id'=>$model->id),
		'Update',
	);

	/*$this->menu=array(
		array('label'=>'List Faq', 'url'=>array('index')),
		array('label'=>'Create Faq', 'url'=>array('create')),
		array('label'=>'View Faq', 'url'=>array('view', 'id'=>$model->id)),
		array('label'=>'Manage Faq', 'url'=>array('admin')),
	);*/
	?>

	<div id="container">
        <div id="activitySets" class="section">
            <h3 class="section_title">Actualizando Pregunta/Respuesta: <?php print $model->id; ?></h3>
            <div class="buttons">
                <?php echo CHtml::link("Volver al inicio", array('/activitySet/admin')); ?>
            </div>
            <div class="data">
				<?php print $this->renderPartial('_form', array('model'=>$model)); ?>
            </div>
        </div>
    </div>
</main>