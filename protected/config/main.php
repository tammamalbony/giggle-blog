<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=> $_ENV['APP_NAME'],

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=> $_ENV['GII_PASSWORD'],
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => array('user/login'),
		),

		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'manifest.json' => 'site/manifest',
    		    'service-worker.js' => 'site/serviceWorker',
			),
		),
		
		'session' => array(
				'autoStart' => true,
			),
		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),
		'mail' => [
			'class' => 'application.components.MailComponent',
			'Host' => $_ENV['MAIL_HOST'],
			'Username' => $_ENV['MAIL_USERNAME'],
			'Password' => $_ENV['MAIL_PASSWORD'],
			'Port' =>  $_ENV['MAIL_PORT'],
			'SMTPSecure' =>  $_ENV['MAIL_SMTP_SECURE'],
			'SMTPAuth' => $_ENV['MAIL_SMTP_AUTH'] === 'true',
			'From' => $_ENV['MAIL_FROM'],
			'FromName' => $_ENV['APP_NAME'],
		],
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
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
		'adminEmail'=> $_ENV['ADMIN_MAIL'],
	),
);
