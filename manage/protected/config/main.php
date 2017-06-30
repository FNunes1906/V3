<?php
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Townwizard - Admin pages',
	'defaultController'=>'site/login',
	'theme'=>'twtheme',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.pager.*',
		'ext.yii-mail.YiiMailMessage',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(

/*		'mail' => array(
			'class' => 'ext.yii-mail.YiiMail',
			'transportType'=>'smtp',
			'transportOptions'=>array(
				'host'=>'smtp.gmail.com',
				'username'=>'yogitownwizard@gmail.com',
				'password'=>'Wiz_1368!',
				'port'=>'465',
				'encryption'=>'ssl',
			),
			'viewPath' => 'application.views.mail',
			'logging' => true,
			'dryRun' => false
		),
*/
		'mail' => array(
			'class' => 'ext.yii-mail.YiiMail',
			'transportType'=>'php',
			'viewPath' => 'application.views.mail',
			'logging' => true,
			'dryRun' => false
		),


		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		'bootstrap' => array(
            'class'=>'bootstrap.components.Bootstrap'
        ),
		
		'image'=>array(
			'class'=>'application.extensions.image.CImageComponent',
			'driver'=>'GD',
		),

 		//'request' => array(
        //   'baseUrl' => 'http://'.$_SERVER['HTTP_HOST'],
        //),


		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		// enable cookie 
		'request'=>array(
            'enableCookieValidation'=>true,
        ),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					//'class'=>'CFileLogRoute',
					//'levels'=>'error, warning',
					'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                	'ipFilters'=>array('127.0.0.1','192.168.1.215'),
					
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'no-reply@townwizard.com',
		'defaultPageSize' => 10,
	),
);