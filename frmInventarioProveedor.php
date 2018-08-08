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
        <title>EDATEL | Inventario parámetros</title>
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

            <?php
            $_SESSION["seccion"] = 4;
            $_SESSION["item"] = 5;
            include './header.php';
            ?>

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2> Inventario - proveedores </h2>
                        </div>
                    </div>

                    <hr />
                    <div class="row">

                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    PROVEEDORES                                    
                                </div>

                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <th><label for="txtId" class="label label-success">id:</label></th>
                                            <th><label for="txtNombre" class="label label-success">Nombre:</label></th>
                                            <th><label for="txtTelefono" class="label label-success">Telefono:</label></th>
                                            <th><label for="chkEstado" class="label label-success">Estado:</label></th>
                                        </tr>
                                        <tr>
                                            <td><input id="txtId" type="text" class="form-control" placeholder="Auto" disabled=""></td>
                                            <td><input id="txtNombre" type="text" class="form-control"></td>
                                            <td><input id="txtTelefono" type="text" class="form-control"></td>
                                            <td><input id="chkEstado" type="checkbox" class="form-control"></td>
                                        </tr>
                                        <tr><td colspan="4"><button id="btnGuardarProveedor" class="btn btn-primary pull-right" onclick="fnGuardarProveedor()">Guardar</button></td></tr>
                                    </table>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered over table-condensed" id="dataTables">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Nombre</th>
                                                    <th>Telefono</th>
                                                    <th>Estado</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM `tbl_invent_proveedores`";
                                                $result = mysqli_query($conn, $sql);
                                                if ($result) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $Estado = $row["Estado"];
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $row["idProveedor"]; ?></td> 
                                                            <td><?php echo $row["NombreProveedor"]; ?></td>
                                                            <td><?php echo $row["Telefono"]; ?></td>
                                                            <td><?php echo $Estado == 1 ? "Activo" : "Inactivo" ?></td>
                                                            <td>
                                                                <div>
                                                                    <button data-toggle="modal" 
                                                                            onclick="fnObtenerProveedor(
                                                                                            '<?php echo $row["idProveedor"]; ?>')" 
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
                                                                            $('#dataTables').DataTable({
                                                                                dom: 'Bfrtip',
                                                                                buttons: [
                                                                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                                                                ]
                                                                            });
                                                                        });</script>

        <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script>
                                                                        $(document).ready(function () {
                                                                            $('#dataTables').dataTable();
                                                                        });
        </script>
        <script>
            function fnGuardarProveedor() {
                //get
                var idProveedor = $('#txtId').val();
                var NombreProveedor = $('#txtNombre').val();
                var Telefono = $('#txtTelefono').val();
                var Estado = ($('#chkEstado').is(":checked")) ? 1 : 0;

                var metodo = idProveedor > 0 ? "EDITAR" : "GUARDAR";
                //Set
                //$('#txt_name').val(bla);
                if (NombreProveedor.length > 0) {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        url: "funciones/inventario_guardarproveedor.php?modo=administrar",
                        data: {
                            idProveedor: idProveedor,
                            NombreProveedor: NombreProveedor,
                            Telefono: Telefono,
                            Estado: Estado,
                            metodo: metodo
                        },
                        success: function (result) {
                            console.log(result);
                            if (result.success == 1) {
                                $('#txtId').val("");
                                $('#txtNombre').val("");
                                $('#txtTelefono').val("");
                                //refresca la tabla despues de insertar
                                $("#dataTables").load("frmInventarioProveedor.php #dataTables");
                                alert(result.message);
                            } else {
                                alert("erorr: " + result.error);
                            }
                        }

                    }).fail(function (jqXHR, textStatus, error) {
                        // Handle error here
                        alert("Error: " + jqXHR.responseText + ", .:. " + error);
                        //$('#editor-content-container').html(jqXHR.responseText);
                        //$('#editor-container').modal('show');
                    });
                } else {
                    alert("Por favor llene todos los campos.");
                }

            }
        </script>

        <script>
            function fnObtenerProveedor(idProveedor = 0) {

                if (idProveedor > 0) {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        url: "funciones/inventario_guardarproveedor.php?modo=obtener",
                        data: {
                            idProveedor: idProveedor
                        },
                        success: function (result) {
                            console.log(result);
                            if (result.success == 1) {
                                $('#txtId').val(result.idProveedor);
                                $('#txtNombre').val(result.NombreProveedor);
                                $('#txtTelefono').val(result.Telefono);
                                $('#chkEstado').prop('checked', result.Estado == 1 ? true : false);
                                alert(result.message);
                            } else {
                                alert("erorr: " + result.error);
                            }
                        }
                    }).fail(function (jqXHR, textStatus, error) {
                        // Handle error here
                        alert("Error: " + jqXHR.responseText + ", .:. " + error);
                        //$('#editor-content-container').html(jqXHR.responseText);
                        //$('#editor-container').modal('show');
                    });
            }
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