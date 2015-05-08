<?php 
require '../../core/init_2.php';

$user 		= $users->userdata($_SESSION['id']);

if(!isset($_SESSION['id']) || $user['stat'] != 9){
	header('Location: ../../index.php');
}

$delete = $users->delete_mail($_GET['id']);

header('Location: utilizatori.php');
?>