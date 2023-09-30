<?php
/*
Todo :
- get chargily api key from db
- get post data from db
- check if response from chargily is correct ( checkout_url )
*/


$chargily_url = "http://epay.chargily.com.dz/api/invoice";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$chargily_url);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-Authorization: '.$_POST['chargily_api_key'],
    ]);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS,[
        'client' => $_POST['client'],
        'client_email' => $_POST['client_email'],
        'invoice_number' => $_POST['invoice_number'],
        'amount' => $_POST['amount'],
        'discount' => 0,
        'back_url' => $_POST['back_url'],
        'webhook_url' => $_POST['webhook_url'],
        'mode' => $_POST['paymentmethod'],
        'comment' => $_POST['comment']
    ]);

    // Receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLINFO_HEADER_OUT, true); // enable tracking

$headerSent = curl_getinfo($ch ); // request headers


$server_output = curl_exec($ch);

curl_close($ch);

$url = json_decode($server_output)->checkout_url;

header('Location: '.$url);

?>