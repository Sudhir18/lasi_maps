<?php

/**

This is database connection class used to perform database query operations

execute query having
*/

class SMSDatabase{
	const DBHOST = 'localhost';
	const DBUSER = 'root';
	const DBPWD = '';
	const DBNAME = 'lasi_maps';
	public $conn = null;
	public $stmt = null;

	 public function __construct(){


	 		try{
	 		
	 		$url = 	'mysql:host='.self::DBHOST.';dbname='.self::DBNAME;
	 		$this->conn = new PDO($url, self::DBUSER, self::DBPWD);
	 		if($this->conn){

		 		$this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);			 			
	 		}

	 		

	 		}catch(PDException $e){

	 			error_log("Failed to connect db " . $e->getMessage());
	 			die();
	 		}	
	 }



	 public function execute($query,$data = null){


	 		try{

	 			
	 	
	 		$this->stmt = $this->conn->prepare($query);

	 		if($data){
	 				$colum_counter = 1;
	 				foreach ($data as  $k=>$value) {
	 					# code...
	 					$this->stmt->bindValue($colum_counter,$value);
	 					$colum_counter++;
	 				}
	 		}

	 			$sql_result = $this->stmt->execute();
				return $sql_result;
	 		}catch(PDOException $e){

	 			return false;	
	 		}
	 		
	 }	



	 public function start_transaction(){

	 		try{

	 		$this->conn->beginTransaction();
	 				
	 		}catch(PDOException $e){

	 			error_log("Failed Transaction".$e->getMessage());	
	 			return false;
	 		}

	 }


	 public function commit(){

	 		try{

	 		$this->conn->commit();
	 				
	 		}catch(PDOException $e){

	 			error_log("Failed comit".$e->getMessage());	
	 			return false;
	 		}

	 }


	 public function rollback(){

	 		try{

	 		$this->conn->rollback();
	 				
	 		}catch(PDOException $e){

	 			error_log("Failed rollback".$e->getMessage());	
	 			return false;
	 		}

	 }	


	 public function close(){
	 		$this->stmt = null;
	 		$this->conn = null;

	 }

	 public function get_records(){

	 	return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	 }

	 public function get_record(){

	 	return $this->stmt->fetch(PDO::FETCH_ASSOC);
	 }

	 public function getRowCount(){
	 		return $this->stmt->rowCount();

	 }

	 public function getLastInsertID(){
	 	return $this->conn->lastInsertId(); 
	 }
}

$db = new SMSDatabase();

?>