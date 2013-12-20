<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'社交管理系统',
	'theme' => 'default',
	'language' => 'zh_cn',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.components.*',
		'application.components.xz.*',
		'application.components.api.*',
		'application.components.widgets.*',
		'application.models.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'andy',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			// accessControl验证失败，默认跳转的url
			'loginUrl' => array('/site'),
		),
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>require(dirname(__FILE__).'/rules.php'),
		),
		
		'db'=>require(dirname(__FILE__).'/db.php'),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				
				// array(
				// 	'class'=>'CWebLogRoute',
				// ),
			),
		),

		'cache' => array(
          	// 'class' => 'CApcCache'
           'class' => 'CFileCache'
        ),	

		//下面是一些自己定义的组建
		'parseRss' => array(
			'class' => 'ext.parseRss.components.parseRss'
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);