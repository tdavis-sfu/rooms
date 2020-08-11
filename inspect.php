<?php
	require_once('includes/global.inc.php');
	global $configInfo; 
	//error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_DEPRECATED);
    //ini_set('display_errors', 'On');
	global $db;
	$template = $twig->load('inspect.twig');
	$var=array();
	//echo "<pre>";
	//printf("Initial character set: %s\n", mysqli_character_set_name($db->_connectionID));
	//mysqli_set_charset($db->_connectionID, "utf8mb4");
        //print_r($db);
        //echo "</pre>";
	//print_r($configInfo);
	//print_r($_REQUEST);
	//Deal with any form input
	echo"<pre>";
	//print_r($db);
	echo"</pre>";
	
	if(sizeof($_REQUEST) >= 1) {
		//clean up
		$request=array();
		foreach($_REQUEST as $key=>$item){
			$request[$key]=filter_var($item,FILTER_SANITIZE_STRING);
		}
	}//any post variables

	//check room_id for validity
	$roominfo=$db->GetRow("SELECT * FROM user_room WHERE id=$request[room_id]");

	if(empty($roominfo)){
		echo "Room ID not found";
	}
	else if(isset($request['status'])) if($request['status']=='save') {
		//Save a completed inspection form 
		//First need to grab the faculty_id to determine the question list. 
		$faculty=$db->GetRow("SELECT * FROM user_faculty WHERE id=$roominfo[faculty_id]");
		if($faculty['id']==5) $faculty_id=5; else $faculty_id=0;
		$questions=$db->GetAll("SELECT * FROM inspection_questions WHERE faculty_id=$faculty_id ORDER BY number");
		$sql="INSERT INTO inspections SET room_id=$request[room_id],datetime=CURDATE(), ";
		foreach($questions as $question){
			$sql.="`Q$question[number]`=";
			$field="Q" . $question['number'];
			if($request[$field]=='yes') $sql.='TRUE, '; 
			elseif ($request[$field]=='no') $sql.='FALSE, ';
			else $sql.="NULL, ";
		}
		//echo mysqli_real_escape_string($db->_connectionID,$request['comments']);
		//echo "<br>";
		if(isset($request['comments'])) {
			$r=mysqli_real_escape_string($db->_connectionID,$request['comments']); 
			$sql.="comments='$r', ";
		}
		else $sql.="comments='', ";
		if(isset($request['actions'])) $sql.="actions='$request[actions]', ";
		else $sql.="actions='', ";
		
		$safety=$db->GetRow("SELECT * FROM safety_plans where room_id=$request[room_id]");
		if($safety) $sql.="supervisor='" . addslashes($safety['pi']) . "', ";
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
		echo $sql;
		if(!$db->Execute($sql)) echo "<br>Error: " . $db->errorMsg() . "<br>";
		else header("Location: $configInfo[url_root]/lookup.php?room_id=$request[room_id]");
		
	}
   
   	if(isset($_REQUEST['status'])) if($_REQUEST['status']=='new' && isset($_REQUEST['room_id'])){
		$sql="SELECT user_building.name as building_name, user_faculty.full_name as faculty_name, user_room.short_name as room, user_faculty.id as faculty_id from user_room LEFT JOIN user_building ON (user_room.building_id=user_building.id) LEFT JOIN user_faculty ON (user_room.faculty_id=user_faculty.id) WHERE user_room.id='$_REQUEST[room_id]'";
		$result=$db->GetRow($sql);
		if($result){
			//if(phpCAS::)
			//Manual implenentation of faculty specific questions:
			if($result['faculty_id']==5) $faculty_id=5; else $faculty_id=0;
			
			$safety=$db->GetRow("SELECT * FROM safety_plans where room_id=$request[room_id]");
			if($safety) $supervisor=$safety['pi'];
			else $supervisor='';
			
	   		$var['building_name']=$result['building_name'];
	   		$var['faculty_name']=$result['faculty_name'];
	   		$var['room']=$result['room'];
	   		$var['supervisor']=$supervisor;
	   		$var['inspector']= phpCAS::getUser();
	   		$var['date']= $form['datetime'];
	   		$var['room_id'] = $_REQUEST['room_id'];

	   		$questions=$db->GetAll("SELECT * FROM inspection_questions WHERE faculty_id=$faculty_id ORDER BY number");

		}
		   
 	} //status=new
   
 	echo $template->render([
 			'var'=>$var,
 			'questions'=>$questions,
 			'config'=>$configInfo,
 			'err'=>$err]);


  
?>