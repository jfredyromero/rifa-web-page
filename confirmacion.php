<?php
    // Conexion a la base de datos
    include_once("connection.php");
    $connection = mysqli_connect($host, $user, $pw, $db);
    mysqli_set_charset($connection, "utf8");
    // Captura de datos
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "POST"){
        $transactionState = $_POST['state_pol'];
        if($transactionState==4){
            $ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
            $merchant_id = "508029";
            $referenceCode = $_POST['reference_sale'];
            $value = $_POST['value'];
            $list_value = explode(".", $value);
            if($list_value[1]=="00"){
                $new_value = $list_value[0].".0";
            }else{
                $new_value = $value;
            }
            $currency = $_POST['currency'];
            $firma = $_POST['sign'];
            $firmacreada = md5("$ApiKey~$merchant_id~$referenceCode~$new_value~$currency~$transactionState");
            // Confirmación de firma
            if (strtoupper($firma) == strtoupper($firmacreada)) {
                $numero_boleta = $_POST['extra1'];
                $comprador_ip = $_POST['ip'];
                $comprador_nombre = $_POST['cc_holder'];
                $comprador_cedula = $_POST['extra2'];
                $comprador_celular = $_POST['phone'];
                $comprador_correo = $_POST['email_buyer'];
                $referencia_pago = $_POST['reference_pol'];
                $referencia_venta = $_POST['reference_sale'];
                $id_transaccion = $_POST['transaction_id'];
                $codigo_referido = $_POST['extra3'];
                $fecha_compra = $_POST['transaction_date'];
                $query = "INSERT INTO boletas (numero_boleta, comprador_ip, comprador_nombre, comprador_cedula, comprador_celular, comprador_correo, referencia_pago, referencia_venta, id_transaccion, codigo_referido, fecha_compra) VALUES ('$numero_boleta', '$comprador_ip', '$comprador_nombre', '$comprador_cedula', '$comprador_celular', '$comprador_correo', '$referencia_pago', '$referencia_venta', '$id_transaccion', '$codigo_referido', '$fecha_compra');";
                $result = mysqli_query($connection, $query);
                mysqli_close($connection);
            }
        }  
    }
    // Tarjeta de credito
    // 4889135968287203
    // 03/2025
    // 802
?>