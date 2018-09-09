<?php
 ini_set('display_errors','on');
 error_reporting(E_ALL);


 include 'Cpanal/connect.php';

$siteroot = 'include/templets'; //the site of root by templets
$lang     = 'include/languge'; //lang directry
$func     = 'include/functions';   
$header   =	'layout/css'; // the site by file css
$footer   = 'layout/js';// the site by file JS



//include the important file
 include "$func/function.php";
include "$lang/eng.php";
include "$siteroot/header.php";



?>