<?php
/* @var $this ActivitySetController */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/7th_art.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/parallax/jquery.parallax.min.js');
?>
<script>
    jQuery(document).ready(function($) {
        //Instrucción de la plantilla de la UNAL
        $('select', 'form').selectpicker();

        //Prueba del parallax
        jQuery('.parallax-layer').parallax({
            mouseport: jQuery('#parallax')
        });
        
        $('body').addClass('not-front page-set movie-perfume not-logged fullpage row-offcanvas row-offcanvas-right');
    });
</script>
<main class="detalle">
    <div class="breadcrumb-class">
        Está en:&nbsp;<a href="http://unal.edu.co" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#" target="_self" title="La Universidad">Sección</a>&nbsp;&nbsp;/&nbsp;&nbsp;<b>Página</b>
    </div>
    <div class="row row1">
        <div id="lbl_set" class="col-xs-12 col-sm-12 col-md-8">
            <h2>PERFUME: The Story of a Murderer</h2>
        </div>
        <div id="credits-movies" class="col-xs-12 col-sm-12 col-md-4">
            <img src="" alt="" />
            <span><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/copyright.png" height="15" width="15"> Credits</a></span>
        </div>
    </div>
    <div class="row row2">
        <div id="menu-movies" class="col-xs-12 col-sm-12 col-md-12">
            <a id="mnu_synopsis" class="mnu_button" href="../../../section/index/movie/<?php echo $model->name; ?>/section/synopsis">Synopsis</a>
            <a id="mnu_pre" class="mnu_button" href="perfume/set_previewing.html">Pre-Viewing <span class="caret"></span></a>
            <a id="mnu_who" class="mnu_button" href="perfume/set_whoiswho.html">Who's Who in...?</a>
            <a id="mnu_film" class="mnu_button" href="perfume/set_filmbased.html">Film-Based <span class="caret"></span></a>
            <a id="mnu_spider" class="mnu_button" href="perfume/set_spidermap.html">Spidermap</a>
            <a id="mnu_after" class="mnu_button" href="perfume/set_afterviewing.html">After-Viewing <span class="caret"></span></a>
            <a id="mnu_expert" class="mnu_button" href="perfume/set_expertsays.html">The Expert Says...</a>
            <a id="mnu_did" class="mnu_button" href="perfume/set_didyouknow.html">Did you know that...?</a>
            <a id="mnu_ack" class="mnu_button" href="perfume/set_aknowledgements.html">Acknoledgments</a>
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
            <div class="parallax-layer" style="width:920px; height:274px;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/1_mountains.png" alt="" />
            </div>
            <div class="parallax-layer" style="width:1100px; height:284px;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/2_hill.png" alt="" style="position:absolute; top:40px; left:0;" />
            </div>
            <div class="parallax-layer" style="width:1360px; height:320px;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/3_wood.png" alt="" style="position:absolute; top:96px; left:0;"/>
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
