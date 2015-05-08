<?php 
#home that redirects to each user home
require 'core/init.php';
$general->logged_out_protect();

$user 		= $users->userdata($_SESSION['id']);

$username 	= $user['username'];
$company     = $user['company'];
$contact     = $user['contact'];
$telephone   = $user['telephone'];
$code        = $user['code'];

$stat 	    = $user['stat'];
if($stat == 0){header('Location: '.$absolute_path.'/user_pages/utilizator/home.php');}
if($stat == 1){header('Location: '.$absolute_path.'/user_pages/furnizor/home.php');}
if($stat == 9){header('Location: '.$absolute_path.'/user_pages/admin/home.php');}
 
?>
