<?php

if(!isset($_SESSION)){
	session_start();
}

include_once(dirname(dirname(__FILE__)).'/config/logger.php');
include_once(dirname(dirname(__FILE__)).'/model/UserModel.php');
include_once(dirname(dirname(__FILE__)).'/config/functions.php');

$logger->log("log","POST data".print_r($_POST,1));


$operation = trim($_POST['operation']);


switch($operation){

	case 'add_user' : $data['username'] = trim($_POST['username']);
					  $data['password'] = trim($_POST['password']);
					  $data['cnf_password'] = trim($_POST['cnf_password']);
					  validateAddInput($data);

					  $data['password'] = md5($data['password']);

					  // add user

					  $result = UserModel::addUser($data);

					  if($result === false){
						logAndExit('error','Failed to add user');
					  }

					  logAndExit('success','User added successfully!');
					  break;

	case 'login' : $data['username']=trim($_POST['username']);
				   $data['password']=trim($_POST['password']);
				   authenticateUser($data);
				    break;

	case 'reset_password': $data['username'] =  trim($_POST['username']);
						   $data['password'] =  trim($_POST['password']);
						   $data['cnf_password'] =  trim($_POST['cnf_password']);
				    		resetPassword($data);
				    		break;

}


function validateAddInput($data){

	if(empty($data['username'])){
		logAndExit('error','Username required!');
	}

	if(empty($data['password'])){
		logAndExit('error','Password required!');
	}

	if(empty($data['cnf_password'])){
		logAndExit('error','Confirm password required!');
	}

	if($data['password'] != $data['cnf_password']){
		logAndExit('error','Confirm Password not matching!');
	}

	if(UserModel::checkUserExists($data['username'])){
		logAndExit('error','Username already exists!');
	}
}


function authenticateUser($data){

	global $logger;
	if(empty($data['username'])){

	}

	if(empty($data['password'])){

	}

	$data['hash_password'] = md5($data['password']);

	$loginResult = UserModel::validateLogin($data);

	if($loginResult === false){
	logAndExit('error','Invalid username and password!');
	}

	$_SESSION['SESS_USERNAME'] = $loginResult['username'];
	$_SESSION['SESS_USERID'] = $loginResult['id'];

	$logger->log('log','Session data'.print_r($_SESSION,1));
	logAndExit('success','Authenticated successfully!');
}

function resetPassword($data){

	if(empty($data['username'])){
		logAndExit('error','Username required!');
	}

	if(empty($data['password'])){
		logAndExit('error','Password required!');
	}

	if(empty($data['cnf_password'])){
		logAndExit('error','Confirm password required!');
	}


	if($data['password'] != $data['cnf_password']){
		logAndExit('error','Confirm password not matching!');
	}

	if(!UserModel::checkUserExists($data['username'])){
		logAndExit('error','User does not exist!');
	}

	// reset Password

	$data['hash_password'] = md5($data['password']);

	$result = UserModel::updatePassword($data);

	if($result ===false){
		logAndExit('error','Failed to reset password!');
	}
	unset($_SESSION);
	session_destroy();
	logAndExit('success','Password reset successfully!');
}

?>
