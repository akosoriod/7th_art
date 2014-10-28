<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7]> <html class="no-js ie6 oldie lang_0" id="html"> <![endif]-->
<!--[if IE 7]> <html class="no-js ie7 oldie lang_0" id="html"> <![endif]-->
<!--[if IE 8]> <html class="no-js ie8 oldie lang_0" id="html"> <![endif]-->
<!--[if gt IE 8]> <!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl; ?>/protected/views/layouts/unal/images/favicon.ico" type="image/x-icon; charset=binary">
        <link rel="icon" href="images/favicon.ico" type="image/x-icon; charset=binary">
        <title>Universidad Nacional de Colombia: 7th @rt The Power of Films to Learn English</title>
        <meta name="revisit-after" content="1 hour">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=0.5, maximum-scale=2.5, user-scalable=yes">
        <base href="">
        <?php
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/protected/views/layouts/unal/css/bootstrap.min.css');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/protected/views/layouts/unal/css/reset.css');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/protected/views/layouts/unal/css/unal.css','all');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/protected/views/layouts/unal/css/base.css','all');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/protected/views/layouts/unal/css/tablet.css','only screen and (min-width: 992px) and (max-width: 1199px)');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/protected/views/layouts/unal/css/phone.css','only screen and (min-width: 768px) and (max-width: 991px)');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/protected/views/layouts/unal/css/small.css','only screen and (max-width: 767px)');
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/protected/views/layouts/unal/css/form.css','all');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/protected/views/layouts/unal/css/bootstrap-select.min.css','all');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/protected/views/layouts/unal/js/bootstrap-select.min.js');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/7th_art.js');
            //Estilos de 7th @rt
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/7th_art.css','all');
        ?>
    </head>
    <body>
        <?php require_once(Yii::app()->basePath . '/views/layouts/header.php'); ?>
        <?php require_once(Yii::app()->basePath . '/views/layouts/services.php'); ?>
        <!-- Menú My Account -->
        <?php (!Yii::app()->user->isGuest) ? require_once(Yii::app()->basePath . '/views/layouts/myAccount.php') : '' ?>
            <div id="mainmenu">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'id'=> 'navlist',
                    'items' => array(
//                        array('label' => 'Home', 'url' => array('/site/index')),
//                        array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                    ),
                ));
                ?>
            </div><!-- mainmenu -->
            <?php if (isset($this->breadcrumbs)): ?>
                <?php
//                $this->widget('zii.widgets.CBreadcrumbs', array(
//                    'links' => $this->breadcrumbs,
//                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>

            <?php echo $content; ?>
            <div class="clear"></div>
        <?php 
            require_once(Yii::app()->basePath . '/views/layouts/footer.php');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/protected/views/layouts/unal/js/unal.js');
        ?>
    </body>
</html>
