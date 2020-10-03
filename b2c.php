<?php
//This API enables Business to Customer (B2C) transactions
//between a company and customers who are the end-users of
//its products or services. Use of this API requires a valid
//and verified B2C M-Pesa Short code.

require "access_token.php";//access token

$url = 'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';//url b2c

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer '.$access_token)); //setting custom header


$curl_post_data = array(
    //Fill in the request parameters with valid values
    'InitiatorName' => 'testapi',//This is the credential/username used to authenticate the transaction request.
    'SecurityCredential' => 'V8sAKPlxqhT+1y52nkMwjJQu/fF/F5JR/Xg89gRyZos1ic8gi1osh9cfvBasxdRuWmwd/sZ5ADL51RMExYTi2f117pix41sbXXZpf8vY2nvFM3fxaF/4fD4Pdij9UGPMY0rhheYt5Heno+wBn31JxS5IeBfuxXywnn7uty3hVEdlt8WOHWW4lj3/QlFAQla+8ktaFBTPCxw4yhmyVmIqZb/3VxxBcZN1Jk13hXAvea3SrMQ7HnmEKskQp+UDDzFN1iUsKai34gMGHVIyFwQS43B4/R07M/E83ZoisS7UDWzyni44bRtF95srrr1Oa9dm54dW4l+orfMp7zlqF1GbAA==',//Base64 encoded string of the B2C short code and password,
    'CommandID' => 'SalaryPayment',//Unique command for each transaction type
    'Amount' => '3000',//The amount being transacted
    'PartyA' => '600130',//Organization’s shortcode initiating the transaction.
    'PartyB' => '254708374149',//Phone number receiving the transaction
    'Remarks' => 'September salary',//Comments that are sent along with the transaction.
    'QueueTimeOutURL' => 'http://jochebedscrib.org/victor/time_out.php',//The timeout end-point that receives a timeout response.
    'ResultURL' => 'http://jochebedscrib.org/victor/result.php',//The end-point that receives the response of the transaction
   // 'Occasion' => ' '//optional
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

//log
$logFile = 'logs/b2c.txt';
$log = fopen($logFile,"a");
fwrite($log,$curl_response);
fclose($log);

//display
echo $curl_response;
