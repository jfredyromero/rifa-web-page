<?php

include_once("./templates/header.php");
include_once("./functions/sessions.php");
include_once("./templates/navbar.php");
include_once("./templates/menu.php");
// Conexion a la base de datos
include_once("../static/connection/connection.php");
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inicio</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Tarjetas Info -->
        <div class="row">

            <!-- col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">

                        <?php
                        try {
                            //code...
                            $conn = mysqli_connect($host, $user, $pw, $db);
                            $sql = "SELECT COUNT(*) as TOTAL FROM boletas";
                            $resultado = $conn->query($sql);
                            $num = $resultado->fetch_assoc();
                        } catch (Exception $e) {
                            //throw $th;
                            $error = $e->getMessage();
                            echo $error;
                        }
                        ?>
                        <h3><?php print_r($num['TOTAL']); ?><sup style="font-size: 25px"></sup></h3>
                        <p>Membresias Vendidas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <a href="views/ticket/readTicket.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

        </div>
        <!-- /. Tarjetas Info -->


    </section>
    <!-- /. Main content -->
</div>
<!-- /.content-wrapper -->

<?php

include_once("templates/footer.php");

?>