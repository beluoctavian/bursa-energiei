<?php
echo'
<div>
	<img class="float-left" src="'.$absolute_path.'/assets/images/icons/single-person-icon.png" />&nbsp;&nbsp;'.$username.'
	<br />
    '.$company.'
</div>

<ul>
    <li class="align-center"><h3>Meniu</h3></li>
    <li><a href="'.$absolute_path.'/user_pages/furnizor/cereri.php"><img src="'.$absolute_path.'/assets/images/icons/document-icon.png" />Cereri de oferta</a></li>
    <li><a href="'.$absolute_path.'/oferte.php"><img src="'.$absolute_path.'/assets/images/icons/document-icon.png" />Oferte transmise</a></li>
    <li><a href="'.$absolute_path.'/settings.php"><img src="'.$absolute_path.'/assets/images/icons/wheel-icon.png" />Setari cont</a></li>
    <li><a href="'.$absolute_path.'/logout.php"><img src="'.$absolute_path.'/assets/images/icons/exit-icon.png" />Log out</a></li>
</ul>';
?>