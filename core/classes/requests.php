<?php 
class Requests{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}	
	 
	public function register($user_id, $loc, $adresa, $program, $consum_lunar, $consum_anual, $consum_ultim, $alimentare, $data_limita, $precizari){

		global $bcrypt;

		$time 		= time();

		$query 	= $this->db->prepare("INSERT INTO `requests` (`user_id`, `loc`, `adresa`, `program`, `consum_lunar`, `consum_anual`, `consum_ultim`, `alimentare`, `time`, `data_limita`, `precizari`, `consum_total_anual`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");

		$query->bindValue(1, $user_id);
		$query->bindValue(2, $loc);
		$query->bindValue(3, $adresa);
		$query->bindValue(4, $program);
		$query->bindValue(5, $consum_lunar);
		$query->bindValue(6, $consum_anual);
		$query->bindValue(7, $consum_ultim);
		$query->bindValue(8, $alimentare);
		$query->bindValue(9, $time);
		$query->bindValue(10, $data_limita);
		$query->bindValue(11, $precizari);
		$query->bindValue(12, $consum_anual);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function add_req_place($user_id, $loc, $adresa, $program, $consum_lunar, $consum_anual, $consum_ultim, $alimentare, $data_limita, $precizari, $req_fat){

		global $bcrypt;

		$time 		= time();

		$query 	= $this->db->prepare("INSERT INTO `requests` (`user_id`, `loc`, `adresa`, `program`, `consum_lunar`, `consum_anual`, `consum_ultim`, `alimentare`, `time`, `data_limita`, `precizari`, `req_fat`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");

		$query->bindValue(1, $user_id);
		$query->bindValue(2, $loc);
		$query->bindValue(3, $adresa);
		$query->bindValue(4, $program);
		$query->bindValue(5, $consum_lunar);
		$query->bindValue(6, $consum_anual);
		$query->bindValue(7, $consum_ultim);
		$query->bindValue(8, $alimentare);
		$query->bindValue(9, $time);
		$query->bindValue(10, $data_limita);
		$query->bindValue(11, $precizari);
		$query->bindValue(12, $req_fat);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function add_consum_total($request_id, $consum){

		global $bcrypt;

		$time 		= time();

		$query 	= $this->db->prepare("UPDATE `requests` SET `consum_total_anual` = `consum_total_anual` + ? WHERE `id` = ?");

		$query->bindValue(1, $consum);
		$query->bindValue(2, $request_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function requestdata($id) {

		$query = $this->db->prepare("SELECT * FROM `requests` WHERE `id`= ?");
		$query->bindValue(1, $id);

		try{

			$query->execute();

			return $query->fetch();

		} catch(PDOException $e){

			die($e->getMessage());
		}

	}

	public function request_exists($id) {
	
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
	
	public function delete_request($id) {
	
		$query = $this->db->prepare("DELETE FROM `requests` WHERE `id`= ?");
		$query->bindValue(1, $id);
		try{
			$query->execute();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function get_requests($user_id,$stat) {

		if($stat == 0){
			
		$query = $this->db->prepare("SELECT * FROM `requests` WHERE `user_id`= ? AND `req_fat` = 0 ORDER BY `time` DESC");
		$query->bindValue(1, $user_id);

		}
		else{
			
		$query = $this->db->prepare("SELECT * FROM `requests` WHERE `req_fat` = 0 ORDER BY `time` DESC");

		}
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}	

	public function get_locations($req_fat) {

		$query = $this->db->prepare("SELECT * FROM `requests` WHERE `req_fat` = ?");
		$query->bindValue(1, $req_fat);

		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}	

}