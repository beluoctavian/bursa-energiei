<?php
require 'core/init.php';
$general->logged_in_protect();
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
            <div>
				<?php include("assets/includes/facebook_plugin.php"); ?>
            </div>
        </div>
<!-- CONTENT BEGIN -->
        <div id="content">
           	<div class="span-23 float-left">
                <h2 class="title">Recuperati-va username-ul / parola.</h2>
                    <div class="formular span-container">
						<?php
                        if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
                            ?>	
                            <div class="error">Verificati-va e-mail-ul pentru a confirma cererea de resetare a parolei.</div>
                            <?php
                        } else {
                            if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
                                if ($users->email_exists($_POST['email']) === true){
                                    $users->confirm_recover($_POST['email']);
                 
                                    header('Location:confirm-recover.php?success');
                                    exit();
                                    
                                } else {
                                    echo '<div class="error">Ne pare rau, email-ul nu este inregistrat.</div>';
                                }
                            }
                            ?>
                        <div>Introduceti email-ul pentru va putea putea prealua cererea.</div>
                        <form action="" method="post">
                            E-mail:<br />
                            <input type="text" required name="email">
                            <br />
                            <input class="button" type="submit" name="submit" />
                        </form>
                    </div>
                    <?php	
                }
                ?>
            </div></div>
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