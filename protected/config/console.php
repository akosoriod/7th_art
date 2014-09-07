<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=7th_art',
			'emulatePrepare' => true,
			'username' => '7th_art_web_app',
			'password' => 'nTwWEMb3YjkLTY4',
			'charset' => 'utf8',
		),
                'authManager'=>array(
			'class'=>'CDbAuthManager',
		    'connectionID'=>'db',
			'itemTable' => 'auth_item',
			'itemChildTable' => 'auth_item_child',
			'assignmentTable' => 'auth_assignment',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);