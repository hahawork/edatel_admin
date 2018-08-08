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

$reportrange = isset($_POST['reportrange']) ? $_POST['reportrange'] : date("Y-m-d") . "," . date("Y-m-d");
$myArray = explode(',', $reportrange);
$FechaIni = $myArray[0]; //isset($_POST['txtFechaDesde']) ? $_POST['txtFechaDesde'] : null;
$FechaFin = $myArray[1]; //isset($_POST['txtFechaHasta']) ? $_POST['txtFechaHasta'] : null;
//$fechaConsulta = isset($_POST["rangoFechas"]) ? $_POST["rangoFechas"] : "";
//$arrFechaConsulta = explode(",", trim($fechaConsulta, " "));

function getDates($FechaIni, $FechaFin) {

    global $conn;

    $sql = "SELECT * FROM `vw_rpte_credito` WHERE FechaVenta BETWEEN '$FechaIni' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY) ORDER BY FechaVenta DESC ";
    $resultFecha = mysqli_query($conn, $sql);

    if ($resultFecha) {
        return $resultFecha;
    } else {
        
    }
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="UTF-8" />
        <title>EDATEL | Reporte de Crédito</title>
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
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
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
            $_SESSION["seccion"] = 2;
            $_SESSION["item"] = 3;
            include './header.php';
            ?>
            <!--END MENU SECTION -->

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2>Reporte de Crédito</h2>
                        </div>
                    </div>

                    <hr />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-success">

                                <div class="panel-heading"> 
                                    <div class="page-header">
                                        <form method="post" class="form-horizontal" action="rpte_credito.php">
                                            <div class="form-group col-sm-8">
                                                <label class="control-label col-sm-3" for="reportrange">Fecha</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="icon-calendar"></i></span>
                                                        <input type="text" class="form-control" value="<?php echo $reportrange ?>" id="reportrange" name="reportrange" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <input type="submit" name="btnConsultar" value="Consultar" class="btn btn-primary">
                                                <!-- <button type="submit" id="export_data" name="export_data" value="Export to excel" class="btn btn-info">Exportar a excel</button> -->
                                            </div>

                                       <!-- <input type="submit" class="btn btn-info" name="btnConsultar" value="Consultar">-->
                                        </form>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Vendedor</th>
                                                    <th>Propietario</th>
                                                    <th>Punto de Venta</th>
                                                    <th>Ruta</th>
                                                    <th>Número</th>
                                                    <th>Cantidad</th>
                                                    <th>Abono</th>
                                                    <th>saldo total</th>
                                                    <th>Fecha Venta</th>
                                                    <th>Fecha Abono</th>
                                                </tr>
                                            </thead>
                                            <tbody style="overflow-y: auto;">
                                                <?php
                                                try {
                                                    if (isset($_POST["btnConsultar"])) {

                                                        $result = getDates($FechaIni, $FechaFin);


                                                        if ($result) {

                                                            while ($row = mysqli_fetch_array($result)) {
                                                                echo '<tr>
                                                                    <td>' . strtoupper(($row['NombreUsuario'])) . '</td>
                                                                    <td>' . strtoupper(($row['NombrePropietario'])) . '</td>
                                                                    <td>' . strtoupper(($row['NombrePdV'])) . '</td>
                                                                    <td>' . strtoupper(($row['nombre_ruta'])) . '</td>
                                                                    <td>' . strtoupper(($row['NumeroPOS'])) . '</td>
                                                                    <td>' . strtoupper(($row['Cantidad'])) . '</td>
                                                                    <td>' . strtoupper(($row['cantidad_abono'])) . '</td>
                                                                    <td>' . strtoupper(($row['cantidad_saldo'])) . '</td>
                                                                    <td>' . strtoupper(($row['FechaVenta'])) . '</td>
                                                                    <td>' . strtoupper(($row['fecha_abono'])) . '</td>
                                                                    
                                                                    </tr>';
                                                            }
                                                        }
                                                    }
                                                } catch (Exception $e) {
                                                    echo 'Excepción capturada: ', $e->getMessage(), "\n";
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
        <!--END MAIN WRAPPER -->
        <!-- FOOTER -->
        <div id="footer">
            <p>Edatel 2018 </p>
        </div>
        <!--END FOOTER -->
        <!-- GLOBAL SCRIPTS -->
        <script src="assets/plugins/jquery-2.0.3.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <!-- END GLOBAL SCRIPTS -->
        <!-- PAGE LEVEL SCRIPTS -->
        <script src="assets/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="assets/plugins/daterangepicker/moment.js" type="text/javascript"></script>
        <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>

        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>


        <script src="funcionesjs/fnTablasReportes.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
    </body>
    <!-- END BODY -->
</html>



