<?php
	header("Content-Type:application/json");
	if (isset($_GET['room_id']) && $_GET['room_id']!="") {
		require_once('includes/connect_only.inc.php');
		//global $configInfo; 
		global $db;
		$room_id=$_GET['room_id'];
		$sql="SELECT * FROM safety_plans LEFT JOIN user_room ON(safety_plans.room_id=user_room.id) WHERE safety_plans.room_id=$room_id";
		$plan=$db->getRow($sql);
		if($plan){
			response(0,$plan['pi'],$plan['contact'],$plan['purpose'],$plan['occupancy'],$plan['plan'],$plan['name']);
		} else {
			response(200,NULL,NULL,NULL,NULL,"No Record Found",NULL);
		}
	} else {
		response(400,NULL,NULL,NULL,NULL,"Invalid Request",NULL);
	}
	
	function response($response_code,$pi,$contact,$purpose,$occupany,$plan,$name){
		$response['pi'] = $pi;
		$response['contact'] = $contact;
		$response['response_code'] = $response_code;
		$response['purpose'] = $purpose;
		$response['occupany'] = $occupany;
		$response['plan'] = $plan;
		$response['name'] = $name;
 
		$json_response = json_encode($response);
		echo $json_response;
		//print_r ($_GET);
	}
?>