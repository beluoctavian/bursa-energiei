<?php 
require '../../core/init_2.php';

$user 		= $users->userdata($_SESSION['id']);

if(!isset($_SESSION['id']) || $user['stat'] != 9){
	header('Location: ../../index.php');
}

$username 	= $user['username'];
$company     = $user['company'];
$contact     = $user['contact'];
$telephone   = $user['telephone'];
$code        = $user['code'];

if (isset($_POST['submit'])) {

	if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['repassword']) || empty($_POST['email']) || empty($_POST['contact']) || empty($_POST['telephone']) || empty($_POST['company'])){

		$errors[] = 'Toate campurile sunt obligatorii.';

	}else{
        
        if ($users->user_exists($_POST['username']) === true) {
            $errors[] = 'Username-ul este deja inregistrat.';
        }
        if(!ctype_alnum($_POST['username'])){
            $errors[] = 'Username-ul poate contine numai litere si cifre.';	
        }
        if (strlen($_POST['username']) <6){
            $errors[] = 'Username-ul trebuie sa contina cel putin 6 caractere.';
        }
		if (strlen($_POST['password']) <6){
            $errors[] = 'Parola trebuie sa aiba cel putin 6 caractere.';
        } else if (strlen($_POST['password']) >18){
            $errors[] = 'Parola nu poate fi mai lunga de 18 caractere.';
        }
		if ($_POST['password'] != $_POST['repassword']){
			$errors[] = 'Cele doua parole nu coincid.';
		}
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Va rugam sa introduceti o adresa de e-mail valida.';
        }else if ($users->email_exists($_POST['email']) === true) {
            $errors[] = 'Adresa de e-mail este deja inregistrata.';
        }
		if(!is_numeric($_POST['telephone'])){
			$errors[] = 'Introduceti doar cifre in casuta "Telefon".';	
		}
	}

	if(empty($errors) === true){
		
		$username 	= htmlentities($_POST['username']);
		$password 	= $_POST['password'];
		$email 		= htmlentities($_POST['email']);
		$contact 	= $_POST['contact'];
		$telephone 	= $_POST['telephone'];
		$company 	= $_POST['company'];
		$minim	= $_POST['minim'];
		$users->register_furnizor($username, $password, $email, $contact, $telephone, $company, $minim);
		header('Location: register_furnizor.php?success');
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bursa energiei</title>
<link href="../../assets/css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>
</head>

<body>
<div id="top_bar">
	<div class="wrapper">
    	<?php include("../../assets/includes/top_bar_nav.php"); ?>
    	<?php include("../../assets/includes/social_sprites.php"); ?>
    </div>
</div>
<div id="header">
	<div class="wrapper">
    	<?php include("../../assets/includes/header.php"); ?>
    </div>
</div>
<div id="navigation_bar">
	<div class="wrapper">
    	<?php include("../../assets/includes/navigation_bar.php"); ?>
    </div>
</div>
<div class="dotted_separator"></div>
<div id="main">
	<div class="wrapper">
		<div id="sidebar">
        	<div id="account">
                <h3 class="align-center">Contul meu</h3>
				<?php
				include("../../assets/includes/admin_menu.php");
                ?>
            </div>
            <div>
				<?php include("../../assets/includes/facebook_plugin.php"); ?>
            </div>
        </div>
<!-- CONTENT BEGIN -->
        <div id="content">
            <h2>Inregistrati un furnizor</h2>
        	<div id="register" class="span-23">
            	<div class="span-container">
					<?php 
                    # if there are errors, they would be displayed here.
                    if(empty($errors) === false){
                        echo '<div class="error">' . implode('</div><div class="error">', $errors) . '</div>';
                    }
					 
					if (isset($_GET['success']) && empty($_GET['success'])) {
					  echo 'Furnizorul a fost inregistrat cu succes.';
					}
                    ?>                    
                    <form method="post" action="">
                        Nume de utilizator:<br />
                        <input type="text" name="username" value="<?php if(isset($_POST['username'])) echo htmlentities($_POST['username']); ?>" />
                        <br />
                        Parola:<br />
                        <input type="password" name="password" />
                        <br />
                        Reintroduceti parola:<br />
                        <input type="password" name="repassword" />
                        <br />
                        E-mail:<br />
                        <input type="text" name="email" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" />
                        <br />
                        Denumire:<br />
                        <input type="text" name="company" value="<?php if(isset($_POST['company'])) echo htmlentities($_POST['company']); ?>" />
                        <br />
                        Persoana de contact:<br />
                        <input type="text" name="contact" value="<?php if(isset($_POST['contact'])) echo htmlentities($_POST['contact']); ?>" />
                        <br />
                        Telefon:<br />
                        <input type="text" name="telephone" value="<?php if(isset($_POST['telephone'])) echo htmlentities($_POST['telephone']); ?>" />
                        <br />
                        Consum minim:<br />
                        <input type="text" name="minim" value="<?php if(isset($_POST['minim'])) echo htmlentities($_POST['minim']); ?>" />
                        <br />
                        <input class="button" type="submit" name="submit" />
                    </form>                   
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
        	<?php include("../../assets/includes/furnizori.php"); ?>
            <div class="clear-both"></div>
        </div>
    </div>
</div>
<div id="footer">
    <div class="wrapper">
    	<?php include("../../assets/includes/footer.php"); ?>
    </div>
</div>
<div id="newsletter">
	<div class="wrapper">
    	<div class="float-left"><img src="../../assets/images/icons/thunderbird_icon.png" /></div>
        <div class="form float-left">
            <h3 class="title">Abonati-va la newsletter!</h3>
            <form action="../../newsletter_subscribe.php" method="post">
            <input class="float-left" type="text" name="email" value="Introduceti adresa de e-mail." onblur="if (this.value == '') {this.value = 'Introduceti adresa de e-mail.';}" onfocus="if (this.value == 'Introduceti adresa de e-mail.') {this.value = '';}" />
            <input class="button float-left" type="submit" name="subscribe" value="Aboneaza-te!"/>
            </form>
        </div>
        <div class="clear-both"></div>
    </div>
</div>
<div id="bottom_bar">
	<div class="wrapper">
    	<?php include("../../assets/includes/bottom_bar.php"); ?>
    </div>
</div>
</body>
</html>