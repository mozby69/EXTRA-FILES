<?php 

$today = date('Y-m-d');
$filename = 'text-file-' . $today . '.txt';

$file = fopen($filename, 'w');
fwrite($file, "Log for $today...");
fclose($file);

?>