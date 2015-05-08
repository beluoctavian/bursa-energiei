<?php 
require 'core/init.php';
if(isset($_SESSION['id'])){
	$user 		= $users->userdata($_SESSION['id']);
	$stat 	    = $user['stat'];
	$username 	= $user['username'];
	$company     = $user['company'];
	$contact     = $user['contact'];
	$telephone   = $user['telephone'];
	$code        = $user['code'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bursa energiei</title>
<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>
</head>

<body>
<div id="top_bar">
	<div class="wrapper">
    	<?php include("assets/includes/top_bar_nav.php"); ?>
    	<?php include("assets/includes/social_sprites.php"); ?>
    </div>
</div>
<div id="header">
	<div class="wrapper">
    	<?php include("assets/includes/header.php"); ?>
    </div>
</div>
<div id="navigation_bar">
	<div class="wrapper">
    	<?php include("assets/includes/navigation_bar.php"); ?>
    </div>
</div>
<div class="dotted_separator"></div>
<div id="main">
	<div class="wrapper">
		<div id="sidebar">
			<?php
				if(isset($_SESSION['id'])){
			?>
                <div id="account">
                    <h3 class="align-center">Contul meu</h3>
            <?php
					if($stat == 0){include("assets/includes/user_menu.php");}
					if($stat == 1){include("assets/includes/furnizor_menu.php");}
					if($stat == 9){include("assets/includes/admin_menu.php");}
			?>
                </div>
            <?php		
                }
            	if(!isset($_SESSION['id'])){
					include("login.php");
				}
			?>
            <div>
				<?php include("assets/includes/facebook_plugin.php"); ?>
            </div>
        </div>
<!-- CONTENT BEGIN -->
        <div id="content">
        	<div class="span-23 float-left">
                <h3 class="title">Intrebari frecvente</h3>
                <div class="span-container">
                    <?php
					$query = $db->prepare("SELECT `content` FROM `pages` WHERE `name` = ?");
					$query->bindValue(1, 'intrebari_frecvente');
					$query->execute();
					$intrebari_frecvente = $query->fetch(PDO::FETCH_ASSOC);
					$text = html_entity_decode($intrebari_frecvente['content']);
					echo $text;
					?>
                </div>
            </div>
            <div class="clear-both"></div>
        </div>
<!-- CONTENT END -->
        <div class="clear-both"></div>
    </div>
    <div class="waves-graph-separator"></div>
</div>
<div id="main-second">
	<div class="wrapper">
        <h3 class="title">Furnizori</h3>
        <div id="furnizori_container">
        	<?php include("assets/includes/furnizori.php"); ?>
            <div class="clear-both"></div>
        </div>
    </div>
</div>
<div id="footer">
    <div class="wrapper">
    	<?php include("assets/includes/footer.php"); ?>
    </div>
</div>
<div id="newsletter">
	<div class="wrapper">
    	<div class="float-left"><img src="assets/images/icons/thunderbird_icon.png" /></div>
        <div class="form float-left">
            <h3 class="title">Abonati-va la newsletter!</h3>
            <form action="newsletter_subscribe.php" method="post">
            <input class="float-left" type="text" name="email" value="Introduceti adresa de e-mail." onblur="if (this.value == '') {this.value = 'Introduceti adresa de e-mail.';}" onfocus="if (this.value == 'Introduceti adresa de e-mail.') {this.value = '';}" />
            <input class="button float-left" type="submit" name="subscribe" value="Aboneaza-te!"/>
            </form>
        </div>
        <div class="clear-both"></div>
    </div>
</div>
<div id="bottom_bar">
	<div class="wrapper">
    	<?php include("assets/includes/bottom_bar.php"); ?>
    </div>
</div>
</body>
</html>