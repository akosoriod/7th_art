<div id="myAccount">
    <div class="tabMyAccount">
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
        <li class="labelaccount">
             <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/Icons/7th.png","",array(
                    'width'=>32,
                    'height'=>32
                ));
            ?>
            <p>Art</p>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/Icons/my_account_ID.png","",array(
                    'width'=>32,
                    'height'=>32
                ));
            ?>
            <a href="#">Profile</a>
            <?php require_once(Yii::app()->basePath . '/views/layouts/profile.php'); ?>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/Icons/Progress.png","",array(
                    'width'=>32,
                    'height'=>32
                ));
            ?>
            <a href="#">Progress</a>
            <?php require_once(Yii::app()->basePath . '/views/layouts/progress.php'); ?>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/Icons/settings.png","",array(
                    'width'=>32,
                    'height'=>32
                )); 
            ?>
            <a href="#">Preferences</a>
            <?php require_once(Yii::app()->basePath . '/views/layouts/preferences.php'); ?>
        </li>
        <li>
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'wall',
                'options'=>array(
                    'title'=>'Wall',
                    'width'=>580,
                    'height'=>450,
                    'autoOpen'=>false,
                    'resizable' => false,
                ),
            ));
            $this->renderPartial('/wall/list');
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/Icons/wall_icon_modified.png","",array(
                    'width'=>32,
                    'height'=>32
                )); 
            ?>
            <?php
                print CHtml::link('Wall',
                    '#',
                    array('onclick'=>'$("#wall").dialog("open"); return false;')
                );
            ?>
        </li>
        <li>
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'faq',
                'options'=>array(
                    'title'=>'FAQ',
                    'width'=>480,
                    'height'=>580,
                    'autoOpen'=>false,
                    'resizable' => false,
                ),
            ));
            require_once(Yii::app()->basePath . '/views/faq/list.php');
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>
            
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/Icons/FAQ.png","",array(
                    'width'=>32,
                    'height'=>32
                )); 
            ?>
            <?php
                print CHtml::link('FAQ',
                    array('controller/action','param1'=>'value1'),
                    array('onclick'=>'$("#faq").dialog("open"); return false;')
                );
            ?>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/Icons/logout.png","",array(
                    'width'=>32,
                    'height'=>32
                ));
            ?>
            <a href="<?php print Yii::app()->request->baseUrl . '/index.php/site/logout' ?>">Logout</a>
        </li>
    </ul>
</div>