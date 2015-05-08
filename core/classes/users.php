<?php 
class Users{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}	
	
	public function change_password($user_id, $password) {

		global $bcrypt;

		/* Two create a Hash you do */
		$password_hash = $bcrypt->genHash($password);

		$query = $this->db->prepare("UPDATE `users` SET `password` = ? WHERE `id` = ?");

		$query->bindValue(1, $password_hash);
		$query->bindValue(2, $user_id);				

		try{
			$query->execute();
			return true;
		} catch(PDOException $e){
			die($e->getMessage());
		}

	}

	public function recover($email, $generated_string) {

		if($generated_string == 0){
			return false;
		}else{
	
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `email` = ? AND `generated_string` = ?");

			$query->bindValue(1, $email);
			$query->bindValue(2, $generated_string);

			try{

				$query->execute();
				$rows = $query->fetchColumn();

				if($rows == 1){
					
					global $bcrypt;

					$username = $this->fetch_info('username', 'email', $email);
					$user_id  = $this->fetch_info('id', 'email', $email);
			
					$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					$generated_password = substr(str_shuffle($charset),0, 10);

					$this->change_password($user_id, $generated_password);

					$query = $this->db->prepare("UPDATE `users` SET `generated_string` = 0 WHERE `id` = ?");

					$query->bindValue(1, $user_id);
	
					$query->execute();
					
					$headers = 'From:Bursaenergiei.ro<office@bursaenergiei.ro>\r\n';
					mail($email, 'Parola dumneavoastra', "Buna ziua " . $username . ",\n\nNoua parola a dumneavoastra este: " . $generated_password . "\n\nVa rugam sa o schimbati imediat ce va logati ducandu-va din meniu la SETARI CONT.\n\nCu Stima,\nEchipa BursaEnergiei.ro\nS.C. CONTROL LED ENERGY S.R.L.\nNr. Reg. Com.: J40/5977/25.05.2012\nCUI/CIF: RO30242910\nTelefon: 0765.513.472.\nFax: 0372.001.307\nE-mail: office@bursaenergiei.ro",$headers);

				}else{
					return false;
				}

			} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}

    public function fetch_info($what, $field, $value){

		$query = $this->db->prepare("SELECT $what FROM `users` WHERE $field = ?");

		$query->bindValue(1, $value);

		try{

			$query->execute();
			
		} catch(PDOException $e){

			die($e->getMessage());
		}

		return $query->fetchColumn();
	}

    public function furnizori_fetch_mail($what, $field, $value){

		$query = $this->db->prepare("SELECT $what FROM `users` WHERE $field < ? AND `stat` = 1");

		$query->bindValue(1, $value);

		try{

			$query->execute();
			
		} catch(PDOException $e){

			die($e->getMessage());
		}

		return $query->fetchColumn();
	}

    public function admin_fetch_mail($what, $field, $value){

		$query = $this->db->prepare("SELECT $what FROM `users` WHERE $field < ? AND `stat` = 9");

		$query->bindValue(1, $value);

		try{

			$query->execute();
			
		} catch(PDOException $e){

			die($e->getMessage());
		}

		return $query->fetchColumn();
	}

	public function confirm_recover($email){

		$username = $this->fetch_info('username', 'email', $email);
		$unique = uniqid('',true);
		$random = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0, 10);
		
		$generated_string = $unique . $random;

		$query = $this->db->prepare("UPDATE `users` SET `generated_string` = ? WHERE `email` = ?");

		$query->bindValue(1, $generated_string);
		$query->bindValue(2, $email);

		try{
			
			$query->execute();

			$headers = 'From:Bursaenergiei.ro<office@bursaenergiei.ro>\r\n';
			mail($email, 'Recuperare parola', "Buna ziua " . $username. ",\r\nVa rugam sa apasati pe link-ul de mai jos pentru a va reseta parola:\r\n\r\nhttp://www.bursaenergiei.ro/recover.php?email=" . $email . "&generated_string=" . $generated_string . "\r\n\r\n Va vom genera o noua parola si o vom trimite pe mail-ul dumneavoastra.\r\n\r\nCu Stima,\nEchipa BursaEnergiei.ro\nS.C. CONTROL LED ENERGY S.R.L.\nNr. Reg. Com.: J40/5977/25.05.2012\nCUI/CIF: RO30242910\nTelefon: 0765.513.472.\nFax: 0372.001.307\nE-mail: office@bursaenergiei.ro",$headers);			
			
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function user_exists($username) {
	
		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `username`= ?");
		$query->bindValue(1, $username);
	
		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	 
	public function email_exists($email) {

		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `email`= ?");
		$query->bindValue(1, $email);
	
		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function user_delete($id) {

		$query = $this->db->prepare("DELETE FROM `users` WHERE `id`= ?");
		$query->bindValue(1, $id);
	
		try{
			$query->execute();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function user_block($id) {

		$query = $this->db->prepare("UPDATE `users` SET `confirmed`=2 WHERE `id`= ?");
		$query->bindValue(1, $id);
	
		try{
			$query->execute();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function user_ok($id) {

		$query = $this->db->prepare("UPDATE `users` SET `confirmed`=1 WHERE `id`= ?");
		$query->bindValue(1, $id);
	
		try{
			$query->execute();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function register($username, $password, $email, $contact, $telephone, $company, $code){

		global $bcrypt;

		$time 		= time();
		$ip 		= $_SERVER['REMOTE_ADDR'];
		$email_code = $email_code = uniqid('code_',true);
		
		$password   = $bcrypt->genHash($password);

		$query 	= $this->db->prepare("INSERT INTO `users` (`username`, `password`, `email`, `ip`, `time`, `email_code`, `contact`, `telephone`, `company`, `code`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");

		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->bindValue(3, $email);
		$query->bindValue(4, $ip);
		$query->bindValue(5, $time);
		$query->bindValue(6, $email_code);
		$query->bindValue(7, $contact);
		$query->bindValue(8, $telephone);
		$query->bindValue(9, $company);
		$query->bindValue(10, $code);

		try{
			$query->execute();

			$headers = 'From:Bursaenergiei.ro<office@bursaenergiei.ro>\r\n';
			mail($email, 'Va rugam sa va activati contul!', "Buna ziua " . $username. ",\r\nVa multumim pentru inregistrare. Va rugam sa vizitati link-ul de mai jos pentru a va activa contul:\r\n\r\nhttp://www.bursaenergiei.ro/activate.php?email=" . $email . "&email_code=" . $email_code . "\r\n\r\nCu Stima,\nEchipa BursaEnergiei.ro\nS.C. CONTROL LED ENERGY S.R.L.\nNr. Reg. Com.: J40/5977/25.05.2012\nCUI/CIF: RO30242910\nTelefon: 0765.513.472.\nFax: 0372.001.307\nE-mail: office@bursaenergiei.ro",$headers);
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function activate($email, $email_code) {
		
		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");

		$query->bindValue(1, $email);
		$query->bindValue(2, $email_code);
		$query->bindValue(3, 0);

		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				
				$query_2 = $this->db->prepare("UPDATE `users` SET `confirmed` = ? WHERE `email` = ?");

				$query_2->bindValue(1, 1);
				$query_2->bindValue(2, $email);				

				$query_2->execute();
				return true;

			}else{
				return false;
			}

		} catch(PDOException $e){
			die($e->getMessage());
		}

	}


	public function email_confirmed($username) {

		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `username`= ? AND `confirmed` = ?");
		$query->bindValue(1, $username);
		$query->bindValue(2, 1);
		
		try{
			
			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch(PDOException $e){
			die($e->getMessage());
		}

	}

	public function login($username, $password) {

		global $bcrypt;  

		$query = $this->db->prepare("SELECT `password`, `id` FROM `users` WHERE `username` = ?");
		$query->bindValue(1, $username);

		try{
			
			$query->execute();
			$data 				= $query->fetch();
			$stored_password 	= $data['password']; 
			$id   				= $data['id'];
			
			if($bcrypt->verify($password, $stored_password) === true){ 
				return $id;
			}else{
				return false;	
			}

		}catch(PDOException $e){
			die($e->getMessage());
		}
	
	}

	public function userdata($id) {

		$query = $this->db->prepare("SELECT * FROM `users` WHERE `id`= ?");
		$query->bindValue(1, $id);

		try{

			$query->execute();

			return $query->fetch();

		} catch(PDOException $e){

			die($e->getMessage());
		}

	}
	  	  	 
	public function get_newsletter_mails() {

		$query = $this->db->prepare("SELECT DISTINCT `email` FROM `newsletter`");

		try{

			$query->execute();

			return $query->fetchAll();

		} catch(PDOException $e){

			die($e->getMessage());
		}

	}
	  	  	 
	public function get_users() {

		$query = $this->db->prepare("SELECT * FROM `users` WHERE `stat` = 0 ORDER BY `time` DESC");
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}	
	
	public function get_furnizori() {

		$query = $this->db->prepare("SELECT * FROM `users` WHERE `stat` = 1 ORDER BY `time` DESC");
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}	

	public function get_admins() {

		$query = $this->db->prepare("SELECT * FROM `users` WHERE `stat` = 9 ORDER BY `time` DESC");
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}	

	public function register_furnizor($username, $password, $email, $contact, $telephone, $company, $minim) {

		global $bcrypt;

		$time 		= time();
		$ip 		= $_SERVER['REMOTE_ADDR'];
		$email_code = $email_code = uniqid('code_',true);
		
		$password   = $bcrypt->genHash($password);

		$query 	= $this->db->prepare("INSERT INTO `users` (`username`, `password`, `email`, `ip`, `time`, `email_code`, `contact`, `telephone`, `company`, `stat`, `confirmed`, `minim`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");

		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->bindValue(3, $email);
		$query->bindValue(4, $ip);
		$query->bindValue(5, $time);
		$query->bindValue(6, $email_code);
		$query->bindValue(7, $contact);
		$query->bindValue(8, $telephone);
		$query->bindValue(9, $company);
		$query->bindValue(10, 1);
		$query->bindValue(11, 1);
		$query->bindValue(12, $minim);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}	
	
	public function add_mail($email, $user_id) {

		$query 	= $this->db->prepare("INSERT INTO `emails` (`user_id` , `email`) VALUES (?, ?) ");
		$query->bindValue(1, $user_id);
		$query->bindValue(2, $email);
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}	

	public function delete_mail($id) {

		$query 	= $this->db->prepare("DELETE FROM `emails` WHERE `id` = ?");
		$query->bindValue(1, $id);
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}	

	public function get_emails($id) {

		$query = $this->db->prepare("SELECT * FROM `emails` WHERE `user_id` = ?");
		$query->bindValue(1, $id);
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}
	public function register_newsletter($email) {

		$query 	= $this->db->prepare("INSERT INTO `newsletter` (`email`) VALUES (?) ");
		$query->bindValue(1, $email);
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}	

	public function add_banner_image($image) {

		$query 	= $this->db->prepare("INSERT INTO `banner` (`image`) VALUES (?) ");
		$query->bindValue(1, $image);
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}	
	public function get_banner_images() {

		$query = $this->db->prepare("SELECT * FROM `banner`");
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}
	public function delete_banner_image($id) {

		$query 	= $this->db->prepare("DELETE FROM `banner` WHERE `id` = ?");
		$query->bindValue(1, $id);
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}	
}