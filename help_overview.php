<?php
	require_once('includes/global.inc.php');
	global $configInfo; 
	global $db;
	

	$template = $twig->load('help_overview.twig');
	
	$admins=$db->GetAll("SELECT * from system_users WHERE admin=1");
	

   	
echo $template->render([
	'pagename'=>'help_overview',
	'title'=>'Help Overview',
	'admins'=>$admins,
	'err'=>$err]);
?>
  

	
	
	


