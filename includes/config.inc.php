<?php


//Trevor local development
$configInfos["localhost"]["host"] = '127.0.0.1';
$configInfos["localhost"]["user"] = 'roombooking';
$configInfos["localhost"]["pass"] = 'rilinc';
$configInfos["localhost"]["dbdriver"] = 'mysqli';
$configInfos["localhost"]["dbname"] = 'roombooking';
$configInfos["localhost"]["peardir"] = '/usr/lib/php'; 
$configInfos["localhost"]["debug"] = false;
$configInfos["localhost"]["url_root"] = 'http://localhost/rooms';
$configInfos["localhost"]["file_root"] = '/Users/tjdavis/OneDrive - Simon Fraser University (1sfu)/Sites/rooms';
$configInfos["localhost"]["vendor"] = '/Users/tjdavis/OneDrive - Simon Fraser University (1sfu)/Sites/rooms/vendor';
$configInfos["localhost"]["templates"] = '/Users/tjdavis/OneDrive - Simon Fraser University (1sfu)/Sites/rooms/templates';
$configInfos["localhost"]["phpcas_path"] = '/Users/tjdavis/OneDrive - Simon Fraser University (1sfu)/Sites/rooms/vendor/jasig/phpcas';

$configInfos["vpr-db13.dc.sfu.ca"]["host"] = 'vpr-db13.dc.sfu.ca';
//$configInfos["vpr-db13.dc.sfu.ca"]["user"] = 'trevormon';
//$configInfos["vpr-db13.dc.sfu.ca"]["pass"] = 'ilike!pasta&pizza33%';
$configInfos["vpr-db13.dc.sfu.ca"]["user"] = 'roombooking';
$configInfos["vpr-db13.dc.sfu.ca"]["pass"] = 'rilincetc';
$configInfos["vpr-db13.dc.sfu.ca"]["dbdriver"] = 'mysqli';
$configInfos["vpr-db13.dc.sfu.ca"]["dbname"] = 'roombooking';
$configInfos["vpr-db13.dc.sfu.ca"]["peardir"] = '/usr/lib/php';
$configInfos["vpr-db13.dc.sfu.ca"]["debug"] = false;
$configInfos["vpr-db13.dc.sfu.ca"]["url_root"] = 'http://vpr-db13.dc.sfu.ca/rooms';
$configInfos["vpr-db13.dc.sfu.ca"]["file_root"] = '/var/www/html/rooms';
$configInfos["vpr-db13.dc.sfu.ca"]["vendor"] = '/var/www/html/rooms/vendor';
$configInfos["vpr-db13.dc.sfu.ca"]["templates"] = '/var/www/html/rooms/templates';
$configInfos["vpr-db13.dc.sfu.ca"]["phpcas_path"] = '/var/www/html/rooms/vendor/jasig/phpcas';

$configInfos["sp.dc.sfu.ca"]["host"] = 'sp.dc.sfu.ca';
//$configInfos["vpr-db13.dc.sfu.ca"]["user"] = 'trevormon';
//$configInfos["vpr-db13.dc.sfu.ca"]["pass"] = 'ilike!pasta&pizza33%';
$configInfos["sp.dc.sfu.ca"]["user"] = 'roombooking';
$configInfos["sp.dc.sfu.ca"]["pass"] = 'rilincetc';
$configInfos["sp.dc.sfu.ca"]["dbdriver"] = 'mysqli';
$configInfos["sp.dc.sfu.ca"]["dbname"] = 'roombooking';
$configInfos["sp.dc.sfu.ca"]["peardir"] = '/usr/lib/php';
$configInfos["sp.dc.sfu.ca"]["debug"] = false;
$configInfos["sp.dc.sfu.ca"]["url_root"] = 'https://sp.dc.sfu.ca/rooms';
$configInfos["sp.dc.sfu.ca"]["file_root"] = '/var/www/html/rooms';
$configInfos["sp.dc.sfu.ca"]["vendor"] = '/var/www/html/rooms/vendor';
$configInfos["sp.dc.sfu.ca"]["templates"] = '/var/www/html/rooms/templates';
$configInfos["sp.dc.sfu.ca"]["phpcas_path"] = '/var/www/html/rooms/vendor/jasig/phpcas';
$configInfos["sp.dc.sfu.ca"]["serverport"] = '443';
$configInfos["sp.dc.sfu.ca"]["https"] = 'https';

//Digital Ocean
$configInfos["rooms.sfuro.ca"]["host"] = '127.0.0.1';
//$configInfos["sp.dc.sfu.ca"]["user"] = 'trevormon';
//$configInfos["sp.dc.sfu.ca"]["pass"] = 'ilike!pasta&pizza33%';
$configInfos["rooms.sfuro.ca"]["user"] = 'roombooking';
$configInfos["rooms.sfuro.ca"]["pass"] = 'rilincetc';
$configInfos["rooms.sfuro.ca"]["dbdriver"] = 'mysqli';
$configInfos["rooms.sfuro.ca"]["dbname"] = 'roombooking';
$configInfos["rooms.sfuro.ca"]["peardir"] = '/usr/lib/php';
$configInfos["rooms.sfuro.ca"]["debug"] = false;
$configInfos["rooms.sfuro.ca"]["url_root"] = 'https://rooms.sfuro.ca/';
$configInfos["rooms.sfuro.ca"]["file_root"] = '/var/www/rooms';
$configInfos["rooms.sfuro.ca"]["vendor"] = '/var/www/rooms/vendor';
$configInfos["rooms.sfuro.ca"]["templates"] = '/var/www/rooms/templates';
$configInfos["rooms.sfuro.ca"]["phpcas_path"] = '/var/www/rooms/vendor/jasig/phpcas';

