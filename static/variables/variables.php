<?php
$ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
$merchantId = "508029";
$accountId = "512321";
$dominio = "https://www.ganatucarro.com";
// $dominio = "localhost/rifa-web-page";
$price = 80000;
$priceRevancha = 25000;

$horas=0;
$minutos=0;
$segundos=0;
$mes=12;
$dia=24;
$anio=2021;

$fecha_sorteo = date("Y-m-d H:i:s", mktime($horas,$minutos,$segundos,$mes,$dia,$anio));
$fecha_sorteo_countdown = date("M d, Y H:i:s", mktime($horas,$minutos,$segundos,$mes,$dia,$anio));

?>