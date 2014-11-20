<?php
$this->Widget('application.extensions.yii-highcharts-4_0_4.highcharts.HighchartsWidget', array(
   'options'=>array(
	  'chart' => array('type' => 'bar'),
      'title' => array('text' => 'Progress Details - Top Ranking'),
      'xAxis' => array(
         'categories' => array(Yii::app()->user->_cn, 'Student 1', 'Student 2', 'Student 3', 'Student 4', 'Student 5')
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
      'series' => array(
         array('name' => 'Perfume', 'data' => array(3, 3, 2, 2, 1, 1)),
         array('name' => 'Horton', 'data' => array(4, 3, 5, 4, 2, 2)),
         array('name' => 'Shine', 'data' => array(4, 4, 2, 3, 4, 3)),
         array('name' => 'Dune', 'data' => array(4, 4, 3, 2, 3, 3)),
      )
   )
));
?>