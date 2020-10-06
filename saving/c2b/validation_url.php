<?php

//sample of validation url file.

// Save the M-PESA input stream.
$mpesaResponse = file_get_contents('php://input');
// log the response
$logFile = "../logs/validationResponse.txt";
// will be used when we want to save the response to database for our reference
// $jsonMpesaResponse = json_decode($mpesaResponse, true);
// write the M-PESA Response to file
$log = fopen($logFile, "a");
fwrite($log, $mpesaResponse);
fclose($log);