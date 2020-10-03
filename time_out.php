<?php

//sample timeout url file.

header("Content-Type: application/json");
// Save the M-PESA input stream.
$mpesaResponse = file_get_contents('php://input');

/******* log the response**********/
$logFile = "Timeout.txt";
// write the M-PESA Response to file
$log = fopen($logFile, "a");
fwrite($log, $mpesaResponse);
fclose($log);