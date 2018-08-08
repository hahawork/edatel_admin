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
        <title>EDATEL | Inventario entradas</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />

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
        <link href="assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

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
            $_SESSION["seccion"] = 4;
            $_SESSION["item"] = 3;
            include './header.php';
            ?>
            <!--END MENU SECTION -->

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h2> Inventario - entrada por compras </h2>
                        </div>
                    </div>

                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    ENTRADA DE PRODUCTO POR COMPRA                                    
                                </div>

                                <div class="panel-body">

                                    <div class="col-md-12">

                                        <div class="form form-horizontal">
                                            <div class="form-group">
                                                <label for="txtProveedor" class="control-label col-sm-3">Proveedor:</label>
                                                <div class="form-group input-group">
                                                    <input type="text" class="form-control" id="txtProveedor"/>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default form-control" type="button">
                                                            <i class="icon-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="button" value="add" id="addbtn" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered over table-condensed" id="dataTablesEntradas">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Familia</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM `tbl_invent_cat_tipoproducto`";
                                                $result = mysqli_query($conn, $sql);
                                                if ($result) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $row["id_catproducto"]; ?></td> 
                                                            <td><?php echo $row["Descripcion"]; ?></td>   
                                                            <td>
                                                                <div>
                                                                    <button data-toggle="modal" data-target="#ModalNuevaFamilia" 
                                                                            onclick="fnLimpiarLlenarCamposFamilia(
                                                                                            '<?php echo $row["id_catproducto"]; ?>',
                                                                                            '<?php echo $row["Descripcion"]; ?>')" 
                                                                            class="btn btn-success btn-small" 
                                                                            data-toggle="tooltip" 
                                                                            title="Editar">
                                                                        <i class="icon-edit"></i>
                                                                    </button>
                                                                </div>    
                                                            </td>
                                                        </tr>

                                                        <?php
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

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
        <script>
                                                                        $(document).ready(function () {
                                                                            $('#dataTablesFamilia').DataTable({
                                                                                dom: 'Bfrtip',
                                                                                buttons: [
                                                                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                                                                ]
                                                                            });
                                                                        });
        </script>

        <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script>
                                                                        $(document).ready(function () {
                                                                            $('#dataTablesEntradas').dataTable();
                                                                            $('#addbtn').click(addrow);
                                                                        });

                                                                        function addrow() {
                                                                            $('#dataTablesEntradas').dataTable().fnAddData([
                                                                                $('#fname').val(),
                                                                                $('#lname').val(),
                                                                                $('#email').val()]);
                                                                        }

        </script>
        <script>

            function fnGuardarFamilia() {
                //get
                var IdFamilia = $('#txtIdFamilia').val();
                var Descripcion = $('#txtDescFamilia').val();
                //Set
                //$('#txt_name').val(bla);
                if (Descripcion.length > 0) {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        url: "funciones/inventario_guardanuevafamilia.php",
                        data: {
                            Descripcion: Descripcion,
                            id_catproducto: IdFamilia
                        },
                        success: function (result) {
                            console.log(result);
                            if (result.success === 1) {
                                $('#txtIdFamilia').val("");
                                $('#txtDescFamilia').val("");
                                //refresca la tabla despues de insertar
                                $("#dataTablesEntradas").load("frmInventarioParametros.php #dataTablesEntradas");
                                alert(result.message);
                            } else {
                                alert("erorr: " + result.error);
                            }
                        }
                    });
                } else {
                    alert("Por favor llene todos los campos.");
                }

            }

            function fnLimpiarLlenarCamposFamilia(idFamilia = "", Descripcion = "") {
                $('#txtIdFamilia').val(idFamilia);
                $('#txtDescFamilia').val(Descripcion);
            }
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <script>
            //esto es para el mensajito encima de un controol al pasar el mouse.
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
            //*****************************************************************
        </script>


    </body>
    <!-- END BODY -->
</html>