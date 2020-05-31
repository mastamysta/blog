<?php

//find todays date
date_default_timezone_set("GMT");
$secs = time();

$bit = array(
    'y' => $secs / 31556926 % 12,
    'w' => $secs / 604800 % 52,
    'd' => $secs / 86400 % 7,
    'h' => $secs / 3600 % 24,
    'm' => $secs / 60 % 60,
    's' => $secs % 60
    );

return $bit;


?>