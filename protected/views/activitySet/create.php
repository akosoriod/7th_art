<?php
/* @var $this ActivitySetController */
/* @var $model ActivitySet */
?>


<main class="detalle">
    <?php
    $this->breadcrumbs=array(
            'Activity Sets'=>array('index'),
            'Create',
    );

    $this->menu=array(
            array('label'=>'List ActivitySet', 'url'=>array('index'))
    );
    ?>
    
    <h2>7th @rt Designer</h2>
    <h1>Create ActivitySet</h1>
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</main>