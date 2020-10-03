<?php 

date_default_timezone_set('Africa/Nairobi');

require "secrets.php";

$headers=['Content-Type:application/json; charset=utf8'];
$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$curl = curl_init($url);
curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

curl_setopt($curl,CURLOPT_HEADER,false);

curl_setopt($curl,CURLOPT_USERPWD,$YOUR_APP_CONSUMER_KEY.':'.$YOUR_APP_CONSUMER_SECRET);
$result = curl_exec($curl);
$status = curl_getinfo($curl,CURLINFO_HTTP_CODE);
$result = json_decode($result);
$access_token = $result->access_token;

//log response
$logFile = '../logs/accessToken.txt';
$log = fopen($logFile,"a");
fwrite($log,$access_token.' '.date("F j, Y, g:i a")."\n");
fclose($log);

echo 'The access token is: '.$access_token.'</br> Status: '.$status;