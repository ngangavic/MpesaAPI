<?php
//Reverses a B2B, B2C or C2B M-Pesa transaction.
require "access_token.php"; //reversal request url
$url = 'https://sandbox.safaricom.co.ke/mpesa/reversal/v1/request';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer '.$access_token)); //setting custom header


$curl_post_data = array(
    //Fill in the request parameters with valid values
   // 'CommandID' => ' ',
    'Initiator' => ' ',//This is the credential/username used to authenticate the transaction request.
    'SecurityCredential' => ' ',//Base64 encoded string of the M-Pesa short code and password,
    'CommandID' => 'TransactionReversal',//Unique command for each transaction type,
    'TransactionID' => ' ',//Organization Receiving the funds.
    'Amount' => ' ',
    'ReceiverParty' => ' ',
    'RecieverIdentifierType' => '4',//Type of organization receiving the transaction.
    'ResultURL' => 'https://ip_address:port/result_url',//The path that stores information of transaction.
    'QueueTimeOutURL' => 'https://ip_address:port/timeout_url',//The path that stores information of time out transaction.
    'Remarks' => ' ',//Comments that are sent along with the transaction.
    //'Occasion' => ' '//optional
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

echo $curl_response;
