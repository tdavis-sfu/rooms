<?php
	require_once('includes/global.inc.php');
	global $configInfo; 

	global $db;
	
	//Check if they are authorized
	if($configInfo['can_admin'] == FALSE) { header("Location: $configInfo[url_root]/unauthorized.html");}
	
	$template = $twig->load('manage.twig');
	
	if(sizeof($_REQUEST) >= 1) {
		//clean up
		$request=array();
		foreach($_REQUEST as $key=>$item){
			$request[$key]=filter_var($item,FILTER_SANITIZE_STRING);
		}
		if ($request['supervisor']) $active_pi=$request['supervisor']; else $active_pi='';
	}//any post variables
	
	if(isset($request['savegroup']) && isset($request['groupname'])){
		if($request['groupname'] !=''){
			//check if group exists
			$result=$db->Execute("DELETE from groups where groupname='$request[groupname]'");
			//$err=$result;
			$err='';
			foreach($request as $key=>$value) {
				if($value=='on'){
					$sql="INSERT INTO groups (groupname,room_id) VALUES ('$request[groupname]','$key')";
					$result=$db->Execute($sql);
					$err=$result;
				}
			}
		}
		
	}
	if(isset($request['groupform'])){
		$result=$db->GetRow("SELECT * FROM groups WHERE groupname='$request[groupform]'");
		if($result) $groupname=$request['groupform'];
		else $groupname='';
	}
	else $groupname='';
	

	$pis=$db->GetAll("SELECT DISTINCT pi as name from safety_plans ORDER BY pi");
	$pi_options="<option value=''></option>\r";
	if($pis){
		foreach($pis as $pi){
			if($pi['name']==$active_pi) $selected='selected'; else $selected='';
			$pi_options.="<option value='$pi[name]' $selected>$pi[name]</option>\r";
		}
	}
	if (!isset($request['faculty'])) $faculty=-1;
	else $faculty=$request['faculty'];
	
	$sql="SELECT * FROM user_faculty where name !='' order by full_name";
   $facultylist=$db->GetAll($sql);
   $foptions="<option value='-1'";
	 if($faculty==-1) $foptions.= " selected ";
	$foptions.=">ALL</option>\r";
	foreach($facultylist as $fac){
		$foptions.= "<option value='$fac[id]' ";
		if($faculty==$fac['id']) $foptions.= 'selected ';
		$foptions.= ">$fac[full_name]</option>\r";
	}
	if(isset($request['supervisor'])) if($request['supervisor'] != '') $supervisor_call="AND pi='$request[supervisor]'"; else $supervisor_call='';
  
	if(isset($request['function'])) switch($request['function']) {
		case 'grouprooms':
			if ($faculty=='-1') $facultycall=">=1"; else $facultycall="=$faculty" ;
				$sql="
SELECT 
	user_building.name as building_name, 
	user_room.short_name as room_name, 
	user_room.type_descript as room_type, 
	user_room.capacity as capacity, 
	safety_plans.pi as pi, 
	safety_plans.purpose as purpose,
	user_room.id as room_id,
	groups.groupname as groupname
FROM user_room 
LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) 
LEFT JOIN inspections ON (user_room.id=inspections.room_id) 
LEFT JOIN safety_plans ON (safety_plans.room_id=user_room.id) 
LEFT JOIN groups ON (groups.room_id=user_room.id)
WHERE 
	faculty_id$facultycall
	$supervisor_call
ORDER BY user_building.name,user_room.short_name";				
			$roomlist=$db->getAll($sql);
			
			$goptions='';
			$sql="SELECT DISTINCT groupname FROM groups WHERE 1 ORDER BY groupname";
			$groups=$db->GetAll($sql);
			if($groups) foreach($groups as $group){
				$goptions.="<option value='$group[groupname]'>$group[groupname]</option>\r";
			}
		
		
		break;
		case 'noinspection':
			if ($faculty=='-1') $facultycall=">=1"; else $facultycall="=$faculty" ;
				$sql="
