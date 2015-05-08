<?php 
require 'core/init.php';
$general->logged_out_protect();

$user 		= $users->userdata($_SESSION['id']);

$username 	= $user['username'];
$company     = $user['company'];
$contact     = $user['contact'];
$telephone   = $user['telephone'];
$code        = $user['code'];

if (isset($_POST['submit'])) {

	if(empty($_POST['loc']) || empty($_POST['adresa']) || empty($_POST['program']) || empty($_POST['consum_mediu']) || empty($_POST['consum_ultim']) || empty($_POST['alimentare'])){

		$errors[] = 'Toate campurile locatiei 1 sunt obligatorii.';

	}else{
        
		if(!is_numeric($_POST['consum_mediu'])){
			$errors[] = 'Introduceti in casuta "consum mediu lunar" din LOCATIA 1 doar cifre (Ex: 157).';	
		}
		if(!is_numeric($_POST['consum_anual'])){
			$errors[] = 'Introduceti in casuta "consum mediu anual" din LOCATIA 1 doar cifre (Ex: 2437).';	
		}
		if(!is_numeric($_POST['alimentare'])){
			$errors[] = 'Introduceti in casuta "tensiune de alimentare" din LOCATIA 1 doar cifre (Ex: 6).';	
		}

	}
	#if Locatia 2 was submitted
	if(!empty($_POST['loc_2'])){
		if(empty($_POST['adresa_2']) || empty($_POST['program_2']) || empty($_POST['consum_mediu_2']) || empty($_POST['consum_ultim_2']) || empty($_POST['alimentare_2'])){
			
			$errors[] = 'Toate campurile locatiei 2 sunt obligatorii.';
	
		}else{
			
			if(!is_numeric($_POST['consum_mediu'])){
				$errors[] = 'Introduceti in casuta "consum mediu lunar" din LOCATIA 2 doar cifre (Ex: 157).';	
			}
			if(!is_numeric($_POST['consum_anual'])){
				$errors[] = 'Introduceti in casuta "consum mediu anual" din LOCATIA 2 doar cifre (Ex: 2437).';	
			}
			if(!is_numeric($_POST['alimentare'])){
				$errors[] = 'Introduceti in casuta "tensiune de alimentare" din LOCATIA 2 doar cifre (Ex: 6).';	
			}
		}
		
		#if Locatia 3 was submitted
		if(!empty($_POST['loc_3'])){
			if(empty($_POST['adresa_3']) || empty($_POST['program_3']) || empty($_POST['consum_mediu_3']) || empty($_POST['consum_ultim_3']) || empty($_POST['alimentare_3'])){
				
				$errors[] = 'Toate campurile locatiei 3 sunt obligatorii.';
		
			}else{
				
				if(!is_numeric($_POST['consum_mediu'])){
					$errors[] = 'Introduceti in casuta "consum mediu lunar" din LOCATIA 3 doar cifre (Ex: 157).';	
				}
				if(!is_numeric($_POST['consum_anual'])){
					$errors[] = 'Introduceti in casuta "consum mediu anual" din LOCATIA 3 doar cifre (Ex: 2437).';	
				}
				if(!is_numeric($_POST['alimentare'])){
					$errors[] = 'Introduceti in casuta "tensiune de alimentare" din LOCATIA 3 doar cifre (Ex: 6).';	
				}
			}
			#if Locatia 4 was submitted
			if(!empty($_POST['loc_4'])){
				if(empty($_POST['adresa_4']) || empty($_POST['program_4']) || empty($_POST['consum_mediu_4']) || empty($_POST['consum_ultim_4']) || empty($_POST['alimentare_4'])){
					
					$errors[] = 'Toate campurile locatiei 4 sunt obligatorii.';
			
				}else{
					
					if(!is_numeric($_POST['consum_mediu'])){
						$errors[] = 'Introduceti in casuta "consum mediu lunar" din LOCATIA 4 doar cifre (Ex: 157).';	
					}
					if(!is_numeric($_POST['consum_anual'])){
						$errors[] = 'Introduceti in casuta "consum mediu anual" din LOCATIA 4 doar cifre (Ex: 2437).';	
					}
					if(!is_numeric($_POST['alimentare'])){
						$errors[] = 'Introduceti in casuta "tensiune de alimentare" din LOCATIA 4 doar cifre (Ex: 6).';	
					}
				}
				#if Locatia 5 was submitted
				if(!empty($_POST['loc_5'])){
					if(empty($_POST['adresa_5']) || empty($_POST['program_5']) || empty($_POST['consum_mediu_5']) || empty($_POST['consum_ultim_5']) || empty($_POST['alimentare_5'])){
						
						$errors[] = 'Toate campurile locatiei 5 sunt obligatorii.';
				
					}else{
						
						if(!is_numeric($_POST['consum_mediu'])){
							$errors[] = 'Introduceti in casuta "consum mediu lunar" din LOCATIA 5 doar cifre (Ex: 157).';	
						}
						if(!is_numeric($_POST['consum_anual'])){
							$errors[] = 'Introduceti in casuta "consum mediu anual" din LOCATIA 5 doar cifre (Ex: 2437).';	
						}
						if(!is_numeric($_POST['alimentare'])){
							$errors[] = 'Introduceti in casuta "tensiune de alimentare" din LOCATIA 5 doar cifre (Ex: 6).';	
						}
					}
				}
			}
		}
	}
	$connection = mysql_connect("localhost","rled3635","C0ntroLed"); 
	if(!$connection) { 
	   die("Database connection failed: " . mysql_error()); 
	}else{
	   $db_select = mysql_select_db("rled3635_bursaenergiei",$connection); 
	   if (!$db_select) { 
		   die("Database selection failed:: " . mysql_error()); 
	   } 
	}
	$sql = "SELECT MAX(id) FROM `requests`";
	$result=mysql_query($sql);
	if(!$result){echo "<p>SQL Error</p>".mysql_error();exit;}
 
	$row = mysql_fetch_row($result) or die(mysql_error());
	$MaxID =  $row[0];

	$nr_locatii = count($_FILES['fisier']['name']);
	$fisier = array();
	
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
				
				while(file_exists("uploads/cereri/" . $nume))
					$nume = rand(0,9999999).$_FILES['fisier']['name'][$i];
				
				if(!move_uploaded_file($_FILES["fisier"]["tmp_name"][$i],"uploads/cereri/" . $nume))
					$errors[] = $_FILES['fisier']['name'][$i].' nu s-a putut uploada. Size: '.($_FILES['fisier']['size'][$i] / 1048576).' MB';
				
				$fisier[] = $nume;
			}
	}
	if(empty($errors) === true){
			
		$loc = $_POST['loc'];
		$adresa = $_POST['adresa'];
		$program = $_POST['program'];
		$consum_lunar = $_POST['consum_mediu'];
		$consum_anual = $_POST['consum_anual'];
		$consum_ultim = $_POST['consum_ultim'];
		$alimentare = $_POST['alimentare'];	
		$data_limita = date('Y-m-d', strtotime($_POST['data_limita']));	
		$precizari = $_POST['precizari'];
  		$requests->register($_SESSION['id'], $loc, $adresa, $program, $consum_lunar, $consum_anual, $consum_ultim, $alimentare, $data_limita, $precizari);
		$minim = $consum_anual;
		$MaxID = $MaxID + 1;
		$query = $db->prepare("UPDATE `requests` SET `file`= ? WHERE `id`= ?");
		$query->bindValue(1, $nume);
		$query->bindValue(2, $MaxID);
		$query->execute();
		
		if(!empty($_POST['loc_2'])){
			$loc = $_POST['loc_2'];
			$adresa = $_POST['adresa_2'];
			$program = $_POST['program_2'];
			$consum_lunar = $_POST['consum_mediu_2'];
			$consum_anual = $_POST['consum_anual_2'];
			$consum_ultim = $_POST['consum_ultim_2'];
			$alimentare = $_POST['alimentare_2'];
			$requests->add_req_place($_SESSION['id'], $loc, $adresa, $program, $consum_lunar, $consum_anual, $consum_ultim, $alimentare, $data_limita, $precizari, $MaxID);
			$requests->add_consum_total($MaxID,$consum_anual);
			$minim += $consum_anual;
			if(!empty($_POST['loc_3'])){
				$loc = $_POST['loc_3'];
				$adresa = $_POST['adresa_3'];
				$program = $_POST['program_3'];
				$consum_lunar = $_POST['consum_mediu_3'];
				$consum_anual = $_POST['consum_anual_3'];
				$consum_ultim = $_POST['consum_ultim_3'];
				$alimentare = $_POST['alimentare_3'];
				$requests->add_req_place($_SESSION['id'], $loc, $adresa, $program, $consum_lunar, $consum_anual, $consum_ultim, $alimentare, $data_limita, $precizari, $MaxID);
				$requests->add_consum_total($MaxID,$consum_anual);
				$minim += $consum_anual;
				if(!empty($_POST['loc_4'])){
					$loc = $_POST['loc_4'];
					$adresa = $_POST['adresa_4'];
					$program = $_POST['program_4'];
					$consum_lunar = $_POST['consum_mediu_4'];
					$consum_anual = $_POST['consum_anual_4'];
					$consum_ultim = $_POST['consum_ultim_4'];
					$alimentare = $_POST['alimentare_4'];
					$requests->add_req_place($_SESSION['id'], $loc, $adresa, $program, $consum_lunar, $consum_anual, $consum_ultim, $alimentare, $data_limita, $precizari, $MaxID);
					$requests->add_consum_total($MaxID,$consum_anual);
					$minim += $consum_anual;
					if(!empty($_POST['loc_5'])){
						$loc = $_POST['loc_5'];
						$adresa = $_POST['adresa_5'];
						$program = $_POST['program_5'];
						$consum_lunar = $_POST['consum_mediu_5'];
						$consum_anual = $_POST['consum_anual_5'];
						$consum_ultim = $_POST['consum_ultim_5'];
						$alimentare = $_POST['alimentare_5'];
						$requests->add_req_place($_SESSION['id'], $loc, $adresa, $program, $consum_lunar, $consum_anual, $consum_ultim, $alimentare, $data_limita, $precizari, $MaxID);
						$requests->add_consum_total($MaxID,$consum_anual);
						$minim += $consum_anual;
					}
				}
			}
		}
		if(file_exists('count_file.txt'))
		{
			$fil = fopen('count_file.txt',r);
			$dat = fread($fil,filesize('count_file.txt'));
			fclose($fil);
			$fil = fopen('count_file.txt',w);
			$ca = $minim * 1.0000 / 1000000;
			fwrite($fil,$dat+$ca);
		}
		else
		{
			$fil = fopen('count_file.txt',w);
			fwrite($fil,155);
			fclose($fil);
		}		
		$headers = 'From:Bursaenergiei.ro<office@bursaenergiei.ro>\r\n';
		
		mail($user['email'], 'Cerere transmisa.', "Buna ziua " . $username. ",\r\nCererea dvs a fost transmisa furnizorilor de energie electrica parteneri. Veti fi contactat in cel mai scurt timp.\r\n\r\nCu Stima,\nEchipa BursaEnergiei.ro\nS.C. CONTROL LED ENERGY S.R.L.\nNr. Reg. Com.: J40/5977/25.05.2012\nCUI/CIF: RO30242910\nTelefon: 0765.513.472.\nFax: 0372.001.307\nE-mail: office@bursaenergiei.ro",$headers);
		
		$furnizori_to_mail 		= $users->get_furnizori();
		$furnizori_to_mail_count = count($furnizori_to_mail);
		foreach ($furnizori_to_mail as $mailfurn) {
			if($mailfurn['minim'] < $minim){
				mail($mailfurn['email'], 'Cerere furnizare energie electrica.', "Buna ziua,\r\nA fost solicitata o cerere de oferta furnizare energie electrica de catre " . $company . " pentru un consum anual de " . $minim . " kWh. Pentru mai multe detalii logativa pe www.Bursaenergiei.ro in contul dvs de furnizor.\r\n\r\nCu Stima,\nEchipa BursaEnergiei.ro\nS.C. CONTROL LED ENERGY S.R.L.\nNr. Reg. Com.: J40/5977/25.05.2012\nCUI/CIF: RO30242910\nTelefon: 0765.513.472.\nFax: 0372.001.307\nE-mail: office@bursaenergiei.ro",$headers);
			
				$allmails = $users->get_emails($mailfurn['id']);
				$allmails_count = count($allmails);
				foreach ($allmails as $alma){
					mail($alma['email'], 'Cerere furnizare energie electrica.', "Buna ziua,\r\nA fost solicitata o cerere de oferta furnizare energie electrica de catre " . $company . " pentru un consum anual de " . $minim . " kWh. Pentru mai multe detalii logativa pe www.Bursaenergiei.ro in contul dvs de furnizor.\r\n\r\nCu Stima,\nEchipa BursaEnergiei.ro\nS.C. CONTROL LED ENERGY S.R.L.\nNr. Reg. Com.: J40/5977/25.05.2012\nCUI/CIF: RO30242910\nTelefon: 0765.513.472.\nFax: 0372.001.307\nE-mail: office@bursaenergiei.ro",$headers);
				}
			}
		}
		
		$admin_to_mail 		= $users->get_admins();
		$admin_to_mail_count = count($admin_to_mail);
		foreach ($admin_to_mail as $mailadmin) {
			mail($mailadmin['email'], 'Cerere furnizare energie electrica.', "Buna ziua,\r\nA fost solicitata o cerere de oferta furnizare energie electrica de catre " . $company . " pentru un consum anual de " . $minim . " kWh. Pentru mai multe detalii logativa pe www.Bursaenergiei.ro in contul dvs de administrator.\r\n\r\nCu Stima,\nEchipa BursaEnergiei.ro\nS.C. CONTROL LED ENERGY S.R.L.\nNr. Reg. Com.: J40/5977/25.05.2012\nCUI/CIF: RO30242910\nTelefon: 0765.513.472.\nFax: 0372.001.307\nE-mail: office@bursaenergiei.ro",$headers);
		}		
		header('Location: cere_oferta.php?success');
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
<script type="text/javascript">
var counter = 0;
var numBoxes = 4;
function toggle4(showHideDiv) {
       var ele = document.getElementById(showHideDiv + counter);
       if(ele.style.display == "block") {
              ele.style.display = "none";
       }
       else {
              ele.style.display = "block";
       }
       if(counter == numBoxes) {
                document.getElementById("toggleButton").style.display = "none";
       }
}
</script>
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
					if($stat == 1){header('Location: home.php');}
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
            	<h3>Cere oferta de pret furnizorilor de energie electrica.</h3>
            	<div class="span-container">
					<?php 
                    # if there are errors, they would be displayed here.
                    if(empty($errors) === false){
                        echo '<div class="error">' . implode('</div><div class="error">', $errors) . '</div>';
                    }
					 
					if (isset($_GET['success']) && empty($_GET['success']) && empty($errors) === true) {
					  echo '<div class="error">Cererea dvs a fost transmisa furnizorilor parteneri. Veti fi contactat in cel mai scurt timp.</div>';
					}
                    ?>                    
                    <form id="cerere" method="post" action="" enctype="multipart/form-data">
                    	<h3>Locatia 1</h3>
                        Denumire loc consum<br />
                        <input type="text" name="loc" value="<?php if(isset($_POST['loc'])) echo htmlentities($_POST['loc']); ?>" /> *
                        <br />
                        Adresa locului de consum (Strada, Numar, Oras, Judet)<br />
                        <input type="text" name="adresa" value="<?php if(isset($_POST['adresa'])) echo htmlentities($_POST['adresa']); ?>" /> *
                        <br />
                        Program de lucru<br />
                        <input type="text" name="program" value="<?php if(isset($_POST['program'])) echo htmlentities($_POST['program']); ?>" /> *
                        <br />
                        Consum mediu lunar (<b>kWh</b> - Ex: 157)<br />
                        <input type="text" name="consum_mediu" value="<?php if(isset($_POST['consum_mediu'])) echo htmlentities($_POST['consum_mediu']); ?>" /> *
                        <br />
                        Consum mediu anual (<b>kWh</b> - Se insumeaza consumurile lunare)<br />
                        <input type="text" name="consum_anual" value="<?php if(isset($_POST['consum_anual'])) echo htmlentities($_POST['consum_anual']); ?>" /> *
                        <br />
                        Consum pe ultimele 12 luni (<b>kWh</b> - Ex: Ianuarie 1244, Februarie 694, Martie 1200, Aprilie 1562, Mai 899, Iunie 120, Iulie 236, August 221, Septembrie 485, Octombrie 688, Noiembrie 521, Decembrie 988)<br />
                        <textarea name="consum_ultim"><?php if(isset($_POST['consum_ultim'])) echo htmlentities($_POST['consum_ultim']); else echo '' ?></textarea> *
                        <br />
                        Tensiunea de alimentare (<b>kV</b> - Ex: 0.4 / 6 / 20 / 110)<br />
                        <input type="text" name="alimentare" value="<?php if(isset($_POST['alimentare'])) echo htmlentities($_POST['alimentare']); ?>" /> *
                        <br />
                        Data limita de transmitere a ofertei de furnizare<br />
						<input type="date" name="data_limita" />
                        <br />
                        Alte precizari (Precizati alte informatii relevante pentru locul dvs de consum)<br />
                        <textarea name="precizari"><?php if(isset($_POST['precizari'])) echo htmlentities($_POST['precizari']); else echo '' ?></textarea>
                        <br />
                        <label for="fisier[]">Daca doriti, puteti adauga si un fisier (Maxim 10 MB).<br />Puteti adauga orice fisier care dataliaza cererea dvs de oferta. Ex: fisiere de consum pe IBD.</label><br />
                        <input name="fisier[]" type="file" id="file" />
                        <br /><br />
                        
<!-- Locatia _2 -->
                    <div id="box1" style="display: none;">
                    	<h3>Locatia 2</h3>
                        Denumire loc consum<br />
                        <input type="text" name="loc_2" value="<?php if(isset($_POST['loc_2'])) echo htmlentities($_POST['loc_2']); ?>" /> *
                        <br />
                        Adresa locului de consum (Strada, Numar, Oras, Judet)<br />
                        <input type="text" name="adresa_2" value="<?php if(isset($_POST['adresa_2'])) echo htmlentities($_POST['adresa_2']); ?>" /> *
                        <br />
                        Program de lucru<br />
                        <input type="text" name="program_2" value="<?php if(isset($_POST['program_2'])) echo htmlentities($_POST['program_2']); ?>" /> *
                        <br />
                        Consum mediu lunar (<b>kWh</b> - Ex: 157)<br />
                        <input type="text" name="consum_mediu_2" value="<?php if(isset($_POST['consum_mediu_2'])) echo htmlentities($_POST['consum_mediu_2']); ?>" /> *
                        <br />
                        Consum mediu anual (<b>kWh</b> - Se insumeaza consumurile lunare)<br />
                        <input type="text" name="consum_anual_2" value="<?php if(isset($_POST['consum_anual_2'])) echo htmlentities($_POST['consum_anual_2']); ?>" /> *
                        <br />
                        Consum pe ultimele 12 luni (<b>kWh</b> - Ex: Ianuarie 1244, Februarie 694, Martie 1200, Aprilie 1562, Mai 899, Iunie 120, Iulie 236, August 221, Septembrie 485, Octombrie 688, Noiembrie 521, Decembrie 988)<br />
                        <textarea name="consum_ultim_2"><?php if(isset($_POST['consum_ultim_2'])) echo htmlentities($_POST['consum_ultim_2']); else echo '' ?></textarea> *
                        <br />
                        Tensiunea de alimentare (<b>kV</b> - Ex: 0.4 / 6 / 20 / 110)<br />
                        <input type="text" name="alimentare_2" value="<?php if(isset($_POST['alimentare_2'])) echo htmlentities($_POST['alimentare_2']); ?>" /> *
                        <br /><br />
                    </div>
<!-- End of Locatia _2 -->

<!-- Locatia _3 -->
                    <div id="box2" style="display: none;">
                    	<h3>Locatia 3</h3>
                        Denumire loc consum<br />
                        <input type="text" name="loc_3" value="<?php if(isset($_POST['loc_3'])) echo htmlentities($_POST['loc_3']); ?>" /> *
                        <br />
                        Adresa locului de consum (Strada, Numar, Oras, Judet)<br />
                        <input type="text" name="adresa_3" value="<?php if(isset($_POST['adresa_3'])) echo htmlentities($_POST['adresa_3']); ?>" /> *
                        <br />
                        Program de lucru<br />
                        <input type="text" name="program_3" value="<?php if(isset($_POST['program_3'])) echo htmlentities($_POST['program_3']); ?>" /> *
                        <br />
                        Consum mediu lunar (<b>kWh</b> - Ex: 157)<br />
                        <input type="text" name="consum_mediu_3" value="<?php if(isset($_POST['consum_mediu_3'])) echo htmlentities($_POST['consum_mediu_3']); ?>" /> *
                        <br />
                        Consum mediu anual (<b>kWh</b> - Se insumeaza consumurile lunare)<br />
                        <input type="text" name="consum_anual_3" value="<?php if(isset($_POST['consum_anual_3'])) echo htmlentities($_POST['consum_anual_3']); ?>" /> *
                        <br />
                        Consum pe ultimele 12 luni (<b>kWh</b> - Ex: Ianuarie 1244, Februarie 694, Martie 1200, Aprilie 1562, Mai 899, Iunie 120, Iulie 236, August 221, Septembrie 485, Octombrie 688, Noiembrie 521, Decembrie 988)<br />
                        <textarea name="consum_ultim_3"><?php if(isset($_POST['consum_ultim_3'])) echo htmlentities($_POST['consum_ultim_3']); else echo '' ?></textarea> *
                        <br />
                        Tensiunea de alimentare (<b>kV</b> - Ex: 0.4 / 6 / 20 / 110)<br />
                        <input type="text" name="alimentare_3" value="<?php if(isset($_POST['alimentare_3'])) echo htmlentities($_POST['alimentare_3']); ?>" /> *
                        <br /><br />
                    </div>
<!-- End of Locatia _3 -->

<!-- Locatia _4 -->
                    <div id="box3" style="display: none;">
                    	<h3>Locatia 4</h3>
                        Denumire loc consum<br />
                        <input type="text" name="loc_4" value="<?php if(isset($_POST['loc_4'])) echo htmlentities($_POST['loc_4']); ?>" /> *
                        <br />
                        Adresa locului de consum (Strada, Numar, Oras, Judet)<br />
                        <input type="text" name="adresa_4" value="<?php if(isset($_POST['adresa_4'])) echo htmlentities($_POST['adresa_4']); ?>" /> *
                        <br />
                        Program de lucru<br />
                        <input type="text" name="program_4" value="<?php if(isset($_POST['program_4'])) echo htmlentities($_POST['program_4']); ?>" /> *
                        <br />
                        Consum mediu lunar (<b>kWh</b> - Ex: 157)<br />
                        <input type="text" name="consum_mediu_4" value="<?php if(isset($_POST['consum_mediu_4'])) echo htmlentities($_POST['consum_mediu_4']); ?>" /> *
                        <br />
                        Consum mediu anual (<b>kWh</b> - Se insumeaza consumurile lunare)<br />
                        <input type="text" name="consum_anual_4" value="<?php if(isset($_POST['consum_anual_4'])) echo htmlentities($_POST['consum_anual_4']); ?>" /> *
                        <br />
                        Consum pe ultimele 12 luni (<b>kWh</b> - Ex: Ianuarie 1244, Februarie 694, Martie 1200, Aprilie 1562, Mai 899, Iunie 120, Iulie 236, August 221, Septembrie 485, Octombrie 688, Noiembrie 521, Decembrie 988)<br />
                        <textarea name="consum_ultim_4"><?php if(isset($_POST['consum_ultim_4'])) echo htmlentities($_POST['consum_ultim_4']); else echo '' ?></textarea> *
                        <br />
                        Tensiunea de alimentare (<b>kV</b> - Ex: 0.4 / 6 / 20 / 110)<br />
                        <input type="text" name="alimentare_4" value="<?php if(isset($_POST['alimentare_4'])) echo htmlentities($_POST['alimentare_4']); ?>" /> *
                        <br /><br />
                    </div>
<!-- End of Locatia _4 -->

<!-- Locatia _5 -->
                    <div id="box4" style="display: none;">
                    	<h3>Locatia 5</h3>
                        Denumire loc consum<br />
                        <input type="text" name="loc_5" value="<?php if(isset($_POST['loc_5'])) echo htmlentities($_POST['loc_5']); ?>" /> *
                        <br />
                        Adresa locului de consum (Strada, Numar, Oras, Judet)<br />
                        <input type="text" name="adresa_5" value="<?php if(isset($_POST['adresa_5'])) echo htmlentities($_POST['adresa_5']); ?>" /> *
                        <br />
                        Program de lucru<br />
                        <input type="text" name="program_5" value="<?php if(isset($_POST['program_5'])) echo htmlentities($_POST['program_5']); ?>" /> *
                        <br />
                        Consum mediu lunar (<b>kWh</b> - Ex: 157)<br />
                        <input type="text" name="consum_mediu_5" value="<?php if(isset($_POST['consum_mediu_5'])) echo htmlentities($_POST['consum_mediu_5']); ?>" /> *
                        <br />
                        Consum mediu anual (<b>kWh</b> - Se insumeaza consumurile lunare)<br />
                        <input type="text" name="consum_anual_5" value="<?php if(isset($_POST['consum_anual_5'])) echo htmlentities($_POST['consum_anual_5']); ?>" /> *
                        <br />
                        Consum pe ultimele 12 luni (<b>kWh</b> - Ex: Ianuarie 1244, Februarie 694, Martie 1200, Aprilie 1562, Mai 899, Iunie 120, Iulie 236, August 221, Septembrie 485, Octombrie 688, Noiembrie 521, Decembrie 988)<br />
                        <textarea name="consum_ultim_5"><?php if(isset($_POST['consum_ultim_5'])) echo htmlentities($_POST['consum_ultim_5']); else echo '' ?></textarea> *
                        <br />
                        Tensiunea de alimentare (<b>kV</b> - Ex: 0.4 / 6 / 20 / 110)<br />
                        <input type="text" name="alimentare_5" value="<?php if(isset($_POST['alimentare_5'])) echo htmlentities($_POST['alimentare_5']); ?>" /> *
                        <br /><br />
                    </div>
<!-- End of Locatia _5 -->

                        <input class="button float-left" type="submit" name="submit" value="Trimiteti"/>
                        <input style="width:200px;!important; margin-left:20px;" class="button float-left" id="toggleButton" type="button" value="Adaugati un nou loc de consum!" onclick="counter++; toggle4('box');">
                        <div class="clear-both"></div>
                    </form>
                    * camp obligatoriu
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