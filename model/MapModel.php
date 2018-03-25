<?php

include_once(dirname(dirname(__FILE__)).'/config/database.php');

class MapModel{

	public static function getAllMaps(){
		global $db;
		$sql = "SELECT * FROM sms_ssu_maps ssm JOIN sms_ssus ss ON ssm.ssuid = ss.ssu_id LEFT JOIN ";
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

	public function getSSUByDistrict($regionid){
		global $db;
		$sql = "SELECT distinct puid,name FROM lasi_psus WHERE regionid = ?  ORDER BY name";
		$db->execute($sql,array($regionid));
		$ssu = $db->get_records();
		return $ssu;
	}
}

?>