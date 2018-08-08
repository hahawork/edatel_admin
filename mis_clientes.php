<?php
session_start();
require_once ('funciones/validaciones.php');
if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    redirect('login.php');
    exit;
}
require_once("conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();
$fechaConsulta = isset($_POST["rangoFechas"]) ? $_POST["rangoFechas"] : "";
$arrFechaConsulta = explode(",", trim($fechaConsulta, " "));
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="UTF-8" />
        <title>Edatel | Mis Clientes</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!--[if IE]>
           <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
           <![endif]-->
        <!-- GLOBAL STYLES -->
        <!-- GLOBAL STYLES -->
        <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="assets/css/theme.css" />
        <link rel="stylesheet" href="assets/css/MoneAdmin.css" />
        <link rel="stylesheet" href="assets/plugins/Font-Awesome/css/font-awesome.css" />
        <!--END GLOBAL STYLES -->

        <!-- PAGE LEVEL STYLES -->
        <link href="assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
        <link href="assets/plugins/daterangepicker/daterangepicker-bs2.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL  STYLES -->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="padTop53 " >

        <!-- MAIN WRAPPER -->
        <div id="wrap">
            <!-- HEADER SECTION -->
            <?php
            $_SESSION["seccion"] = 3;
            $_SESSION["item"] = 1;
            include './header.php';
            ?>
            <!--END MENU SECTION -->

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-lg-12">


                            <h2>Listado de Clientes</h2>



                        </div>
                    </div>

                    <hr />


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"> 

                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Punto de Venta</th>
                                                    <th>Propietario</th>
                                                    <th>Número</th>
                                                    <th>Ciudad</th>
                                                    <th>Ruta</th>
                                                    <th>Usuario</th>
                                                    <th>acción</th>
                                                </tr>
                                            </thead>
                                            <tbody style="overflow-y: auto;">
                                                <?php
                                                $sql = "SELECT * FROM `vw_puntosdeventa`";
                                                $res = mysqli_query($conn, $sql);
                                                if ($res) {

                                                    while ($row = mysqli_fetch_array($res)) {
                                                        echo '<tr>
                                                                  
                                                                  <td>' . strtoupper(($row['NombrePdV'])) . '</td>
                                                                  <td>' . strtoupper(($row['NombrePropietario'])) . '</td>
                                                                  <td>' . strtoupper(($row['NumeroPOS'])) . '</td>
                                                                  <td>' . strtoupper(($row['Ciudad'])) . '</td>
                                                                  <td>' . strtoupper(($row['nombre_ruta'])) . '</td>
                                                                  <td>' . strtoupper(($row['NombreUsuario'])) . '</td>
                                                                  <td>
                                                                  <table>
                                                                    <tr>
                                                                        <td><button type="button" id="btnEditCliente" class="btn btn-info btn-circle btn-grad"><i class="icon-edit"/></button></td>
                                                                        <td><button type="button" id="btnVerCliente" class="btn btn-success btn-circle btn-grad" data-toggle="modal" data-target="#exampleModal"><i class="icon-eye-open"/></button></td>
                                                                    </tr>
                                                                    </table>
                                                                   </td>
                                                                 </tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END PAGE CONTENT -->
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <h5>Popover in a modal</h5>
                            <p>This <a href="#" role="button" class="btn btn-secondary popover-test" title="Popover title" data-content="Popover body content is set in this attribute.">button</a> triggers a popover on click.</p>
                            <hr>
                            <h5>Tooltips in a modal</h5>
                            <p><a href="#" class="tooltip-test" title="Tooltip">This link</a> and <a href="#" class="tooltip-test" title="Tooltip">that link</a> have tooltips on hover.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--END MAIN WRAPPER -->

        <!-- FOOTER -->
        <div id="footer">
            <p>&copy;  binarytheme &nbsp;2014 &nbsp;</p>
        </div>
        <!--END FOOTER -->
        <!-- GLOBAL SCRIPTS -->
        <script src="assets/plugins/jquery-2.0.3.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <!-- END GLOBAL SCRIPTS -->
        <!-- PAGE LEVEL SCRIPTS -->
        <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
        </script>

        <!-- END PAGE LEVEL SCRIPTS -->
    </body>
    <!-- END BODY -->
</html>

