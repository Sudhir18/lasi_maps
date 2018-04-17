<?php

include_once(dirname(dirname(__FILE__)).'/config/database.php');

class MapModel{

	public static function getAllMaps(){
		global $db;
		$sql = "SELECT * FROM sms_ssu_maps ssm JOIN lasi_psus lp ON ssm.ssuid = lp.puid";
		$db->execute($sql);
		$maps = $db->get_records();
		return $maps;
	}

	public static function getStates(){
		global $db;
		$sql = "SELECT distinct stateid,state FROM lasi_psus order by state";
		$db->execute($sql);
		$states = $db->get_records();
		return $states;
	}

	public static function allSSU(){
		global $db;
		$sql = "SELECT * FROM lasi_psus";
		$db->execute($sql);
		$ssu = $db->get_records();
		return $ssu;
	}

	public static function getDistricts($stateid,$urbanrural=1){
		global $db;
		$sql = "SELECT distinct regionid,region FROM lasi_psus WHERE stateid = ? AND urbanrural = ? ORDER BY region";
		$db->execute($sql,array($stateid,$urbanrural));
		$districts = $db->get_records();
		return $districts;
	}

	public static function getSSUByDistrict($regionid){
		global $db;
		$sql = "SELECT distinct puid,name FROM lasi_psus WHERE regionid = ?  ORDER BY name";
		$db->execute($sql,array($regionid));
		$ssu = $db->get_records();
		return $ssu;
	}

	public static function addMap($data){
		global $db;
		$sql = "INSERT INTO sms_ssu_maps(ssuid,uploaded_by) VALUES(?,?)";
		$result = $db->execute($sql,array($data['ssuid'],$data['uploaded_by']));
		if($result !== false){
			return true;
		}
		return false;
	}

	public static function getMapBySSU($ssuid){
		global $db;
		$sql = "SELECT * FROM sms_ssu_maps WHERE ssuid=?";
		$db->execute($sql,array($ssuid));
		$map = $db->get_record();
		return $map;
	}

	public static function updateFilepath($filepath,$filename,$id){
		global $db;
		$sql = "UPDATE sms_ssu_maps SET filepath=?,filename=? WHERE id=?";
		$reuslt = $db->execute($sql,array($filepath,$filename,$id));
		if($result !== false)
			return true;
		return false;
	}

	public static function getSSUById($id){
		global $db;
		$sql = "SELECT * FROM lasi_psus WHERE puid = ?";
		$db->execute($sql,array($id));
		$ssu = $db->get_record();
		return $ssu;
	}

	public static function getMapById($id){
		global $db;
		$sql = "SELECT * FROM sms_ssu_maps WHERE id = ? ";
		$db->execute($sql,array($id));
		$map = $db->get_record();
		return $map;
	}

	public static function updateMap($data,$id){
		global $db;
		$sql = "UPDATE sms_ssu_maps SET ssuid=? WHERE id = ? ";
		$result = $db->execute($sql,array($data['ssuid'],$id));
		if($result !== false)
			return true;

		return false;
	}
}

?>
