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
                $imagenesHTML = $imagenesHTML.'<p style="color: #ffffff;font-size:22px"><strong>MEMBRESÍA
                    # '.$boleta.'<br></strong><br></p> <img src="'.$dominio.'/media/codigosQR/'.$nombreArchivo.'" width="400px" ></img><br>';
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
            $membresias=count($boletas);
            $destinatario = $comprador_correo; 
            $asunto = "La compra de tu membresía ha sido exitosa!"; 
            $cuerpo = ' 
            <!doctype html><html ⚡4email data-css-strict><head><meta charset="utf-8"><style
            amp4email-boilerplate>body{visibility:hidden}</style><script async
            src="https://cdn.ampproject.org/v0.js"></script><style amp-custom>.es-desk-hidden {	display:none;	float:left;	overflow:hidden;	width:0;	max-height:0;	line-height:0;}s {	text-decoration:line-through;}body {	width:100%;	font-family:"open sans", "helvetica neue", helvetica, arial, sans-serif;}table {	border-collapse:collapse;	border-spacing:0px;}table td, html, body, .es-wrapper {	padding:0;	Margin:0;}.es-content, .es-header, .es-footer {	table-layout:fixed;	width:100%;}p, hr {	Margin:0;}h1, h2, h3, h4, h5 {	Margin:0;	line-height:120%;	font-family:"open sans", "helvetica neue", helvetica, arial, sans-serif;}.es-left {	float:left;}.es-right {	float:right;}.es-p5 {	padding:5px;}.es-p5t {	padding-top:5px;}.es-p5b {	padding-bottom:5px;}.es-p5l {	padding-left:5px;}.es-p5r {	padding-right:5px;}.es-p10 {	padding:10px;}.es-p10t {	padding-top:10px;}.es-p10b {	padding-bottom:10px;}.es-p10l {	padding-left:10px;}.es-p10r {	padding-right:10px;}.es-p15 {	padding:15px;}.es-p15t {	padding-top:15px;}.es-p15b {	padding-bottom:15px;}.es-p15l {	padding-left:15px;}.es-p15r {	padding-right:15px;}.es-p20 {	padding:20px;}.es-p20t {	padding-top:20px;}.es-p20b {	padding-bottom:20px;}.es-p20l {	padding-left:20px;}.es-p20r {	padding-right:20px;}.es-p25 {	padding:25px;}.es-p25t {	padding-top:25px;}.es-p25b {	padding-bottom:25px;}.es-p25l {	padding-left:25px;}.es-p25r {	padding-right:25px;}.es-p30 {	padding:30px;}.es-p30t {	padding-top:30px;}.es-p30b {	padding-bottom:30px;}.es-p30l {	padding-left:30px;}.es-p30r {	padding-right:30px;}.es-p35 {	padding:35px;}.es-p35t {	padding-top:35px;}.es-p35b {	padding-bottom:35px;}.es-p35l {	padding-left:35px;}.es-p35r {	padding-right:35px;}.es-p40 {	padding:40px;}.es-p40t {	padding-top:40px;}.es-p40b {	padding-bottom:40px;}.es-p40l {	padding-left:40px;}.es-p40r {	padding-right:40px;}.es-menu td {	border:0;}a {	text-decoration:none;}p, ul li, ol li {	font-family:"open sans", "helvetica neue", helvetica, arial, sans-serif;	line-height:150%;}ul li, ol li {	Margin-bottom:15px;}.es-menu td a {	text-decoration:none;	display:block;	font-family:"open sans", "helvetica neue", helvetica, arial, sans-serif;}.es-menu amp-img, .es-button amp-img {	vertical-align:middle;}.es-wrapper {	width:100%;	height:100%;}.es-wrapper-color {	background-color:#F6F6F6;}.es-header {	background-color:#3D4C6B;}.es-header-body {	background-color:#3D4C6B;}.es-header-body p, .es-header-body ul li, .es-header-body ol li {	color:#B7BDC9;	font-size:16px;}.es-header-body a {	color:#B7BDC9;	font-size:16px;}.es-content-body {	background-color:#F6F6F6;}.es-content-body p, .es-content-body ul li, .es-content-body ol li {	color:#999999;	font-size:16px;}.es-content-body a {	color:#75B6C9;	font-size:16px;}.es-footer {	background-color:transparent;}.es-footer-body {	background-color:transparent;}.es-footer-body p, .es-footer-body ul li, .es-footer-body ol li {	color:#999999;	font-size:14px;}.es-footer-body a {	color:#999999;	font-size:14px;}.es-infoblock, .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li {	line-height:120%;	font-size:12px;	color:#CCCCCC;}.es-infoblock a {	font-size:12px;	color:#CCCCCC;}h1 {	font-size:40px;	font-style:normal;	font-weight:bold;	color:#444444;}h2 {	font-size:28px;	font-style:normal;	font-weight:normal;	color:#444444;}h3 {	font-size:18px;	font-style:normal;	font-weight:normal;	color:#444444;}.es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a {	font-size:40px;}.es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a {	font-size:28px;}.es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a {	font-size:18px;}a.es-button, button.es-button {	border-style:solid;	border-color:#75B6C9;	border-width:15px 25px 15px 25px;	display:inline-block;	background:#75B6C9;	border-radius:28px;	font-size:18px;	font-family:"open sans", "helvetica neue", helvetica, arial, sans-serif;	font-weight:normal;	font-style:normal;	line-height:120%;	color:#FFFFFF;	text-decoration:none;	width:auto;	text-align:center;}.es-button-border {	border-style:solid solid solid solid;	border-color:#75B6C9 #75B6C9 #75B6C9 #75B6C9;	background:#75B6C9;	border-width:1px 1px 1px 1px;	display:inline-block;	border-radius:28px;	width:auto;}@media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150% } h1, h2, h3, h1 a, h2 a, h3 a { line-height:120% } h1 { font-size:30px; text-align:center } h2 { font-size:26px; text-align:center } h3 { font-size:20px; text-align:center } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:30px } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:26px } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px } .es-menu td a { font-size:16px } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:16px } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px } *[class="gmail-fix"] { display:none } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left } .es-m-txt-r amp-img { float:right } .es-m-txt-c amp-img { margin:0 auto } .es-m-txt-l amp-img { float:left } .es-button-border { display:block } a.es-button, button.es-button { font-size:20px; display:block; border-width:15px 25px 15px 25px } .es-btn-fw { border-width:10px 0px; text-align:center } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100% } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%; max-width:600px } .es-adapt-td { display:block; width:100% } .adapt-img { width:100%; height:auto } td.es-m-p0 { padding:0px } td.es-m-p0r { padding-right:0px } td.es-m-p0l { padding-left:0px } td.es-m-p0t { padding-top:0px } td.es-m-p0b { padding-bottom:0 } td.es-m-p20b { padding-bottom:20px } .es-mobile-hidden, .es-hidden { display:none } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto; overflow:visible; float:none; max-height:inherit; line-height:inherit } tr.es-desk-hidden { display:table-row } table.es-desk-hidden { display:table } td.es-desk-menu-hidden { display:table-cell } .es-menu td { width:1% } table.es-table-not-adapt, .esd-block-html table { width:auto } table.es-social { display:inline-block } table.es-social td { display:inline-block } }</style></head>
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
                                    style="background-image:url(https://ganatucarro.com/static/img/9701519718227204.jpg);background-color:
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
                                                                            #ffffff">Membresía</h1>
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
                                                                            28px"><b>Nombre: '.$comprador_nombre.'   </b>
                                                                            </h1><br>
                                                                            <h1
                                                                            style="color:
                                                                            #ffffff;font-size:
                                                                            28px"><b>Cédula: '.$comprador_cedula.' </b>
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
                                                                            membresía
                                                                            en
                                                                            ganatucarro.com,
                                                                            podrás
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
                                                                                Membresía
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
                                                                                Miercoles,
                                                                                24
                                                                                de
                                                                                diciembre
                                                                                de
                                                                                2021
                                                                                a
                                                                                las
                                                                                0:00
                                                                                (hora
                                                                                estándar
                                                                                de
                                                                                Colombia
                                                                                hora
                                                                                de
                                                                                Colombia)
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
                                                                            •&nbsp;
                                                                            <u><a
                                                                                    target="_blank"
                                                                                    href="https://ganatucarro.com"
                                                                                    class="view">Gana
                                                                                    tu
                                                                                    carro&nbsp;</a></u>•&nbsp; <br><br></p><a
                                                                            href="https://www.instagram.com/ganatucarro/">
                                                                            <img
                                                                                src="'.$dominio.'/static/img/ig.png"
                                                                                style="height:24px;padding:0;width:24px"></a><br><a
                                                                            href=""></a></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body></html>

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