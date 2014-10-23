<?php
/* @var $this SiteController */
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
            <div id="set_1" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c10.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">Invictus</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_2" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c2.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">An Inconvenient Truth</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_3" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c4.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">Dune</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_4" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c6.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">Horton Hears a Who!</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_5" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r4_c10.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">Start Dust</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_6" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r4_c2.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">Life of Pi</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_7" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r4_c4.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">Searching for Sugar Man</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_8" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r4_c6.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">Shine</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_9" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r6_c7.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">The Name of the Rose</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_10" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/activitySet/home/movie/perfume">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r7_c11.png" height="130" width="130" alt="movie title"/>
                    <div class="info">
                        <div class="attribute title">Perfume</div>
                        <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                        <div class="attribute director hidden">Ang Lee</div>
                        <div class="attribute year hidden">2012</div>
                        <div class="attribute otro_atributo hidden">otro_valor</div>
                    </div>
                </a>
            </div>
            <div id="set_11" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r7_c2.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">The Man in the Iron Mask</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_12" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r8_c4.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">March of the Penguins</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_13" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c2.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">Rise of the Guardians</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_14" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c2.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">A Clockwork Orange</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_15" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c2.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">Spirited Away</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_16" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c2.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">Donnie Darko</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_17" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c2.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">E.T.</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_18" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c2.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">Avatar</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_19" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c2.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">The Godfather</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
            <div id="set_20" class="set">
                <!--El círculo del porcentaje se dibujará con JS-->
                <div class="percent">25%</div>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/test/7thf1_r2_c2.png" height="130" width="130" alt="movie title"/>
                <div class="info">
                    <div class="attribute title">The Wolverine</div>
                    <!--Los divs a continuación serán visibles si se define que se muestra información al pasar el puntero por el set de actividades-->
                    <div class="attribute director hidden">Ang Lee</div>
                    <div class="attribute year hidden">2012</div>
                    <div class="attribute otro_atributo hidden">otro_valor</div>
                </div>
            </div>
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