<?php

$text = "aaa&#8211;";
echo html_entity_decode($text) . "<br>";
echo html_entity_decode($text, ENT_QUOTES, "UTF-8") . "<br>";
echo html_entity_decode($text, ENT_NOQUOTES, "UTF-8") . "br";

