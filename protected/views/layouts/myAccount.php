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
            <a href="#">Profile</a>
            <?php require_once(Yii::app()->basePath . '/views/layouts/profile.php'); ?>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/icnServSia.png","",array(
                    'width'=>32,
                    'height'=>32
                )); 
            ?>
            <a href="#">Progress</a>
            <?php require_once(Yii::app()->basePath . '/views/layouts/progress.php'); ?>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/icnServLibrary.png","",array(
                    'width'=>32,
                    'height'=>32
                )); 
            ?>
            <a href="#">Preferences</a>
            <?php require_once(Yii::app()->basePath . '/views/layouts/preferences.php'); ?>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/icnServCall.png","",array(
                    'width'=>32,
                    'height'=>32
                )); 
            ?>
            <a href="#">Wall</a>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/icnServCall.png","",array(
                    'width'=>32,
                    'height'=>32
                )); 
            ?>
            <a href="#">FAQs</a>
        </li>
        <li>
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/icnServCall.png","",array(
                    'width'=>32,
                    'height'=>32
                ));
            ?>
            <a href="<?php print Yii::app()->request->baseUrl . '/index.php/site/logout' ?>">Logout</a>
        </li>
    </ul>
</div>