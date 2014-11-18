<?php
/* @var $this SectionController */
/* @var $dataProvider CActiveDataProvider */
/* @var $model Section */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/7th_art.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/activities.css');
?>
<script>
    $(document).ready(function($) {
        //Instrucción de la plantilla de la UNAL
        $('select', 'form').selectpicker();
        $('body').css({
            'background': 'url("<?php echo Yii::app()->request->baseUrl.'/'.$model->activitySet->background.'?'.rand(1,1000000); ?>") repeat scroll center top transparent'
        });
        $('body').addClass('not-front page-set movie-perfume not-logged fullpage row-offcanvas row-offcanvas-right');
        
        //Revisa los objectos de la secciñón y los redimensiona
        $(".object").each(function(){
            console.debug($(this));
            $(this).css({
                left:$(this).attr('data-left')+'px',
                top:$(this).attr('data-top')+'px',
                height:$(this).attr('data-height'),
                width:$(this).attr('data-width'),
                overflow:'auto',
                position:'absolute'
            });
        });
    });
</script>

<main class="detalle">
    <div class="breadcrumb-class">
        Está en:&nbsp;<a href="<?php echo Yii::app()->request->baseUrl; ?>" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/<a href="<?php echo Yii::app()->request->baseUrl.'/index.php/activitySet/home/movie/'.$model->activitySet->name; ?>" target="_self" title="<?php echo $model->activitySet->title; ?>"><?php echo $model->activitySet->title; ?></a>&nbsp;&nbsp;/&nbsp;&nbsp;<b><?php echo $model->sectionType->label; ?></b>
    </div>
    <div class="row row1">
        <div id="lbl_set" class="col-xs-12 col-sm-12 col-md-8">
            <h2><?php echo $model->activitySet->title; ?></h2>
        </div>
        <div id="credits-movies" class="col-xs-12 col-sm-12 col-md-4">
            <img src="" alt="" />
            <span><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/copyright.png" height="15" width="15"> Credits</a></span>
        </div>
    </div>
    <div class="row row2">
        <div id="menu-movies" class="col-xs-12 col-sm-12 col-md-12">
            <a id="mnu_synopsis" class="mnu_button" href="set_synopsis.html">Synopsis</a>
            <a id="mnu_pre" class="mnu_button" href="set_previewing.html">Pre-Viewing <span class="caret"></span></a>
            <a id="mnu_who" class="mnu_button" href="set_whoiswho.html">Who's Who in...?</a>
            <a id="mnu_film" class="mnu_button" href="set_filmbased.html">Film-Based <span class="caret"></span></a>
            <a id="mnu_spider" class="mnu_button" href="set_spidermap.html">Spidermap</a>
            <a id="mnu_after" class="mnu_button" href="set_afterviewing.html">After-Viewing <span class="caret"></span></a>
            <a id="mnu_expert" class="mnu_button" href="set_expertsays.html">The Expert Says...</a>
            <a id="mnu_did" class="mnu_button" href="set_didyouknow.html">Did you know that...?</a>
            <a id="mnu_ack" class="mnu_button" href="set_aknowledgements.html">Aknowledgements</a>
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
    <div id="workspace" class="row row4 row_activities">
        <?php
            $objects=Object::model()->findAll();
            foreach ($objects as $object) {
                echo $object->getHtml();
            }
            
            
            
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