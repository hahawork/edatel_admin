<?php
session_start();
//Importamos el archivo con las validaciones.
require_once ('funciones/validaciones.php');
require_once("conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    redirect('login.php');
    exit;
}

$managua = new DateTimeZone("America/Managua");
$fechahoy = new DateTime("now", $managua);
$diahoy = $fechahoy->format("Y-m-d");
?>

﻿<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="es" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="es"> <!--<![endif]-->

    <!-- BEGIN HEAD -->
    <head>
        <meta charset="UTF-8" />
        <title>EDATEL | Linea de tiempo</title>
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
        <link rel="stylesheet" href="assets/plugins/social-buttons/social-buttons.css" />
        <!-- END PAGE LEVEL  STYLES -->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <!-- BEGIN HEAD -->

    <!-- BEGIN BODY -->
    <body class="padTop53 ">

        <!-- MAIN WRAPPER -->
        <div id="wrap">
            <!-- HEADER SECTION -->
           <?php
            $_SESSION["seccion"] = 1;
            $_SESSION["item"] = 2;
            include './header.php';
            ?>
            <!--END MENU SECTION -->

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2> Reporte Diario </h2>
                        </div>
                    </div>

                    <hr />
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="chat-panel panel panel-primary">
                                <div class="panel-heading">
                                    <i class="icon-asterisk"></i>
                                    Marcaciones

                                </div>

                                <div class="panel-body">
                                    <ul class="chat">

                                        <?php
                                        $sql = "SELECT * FROM `vw_visitasrealizadas` where Fecharegistro LIKE '$diahoy%'";
                                        $res = mysqli_query($conn, $sql);
                                        if ($res) {
                                            if (mysqli_num_rows($res) > 0) {
                                                while ($row = mysqli_fetch_array($res)) {
                                                    ?>
                                                    <li class="left clearfix">
                                                        <span class="chat-img pull-left">
                                                            <img src="assets/img/shop-icon.png" alt="User Avatar" class="img-circle" />
                                                        </span>
                                                        <div class="chat-body clearfix">
                                                            <div class="header">
                                                                <strong class="primary-font"><?php echo $row['NombrePdV'] ?></strong>
                                                                <small class="pull-right text-muted">
                                                                    <i class="icon-time"></i> <?php echo $row['Fecharegistro'] ?>
                                                                </small>
                                                            </div>

                                                            <p>
                                                                <?php echo $row['NombreUsuario'] ?>
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>


                                    </ul>
                                </div>

                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="chat-panel panel panel-primary">
                                <div class="panel-heading">
                                    <i class="icon-asterisk"></i>
                                    VENTAS

                                </div>

                                <div class="panel-body">
                                    <ul class="chat">

                                        <?php
                                        $sql = "SELECT * FROM `vw_ventasrealizadas` where FechaVenta LIKE '$diahoy%'";

                                        $res3 = mysqli_query($conn, $sql);
                                        if ($res3) {
                                            if (mysqli_num_rows($res3) > 0) {
                                                while ($row = mysqli_fetch_array($res3)) {
                                                    ?>
                                                    <li class="left clearfix">
                                                        <span class="chat-img pull-left">
                                                            <img src="assets/img/cordoba_nicaragua.png" alt="User Avatar" class="img-circle" />
                                                        </span>
                                                        <div class="chat-body clearfix">
                                                            <div class="header">
                                                                <strong class="primary-font"><?php echo $row['NombrePdV'] . " (" . $row['NumeroPOS'] . ")" ?></strong>
                                                                <small class="pull-right text-muted">
                                                                    <i class="icon-money"></i> <?php echo "C$" . $row['Cantidad'] ?>
                                                                </small>
                                                            </div>

                                                            <p>
                                                                <?php echo $row['NombreUsuario'] ?>
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>


                                    </ul>
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


    </body>
    <!-- END BODY -->
</html>
