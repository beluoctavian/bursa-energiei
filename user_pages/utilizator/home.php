<?php 
require '../../core/init_2.php';

$user 		= $users->userdata($_SESSION['id']);

if(!isset($_SESSION['id']) || $user['stat'] != 0){
	header('Location: ../../index.php');
}

$username 	= $user['username'];
$company     = $user['company'];
$contact     = $user['contact'];
$telephone   = $user['telephone'];
$code        = $user['code'];
 
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
				include("../../assets/includes/user_menu.php");
                ?>
            </div>
            <div>
				<?php include("../../assets/includes/facebook_plugin.php"); ?>
            </div>
        </div>
<!-- CONTENT BEGIN -->
        <div id="content">
        	<div class="offer_box">
            	<div><a href="../../cere_oferta.php">Cere <b>GRATUIT</b> oferta de pret furnizorilor de energie electrica.</a></div>
            </div>
        	<div class="span-23 float-left">
            	<div style=" width: 158px; margin-left: 289px;">
                	<a href="../../cere_oferta.php" class="offer_button">Cere oferta!</a>
             	</div>
            </div>
        	<div class="span-23 float-left">
            	<div class="span-container">
                	Alegeti o optiune din meniul din partea stanga sau <a href="../../cere_oferta.php"><b>Cereti o oferta</b></a>.
             	</div>
            </div>
        	<div class="span-23 float-left">
                <h3 class="title">Ce ar trebui sa stiti?</h3>
                <div class="span-container">
                    <div>Cota de facturare la Tariful "CPC - componenta de piata concurentiala" din factura emisa de furnizorul implicit de energie, pentru persoanele juridice este in acest moment 100%. Acest tarif reprezinta performanta furnizorului dvs in ceea ce priveste achizitia energiei de pe piata, practic acest terif reflecta pretul de achizitie al energiei de catre furnizor in conditiile unei piete libere la energie. Pentru a analiza posibilitatea reducerii costurilor cu energia electrica va invitam sa transmiteti o cerere de oferta furnizorilor nostri perteneri.<br /><br /></div>
                    <div>Trebuie sa mai stiti ca schimbarea furnizorului de energie electrica poate sa insemne obtinerea unui tarif mai mic la energia electrica chiar de la actualul furnizor, in special atunci cand utilizati un tarif reglementat de ANRE.</div>
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
    	<?php include("../../assets/includes/bottom_bar.php"); ?>
    </div>
</div>
</body>
</html>