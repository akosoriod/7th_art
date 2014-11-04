<!--SYS: Esta sección también se cargará como plantilla, por ahora no se puede por que la funcionalidad está en JQuery-->
<div id="services">
    <div class="indicator">
    </div>
    <ul>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/icnServEmail.png","",array(
                    'width'=>32,
                    'height'=>32
                )); 
            ?>
            <a href="http://correo.unal.edu.co" target="_top">Correo institucional</a>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/icnServSia.png","",array(
                    'width'=>32,
                    'height'=>32
                )); 
            ?>
            <a href="http://www.sia.unal.edu.co" target="_top">Sistema de Información Académica</a>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/icnServLibrary.png","",array(
                    'width'=>32,
                    'height'=>32
                )); 
            ?>
            <a href="http://www.sinab.unal.edu.co" target="_top">Bibliotecas</a>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/icnServCall.png","",array(
                    'width'=>32,
                    'height'=>32
                )); 
            ?>
            <a href="http://168.176.5.43:8082/Convocatorias/indice.iface" target="_blank">Convocatorias</a>
        </li>
    </ul>
</div>