<?php
include_once("../../templates/header.php");
include_once("../../templates/navbar.php");
include_once("../../templates/menu.php");
?>

<!-- 

    FORMULARIO ADMINISTRADOR: 
    Datos visibles:
    -Número boleta: extra1
    -Nombre del dueño de la boleta: extra2
    -Cedula del dueño de la boleta: extra2
    -Ceular del dueño de la boleta: phone
    -Correo del dueño de la boleta: email_buyer

    Datos ocultos: 

    -Comprador ip: ip (capturar la ip del admin)
    -Referencia de pago: reference_pol (nombreAdmin01)
    -Referencia de venta: reference_sale ->md5(nombre-numeroBoleta-Date.now())
    -Id de transacción: transaction_id -> (00000000-0000-0000-0000-000000000000)
    -Codigo de referido: extra3 -> NULL
    -Fecha de compra: transaction_date -> Date.now()

    Lo que esta despues de los : es el nombre que debe tener el input


    Y la peticion se debe realizar a la pagina de confirmación, que ya esta programada para recibirla

    Un apunte importante es que el input de nombre 'extra2' lleva los datos del nombre y la cedula
    De la siguiente forma
    cedula-nombre
    1002970732-Jhon Fredy Romero
    Y también que ese campo referencia de pago, sea un dropdown que muestre a los administradores registrados en la pagina
-->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Agregar Membresía</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Agregar membresía</h3>
            </div>
            <div class="card-body">
                <form role="form" enctype="multipart/form-data" name="createTicket" id="formCreateTicket" method="post" action="ticketModel.php">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="usuario">Número Membresía</label>
                            <input type="number" class="form-control" id="ticketNumber" name="extra1" placeholder="Ingresa el número de la membresía" min="0" max="9999" onKeyPress="if(this.value.length==4) return false;" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre Comprador</label>
                            <input type="text" class="form-control" id="clientName" name="extra2-name" placeholder="Ingresa el nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Cédula Comprador</label>
                            <input type="text" class="form-control" id="clientCC" name="extra2-cc" placeholder="Ingresa la cédula" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Celular Comprador</label>
                            <input type="text" class="form-control" id="clientCel" name="phone" placeholder="Ingresa el celular" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Correo Comprador</label>
                            <input type="email" class="form-control" id="clientEmail" name="email_buyer" placeholder="Ingresa el email" required>
                        </div>

                        <!-- Datos Ocultos -->

                        <input type="hidden" name="ip">
                        <input type="hidden" name="reference_pol">
                        <input type="hidden" name="reference_sale">
                        <input type="hidden" name="transaction_id">
                        <input type="hidden" name="extra2">
                        <input type="hidden" name="extra3">
                        <input type="hidden" name="transaction_date">

                        
 
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <input type="hidden" name="registro" value="nuevo">
                        <button type="submit" id="btnCreateTicket" class="btn btn-primary">Añadir</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /. Main content -->

</div>


<?php
include_once("../../templates/footer.php");
?>