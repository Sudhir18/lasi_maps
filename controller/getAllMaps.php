<?php

include_once(dirname(dirname(__FILE__)).'/model/MapModel.php');
/*
$maps = MapModel::getAllMaps();
$data_arr = array();
if($maps){
	foreach ($maps as $map) {
		# code...
		$itm = array();
		$itm['id'] = $map['id'];
		$itm['ssu'] = $map['ssu'];
		$itm['district'] = $map['district'];
		$itm['state'] = $map['id'];
		$itm['filename'] = $map['filename'];
		$itm['filepath'] = $map['filepath'];
		array_push($data_arr, $itm);
	}
}
*/

$data_arr = array(
		array('id' => 1 ,'ssu' => 'keg' , 'district' => 'pune', 'state'=> 'maharastra'),
		array('id' => 2 ,'ssu' => 'meg' , 'district' => 'beed', 'state'=> 'maharastra'),
		array('id' => 3 ,'ssu' => 'jampur' , 'district' => 'lucknow', 'state'=> 'up'),
		array('id' => 4 ,'ssu' => 'mli' , 'district' => 'patna', 'state'=> 'bihar'),
		array('id' => 5 ,'ssu' => 'truni' , 'district' => 'madhurai', 'state'=> 'tamilnadu'),

);
echo json_encode(array('data' => $data_arr));
exit();
?>