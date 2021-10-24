<?php

    $extra1 = $_POST['extra1'];
    
    // Conexion a la base de datos
    include_once("../../../static/connection/connection.php");
    $conn = mysqli_connect($host, $user, $pw, $db);
    $sql = "SELECT numero_boleta FROM boletas WHERE numero_boleta = $extra1";
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