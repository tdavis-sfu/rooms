<?php
	require_once('includes/global.inc.php');
	global $configInfo; 
	global $db;
	$template = $twig->load('safety.twig');
	
	//Check if they are authorized
	if($configInfo['can_admin'] == FALSE) { header("Location: $configInfo[url_root]/unauthorized.html");}
	
	/*
	$sql="SELECT * from safety_plans where building_id !=0";
	$plans=$db->GetAll($sql);
	foreach($plans as $plan){
		$building=$db->GetRow("select * from user_building where id = $plan[building_id]");
		$room = $db->GetRow("select * from user_room where building_id=$plan[building_id] && (short_name like(' $plan[room2]') || short_name like('$plan[room2]'))");
		if(!$room) echo "Error: $plan[id] , $plan[room] <br>"; 
		else {
			$sql="UPDATE safety_plans SET room_id=$room[id] WHERE id=$plan[id]";
			$db->Execute($sql);
			//echo $sql;
		}
	}	
	*/
	if(sizeof($_REQUEST) >= 1) {
		//clean up
		$request=array();
		foreach($_REQUEST as $key=>$item){
			$request[$key]=filter_var($item,FILTER_SANITIZE_STRING);
		}
	}//any post variables
	
	//repeat last save for new ID
	if(isset($request['save'])) if($request['save']=='repeat') {
		if(isset($request['repeat_id'])){
			$sql="SELECT id, room_id, pi, contact, purpose, occupancy, plan FROM safety_plans WHERE id='$request[repeat_id]'";
			//echo $sql;
			
			$repeat=$db->GetRow($sql);
			if($repeat){
				$request['occupancy']=$repeat['occupancy'];
				$request['pi']=$repeat['pi'];
				$request['contact']=$repeat['contact'];
				$request['plan']=$repeat['plan'];
				$request['purpose']=$repeat['purpose'];
				$request['save']='save';
			}
		}
		//load last ID
		
		
	}

	if(isset($request['save'])) if($request['save']=='save') {
		//checks
		
		if($request['occupancy']=='') $request['occupancy']=0; 
		if(isset($request['pi'])) if($request['pi']=='') $request['pi']=$request['pi_new']; 
		if(isset($request['contact'])) if($request['contact']=='') $request['contact']=$request['contact_new']; 
		if(isset($request['room_id'])){
			//check if this is a new entry
			$safety_plan=$db->GetRow("SELECT * from safety_plans where room_id='$request[room_id]'");
			if(!$safety_plan){
				$db->Execute("INSERT INTO `safety_plans` (room_id) VALUES ($request[room_id])");
				$id=$db->insert_id();
				//echo "INSERTING NEW ONE";
			}
			else $id=$safety_plan['id'];
			
			$sql="UPDATE safety_plans SET 
					room_id='$request[room_id]',
					occupancy='$request[occupancy]',
					pi='$request[pi]',
					contact='$request[contact]',
					purpose='$request[purpose]',
					plan='$request[plan]'
					WHERE id='$id';";
			if(!$db->Execute($sql)) echo "Error updating: ". $db->errorMsg() . "<br>";
		}
	}

	if(isset($_REQUEST['faculty_id'])) $faculty=$_REQUEST['faculty_id']; else $faculty='';
   if(isset($_REQUEST['building_id'])) $sbuilding=$_REQUEST['building_id']; else $sbuilding='';
   if(isset($_REQUEST['room_id'])) $sroom=$_REQUEST['room_id']; else $sroom='';
   if(isset($_REQUEST['repeat_id'])) $repeat_id=$_REQUEST['repeat_id'];
   
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
				
				$sql="SELECT * from safety_plans WHERE room_id=$sroom";
				$safety=$db->GetRow($sql);
				
				$pis=$db->GetAll("SELECT DISTINCT pi as name from safety_plans ORDER BY pi");
				$pi_options="<option value=''></option>\r";
				if($pis){
					foreach($pis as $pi){
						if($pi['name']==$safety['pi']) $selected='selected'; else $selected='';
						$pi_options.="<option value='$pi[name]' $selected>$pi[name]</option>\r";
					}
				}
				$contacts=$db->GetAll("SELECT DISTINCT contact from safety_plans ORDER BY contact");
				$contact_options="<option value=''></option>\r";
				if($contacts){
					foreach($contacts as $contact){
						if($contact['contact']==$safety['contact']) $selected='selected'; else $selected='';
						$contact_options.="<option value='$contact[contact]' $selected>$contact[contact]</option>\r";
					}
				}
				$purposes=$db->GetAll("SELECT DISTINCT purpose from safety_plans ORDER BY purpose");
				$purpose_options="<option value=''></option>\r";
				if($purposes){
					foreach($purposes as $purpose){
						if($purpose['purpose']==$safety['purpose']) $selected='selected'; else $selected='';
						$purpose_options.="<option value='$purpose[purpose]' $selected>$purpose[purpose]</option>\r";
					}
				}
				
			}//if not empty room
		}		
	}			
}

if(isset($id)) $repeat_id=$id; elseif (!isset($repeat_id)) $repeat_id='';
echo $template->render([
	'sroom'=>$sroom,
	'foptions'=>$foptions,
	'boptions'=>$boptions,
	'roptions'=>$roptions,
	'roominfo'=>$roominfo,
	'havesearched'=>$havesearched,
	'config'=>$configInfo,
	'safety'=>$safety,
	'pi_options'=>$pi_options,
	'contact_options'=>$contact_options,
	'purpose_options'=>$purpose_options,
	'faculty'=>$faculty,
	'repeat_id'=>$repeat_id,
	'pagename'=>'safety',
	'title'=>'Safety Plans',
	'err'=>$err]);
?>