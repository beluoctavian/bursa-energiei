<?php 
if(empty($_POST) === false) {
   
	if(empty($_POST['current_password']) || empty($_POST['password']) || empty($_POST['password_again'])){

		$errors[] = 'Toate campurile sunt obligatorii.';

	}else if($bcrypt->verify($_POST['current_password'], $user['password']) === true) {

		if (trim($_POST['password']) != trim($_POST['password_again'])) {
			$errors[] = 'Parolele noi nu coinid.';
		} else if (strlen($_POST['password']) < 6) { 
			$errors[] = 'Noua parola trebuie sa contina minim 6 caractere.';
		} else if (strlen($_POST['password']) >18){
			$errors[] = 'Noua parola trebuie sa contina maxim 18 caractere.';
		} 

	} else {
		$errors[] = 'Parola actuala este gresita';
	}
}

if (isset($_GET['change-password-success']) === true && empty ($_GET['change-password-success']) === true ) {
	echo '<div class="error">Parola a fost schimbata cu succes!</div>';
} else {?>

	<h3>Schimbati parola</h3>
	<hr />
	
	<?php
	if (empty($_POST) === false && empty($errors) === true) {
		$users->change_password($user['id'], $_POST['password']);
		header('Location: settings.php?change-password-success');
	} else if (empty ($errors) === false) {
			
		echo '<div class="error">' . implode('</div><div class="error">', $errors) . '</div>';  
	
	}
	?>
		<form action="" method="post">
			Parola actuala:<br />
			<input type="password" name="current_password">
			<br />
			Noua parola:<br />
			<input type="password" name="password">
			<br />
			Reintroduceti noua parola:<br />
			<input type="password" name="password_again">
			<br />
			<input class="button" type="submit" value="Schimba!">
		</form>
<?php 
}
?> 
