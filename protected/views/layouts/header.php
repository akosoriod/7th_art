<header id="unalTop">
    <div class="logo">
        <a href="http://unal.edu.co">
            <?php 
                echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/escudoUnal.png","Escudo de la Universidad Nacional de Colombia",array(
                    'width'=>189,
                    'height'=>70
                )); 
            ?>
        </a>
        <div class="diag">
        </div>
    </div>
    <div class="seal">
        <?php 
            echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/sealColombia.png","Escudo de la República de Colombia",array(
                'width'=>66,
                'height'=>66
            )); 
        ?>
    </div>
    <div class="firstMenu">
        <div class="btn-group tx-srlanguagemenu">
            <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                ES <span class="caret"></span>
            </div>
            <ul class="dropdown-menu" role="menu">
            </ul>
        </div>
        <ul class="socialLinks">
            <li><a href="https://twitter.com/unimedios" target="_blank" class="twitter" title="Cuenta oficial en Twitter"></a></li>
            <li><a href="https://www.facebook.com/pages/Agencia-de-Noticias-UN/193658967327822" target="_blank" class="facebook" title="Página oficial en Facebook"></a></li>
            <li><a href="http://www.agenciadenoticias.unal.edu.co/nc/sus/type/rss2.html" target="_blank" class="rss" title="Suscripción a canales de información RSS"></a></li>
        </ul>
    </div>
    <div class="navigation">
        <div class="site-url">
            <div class="icon">
            </div>
            7<sup>th</sup> @rt : The Power & Magic of Films to Learn English
        </div>
        <div class="navbar-">
            <div class="btn-group">
                <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a>
                </div>
            </div>
<!--            <div class="btn-group">
                <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    Perfume<span class="caret"></span>
                </div>
                <ul class="dropdown-menu">
                    <li><a href="#" target="_self">Rage</a></li>
                    <li><a href="#" target="_top">Suits</a></li>
                    <li><a href="#" target="_top">Venom</a></li>
                    <li><a href="#" target="_top">Zeus</a></li>
                </ul>
            </div>-->
            <?php if(Yii::app()->user->checkAccess('application')){ ?>
                <div class="btn-group">
                    <div class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <a href="#" target="_top">Wall</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="buscador">
        <gcse:searchbox-only resultsurl="http://unal.edu.co/resultados-de-la-busqueda/"></gcse:searchbox-only>
    </div>
</header>
<div class="home-image">
    <?php 
        echo CHtml::image(Yii::app()->request->baseUrl."/images/unal/img_demo.jpg","",array(
            'width'=>2000,
            'height'=>80
        )); 
    ?>
</div>