<?php
// Ref: http://demo.bsourcecode.com/yiiframework/cjuiaccordion

$faqs = Faq::model()->findAll();

$arrPanel = array();
foreach($faqs as $faq){
	$arrPanel[$faq->question] = $faq->answer;
}

$this->widget('zii.widgets.jui.CJuiAccordion',array(
    'panels'=>$arrPanel,
    // additional javascript options for the accordion plugin
    'options'=>array(
        'collapsible'=> true,
        'animated'=>'bounceslide',
        'autoHeight'=>false,
        'active'=>0,
    ),
));
?>