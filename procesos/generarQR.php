<?php
    if (file_exists("../static/php/phpqrcode/qrlib.php")){
        require "../static/php/phpqrcode/qrlib.php";
    }
        $link = "https://docs.google.com/forms/d/e/1FAIpQLSdV4YbMRe06eLGSxafhb2ZJdxskUnrLAQv22sSXstVCj3KunQ/viewform";
        $rutaQR = "../media/codigosQR/IEEEqr.png";
        $tamaño = 100;
        $level = "h";
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
