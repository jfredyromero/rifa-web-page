<?php
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
    $respuesta = [
        "error"=>$error,
        "mensaje"=>$mensaje,
        "datos"=>$rutaQR
    ];
    echo json_encode($respuesta);
?>
