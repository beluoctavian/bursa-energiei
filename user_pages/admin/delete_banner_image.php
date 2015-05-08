<?php
require '../../core/init_2.php'; 
$user 		= $users->userdata($_SESSION['id']);
$util        = $users->userdata($_GET['id']);

if(!isset($_SESSION['id']) || $user['stat'] != 9){
	header('Location:'.$absolute_path.'/index.php');
}

if(isset($_GET['id']) && empty($_GET['id']) === false) { // Putting everything in this if block.
	if($user['stat'] != 9 || $util['stat'] == 9){header('Location:'.$absolute_path.'/index.php');}
	else{
		$img_delete= $users->delete_banner_image($_GET['id']);
		header('Location:'.$absolute_path.'/user_pages/admin/utilizatori.php');	}
}
?>