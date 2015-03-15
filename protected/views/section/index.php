<?php
/* @var $this SectionController */
/* @var $dataProvider CActiveDataProvider */
/* @var $section Section */
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/editor.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/7th_art.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/activities.css');
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
?>
<script>
    $(document).ready(function($) {
        //Instrucción de la plantilla de la UNAL
        $('select', 'form').selectpicker();
        $('body').css({
            'background': 'url("<?php echo Yii::app()->request->baseUrl.'/'.$section->activitySet->background.'?'.rand(1,1000000); ?>") repeat scroll center top transparent'
        });
        $('body').addClass('not-front page-set movie-perfume not-logged fullpage row-offcanvas row-offcanvas-right');
        
        
        
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
        
        //Revisa los objectos de la secciñón y los redimensiona
//        $(".object").each(function(){
//            console.debug($(this));
//            $(this).css({
//                left:$(this).attr('data-left')+'px',
//                top:$(this).attr('data-top')+'px',
//                height:$(this).attr('data-height'),
//                width:$(this).attr('data-width'),
//                overflow:'auto',
//                position:'absolute'
//            });
//            
            //Agrega los eventos a los objetos
//            $(this).find(".editor-radio-object").buttonset();
//        });
    });
</script>

<main id="activity_set_home" class="detalle" data-step-id="<?php echo $step->id; ?>">
    <div class="breadcrumb-class">
        Está en:&nbsp;<a href="<?php echo Yii::app()->request->baseUrl; ?>" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/<a href="<?php echo Yii::app()->request->baseUrl.'/index.php/activitySet/home/movie/'.$section->activitySet->name; ?>" target="_self" title="<?php echo $section->activitySet->title; ?>"><?php echo $section->activitySet->title; ?></a>&nbsp;&nbsp;/&nbsp;&nbsp;<b><?php echo $section->sectionType->label; ?></b>
    </div>
    <div class="row row1">
        <div id="lbl_set" class="col-xs-12 col-sm-12 col-md-8">
            <h2><?php echo $section->activitySet->title; ?></h2>
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
            <!-- Credits -->
            <div id="credits-movies">
                <img src="" alt="" />
                <span><a class="mnu_button" href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/copyright.png" height="15" width="15"> Credits</a></span>
            </div>
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
    <div class="section_nav row row4">
        <h3 class="section_nav_name"><?php echo $section->sectionType->label; ?></h3>
        <div class="section_nav_steps">
            <?php
                if(count($activity->steps)>1){
                    $stepCounter=1;
                    echo 'Page:';
                    foreach ($activity->steps as $stepIter){
                        $activeClass="";
                        if($step->id==$stepIter->id){
                            $activeClass=" active";
                        }
                        echo '<a class="step_id '.$activeClass.'" '.
                            'href="'.Yii::app()->request->baseUrl.'/index.php/section/index/movie/'.$activitySet->name.'/section/'.$section->sectionType->name.'/activity/'.$stepIter->activity->id.'/step/'.$stepIter->id.'"'.
                            '>'.$stepCounter.'</a>';
                        $stepCounter++;
                    }
                }
            ?>
        </div>
        <div class="step_instruction"><?php echo $step->instruction; ?></div>
    </div>
    <div id="workspace" class="row row4 row_activities"></div>
    
    
    <img id="check_button" src="<?php echo Yii::app()->request->baseUrl; ?>/images/userspace/check-img.png" height="32" width="33" alt="" />
    <div id="status_solved"></div>
    
    <!--<input id="check_button" type="button" value="Check">-->
    
    
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