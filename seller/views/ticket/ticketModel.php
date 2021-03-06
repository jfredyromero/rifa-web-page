<?php
// Variables del ambiente
include_once("../../../static/variables/variables.php");
// Conexion a la base de datos
include_once("../../../static/connection/connection.php");
if (file_exists("../../../static/php/phpqrcode/qrlib.php")){
    require "../../../static/php/phpqrcode/qrlib.php";
}
$connection = mysqli_connect($host, $user, $pw, $db);
mysqli_set_charset($connection, "utf8");


if (isset($_POST['login-admin'])) {

    $usuario = $_POST['user'];
    $password = $_POST['password'];

    try {
        //code...
        $stmt = $connection->prepare("SELECT * FROM sellers WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($id_seller, $usuario_seller, $nombre_seller, $password_seller); //bind_result retorna los resultados de usar SELECT y permite asignarle en ese retorno las variables que se desean usar
        if ($stmt->affected_rows) {
            # code...
            $existe = $stmt->fetch();
            if ($existe) {
                # code...
                if (password_verify($password, $password_seller)) {
                    # code...
                    session_start();
                    $_SESSION['usuario'] = $usuario_seller;
                    $_SESSION['nombre'] = $nombre_seller;
                    $_SESSION['funcion'] = "seller";

                    $respuesta = [
                        'respuesta' => 'exitoso',
                        'usuario' => $nombre_seller
                    ];
                } else {
                    $respuesta = [
                        'respuesta' => 'error'
                    ];
                }
            } else {
                $respuesta = [
                    'respuesta' => 'error'
                ];
            }
        }
        $stmt->close();
        $connection->close();
    } catch (Exception $e) {
        //throw $th;
        echo "Error: " . $e->getMessage();
    }

    die(json_encode($respuesta));
}




if ($_POST['registro'] == 'nuevo') {    

    try {

        $boleta = $_POST['extra1'];
        $sql = "SELECT numero_boleta FROM boletas WHERE numero_boleta = $boleta";
        $resultado = $connection->query($sql);

        if($resultado->num_rows == 1){
            $respuesta = [
                'respuesta' => 'error'
            ];

        }else{
            session_start();
            // Aqui va lo nuestro
            $phone = $_POST['phone'];
            $email_buyer = $_POST['email_buyer'];
            $ip = $_POST['ip'];
            // $comprador_datos = explode("-", $_POST['extra2']);
            $comprador_nombre = $_POST['extra2-name'];
            $comprador_cedula = $_POST['extra2-cc'];
            $comprador_celular = $_POST['phone'];
            $comprador_correo = $_POST['email_buyer'];
            $referencia_pago = '0000000000';
            $referencia_venta = $_POST['reference_sale'];
            $id_transaccion = $_SESSION['usuario']."-".$boleta."-".$_SESSION['usuario']; 
            if (isset($_POST['revancha'])) {
                $revancha = 1;
            }else{
                $revancha = 0;
            }
            $codigo_referido = $_POST['extra3'];
            $fecha_compra = $_POST['transaction_date'];

            // Env??o de SMS
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

            if($codigo_referido==""){
                $query = "INSERT INTO boletas (numero_boleta, comprador_ip, comprador_nombre, comprador_cedula, comprador_celular, comprador_correo, referencia_pago, referencia_venta, id_transaccion, revancha, fecha_compra) VALUES ('$boleta', '$comprador_ip', '$comprador_nombre', '$comprador_cedula', '$comprador_celular', '$comprador_correo', '$referencia_pago', '$referencia_venta', '$id_transaccion', $revancha,'$fecha_compra');";
            }
            else{
                $query = "INSERT INTO boletas (numero_boleta, comprador_ip, comprador_nombre, comprador_cedula, comprador_celular, comprador_correo, referencia_pago, referencia_venta, id_transaccion, revancha, codigo_referido, fecha_compra) VALUES ('$boleta', '$comprador_ip', '$comprador_nombre', '$comprador_cedula', '$comprador_celular', '$comprador_correo', '$referencia_pago', '$referencia_venta', '$id_transaccion', $revancha,'$codigo_referido', '$fecha_compra');";
            }

            $stmt = $connection->prepare($query);
            $stmt->execute();
            $registros = $stmt->affected_rows;
            $stmt->close();
            
            if($registros > 0){
                // Creacion de codigo QR
                $nombreArchivo = $referencia_venta."-".$boleta.".png";
                $rutaQR = "../../../media/codigosQR/".$nombreArchivo;
                $tama??o = 100;
                $level = "H";
                $framesize = 3;
                $link = $dominio."?id_transaccion=".urlencode($id_transaccion)."&comprador_nombre=".urlencode($comprador_nombre)."&comprador_cedula=".urlencode($comprador_cedula)."&numero_boleta=".urlencode($boleta);
                QRcode ::png($link, $rutaQR, $level, $tama??o, $framesize);   
                $imagenesHTML = '<p style="color: #ffffff;font-size:22px"><strong>CUPO
                    # '.$boleta.'<br></strong><br></p> <img src="'.$dominio.'/media/codigosQR/'.$nombreArchivo.'" width="400px" ></img><br>';
                
                //Env??o de SMS
                //Codigo para enviar el mensaje
                $mensajeSMS= "La compra de tu cupo #".$boleta. " en ganatucarro.com ha sido exitosa.";
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
                                    
                // Env??o de correo electr??nico
                $destinatario = $comprador_correo; 
                $asunto = "La compra de tu cupo ha sido exitosa!"; 
                $cuerpo = ' 
                <!doctype html><html><head><meta charset="utf-8"></head>
        <body><div class="es-wrapper-color"> <!--[if gte mso 9]><v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t"> <v:fill type="tile" color="#f6f6f6"></v:fill> </v:background><![endif]--><table
                    class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"><tr><td
                            valign="top"><table cellpadding="0" cellspacing="0"
                                class="es-content" align="center"><tr><td
                                        align="center"><table
                                            class="es-content-body"
                                            style="background-color: transparent"
                                            width="640" cellspacing="0"
                                            cellpadding="0" align="center"><tr><td
                                                    class="es-p15t es-p15b es-p20r
                                                    es-p20l" align="center"> <!--[if mso]><table width="600" cellpadding="0" cellspacing="0"><tr><td width="290" valign="top"><![endif]--><table
                                                        class="es-left"
                                                        cellspacing="0"
                                                        cellpadding="0"
                                                        align="center"><tr><td
                                                                width="290"
                                                                align="center"><table
                                                                    width="100%"
                                                                    cellspacing="0"
                                                                    cellpadding="0"
                                                                    role="presentation"><tr><td>
                                                                        </td></tr></table></td></tr></table>
                                                    <!--[if mso]></td><td width="20"></td><td width="290" valign="top"><![endif]--><table
                                                        class="es-right"
                                                        cellspacing="0"
                                                        cellpadding="0"
                                                        align="center"><tr><td
                                                                width="290"
                                                                align="conter"></td></tr></table>
                                                    <!--[if mso]></td></tr></table><![endif]--></td></tr></table></td>
                                </tr></table><table class="es-content"
                                cellspacing="0" cellpadding="0" align="center"><tr><td
                                        style="background-image:url('.$dominio.'/static/img/fondo.jpg);background-color:
                                        #3d4c6b;background-position: left
                                        top;background-repeat:
                                        no-repeat;background-size: cover"
                                        bgcolor="#3d4c6b" align="center"><table
                                            class="es-content-body"
                                            style="background-color: transparent"
                                            width="640" cellspacing="0"
                                            cellpadding="0" bgcolor="#f6f6f6"
                                            align="center"><tr><td class="es-p10t
                                                    es-p20r es-p20l" align="center"><table
                                                        width="100%" cellspacing="0"
                                                        cellpadding="0"><tr><td
                                                                width="600"
                                                                valign="top"
                                                                align="center"><table
                                                                    width="100%"
                                                                    cellspacing="0"
                                                                    cellpadding="0"
                                                                    role="presentation"><tr><td
                                                                            align="center"
                                                                            style="font-size:
                                                                            0px"><img
                                                                                class="adapt-img"
                                                                                src="'.$dominio.'/static/img/logopng_6Tk.png"
                                                                                alt
                                                                                style="display:
                                                                                block"
                                                                                width="200"
                                                                                height="121"
                                                                                layout="responsive"></img></td></tr><tr><td
                                                                            align="center"
                                                                            class="es-p25t
                                                                            es-p30b"><h1
                                                                                style="color:
                                                                                #ffffff">Cupo</h1>
                                                                        </td></tr><tr><td
                                                                            align="center"
                                                                            style="font-size:
                                                                            0px"><img
                                                                                class="adapt-img"
                                                                                src="'.$dominio.'/static/img/logopng_JiK.png"
                                                                                alt
                                                                                style="display:
                                                                                block"
                                                                                width="400"
                                                                                height="120"
                                                                                layout="responsive"></img></td></tr></table></td></tr><tr><td
                                                                width="600"
                                                                valign="top"
                                                                align="center"><table
                                                                    width="100%"
                                                                    cellspacing="0"
                                                                    cellpadding="0"
                                                                    role="presentation"><tr><td
                                                                            align="center"
                                                                            class="es-p5t
                                                                            es-p30b">
                                                                                <h1
                                                                                style="color:
                                                                                #ffffff;font-size:
                                                                                28px"><b>TODO LISTO! </b>
                                                                                </h1><br><h1
                                                                                style="color:
                                                                                #ffffff;font-size:
                                                                                28px"><b>Nombre: '.preg_replace("/[^A-Za-z0-9 ]/", '',iconv('UTF-8', 'ASCII//TRANSLIT', $comprador_nombre)).'   </b>
                                                                                </h1><br>
                                                                                <h1
                                                                                style="color:
                                                                                #ffffff;font-size:
                                                                                28px"><b>Cedula: '.$comprador_cedula.' </b>
                                                                                </h1></td></tr></table></td></tr></table></td>
                                            </tr><tr><td class="es-p40r es-p40l"
    
                                                    align="center"> <!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="182" valign="top"><![endif]--><table
                                                        class="es-left"
                                                        cellspacing="0"
                                                        cellpadding="0"
                                                        align="center"><tr><td
                                                                class="es-m-p0r"
                                                                width="162"
                                                                align="center"><table
                                                                    width="100%"
                                                                    cellspacing="0"
                                                                    cellpadding="0"
                                                                    role="presentation"><tr><td
                                                                            class="es-p10t
                                                                            es-p20r
                                                                            es-p20l"
                                                                            align="center"
                                                                            style="font-size:0"><table
                                                                                width="100%"
                                                                                cellspacing="0"
                                                                                cellpadding="0"
                                                                                border="0"
                                                                                role="presentation"><tr><td
                                                                                        style="border-bottom:
                                                                                        1px
                                                                                        solid
                                                                                        transparent;background:
                                                                                        none;height:
                                                                                        1px;width:
                                                                                        100%;margin:
                                                                                        0px"></td></tr></table></td></tr></table></td><td
                                                                class="es-hidden"
                                                                width="20"></td></tr></table>
                                                    <!--[if mso]></td>
    <td width="196" valign="top"><![endif]--><table class="es-left" cellspacing="0"
                                                        cellpadding="0"
                                                        align="center"><tr><td
                                                                width="196"
                                                                align="center"></td></tr></table>
                                                    <!--[if mso]></td><td width="20"></td>
    <td width="162" valign="top"><![endif]--><table class="es-right" cellspacing="0"
                                                        cellpadding="0"
                                                        align="right"><tr><td
                                                                width="162"
                                                                align="center"><table
                                                                    width="100%"
                                                                    cellspacing="0"
                                                                    cellpadding="0"
                                                                    role="presentation"><tr><td
                                                                            class="es-p10t
                                                                            es-p20r
                                                                            es-p20l"
                                                                            align="center"
                                                                            style="font-size:0"><table
                                                                                width="100%"
                                                                                cellspacing="0"
                                                                                cellpadding="0"
                                                                                border="0"
                                                                                role="presentation"><tr><td
                                                                                        style="border-bottom:
                                                                                        1px
                                                                                        solid
                                                                                        transparent;background:
                                                                                        none;height:
                                                                                        1px;width:
                                                                                        100%;margin:
                                                                                        0px"></td></tr></table></td></tr></table></td></tr></table>
                                                    <!--[if mso]></td></tr></table><![endif]--></td>
                                            </tr><tr><td class="es-p20t es-p15b
                                                    es-p20r es-p20l" align="left"><table
                                                        width="100%" cellspacing="0"
                                                        cellpadding="0"><tr><td
                                                                width="600"
                                                                valign="top"
                                                                align="center"><table
                                                                    width="100%"
                                                                    cellspacing="0"
                                                                    cellpadding="0"
                                                                    role="presentation"><tr><td
                                                                            class="es-p15t
                                                                            es-p20b"
                                                                            align="center"><p
                                                                                style="color:
                                                                                #b7bdc9;font-family:
                                                                                open
                                                                                sans,
                                                                                helvetica
                                                                                neue,
                                                                                helvetica,
                                                                                arial,
                                                                                sans-serif">Has
                                                                                adquirido
                                                                                satisfactoriamente
                                                                                tu
                                                                                cupo
                                                                                en
                                                                                ganatucarro.com,
                                                                                podras
                                                                                visualizarla
                                                                                con
                                                                                el
                                                                                siguiente
                                                                                QR:&nbsp;</p></td></tr></table></td></tr></table></td></tr></table></td>
                                </tr></table><table cellpadding="0" cellspacing="0"
                                class="es-header" align="center"><tr><td
                                        align="center" bgcolor="#393a4e"
                                        style="background-color: #393a4e"><table
                                            bgcolor="#393a4e" class="es-header-body"
                                            align="center" cellpadding="0"
                                            cellspacing="0" width="640"
                                            style="border-width: 10px;border-style:
                                            solid;border-color:
                                            transparent;background-color: #393a4e"><tr><td
                                                    class="es-p20t es-p20r es-p20l"
                                                    align="left"><table
                                                        cellpadding="0"
                                                        cellspacing="0"
                                                        width="100%"><tr><td
                                                                width="580"
                                                                align="center"
                                                                valign="top"><table
                                                                    cellpadding="0"
                                                                    cellspacing="0"
                                                                    width="100%"
                                                                    style="border-radius:
                                                                    13px;border-collapse:
                                                                    separate"
                                                                    role="presentation"><tr><td
                                                                            align="center"><br>'
                                                                            .$imagenesHTML.
                                                                            '</td>
                                                                    </tr></table></td></tr></table></td></tr><tr><td
                                                    class="es-p20t es-p20r es-p20l"
                                                    align="left"><table
                                                        cellpadding="0"
                                                        cellspacing="0"
                                                        width="100%"><tr><td
                                                                width="580"
                                                                align="center"
                                                                valign="top"><table
                                                                    cellpadding="0"
                                                                    cellspacing="0"
                                                                    width="100%"
                                                                    role="presentation"><tr><td
                                                                            align="center"
                                                                            class="es-p5"
                                                                            style="font-size:
                                                                            0px"><a
                                                                                target="_blank"
                                                                                href=""><br><img
                                                                                    class="adapt-img"
                                                                                    id="ticket"
                                                                                    name="ticket"
                                                                                    src="https://ci4.googleusercontent.com/proxy/8p0n-rSxvsQEVxK16yRAjDG05DmAtl1RhIO0LJDbAz8tWpkNccU9Pgx94RcbeB95cJkODhC9IHmlGo2BjF9wTXd15ATcOhK82hDqgQEK28rGV_XvdaTC7MDK7Zz8C1ojCRUpV-r0aBqY5ChxMoLzfR-0I78Lq77cJlo=s0-d-e1-ft#https://cdn.evbstatic.com/s3-build/perm_001/3a25e5/django/images/emails_2018_rebrand/ticket-icon@2x.png"
                                                                                    style="height:
                                                                                    19px;padding:
                                                                                    0px;width:
                                                                                    19px"
                                                                                    alt
                                                                                    style="display:
                                                                                    block"
                                                                                    width="14"
                                                                                    layout="responsive"></img></a></td>
                                                                                    <td>
                                                                                    <label style="color: #ffffff;font-size:14px">
                                                                                    '.$membresias.'
                                                                                     x
                                                                                    Cupo
                                                                                </label></td>
                                                                    </tr><tr><td
                                                                            align="center"
                                                                            class="es-p5"
                                                                            style="font-size:
                                                                            0px"><a
                                                                                target="_blank"
                                                                                href=""><br><img
                                                                                    class="adapt-img"
                                                                                    id="date"
                                                                                    name="date"
                                                                                    src="https://ci3.googleusercontent.com/proxy/t9w4rGB2UCCV_hN6Yfbat8UQeU5FgWPQbXlFkPQ-lmGfzw-1qk8b84l1XgZgdd2VPrOW9fM16eZFRIPbVoc60lEnD-6Dpsv7RPtrUiPxg1vqfv1x19TczYfQlawkADVSQRRJxjt50uSVCk0G3dhqGvizvzF0mDDW=s0-d-e1-ft#https://cdn.evbstatic.com/s3-build/perm_001/17c084/django/images/emails_2018_rebrand/date-icon@2x.png"
                                                                                    style="height:
                                                                                    19px;padding:
                                                                                    0px;width:
                                                                                    19px"
                                                                                    alt
                                                                                    width="19"
                                                                                    height="19"
                                                                                    layout="responsive"></img></a></td><td><label style="color: #ffffff;font-size:14px">
                                                                                    Revisar la p??gina oficial de gana tu carro en instagram para actualizar la fecha del sorteo.
                                                                                </label></td></tr></table></td></tr></table></td></tr></table></td>
                                </tr></table><table cellpadding="0" cellspacing="0"
                                class="es-footer" align="center"><tr><td
                                        align="center"><table class="es-footer-body"
                                            width="640" cellspacing="0"
                                            cellpadding="0" align="center"><tr><td
                                                    class="es-p40t es-p40b es-p20r
                                                    es-p20l" align="left"><table
                                                        width="100%" cellspacing="0"
                                                        cellpadding="0"><tr><td
                                                                width="600"
                                                                valign="top"
                                                                align="center"><table
                                                                    width="100%"
                                                                    cellspacing="0"
                                                                    cellpadding="0"
                                                                    role="presentation"><tr><td
                                                                            class="es-p15t
                                                                            es-p15b"
                                                                             align="center"><p>Colombia</p></td></tr><tr><td
                                                                            align="center"><p>&nbsp;
                                                                                ???&nbsp;
                                                                                <u><a
                                                                                        target="_blank"
                                                                                        href="https://ganatucarro.com"
                                                                                        class="view">Gana
                                                                                        tu
                                                                                        carro&nbsp;</a></u>???&nbsp; <br><br></p><a
                                                                                href="https://www.instagram.com/ganatucarro/">
                                                                                <img
                                                                                    src="'.$dominio.'/static/img/ig.png"
                                                                                    style="height:24px;padding:0;width:24px"></a><br><a
                                                                                href=""></a></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body></html>
    
                    '; 
                //para el env??o en formato HTML 
                $headers = "MIME-Version: 1.0\r\n"; 
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
                //direcci??n del remitente 
                $headers .= "From: Gana Tu Carro <noreply@ganatucarro.com>\r\n"; 
                //direcci??n de respuesta, si queremos que sea distinta que la del remitente 
                $headers .= "Reply-To: soporte@ganatucarro.com\r\n";     
                //direcciones que recibir??n copia oculta 
                // $headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 
                mail($destinatario, $asunto, $cuerpo, $headers);
                $respuesta = [
                    'respuesta' => 'exito'
                ];                    
            } else {
                $respuesta = [
                    'respuesta' => 'error'
                ];
            }
        }

    } catch (Exception $e) {
        $respuesta = [
            'respuesta' => $e->getMessage()
        ];
    }

    die(json_encode($respuesta));
}

// Eliminar Membres??a

if ($_POST['registro'] == 'eliminar') {
    
    $id_borrar = $_POST['id'];
    
    try {
        $stmt = $connection->prepare('DELETE FROM boletas WHERE id = ?');
        $stmt->bind_param("i", $id_borrar);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = [
                'respuesta' => 'exito',
                'id_eliminado' => $id_borrar
            ];
        } else {
            $respuesta = [
                'respuesta' => 'error'
            ];
        }
        $stmt->close();
    } catch (Exception $e) {

        $respuesta = [
            'respuesta' => $e->getMessage()
        ];
    }

    die(json_encode($respuesta));
}

?>