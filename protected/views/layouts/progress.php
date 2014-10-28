    <ul>
        <li>Total Progress 53%</li>
        <li>
            <div class='progress'>
                <div>Perfume</div>
                <div>100%</div>
                <div><?php print CHtml::image(Yii::app()->request->baseUrl."/images/test/check-img.png","",""); ?></div>
                <div><?php print CHtml::link('details',array('controller/action','param1'=>'value1')); ?></div>
            </div>
            <div class='progress'>
                <div>Horton</div>
                <div>27%</div>
                <div><?php print CHtml::link('details',array('controller/action','param1'=>'value1')); ?></div>
            </div>
            <div class='progress'>
                <div>Shine</div>
                <div>60%</div>
                <div><?php print CHtml::link('details',array('controller/action','param1'=>'value1')); ?></div>
            </div>
            <div class='progress'>
                <div>Dune</div>
                <div>25%</div>
                <div><?php print CHtml::link('details',array('controller/action','param1'=>'value1')); ?></div>
            </div>
            <div>[<?php print CHtml::link('Top Ranking'); ?>]</div>
        </li>
    </ul>