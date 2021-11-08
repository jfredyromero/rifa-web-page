<?php

include_once("../static/connection/connection.php");

$numTicket = $_POST['numTicket'];

$conn = mysqli_connect($host, $user, $pw, $db);
$sql = "SELECT numero_boleta FROM boletas WHERE numero_boleta = $numTicket";
$resultado = $conn->query($sql);

if ($resultado->num_rows) {
    $error = true;
} else {
    $error = false;
}

$dataAjax = [
    "error" => $error
]; 

die(json_encode($dataAjax));

?>