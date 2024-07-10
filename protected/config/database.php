<?php
require_once(dirname(__FILE__).'/../vendor/autoload.php');
if (class_exists('Dotenv\Dotenv')) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__).'/../../');
    $dotenv->load();
} else {
    throw new Exception('Dotenv class not found. Make sure vlucas/phpdotenv is installed.');
}
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