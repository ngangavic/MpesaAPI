<?php
header("Content-Type: application/json");
$response = '{ "ResultCode": 0, "ResultDesc": "Confirmation Received Successfully" }';
// Save the M-PESA input stream.
$mpesaResponse = file_get_contents('php://input');

/******* log the response**********/
$logFile = "../logs/confirmationResponse.txt";
// write the M-PESA Response to file
$log = fopen($logFile, "a");
fwrite($log, $mpesaResponse);
fclose($log);

echo "Confirmation Response: ".$mpesaResponse;