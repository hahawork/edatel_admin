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

function getDates($rangoFecha) {

    global $conn;

    $sql = "SELECT * FROM `vw_rpt_ventashechas` WHERE FechaVenta BETWEEN '$rangoFecha[0]' AND DATE_ADD('$rangoFecha[1]', INTERVAL 1 DAY) ORDER BY FechaVenta DESC ";
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
        <title>BCORE Admin Dashboard Template | Data Tables</title>
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
        
        <link href="assets/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
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
            <div id="top">
                <nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
                    <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                        <i class="icon-align-justify"></i>
                    </a>
                    <!-- LOGO SECTION -->
                    <header class="navbar-header">

                        <a href="index.php" class="navbar-brand">
                            <img src="assets/img/logo1.png" alt="" /></a>
                    </header>
                    <!-- END LOGO SECTION -->                 
                </nav>
            </div>
            <!-- END HEADER SECTION -->



            <!-- MENU SECTION -->
            <div id="left">
                <div class="media user-media well-small">
                    <a class="user-link" href="#">
                        <img class="media-object img-thumbnail user-img" alt="User Picture" src="assets/img/perfil-default.png" />
                    </a>
                    <br />
                    <div class="media-body">
                        <p><?php echo $_SESSION["sUserName"]; ?></p>
                        <ul class="list-unstyled user-info">

                            <li>
                                <a href="logout.php">
                                    <span class="btn btn-success btn-xs btn-circle" style="width: 10px;height: 12px;"> </span> Cerrar Sesión
                                </a>
                            </li>

                        </ul>
                    </div>
                    <br />
                </div>

                <ul id="menu" class="collapse">
                    <li class="panel">
                        <a href="index.php" ><i class="icon-dashboard"></i> Panel de Control</a>                   
                    </li>
                    <li class="panel"> 
                        <a href="visitas_lineatiempo.php" ><i class="icon-eye-open"></i> Visitas</a>                   
                    </li>
                    <li class="panel active">
                        <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#pagesr-nav">
                            <i class="icon-table"></i> Reportes

                            <span class="pull-right">
                                <i class="icon-angle-right"></i>
                            </span>

                        </a>
                        <ul class="collapse" id="pagesr-nav">
                            <li><a href="rpte_marcacion.php"><i class=" icon-map-marker"></i> Reporte de Visitas </a></li>
                            <li><a href="rpte_ventas.php"><i class=" icon-money"></i> Reporte de Ventas </a></li>
                        </ul>

                    </li>
                    <li class="panel">
                        <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#DDL-nav">
                            <i class=" icon-male"></i> Clientes

                            <span class="pull-right">
                                <i class="icon-angle-rigth"></i>
                            </span>
                        </a>
                        <ul class="collapse" id="DDL-nav">
                            <li>
                            <li><a href="mis_clientes.php"><i class="icon-file"></i>Mi Listado de Clientes</a></li>
                            <li><a href="ubicacion_clientes.php"><i class="icon-globe"></i> Ubicación Geografica</a></li>

                        </ul>
                    </li>
                    <li class="panel">
                        <a href="administrar_usuarios.php" ><i class="icon-group"></i> Administrar usuarios</a>                   
                    </li>

                    <li class="panel">
                        <a href="logout.php" ><i class="icon-off"></i> Cerrar Sesión</a>                   
                    </li>
                </ul>
            </div>
            <!--END MENU SECTION -->


            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-lg-12">


                            <h2>Reporte de Ventas</h2>



                        </div>
                    </div>

                    <hr />


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"> 
                                    <form method="post" class="form-inline" action="rpte_ventas.php">
                                        <!-- Date and time range -->
                                        <div class="form-group">                                            
                                            <div id="rangofecha" class="input-group">
                                                <label for="rangofecha" class="label-primary input-group-addon">Fecha</label>
                                                <input type="text" name="rangoFechas" value="<?php echo $fechaConsulta ?>" class="btn btn-default" id="daterange-btn">
                                            </div>

                                        </div>
                                        <!-- /.form group -->
                                        <input type="submit" class="btn btn-info" name="btnConsultar" value="Consultar">
                                    </form>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="example" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Vendedor</th>
                                                    <th>Ruta</th>
                                                    <th>Punto de Venta</th>
                                                    <th>Propietario</th>
                                                    <th>Número</th>
                                                    <th>Cantidad</th>
                                                    <th>Tipo de Venta</th>
                                                    <th>Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody style="overflow-y: auto;">
                                                <?php
                                                try {
                                                    if (isset($_POST["btnConsultar"]) and count($arrFechaConsulta) > 1) {

                                                        $result = getDates($arrFechaConsulta);


                                                        if ($result) {

                                                            while ($row = mysqli_fetch_array($result)) {
                                                                echo '<tr>
                                                                  <td>' . strtoupper(($row['NombreUsuario'])) . '</td>
                                                                 <td>' . strtoupper(($row['nombre_ruta'])) . '</td>
                                                                  <td>' . strtoupper(($row['NombrePdV'])) . '</td>
                                                                  <td>' . strtoupper(($row['Propietario'])) . '</td>
                                                                  <td>' . strtoupper(($row['NumeroPOS'])) . '</td>
                                                                  <td>' . strtoupper(($row['Cantidad'])) . '</td>
                                                                  <td>' . strtoupper(($row['TipoVenta'])) . '</td>
                                                                  <td>' . strtoupper(($row['FechaVenta'])) . '</td>
                                                                
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
            <p>&copy;  Edatel &nbsp;2018 &nbsp;</p>
        </div>
        <!--END FOOTER -->
        <!-- GLOBAL SCRIPTS -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"> </script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
        
        <script src="assets/plugins/jquery-2.0.3.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <!-- END GLOBAL SCRIPTS -->
        <!-- PAGE LEVEL SCRIPTS -->
        <script src="assets/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="assets/plugins/daterangepicker/moment.js" type="text/javascript"></script>
        <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>

        <script>
            //priority: success, info, warning, danger
            $('#daterange-btn').daterangepicker(
                    {
                        ranges: {
                            'Hoy': [moment(), moment()],
                            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Últ. 7 Días': [moment().subtract(6, 'days'), moment()],
                            'Últ. 30 Dias': [moment().subtract(29, 'days'), moment()],
                            'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                            'Últ. mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        startDate: moment().subtract(29, 'days'),
                        endDate: moment()
                    },
            function(start, end) {
                //$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#daterange-btn').val(start.format('YYYY-MM-DD') + ',' + end.format('YYYY-MM-DD'));
            }


            );
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });
        </script>
        
        



        <!-- END PAGE LEVEL SCRIPTS -->
    </body>
    <!-- END BODY -->
</html>


