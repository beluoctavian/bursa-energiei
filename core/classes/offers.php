<?php 
class Offers{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}	
	 
	public function register($request_id, $user_id, $text){

		global $bcrypt; 

		$query 	= $this->db->prepare("INSERT INTO `offers` (`request_id`, `user_id`, `text`) VALUES (?, ?, ?) ");

		$query->bindValue(1, $request_id);
		$query->bindValue(2, $user_id);
		$query->bindValue(3, $text);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function offerdata($id) {

		$query = $this->db->prepare("SELECT * FROM `offers` WHERE `id`= ?");
		$query->bindValue(1, $id);

		try{

			$query->execute();

			return $query->fetch();

		} catch(PDOException $e){
			die($e->getMessage());
		}

	}

	public function offer_exists($id) {
	
		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `requests` WHERE `id`= ?");
		$query->bindValue(1, $id);
	
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

	public function delete_request_offers($id) {
	
		$query = $this->db->prepare("DELETE FROM `offers` WHERE `request_id`= ?");
		$query->bindValue(1, $id);
	
		try{
			$query->execute();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function get_offers($user_id,$stat) {
		if($stat == 9){
			$query = $this->db->prepare("SELECT * FROM `offers` ORDER BY `id` DESC");
		}
		else{
			$query = $this->db->prepare("SELECT * FROM `offers` WHERE `user_id`= ? ORDER BY `id` DESC");
			$query->bindValue(1, $user_id);
		}

		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}	
	
	public function offer_accept($id) {
	
		$query = $this->db->prepare("UPDATE `offers` SET `status` = 1 WHERE `id`=?");
		$query->bindValue(1, $id);
		try{
			$query->execute();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function offer_deny($id) {
	
		$query = $this->db->prepare("UPDATE `offers` SET `status` = 2 WHERE `id`=?");
		$query->bindValue(1, $id);
		try{
			$query->execute();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

}