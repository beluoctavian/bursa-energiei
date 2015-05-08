<?php 
require 'core/init.php';
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
        	<div id="login">
                <h3 class="align-center">Daca v-ati activat deja contul, <a href="index.php#login">click aici pentru a va loga.</a></h3>
            </div>
            <div>
				<?php include("assets/includes/facebook_plugin.php"); ?>
            </div>
        </div>
<!-- CONTENT BEGIN -->
        <div id="content">
            <h2>Activati-va contul.</h2>
        	<div id="activate" class="span-23 float-left">
            	<div class="span-container">
					<?php
                    if (isset($_GET['success']) === true && empty ($_GET['success']) === true) {
                        ?>
                        <h3>Va multumim!</h3>
                        <div>V-am activat contul cu succes. Acum va puteti loga.</div>
                        <?php
                            
                    } else if (isset ($_GET['email'], $_GET['email_code']) === true) {
                        
                    $email 		=trim($_GET['email']);
                    $email_code	=trim($_GET['email_code']);
                        
                        if ($users->email_exists($email) === false) {
                            $errors[] = 'Ne pare rau, adresa de e-mail nu a fost gasita.';
                        } else if ($users->activate($email, $email_code) === false) {
                            $errors[] = 'Ne pare rau, nu v-am putut activa contul.';
                        }
                        
                     if(empty($errors) === false){
                        
                    echo '<div class="error">' . implode('</div><div class="error">', $errors) . '</div>';	
                    
                     } else {
             
                            header('Location: activate.php?success');
                            exit();
             
                        }
                    
                    } else {
                      //  header('Location: index.php');
                        //exit();
                    }
                    ?>
       			</div>
            </div>
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