<?php
session_start();
//Importamos el archivo con las validaciones.
require_once ('funciones/validaciones.php');
require_once("conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"] . "?modo=Lista";
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
        <title>EDATEL | Inventario producto</title>
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
            <!-- HEADER SECTION -->
            <?php
            $_SESSION["seccion"] = 4;
            $_SESSION["item"] = (isset($_GET["modo"]) and $_GET["modo"] == "Lista") ? 1 : 2;
            include './header.php';
            ?>
            <!--END MENU SECTION -->

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2> Inventario - productos </h2>
                        </div>
                    </div>

                    <hr />
                    <div class="row">
                        <?php
                        if (isset($_GET['modo'])) {
                            $modo = $_GET["modo"];
                            if ($modo == 'Lista') {
                                ?>
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <i class="icon-asterisk"></i>
                                            Productos 
                                            <a href="frmInventarioProducto.php?modo=Nuevo"><button class="btn btn-success"><i class="icon-asterisk"></i>Nuevo</button></a>
                                        </div>

                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover table-condensed" id="dataTables">
                                                    <thead>
                                                        <tr>
                                                            <th>Categoria</th>
                                                            <th>Marca</th>
                                                            <th>Producto</th>
                                                            <th>Color</th>
                                                            <th>Stock</th>
                                                            <th>Stock minimo</th>
                                                            <th>P. Compra</th>
                                                            <th>P. Venta</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT * FROM `vw_listadoproductosinventario`";
                                                        $result = mysqli_query($conn, $sql);
                                                        if ($result) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                ?>

                                                                <tr>
                                                                    <td><?php echo $row["Descripcion"] ?></td>
                                                                    <td><?php echo $row["DescMarca"] ?></td>
                                                                    <td><?php echo $row["NombreModelo"] ?></td>
                                                                    <td><?php echo $row["Color"] ?></td>
                                                                    <!-- si el estock esta bajo el minimo se pone la clase warning-->
                                                                    <?php
                                                                    $StockMinimo = $row["StockMinimo"];
                                                                    $Stock = $row["Stock"];
                                                                    ?>
                                                                    <td class="<?php echo $Stock <= $StockMinimo ? 'danger' : '' ?>"><?php echo $Stock; ?></td>
                                                                    <td><?php echo $StockMinimo; ?></td>
                                                                    <td><?php echo $StockMinimo * 20; ?></td>
                                                                    <td><?php echo $row["Precio"] ?></td>
                                                                    <td>
                                                                        <div>
                                                                            <a href="frmInventarioProducto.php?modo=Editar&p=<?php echo $row["id_producto"] ?>" class="btn btn-success btn-small" data-toggle="tooltip" title="Editar"><i class="icon-edit"></i></a>
                                                                            <button class="btn btn-danger btn-small" data-toggle="tooltip" title="Borrar"><i class="icon-trash"></i></button>
                                                                            <button class="btn btn-info btn-small" data-toggle="tooltip" title="Detalles"><i class="icon-list-alt"></i></button>
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

                                <?php
                            } elseif ($modo == 'Nuevo') {
                                ?>
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <i class="icon-asterisk"></i>
                                            Productos
                                        </div>

                                        <div class="panel-body">
                                            <form class="form-horizontal">

                                                <div class="form-group">
                                                    <label for="txtIdProducto" class="control-label col-sm-2">Id:</label>
                                                    <div class="col-sm-4">
                                                        <input type="number" name="txtIdProducto" placeholder="Auto" disabled="" id="txtIdProducto" class="form-control">
                                                    </div>
                                                    <label for="txtColor" class="control-label col-sm-2">Color:</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" list="ColoresProducto" name="txtColor" id="txtColor" class="form-control">
                                                        <datalist id="ColoresProducto">
                                                            <?php
                                                            $sql = "SELECT DISTINCT Color FROM `tbl_invent_producto`";
                                                            $result = mysqli_query($conn, $sql);
                                                            if ($result) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    ?>
                                                                    <option value="<?php echo $row["Color"]; ?>">
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                        </datalist>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="selectFamilia" class="control-label col-md-2">Familia:</label>
                                                    <div class="col-md-4">
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
                                                    <label for="selectMarca" class="control-label col-md-2">Marca:</label>
                                                    <div class="col-md-4">
                                                        <select type="text" name="selectMarca" id="selectMarca" class="form-control">
                                                            <option value="0" disabled="" selected="">Seleccione Marca</option>                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtNumeroModelo" class="control-label col-md-2">Número Modelo:</label>
                                                    <div class="col-md-4">
                                                        <input type="text" id="txtNumeroModelo" class="form-control">
                                                    </div>
                                                    <label for="txtNombreModelo" class="control-label col-md-2">Nombre producto:</label>
                                                    <div class="col-md-4">
                                                        <input type="text" id="txtNombreModelo" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="txtStock" class="control-label col-md-2">Stock:</label>
                                                    <div class="col-md-4">
                                                        <input type="number" id="txtStock" class="form-control">
                                                    </div>
                                                    <label for="txtStockMinimo" class="control-label col-md-2">Stock mínimo:</label>
                                                    <div class="col-md-4">
                                                        <input type="number" id="txtStockMinimo" class="form-control">
                                                    </div>                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtPrecioCompra" class="control-label col-md-2">Precio compra:</label>
                                                    <div class="col-md-4">
                                                        <input type="number" id="txtPrecioCompra" class="form-control">
                                                    </div>
                                                    <label for="txtPrecioVenta" class="control-label col-md-2">Precio venta:</label>
                                                    <div class="col-md-4">
                                                        <input type="number" id="txtPrecioVenta" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">   
                                                    <label for="selectUmedida" class="control-label col-md-2">U. medida:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" id="selectUmedida">

                                                        </select>
                                                    </div>
                                                    <label for="chkEstado" class="control-label col-md-2">Estado:</label>
                                                    <div class="col-md-4">
                                                        <input type="checkbox" id="chkEstado" class="form-control">
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="panel-footer">
                                                <button class="btn btn-success" onclick="fnGuardarProducto()"><i class="icon-save"></i> Guardar </button>
                                                <a class="btn btn-success" href="frmInventarioProducto.php?modo=Lista"><i class="icon-remove-sign"></i> Cancelar </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } elseif ($modo == 'Editar') {
                                if (isset($_GET["p"])) {

                                    $idProducto = $_GET["p"];
                                    $sql = "SELECT * FROM `tbl_invent_producto` WHERE id_producto = '$idProducto'";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result) {
                                        if (mysqli_num_rows($result) > 0) {
                                            $producto = mysqli_fetch_assoc($result);

                                            $id_producto = $producto["id_producto"];
                                            $idMarca = $producto["idMarca"];
                                            $Modelo = $producto["Modelo"];
                                            $NombreModelo = $producto["NombreModelo"];
                                            $Color = $producto["Color"];
                                            $id_cat_tipoproducto = $producto["id_cat_tipoproducto"];
                                            $Stock = $producto["Stock"];
                                            $StockMinimo = $producto["StockMinimo"];
                                            $Precio = $producto["Precio"];
                                            $Estado_activo = $producto["Estado_activo"];
                                            ?>
                                            <div class="col-md-12">
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        <i class="icon-asterisk"></i>
                                                        Productos
                                                    </div>

                                                    <div class="panel-body">
                                                        <form class="form-horizontal">

                                                            <div class="form-group">
                                                                <label for="txtIdProducto" class="control-label col-sm-2">Id:</label>
                                                                <div class="col-sm-4">
                                                                    <input type="number" disabled="" id="txtIdProducto" class="form-control" value="<?php echo $id_producto; ?>">
                                                                </div>
                                                                <label for="txtColor" class="control-label col-sm-2">Color:</label>
                                                                <div class="col-sm-4">
                                                                    <input type="text" list="ColoresProducto" name="txtColor" id="txtColor" class="form-control" value="<?php echo $Color; ?>">
                                                                    <datalist id="ColoresProducto">
                                                                        <?php
                                                                        $sql = "SELECT DISTINCT Color FROM `tbl_invent_producto`";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        if ($result) {
                                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                                ?>
                                                                                <option value="<?php echo $row["Color"]; ?>">
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                    </datalist>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="selectFamilia" class="control-label col-md-2">Familia:</label>
                                                                <div class="col-md-4">
                                                                    <select type="text" name="selectFamilia" id="selectFamilia" class="form-control">
                                                                        <option value="0" disabled="" selected="">Seleccione familia</option>
                                                                        <?php
                                                                        $sql = "SELECT * FROM `tbl_invent_cat_tipoproducto`";
                                                                        $result = mysqli_query($conn, $sql);
                                                                        if ($result) {
                                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                                echo '<option value="' . $row["id_catproducto"] . '">' . $row["Descripcion"] . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <label for="selectMarca" class="control-label col-md-2">Marca:</label>
                                                                <div class="col-md-4">
                                                                    <select type="text" name="selectMarca" id="selectMarca" class="form-control" >
                                                                        <option value="0" disabled="" selected="">Seleccione Marca</option>                                                            
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="txtNumeroModelo" class="control-label col-md-2">Número Modelo:</label>
                                                                <div class="col-md-4">
                                                                    <input type="text" name="txtNumeroModelo" id="txtNumeroModelo" class="form-control" value="<?php echo $Modelo; ?>">
                                                                </div>
                                                                <label for="txtNombreModelo" class="control-label col-md-2">Nombre producto:</label>
                                                                <div class="col-md-4">
                                                                    <input type="text" name="txtNombreModelo" id="txtNombreModelo" class="form-control" value="<?php echo $NombreModelo; ?>">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="txtStock" class="control-label col-md-2">Stock:</label>
                                                                <div class="col-md-4">
                                                                    <input type="number" id="txtStock" class="form-control" value="<?php echo $Stock; ?>">
                                                                </div>
                                                                <label for="txtStockMinimo" class="control-label col-md-2">Stock mínimo:</label>
                                                                <div class="col-md-4">
                                                                    <input type="number" id="txtStockMinimo" class="form-control" value="<?php echo $StockMinimo; ?>">
                                                                </div>                                                                
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="txtPrecioCompra" class="control-label col-md-2">Precio compra:</label>
                                                                <div class="col-md-4">
                                                                    <input type="number" id="txtPrecioCompra" class="form-control">
                                                                </div>
                                                                <label for="txtPrecioVenta" class="control-label col-md-2">Precio venta:</label>
                                                                <div class="col-md-4">
                                                                    <input type="number" id="txtPrecioVenta" class="form-control" value="<?php echo $Precio; ?>">
                                                                </div>

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="selectUmedida" class="control-label col-md-2">U. medida:</label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control" id="selectUmedida">

                                                                    </select>
                                                                </div>
                                                                <label for="chkEstado" class="control-label col-md-2">Estado:</label>
                                                                <div class="col-md-4">
                                                                    <input type="checkbox" id="chkEstado" class="form-control" <?php echo $Estado_activo == 1 ? "checked=''" : ""; ?>>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <div class="panel-footer">
                                                            <button class="btn btn-success" onclick="fnEditarProducto()"><i class="icon-save"></i> Actualizar </button>
                                                            <a class="btn btn-success" href="frmInventarioProducto.php?modo=Lista"><i class="icon-remove-sign"></i> Cancelar </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }   // fin si numero filas del resultado es mayor que cero
                                    }   // fin si result la consulta
                                }   //fin isset($_GET["p"])
                            }   // fin else modo editar 
                        } else {
                            ?>
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <i class="icon-asterisk"></i>
                                        Productos
                                    </div>

                                    <div class="panel-body">
                                        <a href="frmInventarioProducto.php?modo=Lista"><button class="btn btn-success">Lista</button></a>
                                        <a href="frmInventarioProducto.php?modo=Nuevo"><button class="btn btn-success">Nuevo</button></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

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
                                                                });
        </script>

        <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script>
                                                                $(document).ready(function () {
                                                                $('#dataTables').dataTable();
                                                                });
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <script>
            
            $(function () {
                $('#dataTables').DataTable();
            });
        </script>
        <script>
            $(function () {
            $(document).on("change", "#selectFamilia", function () {
            $.ajax({
            url: 'funciones/inventario_getmarcaXfamilia.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {id_catproducto: $(this).val()},
            })
                    .done(function(response) {
                    if (response.success) {
                    $("#selectMarca").html(response.options);
                    } else {
                    $("#selectMarca").html("<option disabled='' selected='' value='0'>No hay marcas</option>");
                    }
                    })
                    .fail(function(data) {
                    alert("Algo ha salido mal. " + data.responseText);
                    });
            });
            });
        </script>

        <script>
            function fnGuardarProducto (){

            var idMarca = $("#selectMarca").val();
            var Modelo = $("#txtNumeroModelo").val();
            var NombreModelo = $("#txtNombreModelo").val();
            var Color = $("#txtColor").val();
            var id_cat_tipoproducto = $("#selectFamilia").val();
            var Stock = $("#txtStock").val();
            var StockMinimo = $("#txtStockMinimo").val();
            var Precio = $("#txtPrecioVenta").val();
            var Estado_activo = ($("#chkEstado").is(":checked")) ? 1 : 0;
            if (id_cat_tipoproducto > 0 &&
                    idMarca > 0 &&
                    NombreModelo.length > 0
                    ){
            $.ajax({
            url: 'funciones/inventario_guardarproducto.php',
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data: {idMarca: idMarca,
                            Modelo: Modelo,
                            NombreModelo: NombreModelo,
                            Color: Color,
                            id_cat_tipoproducto: id_cat_tipoproducto,
                            Stock: Stock,
                            StockMinimo: StockMinimo,
                            Precio: Precio,
                            Estado_activo: Estado_activo
                    },
            })
                    .done(function(response) {
                    if (response.success) {
                    $("#selectMarca").val("0");
                    $("#txtNumeroModelo").val("");
                    $("#txtNombreModelo").val("");
                    $("#txtColor").val("");
                    $("#selectFamilia").val("0");
                    $("#txtStock").val("");
                    $("#txtStockMinimo").val("");
                    $("#txtPrecioVenta").val("");
                    alert(response.message);
                    } else {

                    }
                    })
                    .fail(function(data) {
                    alert("Algo ha salido mal. " + data.responseText);
                    });
            }
            }
        </script>

        <script>
            function fnEditarProducto (){
            var id_producto = $("#txtIdProducto").val();
            var idMarca = $("#selectMarca").val();
            var Modelo = $("#txtNumeroModelo").val();
            var NombreModelo = $("#txtNombreModelo").val();
            var Color = $("#txtColor").val();
            var id_cat_tipoproducto = $("#selectFamilia").val();
            var Stock = $("#txtStock").val();
            var StockMinimo = $("#txtStockMinimo").val();
            var Precio = $("#txtPrecioVenta").val();
            var Estado_activo = ($("#chkEstado").is(":checked")) ? 1 : 0;
            if (
                    id_producto > 0 &&
                    id_cat_tipoproducto > 0 &&
                    idMarca > 0 &&
                    NombreModelo.length > 0
                    ) {
            $.ajax({
            url: 'funciones/inventario_editarproducto.php',
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data: {id_producto: id_producto,
                            idMarca: idMarca,
                            Modelo: Modelo,
                            NombreModelo: NombreModelo,
                            Color: Color,
                            id_cat_tipoproducto: id_cat_tipoproducto,
                            Stock: Stock,
                            StockMinimo: StockMinimo,
                            Precio: Precio,
                            Estado_activo: Estado_activo
                    },
            })
                    .done(function (response) {
                    if (response.success) {
                    $("#selectMarca").val("0");
                    $("#txtNumeroModelo").val("");
                    $("#txtNombreModelo").val("");
                    $("#txtColor").val("");
                    $("#selectFamilia").val("0");
                    $("#txtStock").val("");
                    $("#txtStockMinimo").val("");
                    $("#txtPrecioVenta").val("");
                    alert(response.message);
                    window.location.replace("frmInventarioProducto.php?modo=Lista");
                    } else {

                    }
                    })
                    .fail(function (data) {
                    alert("Algo ha salido mal. " + data.responseText);
                    });
            }
            }
            
            //esto es para el mensajito encima de un controol al pasar el mouse.
            $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            });
            //*****************************************************************

        </script>
    </body>
    <!-- END BODY -->
</html>