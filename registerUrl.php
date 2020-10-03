<?php
//The C2B Register URL API registers the 3rd party’s
//confirmation and validation URLs to M-Pesa

//get the access token
require "access_token.php";

//register the 3rd party urls.
$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header


$curl_post_data = array(
    'ShortCode' => '601523',
    'ResponseType' => 'Confirmed',
    'ConfirmationURL' => 'http://jochebedscrib.org/victor/confirmation_url.php',
    'ValidationURL' => 'http://jochebedscrib.org/victor/validation.php'
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

echo "Register URL: ".$curl_response;
?>