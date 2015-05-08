<?php 
$config = array(
	'host'		=> 'localhost',
	'username' 	=> 'rled3635',
	'password' 	=> 'C0ntroLed',
	'dbname' 	=> 'rled3635_bursaenergiei'
);

$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>