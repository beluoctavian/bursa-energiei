<?php
$furnizori 		 = $users->get_furnizori();
$furnizori_count 	= count($furnizori);
shuffle($furnizori);

foreach ($furnizori as $furniz) {
	if($furniz['file']){
		?>
		<div class="item">
			<span class="helper"></span>
			<img src="<?php echo $absolute_path . "/uploads/furnizori/" . $furniz['file']; ?>"/>
		</div>
		<?php }
}
?>