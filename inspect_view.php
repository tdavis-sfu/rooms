<?php
	require_once('includes/global.inc.php');
	global $configInfo; 
	global $db;
	$template = $twig->load('inspect_view.twig');
	$var=array();
	
	
	//error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_DEPRECATED);
    //ini_set('display_errors', 'On');
	
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
			   $sql="SELECT user_building.name as building_name, user_faculty.full_name as faculty_name, user_room.short_name as room, user_faculty.id as faculty_id FROM user_room LEFT JOIN user_building ON (user_room.building_id=user_building.id) LEFT JOIN user_faculty ON (user_room.faculty_id=user_faculty.id) WHERE user_room.id='$form[room_id]'";
			   $result=$db->GetRow($sql);
			   if($result){
				   	//Manual implenentation of faculty specific questions:
				   	if($result['faculty_id']==5) $faculty_id=5; else $faculty_id=0;
				   	
			   		$var['building_name']=$result['building_name'];
			   		$var['faculty_name']=$result['faculty_name'];
			   		$var['room']=$result['room'];
			   		$var['supervisor']=$form['supervisor'];
			   		$var['inspector']= $form['inspector'];
			   		$var['date']= $form['inspect_date'];
			   	
			   		$questions=$db->GetAll("SELECT * FROM inspection_questions WHERE faculty_id=$faculty_id ORDER BY number");
			   		foreach($questions as $key=>$question){
				   		$field='Q' . $question['number'];
				   		//echo "$question[number] ". $form[$field] . '<br>';
			   			if(is_null($form[$field])) $questions[$key]['stat']='N/A';
			   			elseif ($form[$field] == 1) $questions[$key]['stat']="Yes";
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