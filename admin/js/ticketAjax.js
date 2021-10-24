$(document).ready(function () {

    $("#formCreateTicket").on("submit", function (e) {

        e.preventDefault();

        let num = $("input[name='extra1']").val().toString();

        while (num.length < 4) { num = "0" + num; }

        $("input[name='extra1']").val(num);

        $("input[name='extra2']").val($("input[name='extra2-cc']").val() + "-" + $("input[name='extra2-name']").val());

        $("input[name='ip']").val(myip);

        let nombreAdmin = "Freddy";

        $("input[name='reference_pol']").val(nombreAdmin + "01");

        $("input[name='reference_sale']").val(md5($("input[name='extra2-name']").val() + '-' + $("input[name='extra1']").val() + '-' + Date.now()));

        $("input[name='transaction_id']").val("00000000-0000-0000-0000-000000000000");

        $("input[name='extra3']").val(null);

        $("input[name='transaction_date']").val(formatDate(new Date()));


        let formData = $(this).serialize();
        var sweet_loader = '<div style="width:100%; position:relative; height:100%; display:flex; flex-direction: column; justify-content: center; align-items: center;"><img height="60%" src="../../img/timer.gif"></div>';
        $.ajax({
            type: "POST",
            data: formData,
            url: "ticketModel.php",
            dataType: "json",
            beforeSend: function() {
                swal.fire({
                    title: "Cargando...",
                    html: sweet_loader,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    onRender: function() {
                        // there will only ever be one sweet alert open.
                        $('.swal2-content').prepend(sweet_loader);
                    }
                });
            },
            success: function (data) {
                if (data.respuesta == "error") {
                    Swal.fire({
                        title: "Oops...",
                        text: "La memebresía no esta disponible",
                        icon: "error",
                    });
                } else {
                    Swal.fire({
                        title: "CORRECTO",
                        text: "Registro Exitoso",
                        icon: "success",
                    }).then((result) => {
                        window.location.href = "readTicket.php";
                    });
                }
            }
        })

    });

    $("#ticketNumber").on("input",function (e) {
        
        let num = "extra1="+$(this).val();
        
        $.ajax({
            type: "POST",
            data: num,
            url: "ticketValidate.php",
            dataType: "json",
            success: function (data) {
                console.table(data);
                if (data.error == true) {
                    console.log("red");
                    $("#ticketNumber").removeClass("border-success");
                    $("#ticketNumber").addClass("border-danger");
                    $("#btnCreateTicket").prop('disabled', true)
                } else {
                    $("#ticketNumber").removeClass("border-danger");
                    $("#ticketNumber").addClass("border-success");
                    $("#btnCreateTicket").prop('disabled', false);
                    
                }
            }
        });

    });

    $(".borrar_registro").on("click", function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var tipo = $(this).attr("data-tipo");

        console.log(id);
        console.log(tipo);

        Swal.fire({
            title: "¿Seguro que desea eliminar este registro?",
            text: "Esta accion no se podrá deshacer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar!",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    data: {
                        id: id,
                        registro: "eliminar",
                    },
                    url: tipo + "Model.php",
                    success: function (data) {
                        console.table(data)             
                        jQuery('[data-id="' + data.id_eliminado + '"]').parents("tr").remove();
                    },
                });
                Swal.fire("Eliminado!", "Registro eliminado correctamente", "success");
            }
        });
    });

    const formatDate = (current_datetime)=>{
        let formatted_date = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds();
        return formatted_date;
    }

});

