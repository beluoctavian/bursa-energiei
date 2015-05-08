<?php 
require 'core/init.php';
if(isset($_SESSION['id'])){
	$user 		= $users->userdata($_SESSION['id']);
	$stat 	    = $user['stat'];
	$username 	= $user['username'];
	$company     = $user['company'];
	$contact     = $user['contact'];
	$telephone   = $user['telephone'];
	$code        = $user['code'];
}

if(isset($_POST['contact-submit']))
{
  if(empty($_SESSION['6_letters_code'] ) ||
    strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
  {
      //Note: the captcha code is compared case insensitively.
      //if you want case sensitive match, update the check above to
      // strcmp()
    $errori[] = "Codul de verificare nu este corect!";
  }
 
  if(empty($errori))
  {
		$EmailFrom = "www.bursaenergiei.ro";
		$EmailTo = "office@bursaenergiei.ro";
		$Subject = Trim(stripslashes($_POST['Subject'])); 
		$City = Trim(stripslashes($_POST['City'])); 
		$Name = Trim(stripslashes($_POST['Name'])); 
		$Telefon = Trim(stripslashes($_POST['Telefon'])); 
		$Email = Trim(stripslashes($_POST['Email'])); 
		$Message = Trim(stripslashes($_POST['Message'])); 
		
		// validation
		$validationOK=true;
		if (!$validationOK) {
		  print "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
		  exit;
		}
		
		// prepare email body text
		$Body = "";
		$Body .= "Nume: ";
		$Body .= $Name;
		$Body .= "\n";
		$Body .= "Oras: ";
		$Body .= $City;
		$Body .= "\n";
		$Body .= "Telefon: ";
		$Body .= $Telefon;
		$Body .= "\n";
		$Body .= "E-mail: ";
		$Body .= $Email;
		$Body .= "\n";
		$Body .= "Mesaj: ";
		$Body .= $Message;
		$Body .= "\n";
		
		// send email 
		$success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");
		
		// redirect to success page 
		if ($success){
		  print "<meta http-equiv=\"refresh\" content=\"0;URL=contactthanks.php\">";
		}
		else{
		  print "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
		}
  }
}
// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bursa energiei</title>
<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="assets/js/gen_validatorv31.js" type="text/javascript"></script>	

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
			<?php
				if(isset($_SESSION['id'])){
			?>
                <div id="account">
                    <h3 class="align-center">Contul meu</h3>
            <?php
					if($stat == 0){include("assets/includes/user_menu.php");}
					if($stat == 1){include("assets/includes/furnizor_menu.php");}
					if($stat == 9){include("assets/includes/admin_menu.php");}
			?>
                </div>
            <?php		
                }
            	if(!isset($_SESSION['id'])){
					include("login.php");
				}
			?>
            <div>
				<?php include("assets/includes/facebook_plugin.php"); ?>
            </div>
        </div>
<!-- CONTENT BEGIN -->
        <div id="content">
        	<div class="span-11 float-left">
                <h3 class="title">Contact</h3>
                <div class="span-container">
                    <div id="contact-area">
					<?php if(empty($errori) === false){
                
                        echo '<div class="error">' . implode('</div><div class="error">', $errori) . '</div>';			
                
                    } 
                    ?>
                        <form method="post" name="contact">
                            <label for="Name">Nume:</label><br />
                            <input type="text" name="Name" id="Name" /><br />
                            
                            <label for="Subject">Subiect:</label><br />
                            <input type="text" name="Subject" id="Subject" /><br />

                            <label for="City">Oras:</label><br />
                            <input type="text" name="City" id="City" /><br />
                
                            <label for="Email">E-mail:</label><br />
                            <input type="text" name="Email" id="Email" /><br />

                            <label for="Telefon">Telefon:</label><br />
                            <input type="text" name="Telefon" id="Telefon" /><br />
                            
                            <label for="Message">Mesaj:</label><br />
                            <textarea name="Message" rows="20" cols="20" id="Message"></textarea><br />

                            <img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' ><br>
                            <label>Introduceti codul de verificare de mai sus:</label><br>
                            <input id="6_letters_code" name="6_letters_code" type="text"><br>
                            <small>Nu puteti vedea imaginea? <a href='javascript: refreshCaptcha();'>Click aici pentru reincarcare.</a></small>
                            </p>

                            <input class="button" type="submit" name="contact-submit" value="Trimite"/>
                        </form>
					</div>
                </div>
            </div>
            <div class="span-1 separator">&nbsp;</div>
            <div class="span-11 float-left">
                <h3 class="title">S.C. CONTROL LED ENERGY S.R.L.</h3>
                <div class="span-container">
                    <div><img src="assets/images/icons/home-icon.png" /> Adresa: Drumul Taberei nr. 76, Sector 6, Bucuresti, CP: 061418</div>
                    <div><img src="assets/images/icons/clip-icon.png" /> Nr. Reg. Com.: J40/5977/25.05.2012</div>
                    <div><img src="assets/images/icons/price-icon.png" /> CUI/CIF: RO30242910</div>
                    <div><img src="assets/images/icons/telephone-icon.png" /> Telefon: 0765.513.472.</div>
                    <div><img src="assets/images/icons/mail-icon.png" /> E-mail: office@bursaenergiei.ro</div>
                    <div><img src="assets/images/icons/mail-icon.png" /> E-mail: control.ledenergy@yahoo.com</div>
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
<script language="JavaScript">
// Code for validating the form
// Visit http://www.javascript-coder.com/html-form/javascript-form-validation.phtml
// for details
var frmvalidator  = new Validator("contact");
//remove the following two lines if you like error message box popups
frmvalidator.EnableOnPageErrorDisplaySingleBox();
frmvalidator.EnableMsgsTogether();
</script>
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>

</body>
</html>