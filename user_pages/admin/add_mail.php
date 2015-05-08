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

	if(empty($_POST['email'])){

		$errors[] = 'Toate campurile sunt obligatorii.';

	}else{
        
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Va rugam sa introduceti o adresa de e-mail valida.';
        }else if ($users->email_exists($_POST['email']) === true) {
            $errors[] = 'Adresa de e-mail este deja inregistrata.';
        }
	}

	if(empty($errors) === true){
		
		$email 		= htmlentities($_POST['email']);
		$users->add_mail($email,$_GET['id']);
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
            <h2>Adaugati un e-mail furnizorului "<?php echo $users->fetch_info('company','id',$_GET['id']); ?>"</h2>
        	<div id="register" class="span-23">
            	<div class="span-container">
					<?php 
                    # if there are errors, they would be displayed here.
                    if(empty($errors) === false){
                        echo '<div class="error">' . implode('</div><div class="error">', $errors) . '</div>';
                    }
                    ?>                    
                    <form method="post" action="">
                        E-mail:<br />
                        <input type="text" name="email" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" />
                        <br />
                        <input class="button" type="submit" name="submit" />
                    </form>                   
            	</div>
            </div>
            <h2>Email-urile furnizorului "<?php echo $users->fetch_info('company','id',$_GET['id']); ?>"</h2>
        	<div id="register" class="span-23">
            	<div class="span-container">
                <table id="utilizatori">
                	<thead>
              		<tr class="align-center">
                        <th>E-mail</th>
                        <th>Optiuni</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="align-center">
                        <td><?php
						echo $users->fetch_info('email','id',$_GET['id']);
						?></td>
                        <td>Acest e-mail nu poate fi sters.</td>
                    </tr>
					<?php 
                    $furniz_emails 		 = $users->get_emails($_GET['id']);
                    $furniz_emails_count 	= count($furniz_emails);
                    foreach ($furniz_emails as $frem) {
                        ?>
                        <tr class="align-center">
                            <td><?php
                            echo $frem['email'];
                            ?></td>
                            <td><a href="delete_mail.php?id=<?php echo $frem['id'];?>">Sterge</a></td>
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