<?php
/* @var $this SectionController */
/* @var $dataProvider CActiveDataProvider */
/* @var $section Section */
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/editor.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/7th_art.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/activities.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/activity_sets.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/dropit/dropit.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/tabelizer/tabelizer.min.css');
Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Util.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/ActivitySet.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/dropit/dropit.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/tabelizer/jquery.tabelizer.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/State.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/Entity.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/Workspace.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/editor/Editor.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/recorderjs/recorder.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/recorderjs/jquery.voice.js');
?>
<script>
    $(document).ready(function($) {
        //Instrucción de la plantilla de la UNAL
        $('select', 'form').selectpicker();
        $('body').css({
            'background': 'url("<?php echo Yii::app()->request->baseUrl.'/'.$section->activitySet->background.'?'.rand(1,1000000); ?>") center no-repeat transparent',
            'background-size': 'cover',
            'background-repeat': 'no-repeat',
            'background-position': '50% 50%'
        });
        $('body').addClass('not-front page-set not-logged fullpage row-offcanvas row-offcanvas-right');
        
        var activitySet=new ActivitySet();
        activitySet.init();
        
        var appUrl="<?php echo Yii::app()->baseUrl."/"; ?>";
        window.editor=new Editor({
            appUrl:appUrl,
            mode:'solution'
        });
        editor.init();
        
        var stepId=parseInt($("#activity_set_home").attr("data-step-id"));
        editor.load(stepId);
    });
</script>
<main id="activity_set_home" class="detalle editor_main_space" data-step-id="<?php echo $step->id; ?>" data-activity-set-name="<?php echo $activitySet->name; ?>">
    <div id="ql_breadcrumb" class="breadcrumb-class">
        Está en:&nbsp;<a href="<?php echo Yii::app()->request->baseUrl; ?>" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/<a href="<?php echo Yii::app()->request->baseUrl.'/index.php/activitySet/home/movie/'.$section->activitySet->name; ?>" target="_self" title="<?php echo $section->activitySet->title; ?>"><?php echo $section->activitySet->title; ?></a>&nbsp;&nbsp;/&nbsp;&nbsp;<b><?php echo $section->sectionType->label; ?></b>
    </div>
    <!--<div id="audio_recorded" data-record="<?php // echo $step->getRecord($user); ?>"></div>-->
    <div class="row row1">
        <div id="lbl_set" class="col-xs-12 col-sm-12 col-md-8">
            <h2 id="ql_activity_set_title"><?php echo $section->activitySet->title; ?></h2>
        </div>
        <!-- Acknowledgments -->
        <div id="menu-movies-acknowledgments" class="col-xs-12 col-sm-12 col-md-4">
            <?php
            foreach ($activitySet->sections as $sectionIter){
                if($sectionIter->sectionType->name === 'acknowledgments') {
                    $publishedVersion=$sectionIter->publishedVersion();
                    if($publishedVersion){
                        if(count($publishedVersion->activities)===1){
                            echo '<a id="mnu_'.$sectionIter->sectionType->name.'" class="mnu_button" href="'.Yii::app()->request->baseUrl.'/index.php/section/index/movie/'.$activitySet->name.'/section/'.$sectionIter->sectionType->name.'">'.$sectionIter->sectionType->label.'</a>';
                        }elseif(count($publishedVersion->activities)>1){
                            echo '<ul class="mnu_button activity_set_menu unstyled"><li class="title"><a href="#">'.$sectionIter->sectionType->label.'<span class="caret"></span></a><ul>';
                                foreach ($publishedVersion->activities as $activityMenu) {
                                    echo '<li><a id="mnu_'.$sectionIter->sectionType->name.'" class="mnu_button" href="'.Yii::app()->request->baseUrl.'/index.php/section/index/movie/'.$activitySet->name.'/section/'.$sectionIter->sectionType->name.'/activity/'.$activityMenu->id.'">'.$activityMenu->name.'</a></li>';
                                }
                            echo '</ul></li></ul>';
                        }
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="row row2">
        <!-- Sections -->
        <div id="menu-movies" class="col-xs-12 col-sm-12 col-md-12">
            <?php
                foreach ($activitySet->sections as $sectionIter){
                    if($sectionIter->sectionType->name !== 'acknowledgments') {
                        $publishedVersion=$sectionIter->publishedVersion();
                        if($publishedVersion){
                            if(count($publishedVersion->activities)===1){
                                echo '<a id="mnu_'.$sectionIter->sectionType->name.'" class="mnu_button" href="'.Yii::app()->request->baseUrl.'/index.php/section/index/movie/'.$activitySet->name.'/section/'.$sectionIter->sectionType->name.'">'.$sectionIter->sectionType->label.'</a>';
                            }elseif(count($publishedVersion->activities)>1){
                                echo '<ul class="mnu_button activity_set_menu unstyled"><li class="title"><a href="#">'.$sectionIter->sectionType->label.'<span class="caret"></span></a><ul>';
                                    foreach ($publishedVersion->activities as $activityMenu) {
                                        echo '<li><a id="mnu_'.$sectionIter->sectionType->name.'" class="mnu_button" href="'.Yii::app()->request->baseUrl.'/index.php/section/index/movie/'.$activitySet->name.'/section/'.$sectionIter->sectionType->name.'/activity/'.$activityMenu->id.'">'.$activityMenu->name.'</a></li>';
                                    }
                                echo '</ul></li></ul>';
                            }
                        }
                    }
                }
            ?>
        </div>
    </div>
    <div class="row row3">
        <div id="controls-movies" class="col-xs-12 col-sm-12 col-md-12">
<!--            <div id="volume">
                <img src="" alt="">
                <div id="slider">
                        <img src="<?php // echo Yii::app()->request->baseUrl; ?>/images/test/audio.player.temp.skin.png" height="15" width="95">
                </div>
            </div>
            <div id="progress">
                <span id="percent">58</span>% Activities
            </div>-->
        </div>
    </div>
    <div id="ql_step_header" class="section_nav row row4">
        <h3 id="ql_section_name" class="section_nav_name"><?php echo $section->sectionType->label; ?> <div id="userpoints">Points: <span id="totalPoints"><?php echo $step->getPoints($user); ?></span></div></h3>
        <div class="section_nav_steps">
            <?php
                if(count($activity->steps)>1){
                    $stepCounter=1;
                    echo '<span class="text">Activity:</span>';
                    foreach ($activity->steps as $stepIter){
                        $activeClass="";
                        if($step->id==$stepIter->id){
                            $activeClass=" active";
                        }
                        echo '<a class="step_id '.$activeClass.'" '.
                            'href="'.Yii::app()->request->baseUrl.'/index.php/section/index/movie/'.$activitySet->name.'/section/'.$section->sectionType->name.'/activity/'.$stepIter->activity->id.'/step/'.$stepIter->id.'"'.
                            '>'.$stepIter->name.'</a>';
                        $stepCounter++;
                    }
                }
            ?>
        </div>
        <div id="ql_step_instruction" class="step_instruction"><?php echo $step->instruction; ?></div>
    </div>
    <div id="workspace" class="row row4 row_activities yui3-cssreset ql_workspace"></div>
    <div id="status_solved"></div>
    <div class="row row5">
        <div id="links" class="col-xs-12 col-sm-12 col-md-12">
            <div class="link">
                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'aboutus',
                    'cssFile'=>Yii::app()->baseUrl.'/css/activity_sets.css',
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
                    'cssFile'=>Yii::app()->baseUrl.'/css/activity_sets.css',
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
                    'cssFile'=>Yii::app()->baseUrl.'/css/activity_sets.css',
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
        </div>
    </div>
</main>