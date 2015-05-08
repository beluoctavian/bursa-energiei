<?php 
require 'core/init.php';

if (isset($_POST['subscribe'])) {
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
		$errors[] = 'Va rugam sa introduceti o adresa de e-mail valida.';
	}
	else $users->register_newsletter($_POST['email']);
	if(empty($errors)){
		?>
		<div class="error">V-ati inregistrat cu succes la newsletter.</div>
        <br />
		<a href="<?php echo $absolute_path; ?>">Click aici pentru a reveni pe website</a>
		<?php
	}
	else{
		?>
		<div class="error">Va rugam sa introduceti o adresa de e-mail valida.</div>
        <br />
		<a href="<?php echo $absolute_path; ?>">Click aici pentru a reveni pe website</a>
        <?php
	}
}

