<?php
require_once('includes/global.inc.php');
	global $sessionConfig; 

	global $db;
	
	$sql="SELECT * from safety_plans where building_id !=0 && room_id != 0";
	$plans=$db->GetAll($sql);
	echo "<b>Errors in room identifiers</b><br><br>"
	echo "<table>
			<tr><th>ID</th><th>Room</th><th><th>Building</th><th>PI</th><th>Contact</th><th>Purpose</th></tr>\r";
	foreach($plans as $plan){
		
		$building=$db->GetRow("select * from user_building where id = $plan[building_id]");
		$room = $db->GetRow("select * from user_room where building_id=$plan[building_id] && (short_name like(' $plan[room2]') || short_name like('$plan[room2]'))");
		if(!$room) echo "
		<tr><td>$plan[id]</td><td>$plan[room]</td><td>$plan[building]</td><td>$plan[pi]</td><td>$plan[contact]</td><td>$plan[purpose]</td>"; 
		/*else {
			$sql="UPDATE safety_plans SET room_id=$room[id] WHERE id=$plan[id]";
			$db->Execute($sql);
			//echo $sql;
		}*/
	}	echo"</table>";
	
	
?>