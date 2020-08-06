<?php


//Trevor local development
$configInfos["localhost"]["host"] = '127.0.0.1';
$configInfos["localhost"]["user"] = 'roombooking';
$configInfos["localhost"]["pass"] = 'rilinc';
$configInfos["localhost"]["dbdriver"] = 'mysqli';
$configInfos["localhost"]["dbname"] = 'roombooking';
$configInfos["localhost"]["peardir"] = '/usr/lib/php';
$configInfos["localhost"]["debug"] = false;
$configInfos["localhost"]["url_root"] = 'http://localhost';
$configInfos["localhost"]["file_root"] = '/Users/tjdavis/sfuvault/Sites/contracts';
$configInfos["localhost"]["vendor"] = '/Users/tjdavis/sfuvault/Sites/contracts/vendor';
$configInfos["localhost"]["templates"] = '/Users/tjdavis/sfuvault/Sites/contracts/rooms/templates';

$configInfos["localhost"]["host"] = 'vpr-db12.dc.sfu.ca';
$configInfos["localhost"]["user"] = 'trevormon';
$configInfos["localhost"]["pass"] = 'ilike!pasta&pizza33%';
$configInfos["localhost"]["dbdriver"] = 'mysqli';
$configInfos["localhost"]["dbname"] = 'roombooking';
$configInfos["localhost"]["peardir"] = '/usr/lib/php';
$configInfos["localhost"]["debug"] = true;
$configInfos["localhost"]["url_root"] = 'http://vpr-db13.sfu.ca';
$configInfos["localhost"]["file_root"] = '/var/www/html/rooms';
$configInfos["localhost"]["vendor"] = '/var/www/html/rooms/vendor';
$configInfos["localhost"]["templates"] = '/var/www/html/rooms/templates';
$configInfos["localhost"]["phpcas_path"] = '/var/www/html/rooms/vendor/jasig/phpcas';

$configInfos["contracts.local"]["host"] = 'localhost';
$configInfos["contracts.local"]["user"] = 'roombooking';
$configInfos["contracts.local"]["pass"] = 'rilinc';
$configInfos["contracts.local"]["dbdriver"] = 'mysqli';
$configInfos["contracts.local"]["dbname"] = 'roombooking';
$configInfos["contracts.local"]["debug"] = true;
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
$sessionConfig["sessionname"] = "mtroyalc_research";	// session name to use. Must contain at least one letter.
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

$sessionConfig["usertable"]["testuser1"] = "0d107d09f5bbe40cade3de5c71e9e9b7";
$sessionConfig["usertable"]["testuser2"] = "0d107d09f5bbe40cade3de5c71e9e9b7";
$sessionConfig["usertable"]["testuser3"] = "0d107d09f5bbe40cade3de5c71e9e9b7";
$sessionConfig["usertable"]["testuser4"] = "0d107d09f5bbe40cade3de5c71e9e9b7";
$sessionConfig["usertable"]["testuser5"] = "0d107d09f5bbe40cade3de5c71e9e9b7";
$sessionConfig["usertable"]["testuser6"] = "0d107d09f5bbe40cade3de5c71e9e9b7";
$sessionConfig["usertable"]["dean"] = "0d107d09f5bbe40cade3de5c71e9e9b7";
$sessionConfig["usertable"]["chair"] = "0d107d09f5bbe40cade3de5c71e9e9b7";


//  AUTH  DATABASE CONFIGURATION
$sessionConfig["dbtable"] = "users";                // table to use to check the user/pass
$sessionConfig["dbusernamefield"] = "username";     // field containing the username
$sessionConfig["dbpassfield"] = "password2";        // field containing the pasword (MD5 hash)
// NOTE: for security reasons all input username and password will be cleaned and will allow only the following characters
// for username: a-z A-Z 0-9 @ and _
// for password: a-z A-Z 0-9 ! @ # $ % ^ & * ( ) _ and " " (blank space)

// This is done to avoid SQL injection and other possible attacks

//  AUTH  LDAP CONFIGURATION
// ldap is externally configured in the mrclib.php file

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
            // 20090224 CSN is this really needed?
            /*
            if ($server == "localhost") {	// used on offline testing (localhost installs)
                $server2 = strtolower( gethostbyaddr (gethostbyname ($_SERVER["SERVER_NAME"])));
                //echo "[$server-$server2]";
                switch ($server2) {
                    case "localhost": //temp, maldito linux no me reconoce el hostname de mi lap
                    default:
                        $server="localhost";
                        break;	// hostname no reconocido
                }
            }
            */
if (isset($configInfos[$server])) {
    $configInfo = $configInfos[$server];
} else {
    $configInfo = $configInfos["localhost"];
}

// set up default settings
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
