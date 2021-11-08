<?php

function revisar_usuario() {
    return isset($_SESSION['usuario']);
}

function revisar_funcion() {
    return $_SESSION['funcion']=="seller";
}

function usuario_autenticado() {
    if (!revisar_usuario() || !revisar_funcion()) {
        header('location: login.php');
        exit();
    }
}

session_start();
usuario_autenticado();

?>