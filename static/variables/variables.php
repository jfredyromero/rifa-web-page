<?php
$ApiKey = "oIu6BOWNx227wmiy0C9hTghU0Y";
$merchantId = "951878";
$accountId = "959493";
$dominio = "https://www.ganatucarro.com";
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