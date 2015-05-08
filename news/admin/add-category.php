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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bursa energiei</title>
<link href="../../assets/css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../style/main.css">
<script language="JavaScript" type="text/javascript">
function delpost(id, title)
{
  if (confirm("Are you sure you want to delete '" + title + "'"))
  {
    window.location.href = 'index.php?delpost=' + id;
  }
}
</script>
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
            <h3>Adaugati o categorie</h3>

        	<div class="span-23 float-left">
                <div class="span-container">
	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($catTitle ==''){
			$error[] = 'Please enter the Category.';
		}

		if(!isset($error)){

			try {

				$catSlug = slug($catTitle);

				//insert into database
				$stmt = $db->prepare('INSERT INTO blog_cats (catTitle,catSlug) VALUES (:catTitle, :catSlug)') ;
				$stmt->execute(array(
					':catTitle' => $catTitle,
					':catSlug' => $catSlug
				));

				//redirect to index page
				header('Location: categories.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post'>

		<label>Titlul categoriei:</label><br />
		<input type='text' name='catTitle' value='<?php if(isset($error)){ echo $_POST['catTitle'];}?>'><br />
		<input class="button" type='submit' name='submit' value='Submit'>

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
