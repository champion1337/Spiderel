<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

function identify_url($url,$base_url,$current_url) {
    $path = str_replace($base_url,"",$current_url);
    $url_dirs = explode("/",$url);
    $base_dirs = explode("/",$path);
    $pop = array_pop($base_dirs);
    if($base_dirs[0] != $path) {
        foreach($url_dirs as $dir) {
            if($dir == "..") {
                array_pop($base_dirs);
            }
            else {
                array_push($base_dirs,$dir);
            }
        }
        $path = implode("/",$base_dirs);
        print_r($base_dirs);
        $path = $base_url . $path;
    }
    else { return $base_url . $url; }
    return $path;
}
echo identify_url("mix/a/2/index.php","http://www.webs-it.com/","http://www.webs-it.com/asdasdg/agadg/"); 
