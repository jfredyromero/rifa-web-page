<?php
// Envío de SMS
// Codigo para pedir el token
$data = array("account" => "00486340924", "password" => "Kaliel0830");
$data_string = json_encode($data);
$ch = curl_init('https://api.cellvoz.co/v2/auth/login');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json')
);
$result = curl_exec($ch);
$data = json_decode($result);
$token = $data->token;

// Envío de SMS
//Codigo para enviar el mensaje
$data = array("number" => "57".$comprador_celular, "message" => "La compra de su membresía en ganatucarro.com ha sido exitosa con el numero " .$boleta.". Usted puede visualizar su boleta en: ".$link." Suerte!", "type" => "1");
$data_string = json_encode($data);
$ch = curl_init('https://api.cellvoz.co/v2/sms/single');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$token,
    'api-key: b4403cab3d7927db109ff943627964623debf01f')
);
 ?>