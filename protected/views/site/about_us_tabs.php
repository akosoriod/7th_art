<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
        'Espa&ntilde;ol'=>array('id'=>'tab_about_us_esp',
											'content'=>$this->renderPartial(
												'/site/_about_us_esp','',true
                                        )),
		'English'=>array('id'=>'tab_about_us_eng',
											'content'=>$this->renderPartial(
												'/site/_about_us_eng','',true
                                        )),
        
    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>true,
    ),
    'id'=>'Tab-About-Us',
));
?>