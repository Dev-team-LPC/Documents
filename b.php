<?php

$path_init = getcwd()."/docs/";
$path_init = str_replace("\\", "\/", $path_init);

$str=rand(); 
$result = md5($str); 

$path = $path_init.$result;

echo $path;

?>
