<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

$url = $_GET['url'];

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once (ROOT  . DS . 'bootstrap.php');
