<?php

include_once(dirname(dirname(__FILE__)).'/model/MapModel.php');
include_once(dirname(dirname(__FILE__)).'/config/config.php');

$maps = MapModel::getAllMaps();
//die(print_r($maps,1));
$data_arr = array();
if($maps){
	foreach ($maps as $map) {
		# code...
		$itm = array();
		$itm['id'] = $map['id'];
		$itm['ssu'] = $map['name'];
		$itm['ssuid'] = $map['ssuid'];
		$itm['district'] = $map['region'];
		$itm['state'] = $map['state'];
		$itm['filename'] = $map['filename'];
		$itm['filepath'] = UPLOAD_IMAGE_URL.'/'.$map['id'].'/'.$map['filename'];
		array_push($data_arr, $itm);
	}
}
echo json_encode(array('data' => $data_arr));
exit();
?>