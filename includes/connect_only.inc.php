<?php
/**
* This file includes the config file and necessary libraries for each page, it also makes the connection to the database.
*/
/***********************************
* CONFIGURATION
************************************/
// php5 stuff:
ini_set('zend.ze1_compatibility_mode', 'Off');
$defaultTimeZone = 'Canada/Pacific';
if (function_exists('date_default_timezone_set')) { // to avoid problems in php4
    date_default_timezone_set($defaultTimeZone);
}

sessionConfig(); // set up the session
//ob_start();
require_once("config.inc.php");
require_once('adodb5/adodb.inc.php');
//ob_end_clean();

if (1) {
    error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE & ~E_DEPRECATED);
    ini_set('display_errors', 'On');
} else {
    error_reporting(0);
}

global $configInfo;

/***********************************
* MAIN
************************************/
// set up database connection
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$db = ADONewConnection($configInfo["dbdriver"]); // eg. 'mysql' or 'postgres'
if ($configInfo["debug"]==true) $db->debug = true; 
else $db->debug=false;
//$db->debug = true; 
$db->Connect(
    $configInfo["host"],
    $configInfo["user"],
    $configInfo["pass"],
    $configInfo["dbname"]
);




?>
