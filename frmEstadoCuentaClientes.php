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
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="es" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="es"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="UTF-8" />
        <title>Edatel | Estado de cuenta de clientes</title>
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
            $_SESSION["item"] = 3;
            include './header.php';
            ?>
            <!--END MENU SECTION -->

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">

                    <div class="col-sm-12">
                        <!-- efecto de carga -->
                        <link href="assets/css/efectoguardando.css" rel="stylesheet" type="text/css"/>
                        <div id="text">
                            <h1 id="h1"> CA<span id="offset">R</span>GA</h1>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <h2>Estado de cuenta</h2>

                        </div>
                    </div>
                    <hr />
                    <div class="row">


                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="selectrutas" class="control-label col-sm-3">Filtrar</label>
                                            <div class="col-sm-9">
                                                <select id="selectrutas" class="form-control">
                                                    <?php
                                                    $sqlrutas = "select * from tbl_ruta";
                                                    if ($resRutas = mysqli_query($conn, $sqlrutas)) {
                                                        while ($row = mysqli_fetch_assoc($resRutas)) {
                                                            ?>
                                                            <option value="<?php echo $row["nombre_ruta"] ?>"><?php echo $row["nombre_ruta"] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="panel-body">

                                    <div class="table-responsive">
                                        <table id="tblUsuarios" class="table table-bordered table-condensed table-striped">
                                            <thead>
                                                <tr>
                                                    <th>id cliente</th>
                                                    <th>Nombre</th>
                                                    <th>Telefono</th>
                                                    <th>Ruta</th>
                                                    <th>Saldo</th>
                                                    <th>Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody>

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

        <!-- Modal detalles de creditos-->
        <div class="modal fade" id="modalDetalleCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalNombre">Detalles de créditos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">

                            <label class="control-label col-md-2" for="txtmodalIdCliente">Id:</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtmodalIdCliente" disabled=""/>
                            </div>

                            <label for="txtmodalRuta" class="control-label col-md-2">Ruta:</label>
                            <div class="col-md-4">
                                <input type="text" id="txtmodalRuta" class="form-control" disabled="">
                            </div>
                        </div>

                        <div class="form-group"
                             <label for="txtmodalNombre" class="control-label">Nombre:</label>                            
                            <input type="text" id="txtmodalNombre" class="form-control" disabled="">                         
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="txtmodalNumPOS">Núm. POS:</label>                            
                            <input type="text" class="form-control" id="txtmodalNumPOS" disabled=""/>                                                       
                        </div>

                        <hr>

                        <div class="table-responsive">
                            <table id="tblmodalDetalleventasClientes" class="table table-condensed table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Id venta</th>
                                        <th>Fecha</th>
                                        <th>Vendido</th>
                                        <th>Cobrar</th>
                                        <th>Abonado</th>
                                        <th>Saldo</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!--                        <h5>Popover in a modal</h5>
                                                <p>This <a href="#" role="button" class="btn btn-secondary popover-test" title="Popover title" data-content="Popover body content is set in this attribute.">button</a> triggers a popover on click.</p>
                                                <hr>
                                                <h5>Tooltips in a modal</h5>
                                                <p><a href="#" class="tooltip-test" title="Tooltip">This link</a> and <a href="#" class="tooltip-test" title="Tooltip">that link</a> have tooltips on hover.</p>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <!--                        <button type="button" class="btn btn-primary">Save changes</button>-->
                    </div>
                </div>
            </div>
        </div>
        <!--  fin modal detalles de creditos--> 

        <!--modal para ingresar abonos-->
        <div class="modal fade" id="modalAbonarCredito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Abonar venta al créditos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group input-group col-sm-6">
                            <span class="input-group-addon">Cliente</span>
                            <input type="text" class="form-control" id="HiddentxtIdcliente" disabled=""/>
                            <span class="input-group-addon"><i class="icon-user"></i></span>
                        </div>
                        
                        <div class="form-group input-group col-sm-6">
                            <span class="input-group-addon">Venta</span>
                            <input type="text" class="form-control" id="HiddentxtIdVenta" disabled=""/>
                            <span class="input-group-addon"><i class="icon-home"></i></span>
                        </div>
                        
                        <div class="form-group input-group col-sm-6">
                            <span class="input-group-addon">Abono</span>
                            <input type="text" class="form-control" id="HiddentxtAbonado" disabled=""/>
                            <span class="input-group-addon">.00</span>
                        </div>
                        <div class="form-group input-group col-sm-6">
                            <span class="input-group-addon">Saldo</span>
                            <input type="text" class="form-control" id="HiddentxtSaldo" disabled=""/>
                            <span class="input-group-addon">.00</span>
                        </div>
                        
                        

                        <div class="form-group"
                             <label for="txtcantAbonar" class="control-label">Cantidad a abonar:</label>
                            <input type="number" id="txtcantAbonar" class="form-control">                         
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnmodalAbonar" onclick="fnAbonarVentaCredito()">Abonar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--fin modal ingresar abonos        -->

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

        <script src="funcionesjs/frmEstadoCuentaClientes.js" type="text/javascript"></script>       

        <!-- END PAGE LEVEL SCRIPTS -->
    </body>
    <!-- END BODY -->
</html>