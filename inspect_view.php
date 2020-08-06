<?php
	require_once('includes/global.inc.php');
	global $sessionConfig; 
	global $db;
	$template = $twig->load('inspect_view.twig');
	$var=array();
	
	
	//error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_DEPRECATED);
    //ini_set('display_errors', 'On');
	global $db;
	
	//Deal with any form input	
	if(sizeof($_REQUEST) >= 1) {
		//clean up
		$request=array();
		foreach($_REQUEST as $key=>$item){
			$request[$key]=filter_var($item,FILTER_SANITIZE_STRING);
		}
	}//any post variables
	
  
   //Display one inspection
   if(isset($_REQUEST['inspect'])) {
	   $inspect_id= filter_var($_REQUEST['inspect'],FILTER_SANITIZE_NUMBER_INT);
	   $sql="SELECT * from inspections where id=$inspect_id";
	   $form=$db->GetRow($sql);
	   if(empty($form)) $err= "Inspection record not found";
	   else {
		   $room=$db->GetRow("SELECT * from user_room WHERE id=$form[room_id]");
		   if(!empty($room)) {
			   $sql="SELECT user_building.name as building_name, user_faculty.full_name as faculty_name, user_room.short_name as room from user_room LEFT JOIN user_building ON (user_room.building_id=user_building.id) LEFT JOIN user_faculty ON (user_room.faculty_id=facultyadmin_faculty.id) WHERE user_room.id='$form[room_id]'";
			   $result=$db->GetRow($sql);
			   if($result){
			   		$var['building_name']=$result['building_name'];
			   		$var['faculty_name']=$result['faculty_name'];
			   		$var['room']=$result['room'];
			   		$var['supervisor']=$form['supervisor'];
			   		$var['inspector']= $form['inspector'];
			   		$var['date']= $form['datetime'];
			   	
			   		$questions=$db->GetAll("SELECT * FROM inspection_questions ORDER BY number");
			   		foreach($questions as $key=>$question){
			   			if(is_null($form[$question['number']])) $questions[$key]['stat']='N/A';
			   			elseif ($form[$question['number']] == 1) $questions[$key]['stat']="Yes";
			   			else $questions[$key]['stat']="No";
				   	}
				   	$var['comments']=html_entity_decode($form['comments']);
				   	$var['actions']=html_entity_decode($form['actions']);
				   	if ($form['status']==1) $var['status']='Pass';
				   	else $var['status']='Fail';

				}//result
	   		}//room found
	   
   		}//inspection found
   	}//isset inspect

  
  echo $template->render(['var'=>$var,'questions'=>$questions,'err'=>$err]);
  
?>