SELECT 
	user_building.name as building_name, 
	user_room.short_name as room_name, 
	user_room.type_descript as room_type, 
	user_room.capacity as capacity, 
	safety_plans.pi as pi, 
	safety_plans.purpose as purpose 
FROM user_room 
LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) 
LEFT JOIN inspections ON (user_room.id=inspections.room_id) 
LEFT JOIN safety_plans ON (safety_plans.room_id=user_room.id) 
WHERE 
	faculty_id$facultycall
	AND ISNULL(inspections.id) 
	$supervisor_call
	AND safety_plans.id IS NOT NULL 
ORDER BY user_building.name,user_room.short_name";				
				$roomlist=$db->getAll($sql);
				
		break;
		case 'failedinspection':
			$roomlist=array();
			if ($faculty=='-1') $facultycall=">=1"; else $facultycall="=$faculty" ;

			$rooms=$db->GetAll("SELECT DISTINCT room_id from inspections WHERE 1");
			if($rooms) foreach ($rooms as $room){
				$latest=$db->GetRow("SELECT id, inspect_date FROM inspections WHERE inspect_date= (SELECT max(inspect_date) from inspections WHERE room_id=$room[room_id]) AND room_id=$room[room_id]");
				if($latest) {
					$sql="
SELECT
	user_room.id,
	inspections.id as inspectionid,
	user_building.name as building_name, 
	user_room.short_name as room_name, 
	user_room.type_descript as room_type, 
	user_room.capacity as capacity, 
	safety_plans.pi as pi, 
	safety_plans.purpose as purpose,
    inspections.`inspect_date` as thedate
							
FROM 
	user_room 
	LEFT JOIN inspections  ON (user_room.id=inspections.room_id)
	LEFT JOIN `user_building` ON (user_room.building_id=user_building.id)  
	LEFT JOIN safety_plans ON (safety_plans.room_id=user_room.id)
WHERE
	status=0
	AND
	user_room.faculty_id $facultycall
	$supervisor_call
	AND
	inspections.id=$latest[id]";

				} //if latest
				$result=$db->getRow($sql);
				if($result) $roomlist[]=$result;
				//printr($roomlist);
			}
		break;
		case 'supervised':
		if ($faculty=='-1') $facultycall=">=1"; else $facultycall="=$faculty" ;
		$sql="
SELECT 
	user_building.name as building_name, 
	user_room.short_name as room_name, 
	user_room.type_descript as room_type, 
	user_room.capacity as capacity, 
	safety_plans.pi as pi, 
	safety_plans.purpose as purpose 
FROM safety_plans 
 LEFT JOIN user_room ON (safety_plans.room_id=user_room.id) 
LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) 


WHERE 
	faculty_id$facultycall 
	AND safety_plans.id IS NOT NULL 
	$supervisor_call
	AND safety_plans.id IS NOT NULL
ORDER BY user_building.name,user_room.short_name";	
			
				$roomlist=$db->getAll($sql);
		break;
		case 'timed':
		if ($faculty=='-1') $facultycall=">=1"; else $facultycall="=$faculty" ;
				$sql="
SELECT 
	user_building.name as building_name, 
	user_room.short_name as room_name, 
	user_room.type_descript as room_type, 
	user_room.capacity as capacity, 
	safety_plans.pi as pi, 
	safety_plans.purpose as purpose 
FROM user_room 
LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) 
LEFT JOIN inspections ON (user_room.id=inspections.room_id) 
LEFT JOIN safety_plans ON (safety_plans.room_id=user_room.id) 
WHERE 
	faculty_id$facultycall
	AND (ISNULL(inspections.id) 
		OR
		
	AND safety_plans.id IS NOT NULL 
ORDER BY user_building.name,user_room.short_name";	

			
				$roomlist=$db->getAll($sql);
		break;
		
		case 'listnolink':
		if ($faculty=='-1') $facultycall=">=1"; else $facultycall="=$faculty" ;
		$sql="
SELECT 
	user_building.name as building_name, 
	user_room.short_name as room_name, 
	user_room.type_descript as room_type, 
	user_room.capacity as capacity, 
	safety_plans.pi as pi, 
	safety_plans.purpose as purpose,	
	user_room.id as room_id
FROM user_room 
LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) 
LEFT JOIN safety_plans ON (safety_plans.room_id=user_room.id) 
WHERE 
	faculty_id$facultycall
	AND safety_plans.id IS NOT NULL 
	AND (safety_plans.plan = '')
