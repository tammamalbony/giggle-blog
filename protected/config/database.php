<?php

// This is the database connection configuration.
return array(
	// 'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=' .  $_ENV['DB_HOST'] . ';dbname=' .  $_ENV['DB_NAME'],
    'emulatePrepare' => true,
    'username' =>  $_ENV['DB_USERNAME'],
    'password' =>  $_ENV['DB_PASSWORD'],
    'charset' =>  $_ENV['DB_CHARSET'],
);