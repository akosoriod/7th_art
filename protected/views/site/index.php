<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>


<?php
    if(Yii::app()->user->isGuest){
        echo '<meta http-equiv="refresh" content="0; url='.$this->createUrl('login').'" />';
    }else{
        echo 'Welcome: '.User::getCurrentUser()->name.' '.User::getCurrentUser()->lastname;
        
        print_r("<br><br>");
        if(Yii::app()->user->checkAccess('administrarSetActividades')){
            echo '<ul>';
                echo '<li>'.CHtml::link("Manage activity sets",array("activitySet/index")).'</li>';
            echo '</ul>';
        }
    }