$cas_host = 'cas.sfu.ca';

// Context of the CAS Server
$cas_context = '/cas';

// Port of your CAS server. Normally for a https server it's 443
$cas_port = 443;

// Path to the ca chain that issued the cas server certificate
$cas_server_ca_cert_path = '/path/to/cachain.pem';

$configInfos["contracts.local"]["host"] = 'localhost';
$configInfos["contracts.local"]["user"] = 'roombooking';
$configInfos["contracts.local"]["pass"] = 'rilinc';
$configInfos["contracts.local"]["dbdriver"] = 'mysqli';
$configInfos["contracts.local"]["dbname"] = 'roombooking';
$configInfos["contracts.local"]["debug"] = false;
$configInfos["contracts.local"]["url_root"] = 'http://contracts.local';
$configInfos["contracts.local"]["file_root"] = '/Users/tjdavis/sfuvault/Sites/contracts';
$configInfos["contracts.local"]["vendor"] = '/Users/tjdavis/sfuvault/Sites/contracts/vendor';


$configInfos["ovpr-www-prod-is-sfu.ca"]["host"] = 'localhost';
$configInfos["ovpr-www-prod-is-sfu.ca"]["user"] = 'sfurooms';
$configInfos["ovpr-www-prod-is-sfu.ca"]["pass"] = 'rilinc';
$configInfos["ovpr-www-prod-is-sfu.ca"]["dbdriver"] = 'mysqli';
$configInfos["ovpr-www-prod-is-sfu.ca"]["dbname"] = 'sfurooms';
$configInfos["ovpr-www-prod-is-sfu.ca"]["peardir"] = '/usr/lib/php';
$configInfos["ovpr-www-prod-is-sfu.ca"]["debug"] = true;

// Global variable $configinfo will be filled with correct info depending on the server name

//  AUTH  SESSION CONFIGURATION
$sessionConfig["sessionname"] = "sfuc_research";	// session name to use. Must contain at least one letter.
$sessionConfig["sessionexpire"] = 18000; 				// 1800 secs = 30mins

//  AUTH  AVAILABLE METHODS
// You can select the available Authorization methods to use in this comma separated global variable
// Available methods:
//   ldap 		: use the function mrclib_ldapauth($uid, $pass) defined in the mrclib.php library
//   usertable 	: use the above defined array containing the username md5(password) pairs
//   database   : use a function to connect to a database table to validate username md5(password)
// DATABASE is here as a PLACE HOLDER ONLY, Its CURRENTLY NOT IMPLEMENTED
$sessionConfig["authmethod"] = "database,ldap,usertable";

//  AUTH  USER TABLE CONFIGURATION
// currently the usage of database for username/password is not enabled
// will temporarilly use this table. On this table the passwords must be MD5
// To set your password you can go to http://www.onlinefunctions.com/
// DONT enter there one of your real passwords.

$sessionConfig["usertable"]["tdavis"] = "827ccb0eea8a706c4c34a16891f84e7b"; //"c3f3c0b98db003270f05b83495c5b765";



// Rows per page for paginated listing
$rowsPerPage=20;




if (strpos($_SERVER['HTTP_HOST'],':') != 0) {
    list($server,$port)=explode(":",$_SERVER['HTTP_HOST']);
} else {
    $server = $_SERVER['HTTP_HOST'];
    $port = 80;
}
if (strstr($server,"www.")) {
    $server = substr($server,4);
}
            
if (isset($configInfos[$server])) {
    $configInfo = $configInfos[$server];
} else {
    $configInfo = $configInfos["localhost"];
}

// set up default settings

if(isset($configInfo['serverport'])) $_SERVER['SERVER_PORT']=$configInfo['serverport'];
if(isset($configInfo['https'])) $_SERVER['HTTPS']='on';

if(!isset($configInfo["debug"])) {
    $configInfo["debug"] .= false;
}
if(isset($configInfo['authmethod'])) {
    $sessionConfig["authmethod"] = $configInfo['authmethod'];
} else {
    $sessionConfig["authmethod"] = "database,ldap,usertable";
}

if ($configInfo["peardir"] != "") {
    $configInfo["peardir"] .= "/";
}
if(!isset($configInfo["email_db_options"])) {
    $configInfo["email_db_options"] =  array(
        'type'        => 'db',
        'dsn'         => 'mysql://ors:rilinc@orsadmin-prep.sm.mtroyal.ca/research',
        'mail_table'  => 'mail_queue',
    );
}
if(!isset($configInfo["email_send_now"])) {
    $configInfo["email_send_now"] =  false;
}
if(!isset($configInfo["email_options"])) {
    $configInfo['email_options'] = array(
        'driver'   => 'smtp',
        'host'     => 'localhost',
        'port'     => 25,
        'auth'     => false,
        'username' => '',
        'password' => '',
    );
}
if(!isset($configInfo["debug_email"])) $configInfo['debug_email']=false;


define('MRJQUERYPATH','js/jquery-1.3.2.min.js'); // set up jquery path
define('MRCDEBUG',$configInfo["debug"]); // set up debug mode
define('MRCAJAXLOGIN',true); // set up ajax login

$iso8601 = "Y-m-d G:i";
$iso8601_day = "Y-m-d";
$niceday = "M. j, Y";


?>
