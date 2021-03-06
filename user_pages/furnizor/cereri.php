<?php 
require '../../core/init_2.php';
$general->logged_out_protect();
 
$user 		= $users->userdata($_SESSION['id']);

$username 	= $user['username'];
$company     = $user['company'];
$contact     = $user['contact'];
$telephone   = $user['telephone'];
$code        = $user['code'];

$cereri 		= $requests->get_requests($_SESSION['id'],$user['stat']);
$cereri_count = count($cereri);
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
				if(isset($_SESSION['id'])){
					$stat 	    = $user['stat'];
					if($stat == 0){include("../../assets/includes/user_menu.php");}
					if($stat == 1){include("../../assets/includes/furnizor_menu.php");}
					if($stat == 9){include("../../assets/includes/admin_menu.php");}
                }
                ?>
            </div>
            <div>
				<?php include("../../assets/includes/facebook_plugin.php"); ?>
            </div>
        </div>
<!-- CONTENT BEGIN -->
        <div id="content">
            <h3>Cereri de oferte</h3>
        	<div class="span-23 span-container">
                <h4>Filtrare cereri:</h4>
                <form method="post" action="">
                    Consum mediu anual minim:<br />
                    <input type="text" name="cmin" value="<?php if(isset($_POST['cmin'])) echo htmlentities($_POST['cmin']); ?>" /> 
                    <input class="button" type="submit" name="submit" value="Cauta!"/>
                </form>  
                <p>Dati click pe cerere pentru mai multe detalii.</p>
                <table id="cereri">
                	<thead>
              		<tr class="align-center">
                        <th>Id</th>
                        <th>Nume solicitant</th>
                        <th>Nume societate</th>
                        <th>Consum mediu anual</th>
                        <th>Tensiune de alimentare</th>
                        <th>Data</th>
                        <th>Oferta transmisa</th>
                    </tr>
                    </thead>
                    <tbody>
				<?php 
                foreach ($cereri as $cerere) {
					if(isset($_POST['cmin'])){
						if($_POST['cmin'] > $cerere['consum_total_anual']){ continue; }
					}
					$user_req 		= $users->userdata($cerere['user_id']);

					?>
                    <tr class="align-center">
                        <td><a href="../../request.php?id=<?php echo $cerere['id']; ?>"><?php echo $cerere['id'];?></a></td>
                        <td><a href="../../request.php?id=<?php echo $cerere['id']; ?>"><?php echo $user_req['contact'];?></a></td>
                        <td><a href="../../request.php?id=<?php echo $cerere['id']; ?>"><?php echo $user_req['company'];?></a></td>
                        <td><a href="../../request.php?id=<?php echo $cerere['id']; ?>"><?php echo $cerere['consum_total_anual'];?> kWh</a></td>
                        <td><a href="../../request.php?id=<?php echo $cerere['id']; ?>"><?php echo $cerere['alimentare'];?> kV</a></td>
                        <td><a href="../../request.php?id=<?php echo $cerere['id']; ?>"><?php echo date('d/m/y', $cerere['time']);?></a></td>
                        <td><a href="../../request.php?id=<?php echo $cerere['id']; ?>">
							<?php
							$oferte = $db->prepare("SELECT * FROM `offers` WHERE `request_id`= ? AND `user_id`= ?");
							$oferte->bindValue(1, $cerere['id']);
							$oferte->bindValue(2, $_SESSION['id']);
							$oferte->execute();
							$oferte = $oferte->fetchAll();
							if(count($oferte)>0) echo '<img src="../../assets/images/icons/OK.png" />';
							else echo '<img src="../../assets/images/icons/ico-x.png" />';
							?>
                        </a></td>
                    </tr>
                    <?php
                }
                ?>
                	</tbody>
                </table>
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