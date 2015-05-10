    <ul>
        <li>Total Progress <?php echo round(User::getCurrentUser()->totalPercent()); ?>%</li>
        <li>
            <?php 
                foreach (ActivitySet::model()->findAll() as $activitySet) { 
                    if(intval($activitySet->status_id)===3){
            ?>
                        <div class='progress'>
                            <div class="title"><?php echo $activitySet->title; ?></div>
                            <div class="value"><?php echo $activitySet->percent(User::getCurrentUser()); ?>%</div>
                            <!--<div><?php // print CHtml::image(Yii::app()->request->baseUrl."/images/test/check-img.png","",""); ?></div>-->
<!--                            <div class="details">
                            <?php
//                            print CHtml::link('details',
//                                        array('controller/action','param1'=>'value1'),
//                                        array('onclick'=>'$("#progressDetails").dialog("open"); return false;')
//                                    );
                            ?>
                            </div>-->
                        </div>
                        <?php
                        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id'=>'progressDetails',
                            'options'=>array(
                                'title'=>'Film Progress Details',
                                'width'=>480,
                                'height'=>580,
                                'autoOpen'=>false,
                                'resizable' => false,
                            ),
                        ));
                        require_once(Yii::app()->basePath . '/views/account/progressDetails.php');
                        $this->endWidget('zii.widgets.jui.CJuiDialog');
                        ?>

            <?php             
                    } 
                } 
            ?>
            
            
            
            
            
            
            
            
            
<!--            <div class='progress'>
                <div>Horton</div>
                <div>27%</div>
                <div>
                <?php
//                print CHtml::link('details',
//                            array('controller/action','param1'=>'value1'),
//                            array('onclick'=>'$("#progressDetails").dialog("open"); return false;')
//                        );
//                ?>
                </div>
            </div>-->
<!--            <div class='progress'>
                <div>Shine</div>
                <div>60%</div>
                <div>
                <?php
//                print CHtml::link('details',
//                            array('controller/action','param1'=>'value1'),
//                            array('onclick'=>'$("#progressDetails").dialog("open"); return false;')
//                        );
//                ?>
                </div>
            </div>-->
<!--            <div class='progress'>
                <div>Dune</div>
                <div>25%</div>
                <div>
                <?php
//                print CHtml::link('details',
//                            array('controller/action','param1'=>'value1'),
//                            array('onclick'=>'$("#progressDetails").dialog("open"); return false;')
//                        );
                ?>
                </div>
            </div>-->
            
            <div>[
            <?php
            print CHtml::link('Top Ranking',
                        array('controller/action','param1'=>'value1'),
                        array('onclick'=>'$("#topRanking").dialog("open"); return false;'));
            ?>
            ]</div>
            
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'topRanking',
                'options'=>array(
                    'title'=>'Top Ranking',
                    'width'=>700,
                    'height'=>470,
                    'autoOpen'=>false,
                    'resizable' => false,
                ),
            ));
            require_once(Yii::app()->basePath . '/views/account/topRanking.php');
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            ?>
            
        </li>
    </ul>