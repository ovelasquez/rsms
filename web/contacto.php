<?php

$url = "http://200.110.137.82:81/wss/tcl/confirm.php"; // set up data to send to the form 

$data= '{"credential":{"user": "trabajando","pass": "trabajando"},"contact":{"123456":{"msisdn":"56933333","content":"Ejemplo de contacto 3"}}}';
$data1 = json_encode($data);
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
$resp= curl_exec($ch);
curl_close($ch);
echo $resp;



?>