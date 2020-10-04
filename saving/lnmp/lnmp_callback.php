<?php
$callBackResponse = file_get_contents('php://input');

$logFile = '../logs/lnmpCallBackResponse.txt';
$log = fopen($logFile,"a");
fwrite($log,$callBackResponse."\n");
fclose($log);