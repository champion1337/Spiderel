<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

set_time_limit( 600 );
date_timezone_set("Europe/Helsinki");
if(isset($_GET['url'])) {  $url = $_GET['url']; }

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once (ROOT  . DS . 'bootstrap.php');
