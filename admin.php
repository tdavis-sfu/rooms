<?php
	require_once('includes/global.inc.php');
	global $configInfo; 

	global $db;
	
	//Check if they are authorized
	if($configInfo['can_admin'] == FALSE) { header("Location: $configInfo[url_root]/unauthorized.html");}
	
	$template = $twig->load('admin.twig');
	
	if(sizeof($_REQUEST) >= 1) {
		//clean up
		$request=array();
		foreach($_REQUEST as $key=>$item){
			$request[$key]=filter_var($item,FILTER_SANITIZE_STRING, array('options'=>'FILTER_FLAG_NO_ENCODE_QUOTES'));
		}
	}//any post variables
	$function='list';//default
	if(isset($request['function'])) $function=$request['function']; else $function='list';
	
	if($function=='delete') {
		if(isset($request['id'])){
			$db->Execute("DELETE FROM system_users where id='$request[id]'");
		}
		$function='list';
	}
	
	if ($function=='save') {
		if(isset($request['lastname'])) $lastname=addslashes($request['lastname']); else $lastname='';
		if(isset($request['firstname'])) $firstname=addslashes($request['firstname']); else $firstname='';
		if(isset($request['view'])) $view=TRUE; else $view=0;
		if(isset($request['inspect'])) $inspect=TRUE; else $inspect=0;
		if(isset($request['admin'])) $admin=TRUE; else $admin=0;
		
		if(isset($request['id'])){
			$sql="UPDATE system_users SET
					lastname='$lastname',
					firstname='$firstname',
					compid='$request[compid]',
					view='$view',
					inspect='$inspect',
					admin='$admin'
				WHERE id='$request[id]'";
			if(!$db->Execute($sql)) $err='Error saving';
		}
		$function='list';
		
	}
	
	if ($function=='new') {
		//Create new user
		$db->Execute("INSERT INTO system_users VALUES()");
		//Now edit the item
		$function='edit';
		$request['id']=$db->insert_id();
	}
	if($function=='edit') {
		//Update user
		if(isset($request['id'])){
			$user=$db->GetRow("SELECT * FROM system_users where id='$request[id]'");
		}
		else {$err='User Not Found'; $function='list';}
		
		//if an write happened then dropback to listng. 
		
	} // update

	if ($function=='list') {
	//Edit user privileges
		$sysusers=$db->GetAll("SELECT * FROM system_users ORDER BY lastname,firstname,compid");
		if($sysusers) {
			
		} //if sysusers
	} //function list
		
	echo $template->render([
		'config'=>$configInfo,
		'sysusers'=>$sysusers,
		'pagename'=>'admin',
		'function'=>$function,
		'user'=>$user,
		'err'=>$err]);
?>
  

	
	
	


