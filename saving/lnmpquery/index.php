<?php

require "../auth/access-token.php";

$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
  
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header
  
  
  $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => '174379',
    'Password' => 'MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMjAxMDA2MTYxMjU2',
    'Timestamp' => '20201006161256',
    'CheckoutRequestID' => 'ws_CO_061020201613436283'
  );
  
  $data_string = json_encode($curl_post_data);
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  
  $curl_response = curl_exec($curl);
  print_r($curl_response);
  
  //log response
$logFile = '../logs/lnmpQuery.txt';
$log = fopen($logFile,"a");
fwrite($log,$curl_response."\n");
fclose($log);

  echo $curl_response;