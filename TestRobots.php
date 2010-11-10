<?php
include "RobotsClass.php";
include "HttpRequestClass.php";
$robots = new Robots("http://www.scenefz.net","firefox");
print_r($robots->rules);

