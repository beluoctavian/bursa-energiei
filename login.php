<?php
if (isset($_POST['login-submit'])) {
 
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
 
	if (empty($username) === true || empty($password) === true) {
		$errors[] = 'Va rugam sa introduceti numele de utilizator si parola.';
	} else if ($users->user_exists($username) === false) {
		$errors[] = 'Numele de utilizator introdus nu exista.';
	} else if ($users->email_confirmed($username) === false) {
		$errors[] = 'Ne pare rau, insa trebuie sa va activati contul. Va rugam sa va verificati adresa de e-mail.';
	}
	else {
 
		$login = $users->login($username, $password);
		if ($login === false) {
			$errors[] = 'Combinatia username/parola este incorecta.';
		}else{
			$user 		= $users->userdata($login);
			if($user['confirmed'] == 0){
				$errors[] = 'Contul dumneavoastra nu a fost activat. Va rugam sa va verificati casuta de e-mail.';
			}
			if($user['confirmed'] == 2){
				$errors[] = 'Contul dumneavoastra a fost suspendat. Va rugam sa contactati un administrator.';
			}
			else{
				// username/password is correct and the login method of the $users object returns the user's id, which is stored in $login.	
				session_regenerate_id(true);
				$_SESSION['id'] =  $login; // The user's id is now set into the user's session  in the form of $_SESSION['id'] 
	
				$stat 	    = $user['stat'];
				if($stat == 0){header('Location: '.$absolute_path.'/user_pages/utilizator/home.php');}
				if($stat == 1){header('Location: '.$absolute_path.'/user_pages/furnizor/home.php');}
				if($stat == 9){header('Location: '.$absolute_path.'/user_pages/admin/home.php');}
				exit();
			}
		}
	}
} 
?>
<div id="login">
    <h3 class="align-center">Logati-va</h3>
	<?php if(empty($errors) === false){

        echo '<div class="error">' . implode('</div><div class="error">', $errors) . '</div>';			

    } 
    ?>
    <form action="" method="post">
        <input type="text" name="username" value="<?php if(isset($_POST['username'])) echo htmlentities($_POST['username']); else echo 'username' ?>" onblur="if (this.value == '') {this.value = 'username';}" onfocus="if (this.value == 'username') {this.value = '';}" />
        <input type="password" name="password" value="password" onblur="if (this.value == '') {this.value = 'password';}" onfocus="if (this.value == 'password') {this.value = '';}" />
        <div class="float-left">
        <a href="confirm-recover.php">Ati uitat username-ul?</a><br />
        <a href="confirm-recover.php">Ati uitat parola?</a><br />
        <a href="register.php">Nu sunteti inregistrat?</a><br />
        </div>
        <input class="button float-right" type="submit" name="login-submit" value="Log in"/>
    </form>
    <div class="clear-both"></div>
</div>

