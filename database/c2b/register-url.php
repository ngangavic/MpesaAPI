<?php

require "../auth/access-token.php";

$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
  
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header


$curl_post_data = array(
  //Fill in the request parameters with valid values
  'ShortCode' => '601523',
  'ResponseType' => 'Registered',
  'ConfirmationURL' => 'https://e0a93b8d69c7.ngrok.io/MpesaAPI/database/c2b/confirmation.php',
  'ValidationURL' => 'https://e0a93b8d69c7.ngrok.io/MpesaAPI/database/c2b/validation_url.php'
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

//log response
$logFile = '../logs/registerUrl.txt';
$log = fopen($logFile,"a");
fwrite($log,$curl_response."\n");
fclose($log);

echo $curl_response;