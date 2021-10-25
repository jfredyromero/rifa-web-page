<?php
include_once("../../functions/sessions.php");
include_once("../../templates/header.php");
include_once("../../templates/navbar.php");
include_once("../../templates/menu.php");
// Conexion a la base de datos
include_once("../../../static/connection/connection.php");
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista Boletas</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestion de membresias </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table id="registros" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Boleta</th>
                                        <th>Nombre</th>
                                        <th>Celular</th>
                                        <th>Correo</th>
                                        <th>Id transaccion</th>
                                        <th>Referido</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try {
                                        //code...
                                        $conn = mysqli_connect($host, $user, $pw, $db);
                                        $sql = "SELECT id, numero_boleta, comprador_nombre, comprador_celular, comprador_correo, id_transaccion, fecha_compra, referidos.referido FROM boletas LEFT JOIN referidos ON codigo_referido = referidos.codigo";
                                        $resultado = $conn->query($sql);
                                    } catch (Exception $e) {
                                        //throw $th;
                                        $error = $e->getMessage();
                                        echo $error;
                                    }
                                    while ($registro = $resultado->fetch_assoc()) { ?>

                                        <tr tr-id="<?php echo $registro['id']; ?>">
                                            <td> <?php echo $registro['numero_boleta']; ?> </td>
                                            <td> <?php echo $registro['comprador_nombre']; ?> </td>
                                            <td> <?php echo $registro['comprador_celular']; ?> </td>
                                            <td> <?php echo $registro['comprador_correo']; ?> </td>
                                            <td> <?php echo $registro['id_transaccion']; ?> </td>
                                            <td> <?php echo $registro['referido']; ?> </td>
                                            <td> <?php echo $registro['fecha_compra']; ?> </td>
                                            <td>
                                                <button data-id="<?php echo $registro['id']; ?>" data-tipo="ticket" class="btn bg-maroon btn-flat margin rounded borrar_registro">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Boleta</th>
                                        <th>Nombre</th>
                                        <th>Celular</th>
                                        <th>Correo</th>
                                        <th>Id transaccion</th>
                                        <th>Referido</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->


</div>


<?php
include_once("../../templates/footer.php");
?>