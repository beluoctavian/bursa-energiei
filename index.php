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
<link rel="stylesheet" href="assets/slider/nivo-slider.css" type="text/css" media="screen" />
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
        	<?php include("login.php"); ?>
            <div>
				<?php include("assets/includes/facebook_plugin.php"); ?>
            </div>
        </div>
<!-- CONTENT BEGIN -->
        <div id="content">
        	<div class="offer_box">
            	<div class="float-left">Cere <b>GRATUIT</b> oferta de pret furnizorilor de energie electrica.</div>
                <div class="float-right"><a href="register.php" class="offer_button">Cere oferta!</a></div>
                <div class="clear-both"></div>
            </div>
            <div id="slider-wrapper">
            
                <div id="slider" class="nivoSlider">
					<?php
                    $images = $users->get_banner_images();
                    foreach ($images as $img){ echo '<img src="assets/images/slider/'.$img['image'].'" alt="" />';}
					?>
                </div>
            </div>
            <div class="span-7 float-left">
            	<div class="circle_frame_blue div-center"><img src="assets/images/icons/question-icon-40-blue.png" /></div>
                <h3 class="align-center">Ce este BursaEnergiei?</h3>
                <div class="span-container align-center">BursaEnergiei.ro este un promotor al liberalizarii pietei de energie electrica la consumatorii finali. Asigura consultanta gratuita in schimbarea furnizorului de energie electrica.</div>
            </div>
            <div class="span-1 separator float-left">&nbsp;</div>
            <div class="span-7 float-left">
            	<div class="circle_frame_blue div-center"><img src="assets/images/icons/suit-icon-blue.png" /></div>
                <h3 class="align-center">Cui ne adresam?</h3>
                <div class="span-container align-center">Momentan acest serviciu este adresat numai persoanelor juridice, ca urmare a aplicarii calendarului de eliminare a preturilor reglementate de ANRE la energia electrica incepand cu 01.01.2014.</div>
            </div>
            <div class="span-1 separator float-left">&nbsp;</div>
            <div class="span-7 float-left">
            	<div class="circle_frame_blue div-center"><img src="assets/images/icons/light-bulb-icon-40-blue.png" /></div>
                <h3 class="align-center">Cereri transmise:</h3>
                <div class="span-container align-center">
					<?php
					if(file_exists('count_file.txt'))
					{
						$fil = fopen('count_file.txt','r');
						$dat = fread($fil,filesize('count_file.txt'));
						echo number_format($dat,2).' GWh/an';
						fclose($fil);
					}
					else
					{
						$fil = fopen('count_file.txt','w');
						fwrite($fil,155);
						echo '155';
						fclose($fil);
					}
                    ?>
                </div>
            </div>
            <div class="clear-both"></div>
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
    <script type="text/javascript" src="assets/slider/demo/scripts/jquery-1.4.3.min.js"></script>
    <script type="text/javascript" src="assets/slider/jquery.nivo.slider.pack.js"></script>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script>
	<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-37879649-1', 'auto');
      ga('send', 'pageview');
    
    </script>
</body>
</html>