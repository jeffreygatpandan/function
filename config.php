<?php
// start the session
session_start();


//essenzea
/*define("DBHOST","localhost");
define("DBUSER","paonannual2012"); 
define("DBPASS","mgd123");


define("DBDEFINE","db_paoannual2012");  */




define("DBHOST","localhost");
define("DBUSER","root"); 
define("DBPASS","");


//magcon.net

/*define("DBHOST","localhost");
define("DBUSER","vsc2013"); 
define("DBPASS","mgd123");*/


define("DBDEFINE","db_vsc"); 
define("DBPREFIX","tbl_"); 


$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];

$webRoot  = str_replace(array($docRoot, 'library/config.php'), '', $thisFile);
$srvRoot  = str_replace('library/config.php', '', $thisFile);

define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);

?>
