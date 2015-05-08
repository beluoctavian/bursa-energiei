<?php
echo '
<div class="span-10 float-left">
    <h3 class="title">Despre Bursa Energiei</h3>
    <div>BursaEnergiei.ro este partenerul dvs in reducerea costurilor cu energia electrica. Promovam liberalizarea  pietei de energie electrica la consumatorii finali prin aducerea la aceeasi masa a ofertelor principalilor furnizori de energie electrica si a cererilor consumatorilor finali. Sustinem concurenta pe piata energiei in favoarea consumatorului final. De asemenea promovam ca masura de eficienta energetica utilizarea iluminatului cu LED www.LedEnergy.ro, care poate aduce economii de energie de pana la 90%. Sustinem business-ul romanesc si luptam pentru performanta in contextul crizei actuale.</div>
</div>
<div class="span-1 separator float-left">&nbsp;</div>
<div class="span-10 float-left">
    <h3 class="title">Ultimele stiri</h3>
    <div>';
		try {

			$pages = new Paginator('2','page');

			$stmt = $db->query('SELECT postID FROM blog_posts_seo');

			//pass number of records to
			$pages->set_total($stmt->rowCount());

			$stmt = $db->query('SELECT postID, postTitle, postSlug, postDesc, postDate FROM blog_posts_seo ORDER BY postID DESC '.$pages->get_limit());
			while($row = $stmt->fetch()){
					echo '<a class="footer-link" href="'.$absolute_path.'/news/viewpost.php?id='.$row['postID'].'"><div>';
					echo '<h3>'.$row['postTitle'].'</h3>';
					echo '<p>'.$row['postDesc'].'</p>';				
					echo '</div></a>';
					echo '<br />';
			}

		} catch(PDOException $e) {
			echo $e->getMessage();
		}

echo '
	</div>
</div>
<div class="span-1 separator float-left">&nbsp;</div>
<div class="span-10 float-left">
    <h3 class="title">Contact</h3>
    <div><b>S.C. CONTROL LED ENERGY S.R.L.&nbsp;</b></div>
    <div><img src="'.$absolute_path.'/assets/images/icons/home-icon-white.png" />Adresa: Drumul Taberei nr. 76, Sector 6, Bucuresti, CP: 061418</div>
    <div><img src="'.$absolute_path.'/assets/images/icons/clip-icon-white.png" />Nr. Reg. Com.: J40/5977/25.05.2012</div>
    <div><img src="'.$absolute_path.'/assets/images/icons/price-icon-white.png" />CUI/CIF: RO30242910</div>
    <div><img src="'.$absolute_path.'/assets/images/icons/telephone-icon-white.png" />Telefon: 0765.513.472.</div>
    <div><img src="'.$absolute_path.'/assets/images/icons/mail-icon.png" />E-mail: office@bursaenergiei.ro</div>
    <div><img src="'.$absolute_path.'/assets/images/icons/mail-icon.png" />E-mail: control.ledenergy@yahoo.com</div>
</div>
<div class="clear-both"></div>';
?>
