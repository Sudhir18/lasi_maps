<?php

if(!isset($_SESSION)){
	session_start();
}

include_once(dirname(dirname(__FILE__)).'/config/logger.php');
include_once(dirname(dirname(__FILE__)).'/model/UserModel.php');
include_once(dirname(dirname(__FILE__)).'/model/MapModel.php');
include_once(dirname(dirname(__FILE__)).'/config/functions.php');

$logger->log("log","POST data".print_r($_POST,1));

$operation = trim($_POST['operation']);
//$logger->log("log",$operation);
switch($operation){

	case 'get_districts': $stateid = trim($_POST['stateid']);
						  $urbanrural = trim($_POST['urbanrural']);				
						  $districts = MapModel::getDistricts($stateid,$urbanrural);
						  if(count($districts) > 0 ){
							echo json_encode(array('status' => 'success','districts' => utf8ize($districts)));
							exit();
							}
						echo json_encode(array('status' => 'error','message' => 'no districts found'));
						exit();
						break;

	case 'get_ssu': $stateid = trim($_POST['stateid']);
					$urbanrural = trim($_POST['urbanrural']);
					$regionid = trim($_POST['regionid']);

					$ssu = MapModel::getSSUByDistrict($regionid);
					if(count($ssu) > 0 ){
						echo json_encode(array('status' => 'success','ssu' => utf8ize($ssu)));
						exit();
					}
					echo json_encode(array('status' => 'error','message' => 'no ssu found'));
					exit();
					break;											
}						





?>