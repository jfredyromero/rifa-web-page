<?php
// Captura de datos
$dominio = "https://www.ganatucarro.com";
$method = $_SERVER['REQUEST_METHOD'];
if($method == "POST"){
    // Datos establecidos
    $ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
    $merchantId = "508029";
    $accountId = "512321";
    $responseUrl = $dominio;
    $confirmationUrl = $dominio."/procesos/confirmacion.php";
    $price = 60000;
    $tax = 0;
    $taxReturnBase = 0;
    $currency = "COP";
    $test = 1;
    // Datos capturados del formulario
    $extra1 = $_POST["extra1"];
    // $signature = $_POST["signature"];
    $description = $_POST["description"];
    $referenceCode = $_POST["referenceCode"];
    $extra2 = $_POST["extra2"];
    $extra3 = $_POST["extra3"];
    $payerFullName = $_POST["payerFullName"];
    $payerMobilePhone = $_POST["payerMobilePhone"];
    $amount = $_POST["amount"];

    // Hacer la firma aca
    // Verificar precios
}
?>