<?php
// Captura de datos
$method = $_SERVER['REQUEST_METHOD'];
if($method == "POST"){
    // Variables del ambiente
    include_once("../static/variables/variables.php");
    $extra1 = $_POST["extra1"];
    $boletas = explode("-", $extra1);
    $amount = $_POST["amount"];
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
    // Boletas validas son las boletas que vienen del formulario que no estan en la base de datos
    // Si las boletas del formulario no estan en la base de datos, las boletas validas son las mismas
    // boletas del formulario
    $boletas_validas = array_diff($boletas, $boletas_compradas);
    // Se verifica que las boletas validas no tengan ninguna boleta que no vengan del formulario
    // Si las boletas del formulario tienen alguna boleta que no este en boletas validas, significa
    // que hubieron boletas del formulario existentes en la base de datos.
    // Por lo tanto, si el array de salida esta vacío, las boletas validas son igual a las compradas
    if (empty(array_diff($boletas, $boletas_validas))){
        //
        //
        //
        // Falta verificar que los campos no vengan vacíos
        //
        //
        //

        if($amount==count($boletas)*$price){
            // Datos establecidos
            $responseUrl = $dominio;
            //$confirmationUrl = $dominio."/procesos/confirmacion.php";
            $confirmationUrl = "https://www.ganatucarro.com/procesos/confirmacion.php";
            $tax = 0;
            $taxReturnBase = 0;
            $currency = "COP";
            $test = 1;
            // Datos capturados del formulario
            $buyerFullName = $_POST["buyerFullName"];
            $payerDocument = $_POST["payerDocument"];
            $mobilePhone = $_POST["mobilePhone"];
            $buyerEmail = $_POST["buyerEmail"];
            $description = $_POST["description"];
            $referenceCode = md5($_POST["referenceCode"]);
            $extra2 = $_POST["extra2"];
            $extra3 = $_POST["extra3"];
            $payerFullName = $_POST["payerFullName"];
            $payerMobilePhone = $_POST["payerMobilePhone"];
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
        <input name="buyerFullName" value="<?php echo $buyerFullName; ?>">
        <input name="payerDocument" value="<?php echo $payerDocument; ?>">
        <input name="mobilePhone" value="<?php echo $mobilePhone; ?>">
        <input name="buyerEmail" value="<?php echo $buyerEmail; ?>">
        <input name="extra1" value="<?php echo $extra1; ?>">
        <input name="merchantId" value="<?php echo $merchantId; ?>">
        <input name="accountId" value="<?php echo $accountId; ?>">
        <input name="description" value="<?php echo $description; ?>">
        <input name="referenceCode" value="<?php echo $referenceCode; ?>">
        <input name="extra2" value="<?php echo $extra2; ?>">
        <input name="extra3" value="<?php echo $extra3; ?>">
        <input name="payerFullName" value="<?php echo $payerFullName; ?>">
        <input name="payerMobilePhone" value="<?php echo $payerMobilePhone; ?>">
        <input name="amount" value="<?php echo $amount; ?>">
        <input name="tax" value="<?php echo $tax; ?>">
        <input name="taxReturnBase" value="<?php echo $taxReturnBase; ?>">
        <input name="currency" value="<?php echo $currency; ?>">
        <input name="signature" value="<?php echo $signature; ?>">
        <input name="test" value="<?php echo $test; ?>">
        <input name="responseUrl" value="<?php echo $responseUrl; ?>">
        <input name="confirmationUrl" value="<?php echo $confirmationUrl; ?>">
    </form>
    <div style="display:flex; justify-content: center; align-items: center;">
      <img src="../static/img/timer.gif">
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
    }
}
?>