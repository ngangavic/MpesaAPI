<?php
$callBackResponse = file_get_contents('php://input');

$logFile = 'CallBackResponse.txt';
$log = fopen($logFile,"a");
fwrite($log,$callBackResponse);
fclose($log);
