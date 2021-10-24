<?php
// Variables del ambiente
include_once("../static/variables/variables.php");
// Conexion a la base de datos
include_once("../static/connection/connection.php");
if (file_exists("../static/php/phpqrcode/qrlib.php")){
    require "../static/php/phpqrcode/qrlib.php";
}
$connection = mysqli_connect($host, $user, $pw, $db);
mysqli_set_charset($connection, "utf8");
// Captura de datos

$method = $_SERVER['REQUEST_METHOD'];
if($method == "POST"){
    $transactionState = $_POST['state_pol'];
    if($transactionState==4){
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
        $firmacreada = md5("$ApiKey~$merchantId~$referenceCode~$new_value~$currency~$transactionState");
        // Confirmación de firma
        if (strtoupper($firma) == strtoupper($firmacreada)) {
            $comprador_ip = $_POST['ip'];
            $comprador_datos = explode("-", $_POST['extra2']);
            $comprador_nombre = $comprador_datos[1];
            $comprador_cedula = $comprador_datos[0];
            $comprador_celular = $_POST['phone'];
            $comprador_correo = $_POST['email_buyer'];
            $referencia_pago = $_POST['reference_pol'];
            $referencia_venta = $_POST['reference_sale'];
            $id_transaccion = $_POST['transaction_id'];
            $codigo_referido = $_POST['extra3'];
            $fecha_compra = $_POST['transaction_date'];
            $boletas = explode("-", $_POST['extra1']);

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

            $stringBoletas = "";
            foreach($boletas as $boleta) {
                if($codigo_referido==""){
                    $query2 = "INSERT INTO boletas (numero_boleta, comprador_ip, comprador_nombre, comprador_cedula, comprador_celular, comprador_correo, referencia_pago, referencia_venta, id_transaccion, fecha_compra) VALUES ('$boleta', '$comprador_ip', '$comprador_nombre', '$comprador_cedula', '$comprador_celular', '$comprador_correo', '$referencia_pago', '$referencia_venta', '$id_transaccion', '$fecha_compra');";
                }
                else{
                    $query2 = "INSERT INTO boletas (numero_boleta, comprador_ip, comprador_nombre, comprador_cedula, comprador_celular, comprador_correo, referencia_pago, referencia_venta, id_transaccion, codigo_referido, fecha_compra) VALUES ('$boleta', '$comprador_ip', '$comprador_nombre', '$comprador_cedula', '$comprador_celular', '$comprador_correo', '$referencia_pago', '$referencia_venta', '$id_transaccion', '$codigo_referido', '$fecha_compra');";
                }
                $result = mysqli_query($connection, $query2);
                
                // Creacion de codigo QR
                $nombreArchivo = $referenceCode."-".$boleta.".png";
                $rutaQR = "../media/codigosQR/".$nombreArchivo;
                $tamaño = 100;
                $level = "H";
                $framesize = 3;
                $link = $dominio."?referencia_pago=".urlencode($referencia_pago)."&comprador_nombre=".urlencode($comprador_nombre)."&comprador_cedula=".urlencode($comprador_cedula)."&numero_boleta=".urlencode($boleta);
                QRcode ::png($link, $rutaQR, $level, $tamaño, $framesize);   
                $imagenesHTML = $imagenesHTML.'<h2>Boleta: '.$boleta.'</h2><img src="'.$dominio.'/media/codigosQR/'.$nombreArchivo.'" width="400px" ></img><br>';
            }
            mysqli_close($connection);
            if (count($boletas)>1){
                $mensajeSMS= "La compra de sus membresías en ganatucarro.com ha sido exitosa.";
            }
            else{
                $mensajeSMS= "La compra de su membresía en ganatucarro.com ha sido exitosa.";
            }
            //Envío de SMS
            //Codigo para enviar el mensaje
            $data = array("number" => "57".$comprador_celular, "message" => $mensajeSMS, "type" => "1");
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
                                
            // Envío de correo electrónico
            $destinatario = $comprador_correo; 
            $asunto = "La compra de tu membresía ha sido exitosa!"; 
            $cuerpo = ' 
            <html> 
            <head> 
            <title>Gana Tu Carro</title> 
            </head> 
            <body> 
            <div align= "center">
            <h1>Membresía Gana Tu Carro</h1> 
            <h3><b>Nombre: </b> '.$comprador_nombre.'</h3>
            <h3><b>Cedula: </b> '.$comprador_cedula.'</h3>
            <br>
            <br>'
            .$imagenesHTML.
            '
            </div>
            </body> 
            </html> 
            '; 
            //para el envío en formato HTML 
            $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
            //dirección del remitente 
            $headers .= "From: Gana Tu Carro <noreply@ganatucarro.com>\r\n"; 
            //dirección de respuesta, si queremos que sea distinta que la del remitente 
            $headers .= "Reply-To: soporte@ganatucarro.com\r\n";     
            //direcciones que recibirán copia oculta 
            // $headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 
            mail($destinatario, $asunto, $cuerpo, $headers);
        }
    }
}
// Tarjeta de credito
// 4889135968287203
// 03/2025
// 802
?>