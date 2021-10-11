$(document).ready(function () {

    $("#btnOpen").on("click", function () {
        console.log("Abrir modal");
        $("#card-popup").fadeIn("slow");
    });

    $("#btnClose").on("click", function () {
        console.log("Cerrar modal")
        $("#card-popup").fadeOut("slow");
    });

    $("#btnAceptar").on("click", function () {
        $("#card-popup").fadeOut("slow");
    });

    $("#bg-close").on("click", function () {
        $("#card-popup").fadeOut("slow");
    });
});