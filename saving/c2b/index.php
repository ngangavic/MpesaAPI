<?php

require "../auth/access-token.php";

require "../connection.php";

$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';
  
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header


$curl_post_data = array(
        //Fill in the request parameters with valid values
       'ShortCode' => '600130',
       'CommandID' => 'CustomerPayBillOnline',
       'Amount' => '10000',
       'Msisdn' => '254700352822',
       'BillRefNumber' => '00000'
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

$decode=json_decode($curl_response);

$ConversationID=$decode->ConversationID;
$OriginatorCoversationID=$decode->OriginatorCoversationID;
$ResponseDescription=$decode->ResponseDescription;

/******* log the response**********/
$logFile = "../logs/c2bResponse.txt";
// write the M-PESA Response to file
$log = fopen($logFile, "a");
fwrite($log, $curl_response);
fclose($log);

$stmt=$connection->prepare("INSERT INTO tbl_c2b(ConversationID,OriginatorCoversationID,ResponseDescription)VALUES(?,?,?)");
$stmt->bind_param("sss",$ConversationID,$OriginatorCoversationID,$ResponseDescription);
$stmt->execute();
$stmt->close();
$connection->close();
echo 'Saved';