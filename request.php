<?php 
require 'core/init.php';
$general->logged_out_protect();
$user 		= $users->userdata($_SESSION['id']);
$username 	= $user['username'];
$company     = $user['company'];
$contact     = $user['contact'];
$telephone   = $user['telephone'];
$code        = $user['code'];

$locations 		= $requests->get_locations($_GET['id']);
$locations_count = count($locations);

#if delete was submitted
if (empty($_POST) === false && $user['stat'] == 9) {
	$request     = $requests->delete_request($_GET['id']);
	$offer       = $offers->delete_request_offers($_GET['id']);
}

if(isset($_GET['id']) && empty($_GET['id']) === false) { // Putting everything in this if block.
	if ($requests->request_exists($_GET['id']) === false) { // If the user doesn't exist
		header('Location:cereri.php'); // redirect to index page. Alternatively you can show a message or 404 error
		die();
	}else{
		$request     = $requests->requestdata($_GET['id']);
		$user_request= $users->userdata($request['user_id']);
		if($user['stat'] == 0 && $user_request['id'] != $user['id']){
			header('Location:cereri.php'); // redirect to index page. Alternatively you can show a message or 404 error
			die();
		}
	} 
}
else{
	header('Location: cereri.php'); // redirect to index if there is no username in the Url
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
        	<div id="account">
                <h3 class="align-center">Contul meu</h3>
				<?php
				if(isset($_SESSION['id'])){
					$stat 	    = $user['stat'];
					if($stat == 0){include("assets/includes/user_menu.php");}
					if($stat == 1){
						include("assets/includes/furnizor_menu.php");
						
						$oferte = $db->prepare("SELECT * FROM `offers` WHERE `request_id`= ? AND `user_id`= ?");
						$oferte->bindValue(1, $_GET['id']);
						$oferte->bindValue(2, $_SESSION['id']);
						$oferte->execute();
						$oferte = $oferte->fetchAll();
						
						$are_oferta = count($oferte);
					}
					else{
						$oferte = $db->prepare("SELECT * FROM `offers` WHERE `request_id`= ?");
						$oferte->bindValue(1, $_GET['id']);
						$oferte->execute();
						$oferte = $oferte->fetchAll();
					}
					if($stat == 9){include("assets/includes/admin_menu.php");}
                }
                ?>
            </div>
            <div>
				<?php include("assets/includes/facebook_plugin.php"); ?>
            </div>
        </div>
<!-- CONTENT BEGIN -->
        <div id="content">
        <!-- ofertele vazute de furnizori -->
				<?php
				if($stat == 1){
					if(count($oferte)>0){
						?>
                    <h3>Oferta dumneavoastra la cererea cu id-ul: <?php echo $request['id'];?></h3>
                    <div class="span-23 span-container">
                        <table id="utilizatori">
                            <thead>
                                <tr class="align-center">
                                    <th>Id</th>
                                    <th>Mesaj atasat</th>
                                    <th>Oferta atasata</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php
                            foreach ($oferte as $ofrt) {
                                ?>
                                <tr class="align-center">
                                    <td><?php echo $ofrt['id'];?></td>
                                    <td><?php echo $ofrt['text'];?></td>
                                    <td><a class="error" href="<?php echo $absolute_path.'/uploads/oferte/'.$ofrt['file'];?>">Dati click aici pentru a deschide oferta.</a></td>
                                    <td><?php 
										if($ofrt['status'] == 0) echo 'In asteptare';
										if($ofrt['status'] == 1) echo 'Acceptata';
										if($ofrt['status'] == 2) echo 'Refuzata';
									?></td>
                                </tr>
                                <?php
							}
						?>
							</tbody>
						</table>
                    </div>
                    <?php
					}
				}
				?>
          <!-- sfarsit oferte vazute de furnizor -->
          
          <!-- oferte vazute de useri -->
				<?php
				if($stat == 0){
					if(count($oferte)>0){
						?>
                    <h3>Ofertele cererii cu id-ul: <?php echo $request['id'];?></h3>
                    <div class="span-23 span-container">
                    	<div>Numarul total de oferte: <?php echo count($oferte);?></div>
                        <table id="utilizatori">
                            <thead>
                                <tr class="align-center">
                                    <th>Id</th>
                                    <th>Furnizor</th>
                                    <th>Mesaj atasat</th>
                                    <th>Oferta atasata</th>
                                    <th>Status</th>
                                    <th colspan="2">Optiuni</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php
                            foreach ($oferte as $ofrt) {
								$user_req 		= $users->userdata($ofrt['user_id']);
                                ?>
                                <tr class="align-center">
                                    <td><?php echo $ofrt['id'];?></td>
                                    <td><?php echo $user_req['company'];?></td>
                                    <td><?php echo $ofrt['text'];?></td>
                                    <td><a class="error" href="<?php echo $absolute_path.'/uploads/oferte/'.$ofrt['file'];?>">Dati click aici pentru a deschide oferta.</a></td>
                                    <td><?php 
										if($ofrt['status'] == 0) echo 'In asteptare';
										if($ofrt['status'] == 1) echo 'Acceptata';
										if($ofrt['status'] == 2) echo 'Refuzata';
									?></td>
                                    <?php
									if($ofrt['status'] == 0){
									?>
                                    <td>
                                        <a onclick="return confirm('Sigur doriti sa ACCEPTATI oferta? Actiunea este definitiva.');" href="user_pages/utilizator/accept_offer.php?id=<?php echo $ofrt['id'];?>">ACCEPTA</a>
                                    </td>
                                    <td>
                                        <a onclick="return confirm('Sigur doriti sa REFUZATI oferta? Actiunea este definitiva.');" href="user_pages/utilizator/deny_offer.php?id=<?php echo $ofrt['id'];?>">REFUZA</a>
                                    </td>
                                    <?php	
									}
									else{
									?>
                                    <td colspan="2">
                                    </td>
                                    <?php	
									}
									?>
                                </tr>
                                <?php
							}
						?>
							</tbody>
						</table>
                    </div>
                    <?php
					}
				}
				?>

          <!-- oferte vazute de admini -->
				<?php
				if($stat == 9){
					if(count($oferte)>0){
						?>
                    <h3>Ofertele cererii cu id-ul: <?php echo $request['id'];?></h3>
                    <div class="span-23 span-container">
                    	<div>Numarul total de oferte: <?php echo count($oferte);?></div>
                        <table id="utilizatori">
                            <thead>
                                <tr class="align-center">
                                    <th>Id</th>
                                    <th>Furnizor</th>
                                    <th>Mesaj atasat</th>
                                    <th>Oferta atasata</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php
                            foreach ($oferte as $ofrt) {
								$user_req 		= $users->userdata($ofrt['user_id']);
                                ?>
                                <tr class="align-center">
                                    <td><?php echo $ofrt['id'];?></td>
                                    <td><?php echo $user_req['company'];?></td>
                                    <td><?php echo $ofrt['text'];?></td>
                                    <td><a class="error" href="<?php echo $absolute_path.'/uploads/oferte/'.$ofrt['file'];?>">Dati click aici pentru a deschide oferta.</a></td>
                                    <td><?php 
										if($ofrt['status'] == 0) echo 'In asteptare';
										if($ofrt['status'] == 1) echo 'Acceptata';
										if($ofrt['status'] == 2) echo 'Refuzata';
									?></td>
                                </tr>
                                <?php
							}
						?>
							</tbody>
						</table>
                    </div>
                    <?php
					}
				}
				?>



          
            <h3>Cerere furnizare - <?php echo $user_request['username'];?></h3>
        	<div class="span-23 span-container">
				<?php
				if($stat == 1 && !$are_oferta){
				?>
                    <a class="button" href="creeaza_oferta.php?id=<?php echo $request['id']; ?>">Raspundeti cu oferta</a>
                <?php
				}
				if($stat == 9){
					?>
                    <form action="" method="post">
                    	<input class="button" name="Submit" type="submit" value="Sterge cererea" />
                    </form> 
                    <?php
				}
				?>
                <h4>Numar locatii consum: <?php echo $locations_count + 1; ?></h4>
                <table id="request">
                    	<tr>
                        	<td>Id cerere</td>
                            <td><?php echo $request['id'];?></td>
                        </tr>
                    	<tr>
                        	<td>Consum TOTAL anual</td>
                            <td><?php echo $request['consum_total_anual'];?> <b>kWh</b></td>
                        </tr>
                    	<tr>
                        	<td>Username</td>
                            <td><?php echo $user_request['username'];?></td>
                        </tr>
                    	<tr>
                        	<td>Persoana de contact	</td>
                            <td><?php echo $user_request['contact'];?></td>
                        </tr>
                    	<tr>
                        	<td>E-mail</td>
                            <td><?php echo $user_request['email'];?></td>
                        </tr>
                    	<tr>
                        	<td>Telefon</td>
                            <td><?php echo $user_request['telephone'];?></td>
                        </tr>
                    	<tr>
                        	<td>Nume societate</td>
                            <td><?php echo $user_request['company'];?></td>
                        </tr>
                    	<tr>
                        	<td>CUI / CIF</td>
                            <td><?php echo $user_request['code'];?></td>
                        </tr>
                    	<tr>
                        	<td>Data trimiterii</td>
                            <td><?php echo date('d/m/Y g:i', $request['time']);?></td>
                        </tr>
                    	<tr>
                        	<td>Data limita de transmitere a ofertei de furnizare</td>
                            <td><?php echo date("d/m/Y",strtotime($request['data_limita']));?></td>
                        </tr>
                    	<tr>
                        	<td>Alte precizari</td>
                            <td><?php echo $request['precizari'];?></td>
                        </tr>
                    	<tr>
                        	<td>Fisier atasat cererii</td>
                            <td><?php if($request['file'] != '') { ?><a href="<?php echo $absolute_path.'/uploads/cereri/'.$request['file'];?>">Dati click aici pentru a deschide fisierul.</a><?php } ?></td>
                        </tr>
                </table>
        	</div>
        	<div class="span-23 span-container">
                <h4>Locatia 1</h4>
                <table id="request">
                    	<tr>
                        	<td>Denumire loc consum</td>
                            <td><?php echo $request['loc'];?></td>
                        </tr>
                    	<tr>
                        	<td>Adresa locului de consum</td>
                            <td><?php echo $request['adresa'];?></td>
                        </tr>
                    	<tr>
                        	<td>Program de lucru</td>
                            <td><?php echo $request['program'];?></td>
                        </tr>
                    	<tr>
                        	<td>Consum mediu lunar</td>
                            <td><?php echo $request['consum_lunar'];?> <b>kWh</b></td>
                        </tr>
                    	<tr>
                        	<td>Consum mediu anual</td>
                            <td><?php echo $request['consum_anual'];?> <b>kWh</b></td>
                        </tr>
                    	<tr>
                        	<td>Consum pe ultimele 12 luni <b>(kWh)</b></td>
                            <td><?php echo $request['consum_ultim'];?></td>
                        </tr>
                    	<tr>
                        	<td>Tensiunea de alimentare</td>
                            <td><?php echo $request['alimentare'];?> <b>kV</b></td>
                        </tr>
                </table>
            </div>
<?php
			$itterator = 1;
			foreach ($locations as $locatie) {
			?>
        	<div class="span-23 span-container">
                <h4>Locatia <?php echo ++$itterator; ?></h4>
                <table id="request">
                    	<tr>
                        	<td>Denumire loc consum</td>
                            <td><?php echo $locatie['loc'];?></td>
                        </tr>
                    	<tr>
                        	<td>Adresa locului de consum</td>
                            <td><?php echo $locatie['adresa'];?></td>
                        </tr>
                    	<tr>
                        	<td>Program de lucru</td>
                            <td><?php echo $locatie['program'];?></td>
                        </tr>
                    	<tr>
                        	<td>Consum mediu lunar</td>
                            <td><?php echo $locatie['consum_lunar'];?> <b>kWh</b></td>
                        </tr>
                    	<tr>
                        	<td>Consum mediu anual</td>
                            <td><?php echo $locatie['consum_anual'];?> <b>kWh</b></td>
                        </tr>
                    	<tr>
                        	<td>Consum pe ultimele 12 luni <b>(kWh)</b></td>
                            <td><?php echo $locatie['consum_ultim'];?></td>
                        </tr>
                    	<tr>
                        	<td>Tensiunea de alimentare</td>
                            <td><?php echo $locatie['alimentare'];?> <b>kV</b></td>
                        </tr>
                </table>
            </div>
			<?php
            }
?>
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