<?php

require "../auth/access-token.php";

require "../connection.php";

 $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

 $businessShortCode='174379';//shortcode
$passKey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';//passkey
$timestamp=date("YmdGis");//timestamp
$password=base64_encode($businessShortCode.$passKey.$timestamp);//password encoded Base64
  
 $curl = curl_init();
 curl_setopt($curl, CURLOPT_URL, $url);
 curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header
 
 $curl_post_data = array(
   //Fill in the request parameters with valid values
   'BusinessShortCode' => $businessShortCode,
   'Password' => $password,
   'Timestamp' => $timestamp,
   'TransactionType' => 'CustomerPayBillOnline',
   'Amount' => '1',
   'PartyA' => '254700352822',
   'PartyB' => $businessShortCode,
   'PhoneNumber' => '254700352822',
   'CallBackURL' => 'http://f95844a61e56.ngrok.io/PaymentAPI/saving/lnmp/lnmp_callback.php',
   'AccountReference' => 'Vic0001',
   'TransactionDesc' => 'Order Vic0001 payment'
 );
 
 $data_string = json_encode($curl_post_data);
 
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($curl, CURLOPT_POST, true);
 curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
 
 $curl_response = curl_exec($curl);
//  print_r($curl_response);

$decode=json_decode($curl_response);

if(array_key_exists("errorCode",$decode)){
  $requestId=$decode->requestId;
  $errorCode=$decode->errorCode;
  $errorMessage=$decode->errorMessage;

$stmt=$connection->prepare("INSERT INTO tbl_lnmp_error(requestId,errorCode,errorMessage)VALUES(?,?,?)");
$stmt->bind_param("sss",$requestId,$errorCode,$errorMessage);
$stmt->execute();
$stmt->close();
$connection->close();

echo 'Error';
}else{
  $merchantRequestID=$decode->MerchantRequestID;
 $checkoutRequestID=$decode->CheckoutRequestID;
 $responseCode=$decode->ResponseCode;
 $responseDescription=$decode->ResponseDescription;
 $customerMessage=$decode->CustomerMessage;

 $stmt=$connection->prepare("INSERT INTO tbl_lnmp_success(merchantRequestID,checkoutRequestID,responseCode,responseDescription,customerMessage)VALUES(?,?,?,?,?)");
 $stmt->bind_param("sssss",$merchantRequestID,$checkoutRequestID,$responseCode,$responseDescription,$customerMessage);
 $stmt->execute();
 $stmt->close();
 $connection->close();

echo 'Success';
}

 //log response
$logFile = '../logs/lnmpResponse.txt';
$log = fopen($logFile,"a");
fwrite($log,$curl_response."\n");
fclose($log);
 
//  echo $curl_response;