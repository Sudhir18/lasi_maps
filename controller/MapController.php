<?php

if(!isset($_SESSION)){
	session_start();
}

include_once(dirname(dirname(__FILE__)).'/config/logger.php');
include_once(dirname(dirname(__FILE__)).'/model/UserModel.php');
include_once(dirname(dirname(__FILE__)).'/model/MapModel.php');
include_once(dirname(dirname(__FILE__)).'/config/functions.php');
include_once(dirname(dirname(__FILE__)).'/config/config.php');

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
	case 'add_ssu' : $data = array();
									$data['stateid'] =  trim($_POST['state']);
									$data['urbanrural'] =  trim($_POST['region']);
									$data['regionid'] =  trim($_POST['district']);
									$data['ssuid'] =  trim($_POST['ssu']);
									if(validateAddSSUInput($data)){
										//
										 	$data['uploaded_by'] = $_SESSION['SESS_USERID'];
											if(MapModel::addMap($data)){
													$map_info = MapModel::getMapBySSU($data['ssuid']);
													$filename = basename($_FILES['ssu_file']['name']);
													$targetDir = APPPATH.'\map_images\\'.$map_info['id'].'\\';
													$targetFileName = $targetDir.$filename;
													if(file_exists($targetFileName)){
														unlink($targetFileName);
													}
													
													mkdir($targetDir,0775,true);
													
													//die($targetFileName);
												//	mkdir($targetDir);
													if(move_uploaded_file($_FILES["ssu_file"]["tmp_name"], $targetFileName)){
														MapModel::updateFilepath($targetFileName,$filename,$map_info['id']);
														logAndExit('success','SSU Map uploaded successfully');
													}else{
															if(file_exists($targetFileName)){
														unlink($targetFileName);
													}
														logAndExit('error','Failed to upload image');
													}

											}
											logAndExit('error','Failed to add ssu');
									}
									break;

	case 'edit_ssu' : $data = array();
										$data['id'] = trim($_POST['map_id']);
										$data['ssuid'] = trim($_POST['ssu']);
										$data['stateid'] = trim($_POST['state']);
										$data['regionid'] = trim($_POST['region']);
									//	$data['uploaded_by'] = $_SESSION['SESS_USERID'];

										if(validateEditSSUInput($data)){
											$map_info = MapModel::getMapById($data['id']);
											MapModel::updateMap($data,$data['id']);

											if(isset($_FILES['ssu_file']['name'])){
												//delete previous filepath & update filepath
												$filename = basename($_FILES['ssu_file']['name']);
												$targetDir = APPPATH.'\map_images\\'.$map_info['id'].'\\';
												$targetFileName = $targetDir.$filename;
												if(file_exists($map_info['filepath'])){
													unlink($map_info['filepath']);
												}

												mkdir($targetDir,0775,true);
												
													if(move_uploaded_file($_FILES["ssu_file"]["tmp_name"], $targetFileName)){
														MapModel::updateFilepath($targetFileName,$filename,$map_info['id']);
														logAndExit('success','SSU Map updated successfully');
													}else{
														logAndExit('success','Failed to upload file');
													}
												
											}
											logAndExit('success','SSU Map updated successfully');
										}
										break;


}

function validateAddSSUInput($data){
		if(empty($data['ssuid']) || !is_numeric($data['ssuid'])){
			logAndExit('error','Invalid SSU');
		}

//		var_dump($_FILES);
		if(!isset($_FILES['ssu_file']) || !($_FILES['ssu_file']['size'] > 0)){
			logAndExit('error','File not selected');
		}

		$extension = pathinfo($_FILES['ssu_file']['name'],PATHINFO_EXTENSION);
		if(!in_array($extension,array("jpg","jpeg","png","gif"))){
			logAndExit('error','Invalid extension');
		}

		$map_info = MapModel::getMapBySSU($data['ssuid']);
		if($map_info){
			logAndExit('error','Already map uploaded');
		}

		return true;
}

function validateEditSSUInput($data){
	if(empty($data['ssuid']) || !is_numeric($data['ssuid'])){
		logAndExit('error','Invalid SSU');
	}

	if(isset($_FILES['ssu_file'])){
		$extension = pathinfo($_FILES['ssu_file']['name'],PATHINFO_EXTENSION);
		if(!in_array($extension,array("jpg","jpeg","png","gif"))){
			logAndExit('error','Invalid extension');
		}
	}

	$map_info = MapModel::getMapById($data['id']);
	if(!$map_info){
		logAndExit('error','no map found');
	}
	return true;
}





?>
