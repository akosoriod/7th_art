<?php
/* @var $this ActivitySetController */
/* @var $data ActivitySet */
?>


<div id="set_<?php echo $data->id; ?>" class="set">
    <!--El círculo del porcentaje se dibujará con JS-->
    <div class="total_percent" role="progressbar" data-goal="<?php echo round($data->percent(User::getCurrentUser())); ?>" >
        <div class="total_percent__number">0%</div>
    </div>
    <a href="<?php echo Yii::app()->request->baseUrl.'/index.php/activitySet/home/movie/'.$data->name; ?>">
        <div class="poster">
            <?php echo CHtml::image(Yii::app()->baseUrl.'/'.$data->poster,$data->title); ?>
        </div>
        <div class="info">
            <div class="attribute title"><?php echo $data->title; ?></div>
            <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
            <div class="attribute director hidden"><?php echo $data->director; ?></div>
            <div class="attribute year hidden"><?php echo $data->year; ?></div>
        </div>
    </a>
</div>