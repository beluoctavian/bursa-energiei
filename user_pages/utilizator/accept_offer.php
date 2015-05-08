<?php
require '../../core/init_2.php'; 
$user 		= $users->userdata($_SESSION['id']);
$offer       = $offers->offerdata($_GET['id']);
$request     = $requests->requestdata($offer['request_id']);

if(!isset($_SESSION['id']) || $user['stat'] != 0){
	header('Location:'.$absolute_path.'/index.php');
}

if(isset($_GET['id']) && empty($_GET['id']) === false) { // Putting everything in this if block.
	if($_SESSION['id'] != $request['user_id'] || $offer['status'] != 0){header('Location:'.$absolute_path.'/index.php');}
	else{	
		$headers = 'From:Bursaenergiei.ro<office@bursaenergiei.ro>\r\n';
		
		$furnizori_to_mail = $users->userdata($offer['user_id']);
		mail($furnizori_to_mail['email'], 'Oferta furnizare energie electrica ACCEPTATA!', "Buna ziua,\r\nV-a fost acceptata oferta cu id-ul " . $offer['id'] . ". Accesati http://www.bursaenergiei.ro pentru detalii.\r\n\r\n- Echipa Bursaenergiei.",$headers);
	
		$allmails = $users->get_emails($furnizori_to_mail['id']);
		$allmails_count = count($allmails);
		foreach ($allmails as $alma){
			mail($alma['email'], 'Oferta furnizare energie electrica ACCEPTATA!', "Buna ziua,\r\nV-a fost acceptata oferta cu id-ul " . $offer['id'] . ". Accesati http://www.bursaenergiei.ro pentru detalii.\r\n\r\n- Echipa Bursaenergiei.",$headers);
		}

		
		$admin_to_mail 		= $users->get_admins();
		$admin_to_mail_count = count($admin_to_mail);
		foreach ($admin_to_mail as $mailadmin) {
			mail($mailadmin['email'], 'Oferta furnizare energie electrica ACCEPTATA!', "Buna ziua,\r\nA fost acceptata oferta cu id-ul " . $offer['id'] . ". Accesati http://www.bursaenergiei.ro pentru detalii.\r\n\r\n- Echipa Bursaenergiei.",$headers);
		}
		
		$offer_accept = $offers->offer_accept($_GET['id']);
		header('Location:'.$absolute_path.'/request.php?id='.$request['id']);
	}
}
?>