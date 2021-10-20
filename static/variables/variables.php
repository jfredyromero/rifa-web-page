<?php
$ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
$merchantId = "508029";
$accountId = "512321";
$dominio = "https://www.ganatucarro.com";
// $dominio = "localhost/rifa-web-page";
$price = 80000;
$fecha_sorteo = date_create("2021-12-24 00:00:00");
echo $fecha_sorteo;
$fecha_sorteo = date("Y-m-d H:i:s", mktime(0, 0, 0, 12, 24, 2021));
echo $fecha_sorteo;
?>