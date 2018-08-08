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
            $_SESSION["seccion"] = 8;
            $_SESSION["item"] = 1;
            include './header.php';
            ?>
            <!--END MENU SECTION -->
            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-lg-12">


                            <h2>Reporte de Visitas</h2>



                        </div>
                    </div>

                    <hr />


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Filtro de Fecha

                                    <form method="post" action="prueba.php" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="file" class="control-label col-sm-3">Seleccione archivo</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="file" id="file" class="form-control">
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-primary" name="upload" value="Subir">
                                    </form>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables">
                                            <thead>
                                                <tr>
                                                    <th>Fecha Trnf.</th>
                                                    <th>Tipo Trnf.</th>
                                                    <th>Usuario</th>
                                                    <th>idCliente</th>
                                                    <th>Cliente</th>
                                                    <th>Cant. Vendido</th>
                                                    <th>Cant. Crédito</th>
                                                    <th>Saldo Pend.</th>
                                                    <th>Ruta</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_REQUEST['upload'])) {
                                                    $ok = true;
                                                    if ($_FILES["file"]["error"] > 0) {
                                                        echo "Error: " . $_FILES["file"]["error"] . "<br>";
                                                    } else {

                                                        $mimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
                                                        if (in_array($_FILES['file']['type'], $mimes)) {
                                                            //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
                                                            //echo "Type: " . $_FILES["file"]["type"] . "<br>";
                                                            //echo "mime: " . mime_content_type("" . $_FILES["file"]["tmp_name"] . "") . "<br>";
                                                            //echo "Size: " . (($_FILES["file"]["size"] / 1024)/1024) . " MB<br>";

                                                            $file = $_FILES['file']['tmp_name'];
                                                            $handle = fopen($file, "r");
                                                            if ($file == NULL) {
                                                                error(_('Please select a file to import'));
                                                                redirect(page_link_to('admin_export'));
                                                            } else {
                                                                if (($getfile = fopen($file, "r")) !== FALSE) {
                                                                    $filesop = fgetcsv($getfile, 1000, ";");
                                                                    while (($filesop = fgetcsv($handle, 1000, ";")) !== false) {

                                                                        echo "<tr>
                                                                            <td>$filesop[0]</td>                                                    
                                                                            <td>$filesop[1]</td>
                                                                            <td>$filesop[2]</td>                                                   
                                                                            <td>".getidClienteByPOS(substr($filesop[3],strlen($filesop[3])-9,8))."</td>
                                                                            <td>$filesop[3]</td>
                                                                            <td>".str_replace("C$","",$filesop[4])."</td>                                                    
                                                                            <td>".str_replace("C$","",$filesop[5])."</td>
                                                                            <td>".str_replace("C$","",$filesop[14])."</td>
                                                                            <td>$filesop[15]</td>
                                                                        </tr>";
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            die("Sorry, mime type not allowed");
                                                        }
                                                    }
                                                }
                                                
                                                function getidClienteByPOS($param) {
                                                    global $conn;
                                                    $sql = "SELECT * FROM `tbl_puntosdeventa` WHERE `NumeroPOS` = '$param'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $row = mysqli_fetch_assoc($result);
                                                    return $row["idpdv"];
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
                var myTable = $('#dataTables').dataTable(
                        {
                            "language": {
                                "decimal": ".",
                                "thousands": ",",
                                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                            }
                        });


            });
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->
    </body>
    <!-- END BODY -->
</html>