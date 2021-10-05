<?php
    // Conexion a la base de datos
    include_once("../connection/connection.php");
    $connection = mysqli_connect($host, $user, $pw, $db);
    mysqli_set_charset($connection,"utf8");
    // Captura de datos
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "POST"){
        if($_POST['state_pol']==4){
            $ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
            $merchant_id = "508029";
            $referenceCode = $_POST['referenceCode'];
            $firma = $_POST['sign'];
            // $comprobacion_firma = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
            
                $numero_boleta = $_POST['extra1'];
                $comprador_ip = $_POST['ip'];
                $comprador_nombre = $_POST['nickname_buyer'];
                $comprador_cedula = $_POST['extra3'];
                $comprador_celular = $_POST['phone'];
                $comprador_correo = $_POST['email_buyer'];
                $referencia_venta = $_POST['reference_pol'];
                $codigo_instagram = $_POST['extra2'];
                $fecha = $_POST['date'];
                $query = "INSERT INTO boleta (numero_boleta, comprador_ip, comprador_nombre, comprador_cedula, comprador_celular, comprador_correo, referencia_venta) VALUES ('$numero_boleta', '$comprador_ip', '$comprador_nombre', '$comprador_cedula', '$comprador_celular', '$comprador_correo', '$referencia_venta');";
                $result = mysqli_query($connection, $query);
                // header('Location: http://127.0.0.1/rifa-web-page/prueba.php?nombre='.$comprador_nombre.'&cedula='.$comprador_cedula.'&celular='.$comprador_celular);
                   
        }  
    }

    // Tarjeta de credito
    // 4889135968287203
    // 03/2025
    // 802
?>

