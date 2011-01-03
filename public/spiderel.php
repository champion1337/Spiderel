<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "core.php";
include "ErrorClass.php";
include "ConfigClass.php";
include "RobotsClass.php";
include "HttpRequestClass.php";
include "QueueClass.php";
include "PageClass.php";
include "Pagerank.php";
include "mysql.php";
if ($_GET['action'] == "start") {
    spiderel::init();
	echo "done";
}
if ( $_GET['action'] == "testurl") {

    echo identify_url("../index.php","http://www.webs-it.com/","http://www.webs-it.com/prezentare/doc/lol.php"); 
}

function identify_url($url,$base_url,$current_url) {
    $path = str_replace($base_url,"/",$current_url);
    $url_dirs = explode("/",$url);
    $base_dirs = explode("/",$path);
    $pop = array_pop($base_dirs);
    if(!empty($pop)) {
        foreach($dir as $url_dirs) {
            if($dir == "..") {
                array_pop($base_dirs);
            }
            else {
                array_push($base_dirs,$dir);
            }
        }
        $path = implode("/",$base_dirs);
        $path = $base_url . "/" . $path;
    }
    else { echo "pop empty"; }
    return $path;
}
