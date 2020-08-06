<?php
	require_once('includes/global.inc.php');
	global $sessionConfig; 
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
		$questions=$db->GetAll("SELECT * FROM inspection_questions ORDER BY number");
		$sql="INSERT INTO inspections VALUES(NULL,$request[room_id],CURDATE(), ";
		foreach($questions as $question){
			if(isset($request[$question['number']])) $sql.='TRUE, '; 
			else $sql.='FALSE, ';
		}
		//echo mysqli_real_escape_string($db->_connectionID,$request['comments']);
		//echo "<br>";
		if(isset($request['comments'])) {
			$r=mysqli_real_escape_string($db->_connectionID,$request['comments']); 
			$sql.="'$r',";
		}
		else $sql.=" '',";
		if(isset($request['actions'])) $sql.="'$request[actions]',";
		else $sql.=" '',";
		
		$sql.= "'tjdavis','tjdavis',";
		if(isset($request['decision'])) {
			if($request['decision']==1) $sql.="TRUE";
			else $sql.="FALSE";
		}
		else  $sql.="FALSE";
		$sql.=")";
		echo $sql;
		if(!$db->Execute($sql)) echo "<br>Error: " . $db->errorMsg() . "<br>";
		else header("Location: /rooms/lookup.php?room_id=$request[room_id]");
		
	}
   
   	if(isset($_REQUEST['status'])) if($_REQUEST['status']=='new' && isset($_REQUEST['room_id'])){
		$sql="SELECT user_building.name as building_name, user_faculty.full_name as faculty_name, user_room.short_name as room from user_room LEFT JOIN user_building ON (user_room.building_id=user_building.id) LEFT JOIN user_faculty ON (user_room.faculty_id=user_faculty.id) WHERE user_room.id='$_REQUEST[room_id]'";
		$result=$db->GetRow($sql);
		if($result){
	   		$var['building_name']=$result['building_name'];
	   		$var['faculty_name']=$result['faculty_name'];
	   		$var['room']=$result['room'];
	   		$var['supervisor']=$form['supervisor'];
	   		$var['inspector']= $form['inspector'];
	   		$var['date']= $form['datetime'];
	   		$var['room_id'] = $_REQUEST['room_id'];

	   		$questions=$db->GetAll("SELECT * FROM inspection_questions ORDER BY number");

		}
		   
 	} //status=new
   
 	echo $template->render(['var'=>$var,'questions'=>$questions,'err'=>$err]);

  
?>