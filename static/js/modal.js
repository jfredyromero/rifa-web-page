$(document).ready(function () {

    $("#btnOpen").on("click", function () {
        $("#card-popup").fadeIn("slow");
    });

    $(".btn-close").on("click", function (event) {
        let closeButton = $(event.target);
        closeButton.parent().parent().parent().parent().fadeOut("slow");
    });

    $("#btnAceptar").on("click", function () {
        $("#card-popup").fadeOut("slow");
    });

    $(".bg-close").on("click", function (event) {
        let bgClose = $(event.target);
        bgClose.parent().parent().fadeOut("slow");
    });
});