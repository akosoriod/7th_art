<?php
/* @var $this ActivitySetController */
/* @var $model ActivitySet */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/7th_art.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/activities.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/dropit/dropit.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/ActivitySet.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/dropit/dropit.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/parallax/jquery.parallax.min.js');

//Carga los estilos disponibles para el set de actividades
if ($handle = opendir('protected/data/sets/'.$model->name.'/css/')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            try{
                Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/protected/data/sets/'.$model->name.'/css/'.$entry);
            }catch(Exception $ex){}
        }
    }
    closedir($handle);
}
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
            'background': 'url("<?php echo Yii::app()->request->baseUrl.'/'.$model->background.'?'.rand(1,1000000); ?>") no-repeat center center fixed',
            '-webkit-background-size': 'cover',
            '-moz-background-size': 'cover',
            '-o-background-size': 'cover',
            'background-size': 'cover',
            'background-repeat': 'no-repeat'
        });
        $('body').addClass('not-front page-set fullpage row-offcanvas row-offcanvas-right');
        
        var activitySet=new ActivitySet();
        activitySet.init();
    });
</script>
<main id="activity_set_home" class="detalle front movie-<?php echo $model->name; ?> logged-in no-sidebars">
    <div class="breadcrumb-class">
        Est&aacute; en:&nbsp;<a href="<?php echo Yii::app()->request->baseUrl; ?>" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/&nbsp;&nbsp;<b><?php echo $model->title; ?></b>
    </div>
    <div class="row row1">
        <div id="lbl_set" class="col-xs-12 col-sm-12 col-md-8">
            <h2 id="ql_activity_set_title"><?php echo $model->title; ?></h2>
            <audio autoplay loop>
                <source src="<?php echo Yii::app()->baseUrl.'/'.$model->soundtrack.'?'.rand(1,1000000); ?>" type="audio/ogg">
                Your browser does not support the audio element.
            </audio>
        </div>
        <!-- Acknowledgments -->
        <div id="menu-movies-acknowledgments" class="col-xs-12 col-sm-12 col-md-4">
        </div>
    </div>
    <div class="row row2" style="margin-left: -44px;width: 1075px;">
        <!-- Sections -->
        <div id="menu-movies" class="col-xs-12 col-sm-12 col-md-12">
            <?php
                foreach ($model->sections as $section){
                    $class='';
                    $style ='';
                    if($section->sectionType->name == 'credits') {
                        $section->sectionType->label = $section->sectionType->label 
                                . ' <span style="font-size: 26px"> &copy; </span> ';
                        $style= 'style="padding: 9px 5px 8px;;"';
                    }
                    $publishedVersion=$section->publishedVersion();
                    if($publishedVersion){
                        if(count($publishedVersion->activities)===1){
                            echo '<a ' .$style . ' id="mnu_'.$section->sectionType->name.'" class="mnu_button '.$class.'" href="'.Yii::app()->request->baseUrl.'/index.php/section/index/movie/'.$model->name.'/section/'.$section->sectionType->name.'">'.$section->sectionType->label.'</a>';
                        }elseif(count($publishedVersion->activities)>1){
                            echo '<ul class="mnu_button activity_set_menu unstyled"><li class="title"><a href="#">'.$section->sectionType->label.'<span class="caret"></span></a><ul>';
                                foreach ($publishedVersion->activities as $activity) {
                                    echo '<li><a id="mnu_'.$section->sectionType->name.'" class="mnu_button '.$class.'" href="'.Yii::app()->request->baseUrl.'/index.php/section/index/movie/'.$model->name.'/section/'.$section->sectionType->name.'/activity/'.$activity->id.'">'.$activity->name.'</a></li>';
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
            <div id="progress">
                <!--<span id="percent">58</span>% Activities-->
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
                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'aboutus',
                    'options'=>array(
                        'title'=>'ABOUT US',
                        'width'=>760,
                        'height'=>580,
                        'autoOpen'=>false,
                        'resizable' => false,
                    ),
                ));
                require_once(Yii::app()->basePath . '/views/site/terms_of_use_tabs.php');
                $this->endWidget('zii.widgets.jui.CJuiDialog');
                ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c2.png" height="22" width="22" alt="" />
                <?php
                print CHtml::link('About Us',
                    array('controller/action','param1'=>'value1'),
                    array('onclick'=>'$("#aboutus").dialog("open"); return false;')
                );
                ?>
            </div>
            <div class="link">
                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'copyright',
                    'options'=>array(
                        'title'=>'Copyright',
                        'width'=>740,
                        'height'=>580,
                        'autoOpen'=>false,
                        'resizable' => false,
                    ),
                ));
                require_once(Yii::app()->basePath . '/views/site/copyright_tabs.php');
                $this->endWidget('zii.widgets.jui.CJuiDialog');
                ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c4.png" height="22" width="22" alt="" />
                <?php
                print CHtml::link('Copyright page',
                    array('controller/action','param1'=>'value1'),
                    array('onclick'=>'$("#copyright").dialog("open"); return false;')
                );
                ?>
            </div>
            <div class="link">
                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'terms_of_use',
                    'options'=>array(
                        'title'=>'T&eacute;rminos de Uso',
                        'width'=>960,
                        'height'=>580,
                        'autoOpen'=>false,
                        'resizable' => false,
                    ),
                ));
                require_once(Yii::app()->basePath . '/views/site/about_us_tabs.php');
                $this->endWidget('zii.widgets.jui.CJuiDialog');
                ?>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c8.png" height="22" width="22" alt="" />
                <?php
                print CHtml::link('Terms of Use',
                    array('controller/action','param1'=>'value1'),
                    array('onclick'=>'$("#terms_of_use").dialog("open"); return false;')
                );
                ?>
            </div>
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c10.png" height="22" width="22" alt="" />
                <?php
                print CHtml::link('FAQ',
                    array('controller/action','param1'=>'value1'),
                    array('onclick'=>'$("#faq").dialog("open"); return false;')
                );
                ?>
            </div>
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c10.png" alt="" />
                <a href="#">Research version</a>
            </div>
        </div>
    </div>
</main>
