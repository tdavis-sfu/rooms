<?php
	require_once('includes/global.inc.php');
	global $configInfo; 

	global $db;
	$err='';
	
	//Check if they are authorized
	if($configInfo['can_inspect'] == FALSE) { header("Location: $configInfo[url_root]/unauthorized.html");}
	
	$template = $twig->load('groups.twig');
	
	if(sizeof($_REQUEST) >= 1) {
		//clean up
		$request=array();
		foreach($_REQUEST as $key=>$item){
			$request[$key]=filter_var($item,FILTER_SANITIZE_STRING);
		}

	}//any post variables
	
	$sql="SELECT DISTINCT groupname FROM groups WHERE 1 ORDER BY groupname";
	$groups=$db->GetAll($sql);
	$goptions='';
	if($groups){
		foreach($groups as $group){
			$goptions.="<option value='$group[groupname]'>$group[groupname]</option> \r";
		}
	}
		
	
	echo $template->render([
	'config'=>$configInfo,
	'pagename'=>'groups',
	'title'=>'Inspect Groups',
	'goptions'=>$goptions,
	'err'=>$err]);
?>
  

	
	
	


