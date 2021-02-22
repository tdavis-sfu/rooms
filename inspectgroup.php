<?php
	require_once('includes/global.inc.php');
	global $configInfo; 
	//error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_DEPRECATED);
    //ini_set('display_errors', 'On');
	global $db;
	
	//Check if they are authorized
	
	if($configInfo['can_inspect'] == FALSE) { header("Location: $configInfo[url_root]/unauthorized.html");}
	
	
	$template = $twig->load('inspectgroup.twig');
	$var=array();
	
	
	//echo "<pre>";
	//printf("Initial character set: %s\n", mysqli_character_set_name($db->_connectionID));
	//mysqli_set_charset($db->_connectionID, "utf8mb4");
        //print_r($db);
        //echo "</pre>";
	//print_r($configInfo);
	//print_r($_REQUEST);
	//Deal with any form input
	//echo"<pre>";
	//print_r($db);
	//echo"</pre>";
	
	if(sizeof($_REQUEST) >= 1) {
		//clean up
		$request=array();
		foreach($_REQUEST as $key=>$item){
			$request[$key]=filter_var($item,FILTER_SANITIZE_STRING);
		}
	}//any post variables
	
	//if(isset($_REQUEST['source'])) $source=$_REQUEST['source']; else $source='';
	//if(isset($_REQUEST['faculty'])) $facultyid=$_REQUEST['faculty']; else $facultyid='-1';
	//printr($_REQUEST);

	//check group_id for validity
	$group=$db->GetRow("SELECT * FROM groups WHERE groupname='$request[group_id]'");

	if(empty($group)){
		$err= "Group ID not found";
	}
	else if(isset($request['status'])) if($request['status']=='save') {
		//Save a completed inspection form 
		//First need to grab the faculty_id to determine the question list. 
		//Lookup the first room
		$faculty_id=0;
		$room_id=$group['room_id'];
		$sql="SELECT user_faculty.full_name as faculty_name, user_faculty.id as faculty_id from user_room LEFT JOIN user_building ON (user_room.building_id=user_building.id) LEFT JOIN user_faculty ON (user_room.faculty_id=user_faculty.id) WHERE user_room.id='$room_id'";
		
		$result=$db->GetRow($sql);
		if($result){
			if($result['faculty_id']==5) $faculty_id=5;
		}
		
		$questions=$db->GetAll("SELECT * FROM inspection_questions WHERE faculty_id=$faculty_id ORDER BY number");
		
		$grouplist=$db->GetAll("SELECT * FROM groups WHERE groupname='$request[group_id]'");
		if($grouplist) foreach($grouplist as $room) {
			$sql="INSERT INTO inspections SET room_id=$room[room_id],inspect_date=NOW(), ";
			foreach($questions as $question){
				$sql.="`Q$question[number]`=";
				$field="Q" . $question['number'];
				if($request[$field]=='yes') $sql.='TRUE, '; 
				elseif ($request[$field]=='no') $sql.='FALSE, ';
				else $sql.="NULL, ";
			}
		
			if(isset($request['comments'])) {
				$r=addslashes($request['comments']); 
				$sql.="comments='$r', ";
			}
			else $sql.="comments='', ";
			
			if(isset($request['actions'])) {
				$r=addslashes($request['actions']); 
				$sql.="actions='$r', ";
			}
			else $sql.="actions='', ";
			
			$safety=$db->GetRow("SELECT * FROM safety_plans where room_id=$room[room_id]");
			if($safety) $sql.="supervisor='" . addslashes($safety['pi']) . " ', ";
			else $sql.="supervisor='', ";
			
			$user=phpCAS::getUser();
			if($user) $sql.="inspector='$user', ";
			else $sql.="inspector='', ";
			
			if(isset($request['decision'])) {
				if($request['decision']==1) $sql.="status=TRUE";
				else $sql.="status=FALSE";
			}
			else  $sql.="status=FALSE";
			$sql.="";
			
			//echo $sql;
			//echo ("<br><br>");
			if(!$db->Execute($sql)) echo "<br>Error: " . $db->errorMsg() . "<br>";
		}
		//echo $source; exit;
		//if($source=='manage') header("Location: $configInfo[url_root]/manage.php?function=allinspections&supervisor=&faculty=$facultyid");
		header("Location: $configInfo[url_root]/lookup.php?room_id=$group[room_id]");
		
	}
   
   	if(isset($_REQUEST['status'])) if($_REQUEST['status']=='new' && isset($_REQUEST['group_id'])){
	   	$room_id=$group['room_id'];
	   	
		//Select the first room in the group list to determine the faculty - so as to get the right question list
		$sql="SELECT user_faculty.full_name as faculty_name, user_faculty.id as faculty_id from user_room LEFT JOIN user_building ON (user_room.building_id=user_building.id) LEFT JOIN user_faculty ON (user_room.faculty_id=user_faculty.id) WHERE user_room.id='$room_id'";
		
		$result=$db->GetRow($sql);
		if($result){
			//if(phpCAS::)
			//Manual implenentation of faculty specific questions:
			
			//$err.=print_r($result,true);
			if($result['faculty_id']==5) $faculty_id=5; else $faculty_id=0;
			
			//$safety=$db->GetRow("SELECT * FROM safety_plans where room_id=$request[room_id]");
			//if($safety) $supervisor=$safety['pi'];
			//else $supervisor='';
			
	   		//$var['building_name']=$result['building_name'];
	   		$var['faculty_name']=$result['faculty_name'];
	   		//$var['room']=$result['room'];
	   		//$var['supervisor']=$supervisor;
	   		$var['inspector']= phpCAS::getUser();
	   		$var['date']= $form['datetime'];
	   		$var['group_id'] = $request['group_id'];

	   		$questions=$db->GetAll("SELECT * FROM inspection_questions WHERE faculty_id=$faculty_id ORDER BY number");

		}
		   
 	} //status=new
 	
 	//if (isset($_REQUEST['faculty'])) $faculty=$_REQUEST['faculty']; else $faculty='';
 	//if (isset($_REQUEST['source'])) $source=$_REQUEST['source']; else $source='';
   
 	echo $template->render([
 			'var'=>$var,
 			'questions'=>$questions,
 			'config'=>$configInfo,
 			'err'=>$err]);


  
?>