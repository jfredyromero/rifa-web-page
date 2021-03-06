<?php
// Variables del ambiente
include_once("../static/variables/variables.php");
// Conexion a la base de datos
include_once("../static/connection/connection.php");
if (file_exists("../static/php/phpqrcode/qrlib.php")){
    require "../static/php/phpqrcode/qrlib.php";
}
$mysqli = new mysqli($host, $user, $pw, $db);
if ($mysqli->connect_error) {
    exit('Could not connect');
}
date_default_timezone_set('America/Bogota');
$fechaActual = date("Y-m-d H:i:s");
$nuevaFecha = date("Y-m-d H:i:s", strtotime($fechaActual."- 1 days"));
$sql = "SELECT * FROM boletas WHERE fecha_compra >= '$nuevaFecha'";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $boleta, $comprador_ip, $comprador_nombre, $comprador_cedula, $comprador_celular, $comprador_correo, $referencia_pago, $referencia_venta, $id_transaccion, $revancha, $codigo_referido, $fecha_compra);
$registros = [];
while ($stmt -> fetch()) { 
    $registro = array(
        "id" => $id,
        "boleta" => $boleta,
        "comprador_ip" => $comprador_ip,
        "comprador_nombre" => $comprador_nombre,
        "comprador_cedula" => $comprador_cedula,
        "comprador_celular" => $comprador_celular,
        "comprador_correo" => $comprador_correo,
        "referencia_pago" => $referencia_pago,
        "referencia_venta" => $referencia_venta,
        "id_transaccion" => $id_transaccion,
        "revancha" => $revancha,
        "codigo_referido" => $codigo_referido,
        "fecha_compra" => $fecha_compra
    );
    $registros[] = $registro;
}
$stmt->close();

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

foreach ($registros as $registro) {
    // Acortador de link
    $link = $dominio."?referencia_pago=".urlencode($registro["referencia_venta"])."&comprador_nombre=".urlencode($registro["comprador_nombre"])."&comprador_cedula=".urlencode($registro["comprador_cedula"])."&numero_boleta=".urlencode($registro["boleta"]);
    $cutly_link = urlencode($link);
    $json = file_get_contents("https://cutt.ly/api/api.php?key=6528f6db6cc1e216fe5e5550190b38eeba522&short=$cutly_link");
    $data = array(json_decode($json));
    $respuesta = (array)$data[0];
    $url = (array)$respuesta["url"];
    $shortLink = $url["shortLink"];
    // Envío de SMS
    // Codigo para enviar el mensaje
    $mensajeSMS = "Hola ".$registro["comprador_nombre"].". Usted tiene la membresía de gana tu carro: " .$registro["boleta"]. ", que puede consultar en: ".$shortLink;
    echo $mensajeSMS."<br>";
    $data = array("number" => "57".$registro["comprador_celular"], "message" => $mensajeSMS, "type" => "1");
    $data_string = json_encode($data);
    $ch = curl_init('https://api.cellvoz.co/v2/sms/single');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$token,
        'api-key: 08cf6bb121574a9e24cd041cf2c39832cfe93cc1')
    );
    $result = curl_exec($ch);
    sleep(10);
}
?>