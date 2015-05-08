<?php 
require 'core/init.php';
$general->logged_out_protect();
						
$user 		= $users->userdata($_SESSION['id']);
$stat 	    = $user['stat'];
$username 	= $user['username'];
$company     = $user['company'];
$contact     = $user['contact'];
$telephone   = $user['telephone'];
$code        = $user['code'];

if (isset($_POST['submit'])) {

	$connection = mysql_connect("localhost","rled3635","C0ntroLed"); 
	if(!$connection) { 
	   die("Database connection failed: " . mysql_error()); 
	}else{
	   $db_select = mysql_select_db("rled3635_bursaenergiei",$connection); 
	   if (!$db_select) { 
		   die("Database selection failed:: " . mysql_error()); 
	   } 
	}
	$sql = "SELECT MAX(id) FROM `offers`";
	$result=mysql_query($sql);
	if(!$result){$errors[] = "<p>SQL Error</p>".mysql_error();exit;}
 
	$oferte = $db->prepare("SELECT * FROM `offers` WHERE `request_id`= ? AND `user_id`= ?");
	$oferte->bindValue(1, $_GET['id']);
	$oferte->bindValue(2, $_SESSION['id']);
	$oferte->execute();
	$oferte = $oferte->fetchAll();
	
	$are_oferta = count($oferte);
	if($are_oferta){ $errors[] = "Ati facut deja o oferta pentru aceasta cerere"; }
 
	$row = mysql_fetch_row($result) or die(mysql_error());
	$MaxID =  $row[0] + 1;
	
	$nr_locatii = count($_FILES['fisier']['name']);
	$fisier = array();
	
	if($nr_locatii == 0){

		$errors[] = 'Trebuie sa adaugati neaparat un fisier pentru oferta.';

	}
	
	for($i=0; $i<=$nr_locatii - 1; $i++)
	{	
		if($_FILES['fisier']['name'][$i] != '')
			if($_FILES['fisier']['size'][$i] / 1048576 > 10)
			{
				$errors[] =  $_FILES['fisier']['name'][$i].' nu s-a putut uploada. Size: '.($_FILES['fisier']['size'][$i] / 1048576).' MB';
				
				$fisier[] = '';
			}
			else
			{
				$nume = $_FILES['fisier']['name'][$i];
				
				while(file_exists("uploads/oferte/" . $nume))
					$nume = rand(0,9999999).$_FILES['fisier']['name'][$i];
				
				if(!move_uploaded_file($_FILES["fisier"]["tmp_name"][$i],"uploads/oferte/" . $nume))
					$errors[] = $_FILES['fisier']['name'][$i].' nu s-a putut uploada. Size: '.($_FILES['fisier']['size'][$i] / 1048576).' MB';
				
				$fisier[] = $nume;
			}
	}
	
	if(empty($errors) === true){
		
		$request_id = $_GET['id'];
		$oferta = $_POST['oferta'];
  		$offers->register($request_id, $_SESSION['id'], $oferta);
		
		$request = $requests->requestdata($request_id);
		
		$headers = 'From:Bursaenergiei.ro<office@bursaenergiei.ro>\r\n';

		$consumator_to_mail = $users->userdata($request['user_id']);
		mail($consumator_to_mail['email'], 'Oferta primita!', "Buna ziua,\r\nAti primit o oferta la cererea dumneavoastra de furnizare de energie electrica. Id-ul cererii este " . $request['id'] . ". Accesati http://www.bursaenergiei.ro pentru detalii.\r\n\r\nCu Stima,\nEchipa BursaEnergiei.ro\nS.C. CONTROL LED ENERGY S.R.L.\nNr. Reg. Com.: J40/5977/25.05.2012\nCUI/CIF: RO30242910\nTelefon: 0765.513.472.\nFax: 0372.001.307\nE-mail: office@bursaenergiei.ro",$headers);
	
		$admin_to_mail 		= $users->get_admins();
		$admin_to_mail_count = count($admin_to_mail);
		foreach ($admin_to_mail as $mailadmin) {
			mail($mailadmin['email'], 'Oferta transmisa!', "Buna ziua,\r\nS-a transmis o oferta la cererea de furnizare de energie electrica cu id-ul: " . $request['id'] . ". Accesati http://www.bursaenergiei.ro pentru detalii.\r\n\r\nCu Stima,\nEchipa BursaEnergiei.ro\nS.C. CONTROL LED ENERGY S.R.L.\nNr. Reg. Com.: J40/5977/25.05.2012\nCUI/CIF: RO30242910\nTelefon: 0765.513.472.\nFax: 0372.001.307\nE-mail: office@bursaenergiei.ro",$headers);
		}
		
		$query = $db->prepare("UPDATE `offers` SET `file`= ? WHERE `id`= ?");
		$query->bindValue(1, $nume);
		$query->bindValue(2, $MaxID);
		$query->execute();
		
		header('Location: creeaza_oferta.php?success');
		exit();
	}
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
					if($stat == 0){header('Location: home.php');}
					if($stat == 1){include("assets/includes/furnizor_menu.php");}
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
        	<div class="span-23 float-left">
            	<?php if(isset($_GET['id'])) { ?><h3>Raspundeti cu oferta de pret cererii cu id-ul: <?php echo $_GET['id']; ?></h3><?php } ?>
            	<div class="span-container">
					<?php 
                    # if there are errors, they would be displayed here.
                    if(empty($errors) === false){
                        echo '<div class="error">' . implode('</div><div class="error">', $errors) . '</div>';
                    }
					 
					if (isset($_GET['success']) && empty($_GET['success']) && empty($errors) === true) {
						echo '<div class="error">Oferta a fost trimisa.</div>';
					    ?>
						<script type="text/javascript">
                        
                        (function () {
                            var timeLeft = 5,
                                cinterval;
                        
                            var timeDec = function (){
                                timeLeft--;
                                document.getElementById('countdown').innerHTML = timeLeft;
                                if(timeLeft === 0){
                                    clearInterval(cinterval);
                                }
                            };
                        
                            cinterval = setInterval(timeDec, 1000);
                        })();
                        
                        </script>
                        
                        <div class="error">Veti fi redirectionat in <span id="countdown">5</span> secunde.</div>
						<?php
						header( "refresh:5;url=home.php" );
					}
					if (!isset($_GET['success']) || !empty($_GET['success']) || !empty($errors) === true) {
					?>
                    <form id="cerere" method="post" action="" enctype="multipart/form-data">
                        <label for="file">Va rugam sa adaugati un fisier (Max 10 MB):</label><br />
                        <input name="fisier[]" type="file" id="file" />
                        <br />
                        Daca doriti puteti scrie si un mesaj:<br />
                        <textarea style="width: 99%; height: 300px;" name="oferta"><?php if(isset($_POST['oferta'])) echo htmlentities($_POST['oferta']); ?></textarea>
                        <input class="button" type="submit" name="submit" value="Trimiteti"/>
                    </form>
                    <?php
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