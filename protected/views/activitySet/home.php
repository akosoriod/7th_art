<?php
/* @var $this ActivitySetController */
/* @var $model ActivitySet */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/7th_art.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/activities.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/dropit/dropit.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/ActivitySet.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/dropit/dropit.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/parallax/jquery.parallax.min.js');
?>
<script>
    $(document).ready(function($) {
        //Instrucción de la plantilla de la UNAL
        $('select', 'form').selectpicker();

        //Prueba del parallax
        $('.parallax-layer').parallax({
            mouseport: $("#parallax"),
            yparallax:false,
            xorigin: 'center'
        });
        
        $('body').css({
            'background': 'url("<?php echo Yii::app()->request->baseUrl.'/'.$model->background.'?'.rand(1,1000000); ?>") repeat scroll center top transparent'
        });
        
        $('body').addClass('not-front page-set movie-perfume not-logged fullpage row-offcanvas row-offcanvas-right');
        
        var activitySet=new ActivitySet();
        activitySet.init();
    });
</script>
<main id="activity_set_home" class="detalle">
    <div class="breadcrumb-class">
        Está en:&nbsp;<a href="<?php echo Yii::app()->request->baseUrl; ?>" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/&nbsp;&nbsp;<b><?php echo $model->title; ?></b>
    </div>
    <div class="row row1">
        <div id="lbl_set" class="col-xs-12 col-sm-12 col-md-8">
            <h2><?php echo $model->title; ?></h2>
            <audio autoplay loop>
                <source src="<?php echo Yii::app()->baseUrl.'/'.$model->soundtrack.'?'.rand(1,1000000); ?>" type="audio/ogg">
                Your browser does not support the audio element.
            </audio>
        </div>
        <div id="credits-movies" class="col-xs-12 col-sm-12 col-md-4">
            <img src="" alt="" />
            <span><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/copyright.png" height="15" width="15"> Credits</a></span>
        </div>
    </div>
    <div class="row row2">
        <div id="menu-movies" class="col-xs-12 col-sm-12 col-md-12">
            <?php
                foreach ($model->sections as $section){
                    $publishedVersion=$section->publishedVersion();
                    if($publishedVersion){
                        if(count($publishedVersion->activities)===1){
                            echo '<a id="mnu_'.$section->sectionType->name.'" class="mnu_button" href="'.Yii::app()->request->baseUrl.'/index.php/section/index/movie/'.$model->name.'/section/'.$section->sectionType->name.'">'.$section->sectionType->label.'</a>';
                        }elseif(count($publishedVersion->activities)>1){
                            echo '<ul class="mnu_button activity_set_menu unstyled"><li class="title"><a href="#">'.$section->sectionType->label.'<span class="caret"></span></a><ul>';
                                foreach ($publishedVersion->activities as $activity) {
                                    echo '<li><a id="mnu_'.$section->sectionType->name.'" class="mnu_button" href="'.Yii::app()->request->baseUrl.'/index.php/section/index/movie/'.$model->name.'/section/'.$section->sectionType->name.'/activity/'.$activity->id.'">'.$activity->name.'</a></li>';
                                }
                            echo '</ul></li></ul>';
                        }
                    }
                }
            ?>
        </div>
    </div>
    <div class="row row3">
        <div id="controls-movies" class="col-xs-12 col-sm-12 col-md-12">
            <div id="volume">
                <img src="" alt="">
                <div id="slider">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/audio.player.temp.skin.png" height="15" width="95">
                </div>
            </div>
            <div id="progress">
                <span id="percent">58</span>% Activities
            </div>
        </div>
    </div>
    <div class="row row4">
        <div id="parallax" class="col-xs-12 col-sm-12 col-md-12">
            <div class="parallax-layer" style="width:1238px; height:543px;">
                <img src="<?php echo Yii::app()->request->baseUrl.'/'.$model->paralax_1.'?'.rand(1,1000000); ?>" alt=""/>
            </div>
            <div class="parallax-layer" style="width:1338px; height:543px;">
                <img src="<?php echo Yii::app()->request->baseUrl.'/'.$model->paralax_2.'?'.rand(1,1000000); ?>" alt=""/>
            </div>
            <div class="parallax-layer" style="width:1438px; height:543px;">
                <img src="<?php echo Yii::app()->request->baseUrl.'/'.$model->paralax_3.'?'.rand(1,1000000); ?>" alt=""/>
            </div>
        </div>
    </div>
    <div class="row row5">
        <div id="links" class="col-xs-12 col-sm-12 col-md-12">
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c2.png" height="22" width="22" alt="" />
                <a href="#">About Us</a>
            </div>
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c4.png" height="22" width="22" alt="" />
                <a href="#">Copyright page</a>
            </div>
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c6.png" height="22" width="22" alt="" />
                <a href="#">Flash Version</a>
            </div>
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c8.png" height="22" width="22" alt="" />
                <a href="#">Terms of Use</a>
            </div>
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c10.png" height="22" width="22" alt="" />
                <a href="#">FAQ</a>
            </div>
        </div>
    </div>
</main>
