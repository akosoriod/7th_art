<?php
/* @var $this SiteController */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/activity_sets.css');
?>
<main class="detalle not-front page-home not-logged fullpage">
    <div class="breadcrumb-class">
        Está en:&nbsp;<a href="<?php echo Yii::app()->request->baseUrl; ?>" target="_self" title="Inicio">Inicio</a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="#" target="_self" title="La Universidad">Sección</a>&nbsp;&nbsp;/&nbsp;&nbsp;<b>Página</b>
    </div>
    <div class="row row1">
        <div id="lbl_showtime" class="col-xs-12 col-sm-12 col-md-5">
            <h2>Movie Showtimes</h2>
        </div>
        <div id="tools" class="col-xs-12 col-sm-12 col-md-7">
            <div id="search" class="tool">
                <input type="text" placeholder="Director, Actors, Film" />
            </div>
            <div id="sort" class="tool">
                <select>
                    <option>Sort by</option>
                    <option>Title</option>
                    <option>Director</option>
                    <option>Year</option>
                    <!--Otras opciones-->
                </select>
            </div>
        </div>
    </div>
    <div class="row row2">
        <div id="sets" class="col-xs-12 col-sm-12 col-md-12">
            <?php
                foreach ($activitySets as $activitySet) {
                    $this->renderPartial('/activitySet/_user_view',array('data'=>$activitySet));
                }
            ?>
        </div>
    </div>
    <div class="row row3">
        <div id="links" class="col-xs-12 col-sm-12 col-md-12">
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c2.png" height="22" width="22" alt="" />
                <a href="#">About Us</a>
            </div>
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c4.png" height="22" width="22" alt="" />
                <a href="#">Copyright page</a>
            </div>
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c6.png" height="22" width="22" alt="" />
                <a href="#">Flash Version</a>
            </div>
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c8.png" height="22" width="22" alt="" />
                <a href="#">Terms of Use</a>
            </div>
            <div class="link">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/ico_r2_c10.png" height="22" width="22" alt="" />
                <a href="#">FAQ</a>
            </div>
        </div>
    </div>
</main>