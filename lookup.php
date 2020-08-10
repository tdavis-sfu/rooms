<?php
	require_once('includes/global.inc.php');
	global $sessionConfig; 

	global $db;
	
	//echo"<pre>";
	//print_r($_SESSION); 
	//echo "</pre>";
	$template = $twig->load('lookup.twig');

   if(isset($_REQUEST['faculty_id'])) $faculty=$_REQUEST['faculty_id']; else $faculty='';
   if(isset($_REQUEST['building_id'])) $sbuilding=$_REQUEST['building_id']; else $sbuilding='';
   if(isset($_REQUEST['room_id'])) $sroom=$_REQUEST['room_id']; else $sroom='';
   
   $sql="SELECT * FROM user_faculty where name !='' order by full_name";
   $facultylist=$db->GetAll($sql);
   
   //If just the room was specifided then look up the other data.
   if($sroom !='' && $sbuilding==''){
	   $sql="SELECT user_building.id as building_id, user_faculty.id as faculty_id from user_room LEFT JOIN user_building ON (user_room.building_id=user_building.id) LEFT JOIN user_faculty ON (user_room.faculty_id=user_faculty.id) WHERE user_room.id='$sroom'";
	   $result=$db->GetRow($sql);

	   if($result){
		   $sbuilding=$result['building_id'];
		   $faculty=$result['faculty_id'];
	   }
   }
   $foptions="<option value=''></option>\r";
   $foptions.="<option value='-1'";
		if ($faculty==-1) $foptions.= " selected ";
	$foptions.=">ALL</option>\r";
	foreach($facultylist as $fac){
		$foptions.= "<option value='$fac[id]' ";
		if($faculty==$fac['id']) $foptions.= 'selected ';
		$foptions.= ">$fac[full_name]</option>\r";
	}
		
	if(isset($_REQUEST['faculty_id']) || $faculty !='')	{
		if ($faculty==-1) 
			$sql="SELECT distinct `building_id`, user_building.name from `user_room` LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) WHERE `faculty_id`>=1 order by user_building.name";
		else 
			$sql="SELECT distinct `building_id`, user_building.name from `user_room` LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) WHERE `faculty_id`='$faculty' order by user_building.name ";
		//echo $sql;
		$buildings=$db->GetAll($sql);
		$boptions= "";
		foreach($buildings as $building){
			$building_name=$db->GetRow("SELECT name from user_building where id=$building[building_id]");
			$boptions.=  "<option value='" . $building['building_id'] . "'";
			if($sbuilding==$building['building_id']) $boptions.= " selected ";
			$boptions.= ">" . $building_name['name'] . "</option>\r";
		}
		$roptions='';
		if(isset($_REQUEST['building_id']) || $sbuilding !=''){
			if ($faculty==-1)
				$sql="SELECT *,user_room.id as rm_id, user_room.name as rm_name FROM user_room LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) WHERE faculty_id>=1 AND building_id='$sbuilding' order by user_room.name";
			else
				$sql="SELECT *,user_room.id as rm_id, user_room.name as rm_name FROM user_room LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) WHERE faculty_id='$faculty' AND building_id='$sbuilding' order by user_room.name";
			$rooms=$db->GetAll($sql);
			if (!empty($rooms)){
				foreach($rooms as $room){
					$roptions.=  "<option value='" . $room['rm_id'] . "'";
					if($sroom==$room['rm_id']) $roptions.= " selected ";
					$roptions.= ">" . $room['rm_name'] . "</option>";
				}//foreach room

			if ($sroom !=''){
				if ($faculty=='-1')
					$sql="SELECT * FROM user_room LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) WHERE faculty_id>=1 AND building_id='$sbuilding' AND user_room.id='$sroom'";
				else
					$sql="SELECT * FROM user_room LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) WHERE faculty_id='$faculty' AND building_id='$sbuilding' AND user_room.id='$sroom'";
				
				$roominfo=$db->getRow($sql);

				$sql="SELECT * FROM inspections WHERE room_id=$sroom order by datetime desc";
				$inspections=$db->GetAll($sql);	
			}//if not empty room
		}		
	}			
}
	
echo $template->render([
	'sroom'=>$sroom,
	'foptions'=>$foptions,
	'boptions'=>$boptions,
	'roptions'=>$roptions,
	'roominfo'=>$roominfo,
	'inspections'=>$inspections,
	'havesearched'=>$havesearched,
	'config'=>$sessionConfig,
	'err'=>$err]);
?>
  

	
	
	


