<?php

function revisar_usuario() {

    return isset($_SESSION['usuario']);
}

function usuario_autenticado() {

    if (!revisar_usuario()) {
        # code...
        header('location: /rifa-web-page/admin/login.php');
        exit();
    }
}


session_start();
usuario_autenticado();

?>