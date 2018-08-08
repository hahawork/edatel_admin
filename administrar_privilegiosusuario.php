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
?>

﻿<!DOCTYPE html>
<html lang="es">

    <!-- BEGIN HEAD -->
    <head>
        <meta charset="UTF-8" />
        <title>EDATEL | Administrar usuarios</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta content="" name="description" />
        <meta content="" name="Henrry Herrera Arauz" />
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
        <link href="assets/css/jquery-ui.css" rel="stylesheet" />
        <link href="assets/plugins/jquery-steps-master/demo/css/normalize.css" rel="stylesheet" />
        <link href="assets/plugins/jquery-steps-master/demo/css/wizardMain.css" rel="stylesheet" />
        <link href="assets/plugins/jquery-steps-master/demo/css/jquery.steps.css" rel="stylesheet" />  
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        
        <link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL  STYLES -->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="padTop53">
        <!-- MAIN WRAPPER -->
        <div id="wrap">
            <!-- HEADER SECTION -->
            <?php
            $_SESSION["seccion"] = 5;
            $_SESSION["item"] = 2;
            include './header.php';
            ?>
            <!--END MENU SECTION -->

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Administrar usuarios</h1>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Control de accesos
                                </div>
                                <div class="panel-body">
                                    <div id="wizard" >
                                        <h2> Usuarios </h2>
                                        <section style="overflow-y: auto;">
                                            <div class="w3-container w3-content">
                                                <?php
                                                $sql = "SELECT * FROM `tbl_usuariosaccesos` WHERE Estado = 1 ORDER BY Nombres";
                                                /* Si se ha de recuperar una gran cantidad de datos se emplea MYSQLI_USE_RESULT */
                                                if ($result = $conn->query($sql, MYSQLI_USE_RESULT)) {
                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                        $Idseleccionado = $row["Id_usuario"];
                                                        ?>
                                                        <div class="col-lg-4 col-sm-6">
                                                            <div class="w3-panel w3-white w3-card w3-display-container">
                                                                <label for="Usuario<?php echo $Idseleccionado ?>" class="w3-display-topright w3-padding w3-hover-red">
                                                                    <input type="radio" name="rdbIdUsuario" id="Usuario<?php echo $Idseleccionado ?>" onchange="onRBUsuariosChange(<?php echo $Idseleccionado ?>)">
                                                                </label>
                                                                <p class="w3-text-blue"><b><?php echo $row["Nombres"] . " " . $row["Apellidos"]; ?></b></p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>                                                                                                
                                            </div>
                                        </section>

                                        <?php
                                        //para sacar todos los menus principales
                                        $sql = "SELECT * FROM  `tbl_sistweb_menu` ORDER BY  `MenuPosicion`";
                                        if ($result = mysqli_query($conn, $sql)) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                <h2><i class="<?php echo $row["claseIcono"]; ?>"></i> <?php echo $row["DescMenu"]; ?> </h2>
                                                <section style="overflow-y: auto;">
                                                    <form action="" method="get" name="frmcheckboxs">
                                                        <?php
                                                        $sqlItem = "SELECT * FROM `tbl_sistweb_menu_items` WHERE `idMenu` = '" . $row["idMenu"] . "' ORDER BY itemPosic";
                                                        /* Si se ha de recuperar una gran cantidad de datos se emplea MYSQLI_USE_RESULT */
                                                        if ($resultItem = mysqli_query($conn, $sqlItem)) {
                                                            while ($rowItem = mysqli_fetch_assoc($resultItem)) {
                                                                
                                                                $onchange = $row["idMenu"] . "," . $rowItem["idMenuItem"]; // esto es pra los parametros del cambio d estado del checkbox
                                                                ?>
                                                                <div class="col-lg-4 col-sm-6">
                                                                    <div class="w3-panel w3-white w3-card w3-display-container">
                                                                        <label for="Item<?php echo $rowItem["idMenuItem"]; ?>" class="w3-display-topright w3-padding w3-hover-red">
                                                                            <input type="checkbox" name="chkIdItem" value="<?php echo $rowItem["idMenuItem"]; ?>" id="Item<?php echo $rowItem["idMenuItem"]; ?>" onchange="onCHKItemChanged(<?php echo $onchange ?>, this)">
                                                                        </label>
                                                                        <p class="w3-text-blue">
                                                                            <b>
                                                                                <i class="<?php echo $rowItem["claseIcono"]; ?>"></i> <?php echo $rowItem["DescItem"]; ?>
                                                                            </b>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        } else {
                                                            echo 'erorr ' . mysqli_error($conn);
                                                        }
                                                        ?>
                                                    </form>
                                                </section>

                                                <?php
                                            }
                                        }
                                        ?>                                       
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <!-- END PAGE CONTENT -->
        </div>
        <!--END MAIN WRAPPER -->
        <!-- FOOTER -->
        <div id="footer">
            <p>&copy;  EDATEL &nbsp;2018 &nbsp;</p>
        </div>
        <!--END FOOTER -->

        <!-- GLOBAL SCRIPTS -->
        <script src="assets/plugins/jquery-2.0.3.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <!-- END GLOBAL SCRIPTS -->

        <!-- PAGE LEVEL SCRIPT-->
        <script src="assets/plugins/jquery-steps-master/build/jquery.steps.js"></script>   
        <script src="assets/js/WizardInit.js"></script>
        
        <script src="assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
        <script src="assets/js/moreNoti.js" type="text/javascript"></script>
        
        <script src="funcionesjs/AgregarQuitarRolesUsuario.js" type="text/javascript"></script>
        <!--END PAGE LEVEL SCRIPT-->

        <script>
                                                                $(document).ready(function () {

                                                                });

        </script>
    </body>
    <!-- END BODY -->
</html>