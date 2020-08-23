<?php
	require_once('includes/global.inc.php');
	global $configInfo; 
	global $db;
	

	$template = $twig->load('help_overview.twig');

   	
echo $template->render([
	'pagename'=>'help_overview',
	'title'=>'Help Overview',
	'err'=>$err]);
?>
  

	
	
	


