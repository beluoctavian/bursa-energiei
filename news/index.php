<?php 
require '../core/init_1.php';
if(isset($_SESSION['id'])){
	$user 		= $users->userdata($_SESSION['id']);
	$stat 	    = $user['stat'];
	$username 	= $user['username'];
	$company     = $user['company'];
	$contact     = $user['contact'];
	$telephone   = $user['telephone'];
	$code        = $user['code'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bursa energiei</title>
<link href="../assets/css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="top_bar">
	<div class="wrapper">
    	<?php include("../assets/includes/top_bar_nav.php"); ?>
    	<?php include("../assets/includes/social_sprites.php"); ?>
    </div>
</div>
<div id="header">
	<div class="wrapper">
    	<?php include("../assets/includes/header.php"); ?>
    </div>
</div>
<div id="navigation_bar">
	<div class="wrapper">
    	<?php include("../assets/includes/navigation_bar.php"); ?>
    </div>
</div>
<div class="dotted_separator"></div>
<div id="main">
	<div class="wrapper">
		<div id="sidebar">
			<?php
				if(isset($_SESSION['id'])){
			?>
                <div id="account">
                    <h3 class="align-center">Contul meu</h3>
            <?php
					if($stat == 0){include("../assets/includes/user_menu.php");}
					if($stat == 1){include("../assets/includes/furnizor_menu.php");}
					if($stat == 9){include("../assets/includes/admin_menu.php");}
			?>
                </div>
            <?php		
                }
            	if(!isset($_SESSION['id'])){
					include("../login.php");
				}
			?>
            <div>
				<?php include("../assets/includes/facebook_plugin.php"); ?>
            </div>
        </div>
<!-- CONTENT BEGIN -->
        <div id="content">
        	<div class="span-23">
                <h3 class="title">Stiri</h3>
					<?php
                        try {
        
                            $pages = new Paginator('5','page');
        
                            $stmt = $db->query('SELECT postID FROM blog_posts_seo');
        
                            //pass number of records to
                            $pages->set_total($stmt->rowCount());
        
                            $stmt = $db->query('SELECT postID, postTitle, postSlug, postDesc, postDate FROM blog_posts_seo ORDER BY postID DESC '.$pages->get_limit());
                            while($row = $stmt->fetch()){
									echo '<div class="span-container">';
                                    echo '<h3><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h3>';
                                    echo '<p>Postat: '.date('jS M Y H:i:s', strtotime($row['postDate'])).' in ';
        
                                        $stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM blog_cats, blog_post_cats WHERE blog_cats.catID = blog_post_cats.catID AND blog_post_cats.postID = :postID');
                                        $stmt2->execute(array(':postID' => $row['postID']));
        
                                        $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        
                                        $links = array();
                                        foreach ($catRow as $cat)
                                        {
                                            $links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
                                        }
                                        echo implode(", ", $links);
										
                                    echo '</p>';
                                    echo '<p>'.$row['postDesc'].'</p>';				
                                    echo '<p><a href="viewpost.php?id='.$row['postID'].'">Citeste mai mult</a></p>';
									echo '</div>';
									echo '<br />';
                            }
        
                            echo $pages->page_links();
        
                        } catch(PDOException $e) {
                            echo $e->getMessage();
                        }
                    ?>
            </div>
            <div class="clear-both"></div>
        </div>
<!-- CONTENT END -->
        <div class="clear-both"></div>
    </div>
    <div class="waves-graph-separator"></div>
</div>
<div id="main-second">
	<div class="wrapper">
        <h3 class="title">Furnizori</h3>
        <div id="furnizori_container">
        	<?php include("../assets/includes/furnizori.php"); ?>
            <div class="clear-both"></div>
        </div>
    </div>
</div>
<div id="footer">
    <div class="wrapper">
    	<?php include("../assets/includes/footer.php"); ?>
    </div>
</div>
<div id="newsletter">
	<div class="wrapper">
    	<div class="float-left"><img src="../assets/images/icons/thunderbird_icon.png" /></div>
        <div class="form float-left">
            <h3 class="title">Abonati-va la newsletter!</h3>
            <form action="../newsletter_subscribe.php" method="post">
            <input class="float-left" type="text" name="email" value="Introduceti adresa de e-mail." onblur="if (this.value == '') {this.value = 'Introduceti adresa de e-mail.';}" onfocus="if (this.value == 'Introduceti adresa de e-mail.') {this.value = '';}" />
            <input class="button float-left" type="submit" name="subscribe" value="Aboneaza-te!"/>
            </form>
        </div>
        <div class="clear-both"></div>
    </div>
</div>
<div id="bottom_bar">
	<div class="wrapper">
    	<?php include("../assets/includes/bottom_bar.php"); ?>
    </div>
</div>
</body>
</html>