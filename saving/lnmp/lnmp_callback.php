<?php

require "../connection.php";

$callBackResponse = file_get_contents('php://input');

$decode=json_decode($callBackResponse);

$resultCode=$decode->Body->stkCallback->ResultCode;
$merchantRequestID=$decode->Body->stkCallback->MerchantRequestID;
$checkoutRequestID=$decode->Body->stkCallback->CheckoutRequestID;
$resultDesc=$decode->Body->stkCallback->ResultDesc;

if($resultCode==0){

    $amount=$decode->Body->CallbackMetadata->Item[0]->Value;
    $mpesaReceiptNumber=$decode->Body->CallbackMetadata->Item[1]->Value;
    $balance=$decode->Body->CallbackMetadata->Item[2]->Value;
    $transactionDate=$decode->Body->CallbackMetadata->Item[3]->Value;
    $phoneNumber=$decode->Body->CallbackMetadata->Item[4]->Value;

    $toSave=$amount."\n".$mpesaReceiptNumber."\n".$balance."\n".$transactionDate."\n".$phoneNumber;

    $logSFile = '../logs/lnmpCallBackResponseSuccess.txt';
$logS = fopen($logSFile,"a");
fwrite($logS,$toSave."\n");
fclose($logS);

    $stmt=$connection->prepare("INSERT INTO tbl_lnmp_callback_success(MerchantRequestID, CheckoutRequestID, ResultCode, ResultDesc, Amount, MpesaReceiptNumber, Balance, TransactionDate, PhoneNumber) VALUES (s,s,s,s,s,s,s,s,s)");
    $stmt->bind_param("ssssssss",$merchantRequestID,$checkoutRequestID,$resultCode,$resultDesc,$amount,$mpesaReceiptNumber,$balance,$transactionDate,$phoneNumber);
    $stmt->execute();
    $stmt->close();
    $connection->close();


}else{

    $logFileE = '../logs/lnmpCallBackResponseError.txt';
$logE = fopen($logFileE,"a");
fwrite($log,"ERROR"."\n");
fclose($log);

    $stmt=$connection->prepare("INSERT INTO tbl_lnmp_callback_error(MerchantRequestID, CheckoutRequestID, ResultCode, ResultDesc) VALUES (s,s,s,s)");
    $stmt->bind_param("ssss",$merchantRequestID,$checkoutRequestID,$resultCode,$resultDesc);
    $stmt->execute();
    $stmt->close();
    $connection->close();

}


$logFile = '../logs/lnmpCallBackResponse.txt';
$log = fopen($logFile,"a");
fwrite($log,$callBackResponse."\n");
fclose($log);