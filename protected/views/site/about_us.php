        <main class="detalle">
            <div class="breadcrumb-class">
                Está en:&nbsp;<a href="http://unal.edu.co" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#" target="_self" title="La Universidad">Sección</a>&nbsp;&nbsp;/&nbsp;&nbsp;<b>Página</b>
            </div>
            <div class="row row1">
                <div id="div_img_camera" class="col-xs-12 col-sm-12 col-md-5">
                    <img id="img_camera" src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/camara.png" height="441" width="296" alt="camera"/>
                </div>
                <div id="terms" class="col-xs-12 col-sm-12 col-md-7">
                    <h2>Terms of use</h2>
                    <p>7th @rt is directly concerned with the educational purpose of providing opportunities for independent learners to strengthen  and, to help foster positive attitudes for improvement and consolidation of knowledge of the English language, language skills and learning strategies. In this sense, it is a goal but, more significantly, it is an on-going process, principled by the idea that learning a foreign language is not only a communicative and cooperative activity itself, but very importantly, an autonomous one. It therefore emphasizes the great need and importance of students’ initiatives and contributions to the learning experience in the process of becoming autonomous learners.</p>

                    <p>The English Language Autonomous Learning materals (ELAL) presented in 7th @rt are the product of a research project developed with students of the Philology and Languages degree, which take advantage of their strengths, improvement and achievements, for the benefit of the entire learning community at Universidad Nacional de Colombia.</p>

                    <p>7th @rt makes use of the compelling, undeniable power of feature films and the Internet that expose learners to authentic language in authentic contexts, in order to build up an overwhelming tool and environment for the learning experience. It introduces new features to challenge young adult students’ language comprehension and production, and to allow them to verify that learning the target language can be an interesting, enriching and motivating experience that promotes independent thinking.</p>

                    <p>Each set of film activities presents the following sections which are expected to be relevant to the learner’s needs, interests and abilities.</p>

                    <p>Your comments and suggestions are warmly welcome on the 7th @rt Wall.</p>

                    <p>The Director-Editor</p>

                    <?php
                    $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'aboutus-form',
                    ));
                    ?>
                        <div id="buttons" class="col-xs-12 col-sm-12 col-md-12">
                            <div id="btn_agree" class="button">
                                <?php
                                print CHtml::submitButton('I READ IT AND I AGREE', array('name'=>'AGREE'));
                                ?>
                            </div>
                            <div id="btn_decline" class="button">
                                    <?php
                                    print CHtml::submitButton('I DECLINE', array('name'=>'DECLINE'));
                                    ?>
                            </div>
                        </div>
                    <?php $this->endWidget(); ?>

                    <div id="steps" class="col-xs-12 col-sm-12 col-md-12">
                        <div id="btn_step_1" class="step step_active">1</div>
                        <div id="btn_step_2" class="step step_active">2</div>
                        <div id="btn_step_3" class="step">3</div>
                        <div id="btn_step_4" class="step">4</div>
                    </div>

                </div>


            </div>

        </main>