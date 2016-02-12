<?php
$baseDir =dirname(__FILE__).DIRECTORY_SEPARATOR;
$config = array(
	'log_file'=>$baseDir .'log'.DIRECTORY_SEPARATOR.'application.log',
	'secret'=>'NwvprhfBkGuPJnjJp77UPJWJUpgC7mLz',
);

$db = array(
	'dsn'=> 'mysql:charset=UTF8;host=localhost;dbname=microsites', 
	'username'=>'root', 
	'password'=>'riavera'
);
//$db = array(
//	'dsn'=> 'mysql:charset=UTF8;host=webhomecamcom.fatcowmysql.com;dbname=testtrans', 
//	'username'=>'trans', 
//	'password'=>'trans1234'
//);