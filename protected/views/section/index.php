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
        console.debug(editor);
        
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
        <div id="credits-movies" class="col-xs-12 col-sm-12 col-md-4">
            <img src="" alt="" />
            <span><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/copyright.png" height="15" width="15"> Credits</a></span>
        </div>
    </div>
    <div class="row row2">
        <div id="menu-movies" class="col-xs-12 col-sm-12 col-md-12">
            <?php
                foreach ($activitySet->sections as $sectionIter){
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
    <div id="workspace" class="row row4 row_activities">
        <?php
        
            foreach ($step->entities as $entity) {
                print_r($entity);
                print_r("<br>");
                print_r("<br>");
            }
//        
//        
//            $objects=$activity->steps;
//            foreach ($objects as $object) {
//                //TODO: Calcular automáticamente
//                $html=str_replace('src="../../','src="/7th_art/',$object->getHtml());
//                echo $html;
//            }
        ?>
<!--        <div id="activities" class="col-xs-12 col-sm-12 col-md-12">
            <div id="set_1" class="set">
                <div id="activity_1" class="synopsis" data-template="354">
                    <div class="title">
                        <h4>Synopsis</h4>
                    </div>
                    <div class="content">
                        <div id="object_2345" class="object" data-type="textarea">
                            <textarea>Set in the illustrious XVIII Century in France, Perfume, Tom Tykwer's drama-thriller production, based on Patrick Sϋskind's heart-stopping masterpiece, portrays an interesting link between alchemy - misinterpreted as witchcraft - and poverty.

Jean Baptiste Grenouille (Ben Whishaw), a newborn French boy is abandoned by his fish seller mother in a market in Orleans, and later taken to a local orphanage where he is severely mistreated for his strong sense of smell. Twenty years later, forced to work as a slave in a Parisian leather shop, he accidentally kills a plum seller and he then meets Giussepe Baldini (Dustin Hoffman), an old fame-thirsty Italian perfumer who uses Grenouille´s gift to, once again, be recognized as the best perfumer in France. Hence, he teaches Grenouille everything he knows about perfumery and alchemy, with the exception of an old mysterious technique, developed in Grasse called Enfleurage.

During his long journey to Grasse, Grenouille becomes obsessed with the idea of not having his own scent, which differentiates him from the rest of the people. When he arrives in the town, he first manages to learn the Enfleurage technique and then starts killing young women with the purpose of extracting their scents in order to make the best perfume in the world. After twelve murders, Grenouille meets Laura Richis (Laura Hurd), an exceptionally stunning woman who enchants him with her infinite beauty, and falls in love with her unique scent. However, her brave father Antoine Richis (Alan Rickman), one of the most famous and powerful counts of France, tries hard to save his daughter from being murdered by Grenouille.

Love, hatred, despair, madness and death are the main features involved in this amazing story, held in ancient imposing castles, and including stunning landscapes, luxurious costumes and unexpected adventures, that make this film one of the most important spellbinding films of the XXI Century.

Set in the illustrious XVIII Century in France, Perfume, Tom Tykwer's drama-thriller production, based on Patrick Sϋskind's heart-stopping masterpiece, portrays an interesting link between alchemy - misinterpreted as witchcraft - and poverty.

Jean Baptiste Grenouille (Ben Whishaw), a newborn French boy is abandoned by his fish seller mother in a market in Orleans, and later taken to a local orphanage where he is severely mistreated for his strong sense of smell. Twenty years later, forced to work as a slave in a Parisian leather shop, he accidentally kills a plum seller and he then meets Giussepe Baldini (Dustin Hoffman), an old fame-thirsty Italian perfumer who uses Grenouille´s gift to, once again, be recognized as the best perfumer in France. Hence, he teaches Grenouille everything he knows about perfumery and alchemy, with the exception of an old mysterious technique, developed in Grasse called Enfleurage.

During his long journey to Grasse, Grenouille becomes obsessed with the idea of not having his own scent, which differentiates him from the rest of the people. When he arrives in the town, he first manages to learn the Enfleurage technique and then starts killing young women with the purpose of extracting their scents in order to make the best perfume in the world. After twelve murders, Grenouille meets Laura Richis (Laura Hurd), an exceptionally stunning woman who enchants him with her infinite beauty, and falls in love with her unique scent. However, her brave father Antoine Richis (Alan Rickman), one of the most famous and powerful counts of France, tries hard to save his daughter from being murdered by Grenouille.

Love, hatred, despair, madness and death are the main features involved in this amazing story, held in ancient imposing castles, and including stunning landscapes, luxurious costumes and unexpected adventures, that make this film one of the most important spellbinding films of the XXI Century.
                            </textarea>
                        </div>
                        <div id="object_2346" class="object" data-type="image">
                            <img src="../editor/perfume/css/images/image_321.png" id="image_321" alt="name_of_image"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
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