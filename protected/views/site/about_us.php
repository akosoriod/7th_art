<main class="detalle">
    <div class="breadcrumb-class">
        Est&aacute; en:&nbsp;<a href="http://unal.edu.co" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#" target="_self" title="La Universidad">Secci&oacute;n</a>&nbsp;&nbsp;/&nbsp;&nbsp;<b>About us</b>
    </div>
    <?php
    $script = <<< EOD
$("#language-english, #language-spanish").click(function(){
	var currentlp = $("#language-selector").attr("current-lp-id");
	var current_lan = $("#language-selector").attr("current-language");
	var sel_lan = $(this).attr("slanguage");
	if (current_lan === sel_lan) {
		return;};
	doTranslate("#legal-page-" + currentlp,sel_lan);
	$("#language-selector").attr("current-language", sel_lan);
	$("#language-"+sel_lan).addClass("slanguage");
	$("#language-"+current_lan).removeClass("slanguage");

});

function doTranslate(panel,lang) {
	var ander = lang === "english" ? "spanish":"english";

   	$(panel).find(".about-"+ander).css("display", "none");
   	$(panel).find(".about-"+lang).css("display", "block");

};
EOD;

    Yii::app()->clientScript->registerScript('aashshuahauha', $script);
    ?>

    <div id="language-selector" style="display:inline-flex" current-lp-id="1" current-language="english">
        <div id="language-english" class="slanguage" slanguage="english" style="font-size: 13pt; font-weight: bold;">
            English
        </div>
        <div id="language-spanish" slanguage="spanish" style="font-size: 13pt; font-weight: bold;">
            Spanish
        </div>
    </div>
    <div style="display:none; text-align:right;">
        <a class="prev-tab">Previous</a>
        <a class="next-tab">Next</a>
    </div>
    <div id="legal-page-1" class="legal-page">
        <div class="about-english" style="display:block;">
            <p  style="text-align:center;font-weight:bold; font-size:20px">ABOUT US</p>
            <div class="legal-p"> 
                <p><span style="font-style: italic;"> 7<sup>th</sup> @rt: The Power & Magic of Films to Learn English</span> is a virtual tool researched, created and produced by the Foreign Languages Department to support the autonomous learning of English as a foreign language of under and postgraduates at Universidad Nacional de Colombia by making use of Cinema, the Internet and Virtual Learning environments, through learning activities aiming at  encouraging and developing anticipation, comprehension and extension macro abilities based on the characters, the settings, the topics and the plots of the films.</p><br>

                <p>In other words, <span style="font-style: italic;font-weight:bold;">7th @rt</span> is concerned with providing opportunities for autonomous learners to strengthen and to help foster positive attitudes to improve their knowledge of the English language, language skills and learning strategies. In this sense, it is a goal but more significantly it is an on-going process principled by the idea that learning a foreign language is not only a communicative and cooperative activity itself, but very importantly, an autonomous one. It therefore emphasizes the great need and importance of students' initiatives and contributions to their learning experience in the process of becoming autonomous learners.</p><br>

                <p>The adaptation process of <span style="font-style: italic;">7th @rt</span> to the HTML5 language is carried out through a project of the Academic Affairs Office, Bogota Campus, as part of a macro project called “Strengthening of Academic Communicative Competencies (Reading and Writing) through Curriculum and Use of Foreign Languages” (Global Development Program 2013-2015), further continuing the research-creation study entitled  <span style="font-style: italic;font-weight:bold">7th @rt Virtual Material for Autonomous Learners</span> (Research Affairs Office, Bogota Campus)</p><br>


                <p style="text-align: center;"><img src="/7th_art/images/test/7thart_process.png" style="height:315px;width:526px" alt="7th @rt Graphic"/></p>
                <br>

                <p style="font-size:12pt; font-weight:bold;">Strengths</p>
                <ol class="about-us-ol legal-p">
                    <li>lt is an innovative learning tool and a pioneer in the use of Cinema, the Intemet and the virtual learning environments, within the framework of the Autonomous Learning of English in the Colombian context.</li>
                    <li>It facilitates learners exposure to authentic language and language use in authentic cultural contexts.</li>
                    <li>Texts, images and sound tracks are original and strictly comply with Copyright Law.</li>
                    <li>lts adaptation process to HTML5 is being done through interdisciplinary work that involves the participation of graduates and under and postgraduate students of seven Academic Units -four faculties- with the support afstalï teachers, as shown in the chart below.</li>
                    <li>This tool results from a research study developed with the participation of students of the Philology and Languages Degree.</li>
                </ol>



                <p style="font-size:12pt; font-weight:bold;"><span style="font-style: italic;">7th @rt</span> format presents </p>
                <ol class="about-us-ol legal-p">
                    <li>A video tutorial.</li>
                    <li>A film billboard linked to the activity sets, with a filter to sort by title, director and year.</li>
                    <li>An interactive menu.</li>
                    <li>Film synopsis.</li>
                    <li>Learning activities based not only on the films, but also on the invaluable academic research reports of Universidad Nacional de Colombia, dealing with picture and documentary films.</li>
                    <li>Film reviews and film related columns written by teachers from different departments at UN and by guest columnists.</li>
                    <li>Compelling information related to the topics.</li>
                    <li>Native and non-native recorded audio texts.</li>
                    <li>A board that allows interaction with and amongst end users.</li>
                    <li>The tool prototype, research version.</li>
            </div>
        </div>
        <div class="about-spanish" style="display:none;">
            <p  style="text-align:center;font-weight:bold; font-size:20px">QUIENES SOMOS</p>
            <div class="legal-p"> 
                <p><span style="font-style: italic;"> 7<sup>th</sup> @rt: The Power & Magic of Films to Learn English</span> es una herramienta virtual, creada y producida por el Departamento de Lenguas Extranjeras para apoyar el aprendizaje autónomo del inglés de los estudiantes de pregrado y posgrado de la Universidad Nacional de Colombia, mediante la utilización del cine, la Internet y los ambientes virtuales, a través de actividades de aprendizaje que buscan incentivar y desarrollar macro habilidades de anticipación, comprensión y extensión; a partir del reparto, los personajes, los escenarios, los temas y tramas de los filmes.</p><br>

                <p>En otras palabras, <span style="font-style: italic;font-weight:bold;">7th @rt</span> ofrece a los estudiantes oportunidades para fortalecer y generar actitudes positivas que les ayuden a mejorar su conocimiento del inglés y desarrollar habilidades de lengua y estrategias de aprendizaje. En este sentido, este objetivo denota además un proceso continuo, bajo el principio de que aprender una lengua extranjera es no sólamente una actividad comunicativa y cooperativa en sí misma, sino también un ejercicio de autonomía. Por lo tanto, se hace énfasis en la gran necesidad e importancia de que los estudiantes tomen iniciativas que contribuyan a su experiencia de aprendizaje, en el proceso de convertirse en aprendices autónomos.</p><br>

                <p>La adaptación de <span style="font-style: italic;">7th @rt</span> a lenguaje HTML5 es un proyecto de la Dirección Académica, Sede Bogotá, contemplado en el macro proyecto “Fortalecimiento de las competencias comunicativas académicas (lectura y escritura) a través de los currículos y uso de las lenguas extranjeras para la proyección internacional” (Plan Global de Desarrollo 2013-2015), que da continuidad al proyecto de investigación-creación <span style="font-style: italic;font-weight:bold">7th @rt Virtual Material for Autonomous Learners</span> de la Dirección de Investigación, Sede Bogotá.</p><br>


                <p style="text-align: center;"><img src="/7th_art/images/test/7thart_process.png" style="height:315px;width:526px" alt="7th @rt Graphic"/></p>
                <br>


                <p style="font-size:12pt; font-weight:bold;">Sus fortalezas</p>
                <ol class="about-us-ol legal-p">
                    <li>Es un recurso innovador de aprendizaje por ser pionero en cuanto a la llave cine-Internet y los ambientes virtuales, medios propios de la educación por la imagen del siglo XXI, en el marco del aprendizaje autónomo del inglés en el contexto nacional.</li>
                    <li>Facilita el acercamiento del estudiante a una lengua auténtica y su uso en contextos culturales auténticos.</li>
                    <li>Observa total originalidad en la composición de textos, la producción de imágenes y la interpretación de bandas sonoras, en estricto cumplimiento de la Ley de Derechos de Autor.</li>
                    <li>El proceso de su adaptación a HTML5 se desarrolla a través de un trabajo interdisciplinario con la participación de egresados, y estudiantes de pregrado y posgrado de siete Unidades Académicas -cuatro Facultades- con el concurso de profesores, como se ilustra en el gráfico.</li>
                    <li>Es una herramienta producto de un estudio desarrollado con la participación de estudiantes del Programa de Filología e Idiomas: Inglés.</li>
                </ol>



                <p style="font-size:12pt; font-weight:bold;">Su formato presenta</p>
                <ol class="about-us-ol legal-p">
                    <li>Video tutorial.</li>
                    <li>Cartelera cinematográfica con enlace hacia los sets de actividades, con filtro de búsqueda por título, director y año.</li>
                    <li>Menú interactivo por película o documental.</li>
                    <li>Síntesis de las obras cinematográficas.</li>
                    <li>Actividades de aprendizaje basadas tanto en los filmes, como en la invaluable producción investigativa de la Universidad Nacional de Colombia que desarrollan temas asociados a las películas y documentales.</li>
                    <li>Columnas escritas por profesores de diferentes facultades y columnistas invitados, que comentan la obra cinematogrâñcao sus temas.</li>
                    <li>Datos interesantes asociados a los temas vistos en cada filme.</li>
                    <li>Audio textos de nativos y estudiantes no nativos.</li>
                    <li>Recurso para grabación de voz.</li>

                    <li>Muro para la interacción entre y con los usuarios.</li>
                    <li>Prototipo de la herramienta, versión producto de investigación.</li>
                </ol>
            </div>
        </div>    
    </div>             
    <div id="legal-page-2" class="legal-page" style="display: none">
        <div class="about-spanish" style="display:block;">
            Spaaaaanisch 2
        </div>
        <div class="about-english" style="display:none;">
            Eeeeenglisch 2
        </div>    
    </div>       




    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'aboutus-form',
    ));
    ?>
    <div id="buttons" class="col-xs-12 col-sm-12 col-md-12" style="display:inline-flex;">
        <div id="btn_agree" class="button">
            <?php
            print CHtml::submitButton('I READ IT AND I AGREE', array('name' => 'AGREE'));
            ?>
        </div>
        <div id="btn_decline" class="button">
            <?php
            print CHtml::submitButton('I DECLINE', array('name' => 'DECLINE'));
            ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

    <div id="steps" class="col-xs-12 col-sm-12 col-md-12" style="display: none;">
        <div id="btn_step_1" class="step step_active">1</div>
        <div id="btn_step_2" class="step step_active">2</div>
        <div id="btn_step_3" class="step">3</div>
        <div id="btn_step_4" class="step">4</div>
    </div>

</div>


</div>

</main>