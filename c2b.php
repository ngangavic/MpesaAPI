<?php
//This API enables Paybill and Buy Goods merchants to integrate
//to M-Pesa and receive real time payments notifications.
require  "access_token.php"; //access token

$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate'; //c2c url

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer '.$access_token)); //setting custom header

$curl_post_data = array(
    //Fill in the request parameters with valid values
    'ShortCode' => '600130',
    'CommandID' => 'CustomerPayBillOnline',
    'Amount' => '100',//amount
    'Msisdn' => '254708374149',//phone number
    'BillRefNumber' => 'Test Simulation'//unique reference code for the transaction
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

/******* log the response**********/
$logFile = "c2b.txt";
// write the M-PESA Response to file
$log = fopen($logFile, "a");
fwrite($log, $curl_response);
fclose($log);

//display the response
echo $curl_response;