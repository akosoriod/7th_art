<?php
/* @var $this SiteController */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/activity_sets.css');
?>
<main class="detalle not-front page-home not-logged fullpage">
    <div class="breadcrumb-class">
        Est&aacute; en:&nbsp;<a href="<?php echo Yii::app()->request->baseUrl; ?>" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#" target="_self" title="La Universidad">Secci&oacute;n</a>&nbsp;&nbsp;/&nbsp;&nbsp;<b>P&aacute;gina</b>
    </div>
    <div class="row row1">
        <div id="lbl_showtime" class="col-xs-12 col-sm-12 col-md-5">
            <h2>Movie Showtimes</h2>
        </div>
        <div id="tools" class="col-xs-12 col-sm-12 col-md-7">
            <div id="search" class="tool">
                <input type="text" placeholder="Director, Actors, Film" />
            </div>
            <div id="sort" class="tool">
                <select>
                    <option>Sort by</option>
                    <option>Title</option>
                    <option>Director</option>
                    <option>Year</option>
                    <!--Otras opciones-->
                </select>
            </div>
        </div>
    </div>
    <div class="row row2">
        <div id="sets" class="col-xs-12 col-sm-12 col-md-12">
            <?php
                foreach ($activitySets as $activitySet) {
                    $this->renderPartial('/activitySet/_user_view',array('data'=>$activitySet));
                }
            ?>
        </div>
    </div>
    <div class="row row3">
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