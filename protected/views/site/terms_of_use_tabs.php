<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
        'Espa&ntilde;ol'=>array('id'=>'tab_terms_of_use_esp',
											'content'=>$this->renderPartial(
												'/site/_terms_of_use_esp','',true
                                        )),
		'English'=>array('id'=>'tab_terms_of_use_eng',
											'content'=>$this->renderPartial(
												'/site/_terms_of_use_eng','',true
                                        )),
        
    ),
    // additional javascript options for the tabs plugin
    'options'=>array(
        'collapsible'=>true,
    ),
    'id'=>'Tab-Terms-of-Use',
));
?>