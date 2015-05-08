<?php 
session_start();
$absolute_path = 'http://www.bursaenergiei.ro';

require 'connect/database.php';
require 'classes/users.php';
require 'classes/requests.php';
require 'classes/offers.php';
require 'classes/general.php';
require 'classes/bcrypt.php';
require 'classes/class.paginator.php';
require 'news/includes/functions.php';

$users 		= new Users($db);
$requests    = new Requests($db);
$offers    = new Offers($db);
$general 	= new General();
$bcrypt 	= new Bcrypt(12);

$errors = array();

if ($general->logged_in() === true)  {
	$user_id 	= $_SESSION['id'];
	$user 		= $users->userdata($user_id);
}


ob_start();