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
    'Initiator' => 'testapi',//This is the credential/username used to authenticate the transaction request.
    'SecurityCredential' => 'V8sAKPlxqhT+1y52nkMwjJQu/fF/F5JR/Xg89gRyZos1ic8gi1osh9cfvBasxdRuWmwd/sZ5ADL51RMExYTi2f117pix41sbXXZpf8vY2nvFM3fxaF/4fD4Pdij9UGPMY0rhheYt5Heno+wBn31JxS5IeBfuxXywnn7uty3hVEdlt8WOHWW4lj3/QlFAQla+8ktaFBTPCxw4yhmyVmIqZb/3VxxBcZN1Jk13hXAvea3SrMQ7HnmEKskQp+UDDzFN1iUsKai34gMGHVIyFwQS43B4/R07M/E83ZoisS7UDWzyni44bRtF95srrr1Oa9dm54dW4l+orfMp7zlqF1GbAA==',//Base64 encoded string of the M-Pesa short code and password,
    'CommandID' => 'TransactionReversal',//Unique command for each transaction type,
    'TransactionID' => ' ',//Organization Receiving the funds.
    'Amount' => ' ',
    'ReceiverParty' => ' ',
    'RecieverIdentifierType' => '4',//Type of organization receiving the transaction.
    'ResultURL' => 'http://jochebedscrib.org/victor/result.php',//The path that stores information of transaction.
    'QueueTimeOutURL' => 'http://jochebedscrib.org/victor/time_out.php',//The path that stores information of time out transaction.
    'Remarks' => 'Reversal',//Comments that are sent along with the transaction.
    //'Occasion' => ' '//optional
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

echo $curl_response;
