<?php
require_once('includes/global.inc.php');
	global $sessionConfig; 

	global $db;
	
	$sql="SELECT * from safety_plans where building_id !=0";
	$plans=$db->GetAll($sql);
	foreach($plans as $plan){
		$building=$db->GetRow("select * from user_building where id = $plan[building_id]");
		$room = $db->GetRow("select * from user_room where building_id=$plan[building_id] && (short_name like(' $plan[room2]') || short_name like('$plan[room2]'))");
		if(!$room) echo "Error: $plan[id] , $plan[room] <br>"; 
		/*else {
			$sql="UPDATE safety_plans SET room_id=$room[id] WHERE id=$plan[id]";
			$db->Execute($sql);
			//echo $sql;
		}*/
	}	
	
	
?>