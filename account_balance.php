<?php
//The Account Balance API requests for the account balance of a shortcode.
require "access_token.php";
$url = 'https://sandbox.safaricom.co.ke/mpesa/accountbalance/v1/query';//account balance url

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer '.$access_token)); //setting custom header

$curl_post_data = array(
    //Fill in the request parameters with valid values
    //'CommandID' => ' ',
    'Initiator' => 'testapi',//username used to authenticate the transaction
    'SecurityCredential' => 'V8sAKPlxqhT+1y52nkMwjJQu/fF/F5JR/Xg89gRyZos1ic8gi1osh9cfvBasxdRuWmwd/sZ5ADL51RMExYTi2f117pix41sbXXZpf8vY2nvFM3fxaF/4fD4Pdij9UGPMY0rhheYt5Heno+wBn31JxS5IeBfuxXywnn7uty3hVEdlt8WOHWW4lj3/QlFAQla+8ktaFBTPCxw4yhmyVmIqZb/3VxxBcZN1Jk13hXAvea3SrMQ7HnmEKskQp+UDDzFN1iUsKai34gMGHVIyFwQS43B4/R07M/E83ZoisS7UDWzyni44bRtF95srrr1Oa9dm54dW4l+orfMp7zlqF1GbAA==',//Base64 encoded string of the M-PESA shortcode
    'CommandID' => 'AccountBalance',//A unique command passed to the M-Pesa system.
    'PartyA' => '600130',//The shortcode of the organisation receiving the transaction.
    'IdentifierType' => '4',//Type of the organisation receiving the transaction.
    'Remarks' => 'Checking acc bal for today',//Comments that are sent along with the transaction.
    'QueueTimeOutURL' => 'http://jochebedscrib.org/victor/time_out.php',//The timeout end-point that receives a timeout message.
    'ResultURL' => 'http://jochebedscrib.org/victor/result.php'//The end-point that receives a successful transaction.
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

//log response
$logFile = 'accountBalance.txt';
$log = fopen($logFile,"a");
fwrite($log,$curl_response);
fclose($log);

//display response
echo $curl_response;
