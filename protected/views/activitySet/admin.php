<?php
/* @var $this ActivitySetController */
/* @var $model ActivitySet */

$this->breadcrumbs=array(
	'Activity Sets'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ActivitySet', 'url'=>array('index')),
	array('label'=>'Create ActivitySet', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#activity-set-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Activity Sets</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'activity-set-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'status',
		'publication',
		'tagline',
		'director',
		/*
		'year',
		'operator',
		'soundtrack',
		'image',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
