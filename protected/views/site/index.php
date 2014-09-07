<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>


<?php
    if(Yii::app()->user->isGuest){
        echo '<meta http-equiv="refresh" content="0; url='.$this->createUrl('login').'" />';
    }else{
        
        //COLLECT
        if(Yii::app()->user->checkAccess('collect')){
            echo '<h3>Recaudo</h3>';
            echo '<ul>';
            echo '<li>'.CHtml::link("Recaudo",array("collect/create")).'</li>';
            if(Yii::app()->user->checkAccess('paySocialPlan')){
                echo '<li>'.CHtml::link("Abonar al plan social",array("collect/paySocialPlan")).'</li>';
            }
            echo '</ul>';
        }
        
        //DISCOUNTS
        if(Yii::app()->user->checkAccess('discount')){
            echo '<h3>Descuentos</h3>';
            echo '<ul>';
            if(Yii::app()->user->checkAccess('createDiscount')){
                echo '<li>'.CHtml::link("Hacer un descuento",array("discount/create")).'</li>';
            }
            if(Yii::app()->user->checkAccess('viewDiscount')){
                echo '<li>'.CHtml::link("Ver los descuentos realizados",array("discount/index")).'</li>';
            }
            echo '</ul>';
        }
        
        //SCHEDULES
        if(Yii::app()->user->checkAccess('schedule')){
            echo '<h3>Programación</h3>';
            echo '<ul>';
            if(Yii::app()->user->checkAccess('createSchedule')){
                echo '<li>'.CHtml::link("Administrar programación",array("schedule/index")).'</li>';
            }
            echo '</ul>';
        }
        
        //REPORTING
        if(Yii::app()->user->checkAccess('reporting')){
            echo '<h3>Reportes</h3>';
            echo '<ul>';
            echo '<li>'.CHtml::link("Ver reportes",array("report/index")).'</li>';
            echo '</ul>';
        }
    }