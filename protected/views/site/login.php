<?php
/* @var $this SiteController */
?>


    
    <main class="detalle">
            <div class="breadcrumb-class">
                Está en:&nbsp;<a href="http://unal.edu.co" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#" target="_self" title="La Universidad">Sección</a>&nbsp;&nbsp;/&nbsp;&nbsp;<b>Página</b>
            </div>
            <div class="row row1">
                <div id="welcome" class="col-xs-12 col-sm-12 col-md-6">
                    <h2>Welcome to</h2>
                    <h1>The Power & Magic of Films to Learn English</h1>
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
<!--                    <form id="loginform" action="about_us.html" method="post">
                        <label>Username: </label><input type="text" name="username">@unal.edu.co
                         <label>Password: </label><input type="text" name="password">
                           <input type="submit" value="LOGIN">
                    </form>-->
                    <div class="form">
                        <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'loginform',
                                'enableClientValidation'=>true,
                                'clientOptions'=>array(
                                        'validateOnSubmit'=>true,
                                ),
                        )); ?>
                                <div class="row">
                                        <?php echo $form->labelEx($model,'username'); ?>
                                        <?php echo $form->textField($model,'username').'@unal.edu.co'; ?>
                                        <?php echo $form->error($model,'username'); ?>
                                </div>

                                <div class="row">
                                        <?php echo $form->labelEx($model,'password'); ?>
                                        <?php echo $form->passwordField($model,'password'); ?>
                                        <?php echo $form->error($model,'password'); ?>
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