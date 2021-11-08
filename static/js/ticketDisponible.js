$("#inpSearch").on("input", function (e) {
    let num = "numTicket=" + $(this).val();

    console.log(num);

    $.ajax({
        type: "POST",
        data: num,
        url: "procesos/ticketDisponible.php",
        dataType: "json",
        success: function (data) {
            console.table(data);
            if (data.error == true) {
                console.log("red");
                $("#inpSearch").removeClass("border-gold");
                $("#inpSearch").addClass("border-danger");
                $("#btnSearch").prop("disabled", true);
                $("#avisoTicketComprado").text("Ticket "+$("#inpSearch").val()+" No disponible");
            } else {
                $("#inpSearch").removeClass("border-danger");
                $("#inpSearch").addClass("border-gold");
                $("#btnSearch").prop("disabled", false);
                $("#avisoTicketComprado").text("");
            }
        },
    });
});