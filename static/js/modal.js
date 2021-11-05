$(document).ready(function () {

    // $("#btnOpen").on("click", function () {
    //     $("#card-popup").fadeIn("slow");
    // });

    $(".btn-close").on("click", function (event) {
        let closeButton = $(event.target);
        closeButton.parent().parent().parent().parent().fadeOut("slow");
    ]    window.location.href = "https://ganatucarro.com";
    });

    $(".btnAceptar").on("click", function (event) {
        let aceptarButton = $(event.target);
        aceptarButton.parent().parent().parent().parent().fadeOut("slow");
        // window.location.href = "https://ganatucarro.com";
    });

    $("#btnAceptar").on("click", function () {
        document.getElementById('form-boleta').submit();
    });

    $(".bg-close").on("click", function (event) {
        let bgClose = $(event.target);
        bgClose.parent().parent().fadeOut("slow");
        // window.location.href = "https://ganatucarro.com";
    });
});