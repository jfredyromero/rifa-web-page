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
            // Generacion de codigo QR
            if (file_exists("phpqrcode/qrlib.php")){
                require "phpqrcode/qrlib.php";
                $link = "https://www.ganatucarro.com";
                $rutaQR = "img/prueba.png";
                $tamaño = 10;
                $level = "Q";
                $framesize = 3;
                QRcode ::png($link, $rutaQR, $level, $tamaño, $framesize);
                if (file_exists($rutaQR)){
                    $error = 0;
                    $mensaje = "Archivo generado";
                }
            }else{
                $error = 1;
                $mensaje = "No existe la libreria";
            }
            // Envío de correo electrónico
            $destinatario = 'gigia.munoz@gmail.com' . ', '; // note the comma
            $destinatario .= 'jfredyrom@gmail.com' . ', '; // note the comma
            $asunto = "Este mensaje es de prueba"; 
            $cuerpo = ' 
            <html> 
            <head> 
            <title>Prueba de correo</title> 
            </head> 
            <body> 
            <h1>Hola amigos!</h1> 
            <p> 
            <b>Bienvenidos a mi correo electrónico de prueba</b>. Estoy encantado de tener tantos lectores. Este cuerpo del mensaje es del artículo de envío de mails por PHP. Habría que cambiarlo para poner tu propio cuerpo. Por cierto, cambia también las cabeceras del mensaje. 
            </p>
            <h1>Tu boleta comprada fue '.'4567'.'</h1> 
            <img src="img/prueba.png"></img>
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