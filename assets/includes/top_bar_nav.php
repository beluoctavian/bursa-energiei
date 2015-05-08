<?php
if(isset($_SESSION['id'])){
	echo '
	<ul>
		<li><a href="'.$absolute_path.'/home.php"><img src="'.$absolute_path.'/assets/images/icons/single-person-icon.png"/>'.$username.'</a></li>
        <li class="last"><a href="'.$absolute_path.'/logout.php"><img src="'.$absolute_path.'/assets/images/icons/exit-icon.png" />Log out</a></li>
	</ul>';
	} else {
	echo '
    <ul>
        <li><a href="'.$absolute_path.'/index.php"><img src="'.$absolute_path.'/assets/images/icons/enter-icon.png" />Autentificare</a></li>
        <li><a href="'.$absolute_path.'/register.php"><img src="'.$absolute_path.'/assets/images/icons/document-icon.png" />Cere oferta de pret</a></li>
        <li><a href="'.$absolute_path.'/#"><img src="'.$absolute_path.'/assets/images/icons/business-card-icon.png" />Despre noi</a></li>
        <li class="last"><a href='.$absolute_path.'/"#"><img src="'.$absolute_path.'/assets/images/icons/conversation-icon.png" />Contact</a></li>
    </ul>';
	}
?>
	