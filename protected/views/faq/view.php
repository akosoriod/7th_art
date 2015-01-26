<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
?>

<main id="admin_view_page" class="admin_page">
	<?php
	$this->breadcrumbs=array(
		'Faqs'=>array('index'),
		$model->id,
	);

	/*$this->menu=array(
		array('label'=>'List Faq', 'url'=>array('index')),
		array('label'=>'Create Faq', 'url'=>array('create')),
		array('label'=>'Update Faq', 'url'=>array('update', 'id'=>$model->id)),
		array('label'=>'Delete Faq', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
		array('label'=>'Manage Faq', 'url'=>array('admin')),
	);
	*/
	?>	
	
	<div id="container">
        <div class="section">
            <h1>Ver Pregunta/Respuesta #<?php echo $model->id; ?></h1>
            <div class="buttons">
                <?php echo CHtml::link("Volver", array('/activitySet/admin')); ?> - 
                <?php echo CHtml::link("Editar", array('update','id'=>$model->id)); ?>
            </div>
        </div>
        <div class="section">
            <div class="field">
                <label for="question">Pregunta</label>
                <div id="question" class="value"><?php print $model->question; ?></div>
            </div>
            <div class="field">
                <label for="answer">Respuesta</label>
                <div id="answer" class="value"><?php echo $model->answer; ?></div>
            </div>
        </div>
	</div>
</main>