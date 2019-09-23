<?php
//This API enables Business to Business (B2B) transactions between
//a business and another business. Use of this API requires a valid
//and verified B2B M-Pesa short code for the business initiating the
//transaction and the both businesses involved in the transaction.

require "access_token.php";//acces token

$url = 'https://sandbox.safaricom.co.ke/mpesa/b2b/v1/paymentrequest';//b2b url;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer '.$access_token)); //setting custom header

$curl_post_data = array(
    //Fill in the request parameters with valid values
    'Initiator' => 'testapi',//This is the credential/username used to authenticate the transaction request.
    'SecurityCredential' => 'V8sAKPlxqhT+1y52nkMwjJQu/fF/F5JR/Xg89gRyZos1ic8gi1osh9cfvBasxdRuWmwd/sZ5ADL51RMExYTi2f117pix41sbXXZpf8vY2nvFM3fxaF/4fD4Pdij9UGPMY0rhheYt5Heno+wBn31JxS5IeBfuxXywnn7uty3hVEdlt8WOHWW4lj3/QlFAQla+8ktaFBTPCxw4yhmyVmIqZb/3VxxBcZN1Jk13hXAvea3SrMQ7HnmEKskQp+UDDzFN1iUsKai34gMGHVIyFwQS43B4/R07M/E83ZoisS7UDWzyni44bRtF95srrr1Oa9dm54dW4l+orfMp7zlqF1GbAA==',//Base64 encoded string of the B2B short code and password
    'CommandID' => 'BusinessPayBill',//	Unique command for each transaction type
    'SenderIdentifierType' => '4',//Type of organization sending the transaction.
    'RecieverIdentifierType' => '4',//Type of organization receiving the funds being transacted.
    'Amount' => '10000',//amount being transacted
    'PartyA' => '600130',//	Organization’s short code initiating the transaction.
    'PartyB' => '600000',//Organization’s short code receiving the funds being transacted.
    'AccountReference' => 'KAR400T',//Account Reference mandatory for “BusinessPaybill” CommandID.
    'Remarks' => 'Payment of car hire fee',//	Comments that are sent along with the transaction.
    'QueueTimeOutURL' => 'http://jochebedscrib.org/victor/time_out.php',//The path that stores information of time out transactions.
    'ResultURL' => 'http://jochebedscrib.org/victor/result.php'//The path that receives logs from M-Pesa
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

//log
$logFile = 'logs/b2b.txt';
$log = fopen($logFile,"a");
fwrite($log,$curl_response);
fclose($log);

//display
echo $curl_response;
