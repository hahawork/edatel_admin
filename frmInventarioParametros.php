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
            $_SESSION["item"] = 6;
            include './header.php';
            ?>

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2> Inventario - parámetros </h2>
                        </div>
                    </div>

                    <hr />
                    <div class="row">

                        <div class="col-md-5">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    FAMILIA DE PRODUCTO  
                                    <button class="btn btn-success" data-toggle="modal" data-target="#ModalNuevaFamilia" onclick="fnLimpiarLlenarCamposFamilia()">
                                        <i class="icon-certificate"></i>
                                        Nueva familia
                                    </button>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered over table-condensed" id="dataTablesFamilia">
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

                        <div class="col-md-7">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    MARCAS DE PRODUCTOS 
                                    <a href="frmInventarioProducto.php">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#ModalNuevaMarca" onclick="fnLimpiarLlenarCamposMarca()">
                                            <i class="icon-certificate"></i>
                                            Nueva marca
                                        </button>
                                    </a>
                                </div>

                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-condensed" id="dataTablesMarcas">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Familia</th>
                                                    <th>Marca</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT m.`id_marca`, m.`id_catproducto`, tp.Descripcion, `DescMarca` FROM `tbl_invent_cat_marca` as m INNER JOIN tbl_invent_cat_tipoproducto as tp ON m.`id_catproducto` = tp.id_catproducto";
                                                $result = mysqli_query($conn, $sql);
                                                if ($result) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>                                                   
                                                        <tr>
                                                            <td><?php echo $row["id_marca"]; ?></td>
                                                            <td><?php echo $row["Descripcion"]; ?></td>
                                                            <td><?php echo $row["DescMarca"]; ?></td> 
                                                            <td>
                                                                <div>
                                                                    <button data-toggle="modal" data-target="#ModalNuevaMarca" 
                                                                            onclick="fnLimpiarLlenarCamposMarca(
                                                                                            '<?php echo $row["id_marca"]; ?>',
                                                                                            '<?php echo $row["id_catproducto"]; ?>',
                                                                                            '<?php echo $row["DescMarca"]; ?>')" 
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
                    <div class="row">
                        <div class="col-md-5">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    UNIDADES DE MEDIDAS                                      
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <th><label class="label label-success" for="txtIdUM">Id</label></th>
                                            <th><label class="label label-success" for="txtNombreUM">U. Medida</label></th>
                                            <th><label class="label label-success" for="txtAbrevUM">Abreviatura</label></th>
                                        </tr>
                                        <tr>
                                            <td><input class="form-control" type="number" disabled="" id="txtIdUM"></td>
                                            <td><input class="form-control" type="text" id="txtNombreUM"></td>
                                            <td><input class="form-control" type="text" id="txtAbrevUM"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <button class="btn btn-small btn-primary pull-right" id="btnGuardarUM" onclick="fnGuardarUnddMedida()">Guardar</button>
                                            </td>
                                        </tr>
                                    </table>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered over table-condensed" id="dataTablesUM">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Nombre</th>
                                                    <th>Abreviatura</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM `tbl_invent_undmedida`";
                                                $result = mysqli_query($conn, $sql);
                                                if ($result) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $row["idUndmedida"]; ?></td> 
                                                            <td><?php echo $row["NombreMedida"]; ?></td>
                                                            <td><?php echo $row["Abreviatura"]; ?></td>
                                                            <td>
                                                                <div>
                                                                    <button onclick="fnObtenerUndsMedida('<?php echo $row["idUndmedida"]; ?>')" 
                                                                            class="btn btn-success btn-small" data-toggle="tooltip" title="Editar">
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

            <!--  DIALOGOS MODALES-->
            <div class="modal fade" id="ModalNuevaFamilia" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="H1"> Familia</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form form-horizontal">
                                <div class="form-group">
                                    <label for="txtIdFamilia" class="control-label col-md-2">Id:</label>
                                    <div class="col-md-2">
                                        <input type="number" name="txtIdFamilia" id="txtIdFamilia" placeholder="Auto" class="form-control disabled" disabled="">    
                                    </div>

                                    <label for="txtDescFamilia" class="control-label col-md-2">Familia:</label>
                                    <div class="col-md-4">
                                        <input type="text" name="txtDescFamilia" id="txtDescFamilia" class="validate[required] form-control">    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="btnGuardarFamilia" onclick="fnGuardarFamilia()"> Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="ModalNuevaMarca" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="H1"> Marca</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form form-horizontal">
                                <div class="form-group">
                                    <label for="txtIdMarca" class="control-label col-md-3">Id:</label>
                                    <div class="col-md-3">
                                        <input type="number" name="txtIdMarca" id="txtIdMarca" placeholder="Auto" class="form-control disabled" disabled="">    
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="selectFamilia" class="control-label col-md-3">Familia:</label>
                                    <div class="col-md-9">
                                        <select type="text" name="selectFamilia" id="selectFamilia" class="form-control">
                                            <option value="0" disabled="" selected="">Seleccione familia</option>
                                            <?php
                                            $sql = "SELECT * FROM `tbl_invent_cat_tipoproducto`";
                                            $result = mysqli_query($conn, $sql);
                                            if ($result) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                    <option value="<?php echo $row["id_catproducto"]; ?>"> <?php echo $row["Descripcion"]; ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="txtMarca" class="control-label col-md-3">Marca:</label>
                                    <div class="col-md-9">
                                        <input type="text" name="txtMarca" id="txtMarca" class="form-control">    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="btnGuardarMarca" onclick="fnGuardarMarca()"> Guardar</button>
                        </div>
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

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
        
        <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
        
        <script src="funcionesjs/inventarioparametros.js" type="text/javascript"></script>
        
    </body>
    <!-- END BODY -->
</html>