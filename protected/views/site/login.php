<?php
/* @var $this SiteController */

?>
<main class="detalle front page-intro not-logged fullpage">
    <div class="breadcrumb-class">
        Está en:&nbsp;<a href="http://unal.edu.co" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#" target="_self" title="La Universidad">Sección</a>&nbsp;&nbsp;/&nbsp;&nbsp;<b>Página</b>
    </div>
    <div class="row row1">
        <div id="welcome" class="col-xs-12 col-sm-12 col-md-6">
            <h2>Welcome to</h2>
            <!--<h1>The Power & Magic of Films to Learn English</h1>-->
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/Logotipo_7th_art_301x73.jpg" height="73" width="301">
            <p>7th @rt is directly concerned with the educational purpose of providing opportunities for independent learners to strengthen  and, to help foster positive attitudes for improvement and consolidation of knowledge of the English language, language skills and learning strategies.</p>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div id="intro_video">
                <iframe width="400" height="225" src="//www.youtube.com/embed/cqkq5PkhVJM?rel=0" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <div class="row row2" id="login">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'loginform',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'focus'=>array($model,'username'),
                ));
                ?>
                <div class="row">
                    <?php echo $form->labelEx($model, 'username'); ?>
                    <?php echo $form->textField($model, 'username') . '@unal.edu.co'; ?>
                    <?php echo $form->error($model, 'username'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'password'); ?>
                    <?php echo $form->passwordField($model, 'password'); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
                <div class="row" style="margin: 2px 0px 2px 0px; color: #000">
                    Al ingresar, usted acepta nuestros 
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
                <?php
                print CHtml::link('Términos de uso',
                    array('controller/action','param1'=>'value1'),
                    array('onclick'=>'$("#terms_of_use").dialog("open"); return false;')
                );
                ?>
                </div>
                <div class="row buttons">
                <?php echo CHtml::submitButton('LOGIN'); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
    <div class="row row3" id="investment_project">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <span>Investment Project BPUN 400000019818</span>
        </div>
    </div>
</main>