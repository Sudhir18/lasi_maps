<?php

include_once(dirname(dirname(__FILE__)).'/config/database.php');
include_once(dirname(dirname(__FILE__)).'/config/logger.php');

class UserModel{

public static function addUser($data){

	global $db;
	$sql = "INSERT INTO sms_map_users(username,password) VALUES(?,?)";
	$val_arr = array($data['username'],$data['password']);

	$result = $db->execute($sql,$val_arr);

	if($result !== false){
		return true;
	}
	return false;
}

public static function checkUserExists($username){


	global $db;

	$sql = "SELECT * FROM sms_map_users WHERE username=?";

	$db->execute($sql,array($username));
	if($db->getRowCount() > 0){
		return true;
	}

	return false;
}


public static function validateLogin($data){
	global $db;

	$sql = "SELECT * FROM sms_map_users WHERE username=? AND password=?";
	$val_arr = array($data['username'],$data['hash_password']);

	$db->execute($sql,$val_arr);

	if($db->getRowCount() == 1){

		// get user return user;

		$user = $db->get_record();
		//$usr = $users[0;
		return $user;

	}

	return false;
}

public static function updatePassword($data){

	global $db;

	$sql = "UPDATE sms_map_users SET password=? WHERE username=?";
	$val_arr = array($data['hash_password'],$data['username']);
	$result = $db->execute($sql,$val_arr);

	if($result !== false){
		return true;
	}
	return false;
}


}

?>