ORDER BY user_building.name,user_room.short_name";	
			
				$roomlist=$db->getAll($sql);
		break;
		
		case 'allinspections':
		if ($faculty=='-1') $facultycall=">=1"; else $facultycall="=$faculty" ;
	/*$sql="

		
		SELECT 
	user_building.name as building_name, 
	user_room.short_name as room_name, 
	inspections.id as inspectionid,
	user_room.type_descript as room_type, 
	user_room.capacity as capacity, 
	safety_plans.pi as pi, 
	safety_plans.purpose as purpose ,
	inspections.`inspect_date` as thedate
FROM user_room 
LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) 
LEFT JOIN inspections ON (user_room.id=inspections.room_id) 
LEFT JOIN safety_plans ON (safety_plans.room_id=user_room.id) 
WHERE 
	faculty_id$facultycall
	AND (inspections.id IS NOT NULL) 
	$supervisor_call
	AND safety_plans.id IS NOT NULL 
ORDER BY user_building.name,user_room.short_name,thedate desc";	
*/

		$sql="
		SELECT 
	user_building.name as building_name, 
	user_room.short_name as room_name, 
	user_room.type_descript as room_type, 
	user_room.capacity as capacity, 
	safety_plans.pi as pi, 
	safety_plans.purpose as purpose,
	user_room.id as room_id
FROM user_room 
LEFT JOIN `user_building` ON (user_room.building_id=user_building.id) 
LEFT JOIN safety_plans ON (safety_plans.room_id=user_room.id) 
WHERE 
	faculty_id$facultycall
	$supervisor_call
	AND safety_plans.id IS NOT NULL 
ORDER BY user_building.name,user_room.short_name
		";			
		$roughlist=$db->getAll($sql);
		$roomlist=array();		
		if($roughlist) foreach($roughlist as $oneroom){
			$oneroom['inspectionid']='';
			$oneroom['thedate']='';
			$oneroom['outcome']='';
			$oneroom['inspectme']="<button style='background-color: #4CAF50;' onClick='window.location.href=\"inspect.php?status=new&room_id=$oneroom[room_id]&source=manage&faculty=$faculty\"'>Inspect</button>";
			
			$sql="SELECT * from inspections WHERE room_id=$oneroom[room_id] order by inspect_date DESC LIMIT 5";
			$inspections=$db->getAll($sql);
			if(count($inspections) > 0){
				$number=count($db->getAll("SELECT * from inspections WHERE room_id=$oneroom[room_id]"));
				$oneroom['thedate']="Total: $number";
				$roomlist[]=$oneroom; //create a line
				foreach($inspections as $insp){
					$subline=array();
					$subline['inspectionid']=$insp['id'];
					$subline['thedate']=$insp['inspect_date'];
					$subline['outcome']=(0 == $insp['status']) ? 'Non-compliant' : 'Compliant';
					$subline['inspectme']= "<button style='background-color: #AAAAAA;' onClick='window.location.href=\"inspect_view.php?&inspect=$insp[id]\"'>View</button>";
					$roomlist[]=$subline;
				}//foreach
			}
			else { 
				$oneroom['thedate']='None';
				$roomlist[]=$oneroom;
			} //no inspections
		}
		//else $roomlist='';
				
		
		
	}//case
	//printr($roomlist);

if($roomlist) $count=count($roomlist); else $count=0;
echo $template->render([
	'config'=>$configInfo,
	'pi_options'=>$pi_options,
	'foptions'=>$foptions,
	'roomlist'=>$roomlist,
	'calledfunction'=>$request['function'],
	'pagename'=>'manage',
	'title'=>'Manage',
	'count'=>$count,
	'faculty'=>$faculty,
	'supervisor'=>$request['supervisor'],
	'goptions'=>$goptions,
	'err'=>$err]);
?>
  

	
	
	


