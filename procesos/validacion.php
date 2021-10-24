<?php
// Captura de datos
$method = $_SERVER['REQUEST_METHOD'];
if($method == "POST"){
    // Variables del ambiente
    include_once("../static/variables/variables.php");
    // Conexión a la base de datos
    include_once("../static/connection/connection.php");
    $mysqli = new mysqli($host, $user, $pw, $db);
    if ($mysqli->connect_error) {
        exit('Could not connect');
    }
    $sql = "SELECT numero_boleta FROM boletas";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($num);
    $boletas_compradas = [];
    while ($stmt -> fetch()) { 
        $boletas_compradas[] = (int)$num;
    }
    $stmt->close();

    // Validacion de campos vacíos
    $validacion1 = !empty($_POST['amount']) && !empty($_POST['extra1']) && !empty($_POST['buyerFullName']) && !empty($_POST['payerDocument']) && !empty($_POST['mobilePhone']) && !empty($_POST['buyerEmail']) && !empty($_POST['description']) && !empty($_POST['referenceCode']) && !empty($_POST['extra2']) && !empty($_POST['payerFullName']) && !empty($_POST['payerMobilePhone']);
    if (!$validacion1) {
        exit('Campo obligatorio vacío');
    }

    // Validación de boletas validas
    $extra1 = trim(htmlspecialchars($_POST["extra1"]));
    $boletas = explode("-", $extra1);
    // Boletas validas son las boletas que vienen del formulario que no estan en la base de datos
    // Si las boletas del formulario no estan en la base de datos, las boletas validas son las mismas
    // boletas del formulario
    $boletas_validas = array_diff($boletas, $boletas_compradas);
    // Se verifica que las boletas validas no tengan ninguna boleta que no vengan del formulario
    // Si las boletas del formulario tienen alguna boleta que no este en boletas validas, significa
    // que hubieron boletas del formulario existentes en la base de datos.
    // Por lo tanto, si el array de salida esta vacío, las boletas validas son igual a las compradas
    $validacion2 = empty(array_diff($boletas, $boletas_validas));
    if (!$validacion2) {
        exit('Boletas inválidas');
    }

    // Validación de precio válido
    $amount = trim(htmlspecialchars($_POST["amount"]));
    $amount = filter_var($amount, FILTER_VALIDATE_INT);
    if ($amount === false) {
        exit('Precio en formato no válido');
    }
    $validacion3 = ($amount==count($boletas)*$price);
    if (!$validacion3) {
        exit('Precio Adulterado');
    }

    // Datos establecidos
    $responseUrl = $dominio;
    $confirmationUrl = $dominio."/procesos/confirmacion.php";
    $tax = 0;
    $taxReturnBase = 0;
    $currency = "COP";
    $test = 1;

    // Datos capturados del formulario
    $buyerFullName = trim(htmlspecialchars($_POST["buyerFullName"]));
    $payerDocument = trim(htmlspecialchars($_POST["payerDocument"]));
    $mobilePhone = trim(htmlspecialchars($_POST["mobilePhone"]));

    // Validacion de email válido
    $buyerEmail = trim(htmlspecialchars($_POST["buyerEmail"]));
    $buyerEmail = filter_var($buyerEmail, FILTER_VALIDATE_EMAIL);
    if ($buyerEmail === false) {
        exit('Email Inválido');
    }

    $description = trim(htmlspecialchars($_POST["description"]));
    $referenceCode = md5(trim(htmlspecialchars($_POST["referenceCode"])));
    $extra2 = trim(htmlspecialchars($_POST["extra2"]));

    // Validación de codigo de referido válido
    $extra3 = "";
    if(!empty($_POST["extra3"])){
        $extra3 = trim(htmlspecialchars($_POST["extra3"]));
        $sql = "SELECT referido FROM referidos WHERE codigo='$extra3';";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($ref);
        $referido = "";
        while ($stmt -> fetch()) { 
            $referido = $ref;
        }
        $stmt->close();
        if ($referido == "") {
            exit('Referido Inválido');
        }
    }
    $payerFullName = trim(htmlspecialchars($_POST["payerFullName"]));
    $payerMobilePhone = trim(htmlspecialchars($_POST["payerMobilePhone"]));
    // Datos generados
    $signature = md5("$ApiKey~$merchantId~$referenceCode~$amount~$currency");
    // Generar solicitud POST a PayU
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación</title>
</head>
<body>
    <form id="myForm" style = "display:none;" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu" method="POST">
        <input name="buyerFullName" type="hidden" value="<?php echo $buyerFullName; ?>">
        <input name="payerDocument" type="hidden" value="<?php echo $payerDocument; ?>">
        <input name="mobilePhone" type="hidden" value="<?php echo $mobilePhone; ?>">
        <input name="buyerEmail" type="hidden" value="<?php echo $buyerEmail; ?>">
        <input name="extra1" type="hidden" value="<?php echo $extra1; ?>">
        <input name="merchantId" type="hidden" value="<?php echo $merchantId; ?>">
        <input name="accountId" type="hidden" value="<?php echo $accountId; ?>">
        <input name="description" type="hidden" value="<?php echo $description; ?>">
        <input name="referenceCode" type="hidden" value="<?php echo $referenceCode; ?>">
        <input name="extra2" type="hidden" value="<?php echo $extra2; ?>">
        <input name="extra3" type="hidden" value="<?php echo $extra3; ?>">
        <input name="payerFullName" type="hidden" value="<?php echo $payerFullName; ?>">
        <input name="payerMobilePhone" type="hidden" value="<?php echo $payerMobilePhone; ?>">
        <input name="amount" type="hidden" value="<?php echo $amount; ?>">
        <input name="tax" type="hidden" value="<?php echo $tax; ?>">
        <input name="taxReturnBase" type="hidden" value="<?php echo $taxReturnBase; ?>">
        <input name="currency" type="hidden" value="<?php echo $currency; ?>">
        <input name="signature" type="hidden" value="<?php echo $signature; ?>">
        <input name="test" type="hidden" value="<?php echo $test; ?>">
        <input name="responseUrl" type="hidden" value="<?php echo $responseUrl; ?>">
        <input name="confirmationUrl" type="hidden" value="<?php echo $confirmationUrl; ?>">
        <input name="Submit" type="submit" value="Enviar" >
    </form>
    <div style="width:100%; position:relative; height:90vh; display:flex; flex-direction: column; justify-content: center; align-items: center;">
        <img src="../static/img/timer.gif">
        <h2>You're being redirected...</h2>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById('myForm').submit();
        })
    </script>
</body>
</html>
<?php
}
?>