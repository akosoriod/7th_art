<?php
/* @var $this ActivitySetController */
/* @var $model ActivitySet */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/administrator.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/parallax/jquery.parallax.min.js');
?>
<script>
    $( document ).ready(function(){
        $('.parallax-layer').parallax({
            mouseport: $(".parallax"),
            yparallax:false,
            xorigin: 'center'
        });
    });
</script>
<main id="admin_view_page" class="admin_page">
    <?php
    $this->breadcrumbs=array(
	'Activity Sets'=>array('index'),
	$model->title,
    );
    ?>
    <div id="container">
        <div id="activitySets" class="section">
            <h1><?php echo $model->title; ?></h1>
            <div class="buttons">
                <?php echo CHtml::link("Volver", array('admin')); ?> - 
                <?php echo CHtml::link("Editar", array('update','id'=>$model->id)); ?>
            </div>
        </div>
        <div id="activitySets" class="section">
            <div class="field">
                <label for="title">Título</label>
                <div id="title" class="value"><?php echo $model->title; ?></div>
            </div>
            <div class="field">
                <label for="status">Estado</label>
                <div id="status" class="value"><?php echo $model->status->name; ?></div>
            </div>
            <div class="field">
                <label for="tagline">Tagline</label>
                <div id="tagline" class="value"><?php echo $model->tagline; ?></div>
            </div>
            <div class="field">
                <label for="director">Director</label>
                <div id="director" class="value"><?php echo $model->director; ?></div>
            </div>
            <div class="field">
                <label for="year">Año</label>
                <div id="year" class="value"><?php echo $model->year; ?></div>
            </div>
            <div class="field">
                <label for="operator">Operador</label>
                <div id="operator" class="value"><?php echo $model->operator->name.' '.$model->operator->lastname; ?></div>
            </div>
        </div>
        
        <div id="multimedia" class="section">
            <h3>Multimedia</h3>
            <div class="media">
                <h4>Soundtrack</h4>
                <div class='soundtrack'>
                    <audio controls>
                        <source src="<?php echo Yii::app()->baseUrl.'/'.$model->soundtrack.'?'.rand(1,1000000); ?>" type="audio/ogg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
            <div class="media">
                <h4>Póster</h4>
                <div class='poster'>
                <?php
                    echo CHtml::image(Yii::app()->baseUrl.'/'.$model->poster.'?'.rand(1,1000000),"Póster");
                ?>
                </div>
            </div>
            <div class="media">
                <h4>Fondo</h4>
                <div class='fondo'>
                <?php
                    echo CHtml::image(Yii::app()->baseUrl.'/'.$model->background.'?'.rand(1,1000000),"Fondo");
                ?>
                </div>
            </div>
            <div class="media">
                <h4>Parallax</h4>
                <div class='parallax'>
                    <div class="parallax-layer" style="width:693px; height:200px;">
                        <?php echo CHtml::image(Yii::app()->baseUrl.'/'.$model->paralax_1.'?'.rand(1,1000000),"Paralax 1",array("id"=>"parallax1")); ?>
                    </div>
                    <div class="parallax-layer" style="width:1100px; height:200px;">
                        <?php echo CHtml::image(Yii::app()->baseUrl.'/'.$model->paralax_2.'?'.rand(1,1000000),"Paralax 2",array("id"=>"parallax2")); ?>
                    </div>
                    <div class="parallax-layer" style="width:1360px; height:200px;">
                        <?php echo CHtml::image(Yii::app()->baseUrl.'/'.$model->paralax_3.'?'.rand(1,1000000),"Paralax 3",array("id"=>"parallax3")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>