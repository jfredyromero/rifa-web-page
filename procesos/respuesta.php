<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Respuesta</title>
    </head>
    <body>
    <?php
        include_once("../static/connection/connection.php");
        $connection = mysqli_connect($host, $user, $pw, $db);
        mysqli_set_charset($connection, "utf8");
        if (file_exists("../static/php/phpqrcode/qrlib.php")){
            require "../static/php/phpqrcode/qrlib.php";
        }
        $ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
        $merchant_id = $_REQUEST['merchantId'];
        $referenceCode = $_REQUEST['referenceCode'];
        $TX_VALUE = $_REQUEST['TX_VALUE'];
        $New_value = number_format($TX_VALUE, 1, '.', '');
        $currency = $_REQUEST['currency'];
        $transactionState = $_REQUEST['transactionState'];
        $firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
        $firmacreada = md5($firma_cadena);
        $firma = $_REQUEST['signature'];
        $reference_pol = $_REQUEST['reference_pol'];
        $cus = $_REQUEST['cus'];
        $description = $_REQUEST['description'];
        $pseBank = $_REQUEST['pseBank'];
        $lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
        $transactionId = $_REQUEST['transactionId'];

        // Se comparan las firmas por seguridad
        if (strtoupper($firma) == strtoupper($firmacreada)) {
            $link = "Soy Lina fea";
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
            $boletas = explode("-", $_GET['extra1']);
            foreach ($boletas as $boleta) { 
                $query = "INSERT INTO boletas (numero_boleta, comprador_ip, comprador_nombre, comprador_cedula, comprador_celular, comprador_correo, referencia_pago, referencia_venta, id_transaccion, codigo_referido, fecha_compra) VALUES ('$boleta', '10.25.012', 'ElsaCapunta', '105656516', '3105110389', 'gigia.munoz@gmail.com', '5166516116', '$68165353516', '$4516516dvd6v51s6', '554154', '2021-10-12 11:34:00');";
                $result = mysqli_query($connection, $query);

                // Creacion de codigo QR
                $link = "https://www.ganatucarro.com";             //CAMBIARRRRRRR
                $nombreArchivo = $referenceCode."-".$boleta.".png";
                $rutaQR = "../media/codigosQR/".$nombreArchivo;
                $tamaño = 100;
                $level = "H";
                $framesize = 3;
                QRcode ::png($link, $rutaQR, $level, $tamaño, $framesize);
                echo "QR creado<br>";
                // Envío de correo electrónico
                $destinatario = "jhonrom@unicauca.edu.co" ; 
                $asunto = "Compra exitosa. Tu boleta es ".$boleta; 
                $cuerpo = ' 
                <html> 
                <head> 
                <title>Gana Tu Carro</title> 
                </head> 
                <body> 
                <div align= "center">
                <h1>Membresía Gana Tu Carro</h1> 
                <h3><b>Nombre: </b> '.'Jhon Fredy'.'</h3>
                <h3><b>Cedula: </b> '.'1002970732'.'</h3>
                <br>
                <br>
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
                // Envío de SMS
                //Codigo para enviar el mensaje
                $data = array("number" => "573014822371", "message" => "La compra de su membresía en ganatucarro.com ha sido exitosa con el numero " .$boleta.". Usted puede visualizar su boleta en: ".$link." Suerte!", "type" => "1");
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
                $result = curl_exec($ch);
                echo "Acabo un ciclo";
            }
            mysqli_close($connection);
            // Solo entra si la transacción es exitosa
            if ($_REQUEST['transactionState'] == 4 ) {
                $estadoTx = "Transacción aprobada";
            }
            else if ($_REQUEST['transactionState'] == 6 ) {
                $estadoTx = "Transacción rechazada";
            }
            else if ($_REQUEST['transactionState'] == 104 ) {
                $estadoTx = "Error";
            }
            else if ($_REQUEST['transactionState'] == 7 ) {
                $estadoTx = "Transacción pendiente";
            }
            else {
                $estadoTx=$_REQUEST['mensaje'];
            }
    ?>
        <h2>Resumen Transacción</h2>
        <table>
        <tr>
        <td>Estado de la transaccion</td>
        <td><?php echo $estadoTx; ?></td>
        </tr>
        <tr>
        <tr>
        <td>ID de la transaccion</td>
        <td><?php echo $transactionId; ?></td>
        </tr>
        <tr>
        <td>Referencia de la venta</td>
        <td><?php echo $reference_pol; ?></td>
        </tr>
        <tr>
        <td>Referencia de la transaccion</td>
        <td><?php echo $referenceCode; ?></td>
        </tr>
        <tr>
        <?php
        if($pseBank != null) {
        ?>
            <tr>
            <td>cus </td>
            <td><?php echo $cus; ?> </td>
            </tr>
            <tr>
            <td>Banco </td>
            <td><?php echo $pseBank; ?> </td>
            </tr>
        <?php
        }
        ?>
        <tr>
        <td>Valor total</td>
        <td>$<?php echo number_format($TX_VALUE); ?></td>
        </tr>
        <tr>
        <td>Moneda</td>
        <td><?php echo $currency; ?></td>
        </tr>
        <tr>
        <td>Descripción</td>
        <td><?php echo ($description); ?></td>
        </tr>
        <tr>
        <td>Entidad:</td>
        <td><?php echo ($lapPaymentMethod); ?></td>
        </tr>
        </table>
    <?php
        }else{
    ?>
        <h1>Error validando firma digital.</h1>
    <?php
        }
    ?>
    </body>
</html>