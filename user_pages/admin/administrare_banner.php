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

	$nr_locatii = count($_FILES['fisier']['name']);
	$fisier = array();
	
	if($nr_locatii == 0){

		$errors[] = 'Trebuie sa adaugati neaparat un fisier.';

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
				
				while(file_exists("../../assets/images/slider/" . $nume))
					$nume = rand(0,9999999).$_FILES['fisier']['name'][$i];
				
				if(!move_uploaded_file($_FILES["fisier"]["tmp_name"][$i],"../../assets/images/slider/" . $nume))
					$errors[] = $_FILES['fisier']['name'][$i].' nu s-a putut uploada. Size: '.($_FILES['fisier']['size'][$i] / 1048576).' MB';
				
				$fisier[] = $nume;
			}
	}
	if(empty($errors) === true){
		$users->add_banner_image($nume);	
		header('Location: utilizatori.php');
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
            <h2>Administrare banner.</h2>
            <div class="span-container error">Dimensiunea imaginilor trebuie sa fie 734px x 300px pentru o incadrare perfecta.</div><br />
        	<div id="register" class="span-23">
            	<div class="span-container">
					<?php 
                    # if there are errors, they would be displayed here.
                    if(empty($errors) === false){
                        echo '<div class="error">' . implode('</div><div class="error">', $errors) . '</div>';
                    }
                    ?>                    
                    <form method="post" action="" enctype="multipart/form-data">
                        <label for="file">Adaugati o imagine la banner.</label><br />
                        <input name="fisier[]" type="file" id="file" /><br />
                        <input class="button" type="submit" name="submit" />
                    </form>   
            	</div><br />

                <div class="span-container">
                <?php
				$imagini 		 = $users->get_banner_images();
				$imagini_count 	= count($imagini);
				?>
                <table id="utilizatori">
                	<thead>
              		<tr class="align-center">
                        <th>Id</th>
                        <th>Imagine</th>
                        <th>Optiuni</th>
                    </tr>
                    </thead>
                    <tbody>
				<?php 
				foreach ($imagini as $img) {
					?>
                    <tr class="align-center">
                        <td><?php echo $img['id'];?></td>
                        <td><?php echo $img['image'];?></td>
                        <td>
                            <a class="image_cont" onclick="return confirm('Sigur vreti sa stergeti imaginea?');" href="delete_banner_image.php?id=<?php echo $img['id'];?>">DELETE</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                	</tbody>
                </table><br />
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