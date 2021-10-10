$(document).ready(function () {

    // Se abre el popup cada que se recarga la página
    // $("#card-popup").fadeIn("slow");

    // Descomentar si se quiere abrir el modal con un botón
    $("#btnOpen").on("click", function () {
        $("#card-popup").fadeIn("slow");
    });

    $("#btnClose").on("click", function () {
        $("#card-popup").fadeOut("slow");
    });

    $("#btnAceptar").on("click", function () {
        $("#card-popup").fadeOut("slow");
    });

    $("#bg-close").on("click", function () {
        $("#card-popup").fadeOut("slow");
    });
});