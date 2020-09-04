<?php
	header("Content-Type:application/json");
	if (isset($_GET['room_id']) && $_GET['room_id']!="") {
		require_once('includes/connect_only.inc.php');
		//global $configInfo; 
		global $db;
		$room_id=$_GET['room_id'];
		$sql="SELECT * from safety_plans WHERE room_id=$room_id";
		$plan=$db->getRow($sql);
		if($plan){
			response(0,$plan['pi'],$plan['contact'],$plan['purpose'],$plan['occupancy'],$plan['plan']);
		} else {
			response(200,NULL,NULL,NULL,NULL,"No Record Found");
		}
	} else {
		response(400,NULL,NULL,NULL,NULL,"Invalid Request");
	}
	
	function response($response_code,$pi,$contact,$purpose,$occupany,$plan){
		$response['pi'] = $pi;
		$response['contact'] = $contact;
		$response['response_code'] = $response_code;
		$response['purpose'] = $purpose;
		$response['occupany'] = $occupany;
		$response['plan'] = $plan;
 
		$json_response = json_encode($response);
		echo $json_response;
		//print_r ($_GET);
	}
?>