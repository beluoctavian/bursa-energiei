<?php
echo '
<div>
	<img class="float-left" src="'.$absolute_path.'/assets/images/icons/single-person-icon.png" />&nbsp;&nbsp;'.$username.'
	<br />
    <?php echo $company; ?>
</div>

<ul>
    <li class="align-center"><h3>Meniu</h3></li>
    <li><a href="'.$absolute_path.'/home.php"><img src="'.$absolute_path.'/assets/images/icons/home-icon.png" />Home</a></li>
    <li><a href="'.$absolute_path.'/cere_oferta.php"><img src="'.$absolute_path.'/assets/images/icons/battery-icon.png" />Cere oferta de pret</a></li>
    <li><a href="'.$absolute_path.'/cereri.php"><img src="'.$absolute_path.'/assets/images/icons/document-icon.png" />Cererile mele</a></li>
    <li><a href="'.$absolute_path.'/settings.php"><img src="'.$absolute_path.'/assets/images/icons/wheel-icon.png" />Setari cont</a></li>
    <li><a href="'.$absolute_path.'/logout.php"><img src="'.$absolute_path.'/assets/images/icons/exit-icon.png" />Log out</a></li>
</ul>';
?>
