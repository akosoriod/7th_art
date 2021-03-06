<?php
/* @var $this SiteController */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/activity_sets.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/plugins/circle/progress.css');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/plugins/circle/jquery-asPieProgress.min.js');
?>
<script>
    $( document ).ready(function(){
        $('.total_percent').asPieProgress({
            classes: {
                element: 'total_percent',
                number: 'total_percent__number',
                content: 'pie_progress__content'
            },
            barsize: '20',
            fillcolor: 'white',
            'namespace': 'total_percent',
            speed: 30,
            trackcolor: '#ccc'
        });
        setTimeout(function(){
            $('.total_percent').asPieProgress('start');
        },600);
    });
</script>
<main class="detalle not-front page-home logged-in fullpage">
    <div class="breadcrumb-class">
        Est&aacute; en:&nbsp;<a href="<?php echo Yii::app()->request->baseUrl; ?>" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#" target="_self" title="La Universidad">Secci&oacute;n</a>&nbsp;&nbsp;/&nbsp;&nbsp;<b>P&aacute;gina</b>
    </div>
    <div class="row row1">
        <div id="lbl_showtime" class="col-xs-12 col-sm-12 col-md-5">
            <h2>Movie Showtimes</h2>
        </div>
        <!-- form -->
        <div id="tools" class="col-xs-12 col-sm-12 col-md-7">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'searchform',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions'=>array(
                   'onsubmit'=>"return false;",/* Disable normal form submit */
                   'onkeypress'=>" if(event.keyCode == 13){ searchActivitySet(); } " /* Do ajax call when user presses enter key */
                ),
            ));
            ?>
            <div id="search" class="tool">
                <?php
                Yii::app()->clientScript->registerScript('searchActivitySet',
                 'function searchActivitySet(){
                    var data=$("#searchform").serialize();
                     $.ajax({
                         url: "'.CController::createUrl("//site/search").'",
                         type:"POST",
                         data: data,
                         success: function(data){
                            $("#sets").html(data);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                     })
                 }', CClientScript::POS_END);
                ?>
                <?php
                print CHtml::textField('searchField', '',
                    array('id'=>'idSearch', 
                        'maxlength'=>100,
                        'placeholder'=>'Title, Director, Year'
                ));
                ?>
            </div>
            <div id="sort" class="tool">
                <?php
                print CHtml::dropDownList('sortBy','', array(''=>'Sort by','title'=>'Title','director'=>'Director','year'=>'Year'),
                    array(
                    'ajax' => array(
                    'type'=>'POST', //request type
                    //Style: CController::createUrl('currentController/methodToCall')
                    'url'=>CController::createUrl('//site/sort'), //url to call.
                    //leave out the data key to pass all form values through
                    //'data'=>'js:javascript statement'
                    'success' => 'function(data, textStatus, jqXHR) { $("#sets").html(data); }',
                )));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div> <!-- form -->
    </div>
    <div class="row row2">
        <div id="sets" class="col-xs-12 col-sm-12 col-md-12">
            <?php
            $user=User::getCurrentUser();
             if ($user->email == "demo7thart_bog@unal.edu.co") {
                 foreach ($activitySets as $activitySet) {
                     if ($activitySet->id == 12){
                         $this->renderPartial('/activitySet/_user_view',array('data'=>$activitySet));
                     }
                }
             }else{
                foreach ($activitySets as $activitySet) {
                    $this->renderPartial('/activitySet/_user_view',array('data'=>$activitySet));
                }
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
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c2.png" alt="" />
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
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c4.png" alt="" />
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
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c8.png" alt="" />
                <?php
                print CHtml::link('Terms of Use',
                    array('controller/action','param1'=>'value1'),
                    array('onclick'=>'$("#terms_of_use").dialog("open"); return false;')
                );
                ?>
            </div>
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c10.png" alt="" />
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