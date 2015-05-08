<?php 
session_start();
$absolute_path = 'http://www.bursaenergiei.ro';

require '../../core/connect/database.php';
require '../../core/classes/users.php';
require '../../core/classes/requests.php';
require '../../core/classes/offers.php';
require '../../core/classes/general.php';
require '../../core/classes/bcrypt.php';
require '../../core/classes/class.paginator.php';
require '../../news/includes/functions.php';

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


ob_start(); // Added to avoid a common error of 'header already sent'