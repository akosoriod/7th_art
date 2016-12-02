<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
        'Espa&ntilde;ol'=>array('id'=>'tab_copyright_esp',
											'content'=>$this->renderPartial(
												'/site/_copyright_esp','',true
                                        )),
		'English'=>array('id'=>'tab_copyright_eng',
											'content'=>$this->renderPartial(
												'/site/_copyright_eng','',true
                                        )),
        
    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>true,
    ),
    'id'=>'Tab-Copyright',
));
?>