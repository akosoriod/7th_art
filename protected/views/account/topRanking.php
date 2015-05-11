<?php
$categories=array();
$rankingUsers=User::getTopRanking();
foreach ($rankingUsers as $user) {
    $categories[]=$user["fullname"];
}
//Muestra la lista de sets de actividades
$series=array();
foreach (ActivitySet::getPublished() as $activitySet) {
    $data=array();
    foreach ($rankingUsers as $user) {
        $data[]=$activitySet->percent(User::model()->findByPk($user['id']));
    }
    $series[]=array(
        'name'=>$activitySet->title,
        'data'=>$data
    );
}

$this->Widget('application.extensions.yii-highcharts-4_0_4.highcharts.HighchartsWidget', array(
   'options'=>array(
	  'chart' => array('type' => 'bar'),
      'title' => array('text' => 'Progress Details - Top Ranking'),
      'xAxis' => array(
         'categories' => $categories
      ),
      'yAxis' => array(
		 'min' => 0,
         'title' => array('text' => 'Progress (%)')
      ),
	  'legend' => array(
		  'reversed' => true,
	  ),
	  'plotOptions' => array(
		  'series' => array(
			  'stacking' => 'normal',
		  ),
	  ),
      'series' => $series
   )
));