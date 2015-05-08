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

$members 		 = $users->get_users();
$member_count 	= count($members);
$furnizori 		 = $users->get_furnizori();
$furnizori_count 	= count($furnizori);
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
            <h3>Furnizori</h3>
        	<div class="span-23 span-container">
                <table id="utilizatori">
                	<thead>
              		<tr class="align-center">
                        <th>Id</th>
                        <th>Username</th>
                        <th>E-mail</th>
                        <th>Persoana de contact</th>
                        <th>Nume societate</th>
                        <th>Status</th>
                        <th colspan="4">Optiuni</th>
                    </tr>
                    </thead>
                    <tbody>
				<?php 
				foreach ($furnizori as $furniz) {
					?>
                    <tr class="align-center">
                        <td><?php echo $furniz['id'];?></td>
                        <td><?php echo $furniz['username'];?></td>
                        <td><?php
							echo $furniz['email'];
							$furniz_emails 		 = $users->get_emails($furniz['id']);
							$furniz_emails_count 	= count($furniz_emails);
							foreach ($furniz_emails as $frem) {
								echo ' ; '.$frem['email'];
								
							}

						?></td>
                        <td><?php echo $furniz['contact'];?></td>
                        <td><?php echo $furniz['company'];?></td>
                        <td><?php
						if($furniz['confirmed'] == 0) echo 'Neactivat';
						if($furniz['confirmed'] == 1) echo 'Activ';
						if($furniz['confirmed'] == 2) echo 'Blocat';
						
						?></td>
                        <td style="border-right:none;">
                            <a class="image_cont" onclick="return confirm('Sigur vreti sa DEblocati contul?');" href="ok_user.php?id=<?php echo $furniz['id'];?>"><img src="../../assets/images/icons/user_ok.png" /></a>
                        </td>
                        <td style="border-left:none; border-right:none;">
                            <a class="image_cont" onclick="return confirm('Sigur vreti sa blocati contul?');" href="block_user.php?id=<?php echo $furniz['id'];?>"><img src="../../assets/images/icons/user_block.png" /></a>
                        </td>
                        <td style="border-left:none; border-right:none;">
                            <a class="image_cont" onclick="return confirm('Sigur vreti sa stergeti contul?');" href="delete_user.php?id=<?php echo $furniz['id'];?>"><img src="../../assets/images/icons/user_delete.png" /></a>
                        </td>
                        <td style="border-left:none;">
                            <a class="image_cont"  href="add_mail.php?id=<?php echo $furniz['id'];?>"><img src="../../assets/images/icons/add-mail-icon.png" /></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                	</tbody>
                </table><br />
                <a class="button" href="register_furnizor.php">Adauga furnizor</a>
                <a class="button" href="add_image.php">Adauga imagine</a>
            </div>
            <h3>Utilizatori inregistrati</h3>
        	<div class="span-23 span-container">
                <table id="utilizatori">
                	<thead>
              		<tr class="align-center">
                        <th>Id</th>
                        <th>Username</th>
                        <th>E-mail</th>
                        <th>Persoana de contact</th>
                        <th>Nume societate</th>
                        <th>Status</th>
                        <th colspan="3">Optiuni</th>
                    </tr>
                    </thead>
                    <tbody>
				<?php 
				foreach ($members as $member) {
					?>
                    <tr class="align-center">
                        <td><?php echo $member['id'];?></td>
                        <td><?php echo $member['username'];?></td>
                        <td><?php echo $member['email'];?></td>
                        <td><?php echo $member['contact'];?></td>
                        <td><?php echo $member['company'];?></td>
                        <td><?php
						if($member['confirmed'] == 0) echo 'Neactivat';
						if($member['confirmed'] == 1) echo 'Activ';
						if($member['confirmed'] == 2) echo 'Blocat';
						
						?></td>
                        <td style="border-right:none;">
                            <a class="image_cont" onclick="return confirm('Sigur vreti sa DEblocati contul?');" href="ok_user.php?id=<?php echo $member['id'];?>"><img src="../../assets/images/icons/user_ok.png" /></a>
                        </td>
                        <td style="border-left:none; border-right:none;">
                            <a class="image_cont" onclick="return confirm('Sigur vreti sa blocati contul?');" href="block_user.php?id=<?php echo $member['id'];?>"><img src="../../assets/images/icons/user_block.png" /></a>
                        </td>
                        <td style="border-left:none;">
                            <a class="image_cont" onclick="return confirm('Sigur vreti sa stergeti contul?');" href="delete_user.php?id=<?php echo $member['id'];?>"><img src="../../assets/images/icons/user_delete.png" /></a>
                        </td>
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