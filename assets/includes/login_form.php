<?php
if (empty($_POST) === false) {
 
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
 
	if (empty($username) === true || empty($password) === true) {
		$errors[] = 'Va rugam sa introduceti numele de utilizator si parola.';
	} else if ($users->user_exists($username) === false) {
		$errors[] = 'Numele de utilizator introdus nu exista.';
	} else if ($users->email_confirmed($username) === false) {
		$errors[] = 'Ne pare rau, insa trebuie sa va activati contul. Va rugam sa va verificati adresa de e-mail.';
	} else {
 
		$login = $users->login($username, $password);
		if ($login === false) {
			$errors[] = 'Combinatia username/parola este incorecta.';
		}else {
			// username/password is correct and the login method of the $users object returns the user's id, which is stored in $login.
 
 			$_SESSION['id'] =  $login; // The user's id is now set into the user's session  in the form of $_SESSION['id'] 
			
			#Redirect the user to home.php.
			header('Location: home.php');
			exit();
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
    <form action="login.php" method="post">
        <input type="text" name="username" value="username" onblur="if (this.value == '') {this.value = 'username';}" onfocus="if (this.value == 'username') {this.value = '';}" />
        <input type="password" name="password" value="password" onblur="if (this.value == '') {this.value = 'password';}" onfocus="if (this.value == 'password') {this.value = '';}" />
        <div class="float-left">
        <a href="#">Retrimitere username.</a><br />
        <a href="#">Resetare parola.</a><br />
        <a href="register.php">Nu esti inregistrat?</a><br />
        </div>
        <input class="button float-right" type="submit" name="login" value="Log in"/>
    </form>
    <div class="clear-both"></div>
</div>
