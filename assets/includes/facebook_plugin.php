<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ro_RO/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="span-container">
	<p><b>Găseşte-ne pe Facebook.</b></p>
	<div class="fb-like" data-href="https://www.facebook.com/BursaEnergiei.ro" data-width="256" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
</div>
<br />
<div class="span-container" id="reclame">
	<?php
    $query = $db->prepare("SELECT `content` FROM `pages` WHERE `name` = ?");
    $query->bindValue(1, 'reclame');
    $query->execute();
    $despre_noi = $query->fetch(PDO::FETCH_ASSOC);
    $text = html_entity_decode($despre_noi['content']);
    echo $text;
    ?>
</div>