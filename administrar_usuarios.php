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
            $_SESSION["item"] = 1;
            include './header.php';
            ?>
            <!--END MENU SECTION -->

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">Administrar usuarios</h1>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="panel panel-primary">

                                <div class="panel-heading"><i class="icon-plus"></i>

                                    <h5>Agregar usuario</h5>
                                </div>

                                <div class="panel-body">

                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#movil" data-toggle="tab">Móvil</a>
                                        </li>
                                        <li><a href="#admin" data-toggle="tab">Admin</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="movil">
                                            <form action="administrar_usuarios.php" method="post" class="form-horizontal"> 
                                                <div class="form-group">
                                                    <label for="textId" class="control-label col-md-2">Identificador</label>
                                                    <div class="col-md-4">
                                                        <input type="text" id="textId" class="form-control" disabled=""/>
                                                    </div> 
                                                </div>

                                                <div class="form-group">

                                                    <label for="textNombreCompleto" class="control-label col-md-2">Nombre Completo</label>
                                                    <div class="col-md-4">
                                                        <input type="text" id="textNombreCompleto" placeholder="Nombre Completo" class="form-control"/>
                                                    </div>

                                                    <label for="textEtiquetaMapa" class="control-label col-md-2">Etiqueta Mapa</label>
                                                    <div class="col-md-4">
                                                        <input type="text" id="textEtiquetaMapa" placeholder="AAAA" class="form-control"/> 
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="textCorreoElectronico" class="control-label col-md-2">Correo Electrónico</label>
                                                    <div class="col-md-4">
                                                        <input type="email" id="textCorreoElectronico" placeholder="Correo Electrónico" class="form-control"/>
                                                    </div>

                                                    <label for="textNumeroCelular" class="control-label col-md-2">Número Celular</label>
                                                    <div class="input-group col-md-4">
                                                        <input class="form-control" type="text" id="textNumeroCelular" placeholder="12345678" data-mask="99999999"/>
                                                        <span class="input-group-addon">00000000</span>
                                                    </div>  
                                                </div>

                                                <div class="form-group">
                                                   
                                                    <label class="control-label col-md-2" for="select_ruta">Ruta</label>
                                                    <div class="col-md-4">
                                                        <select name="select_ruta" id="select_ruta" class="validate[required] form-control">
                                                            <option value="0" disabled="disabled" selected="selected">Seleccione</option>
                                                            <?php
                                                            require_once("conexion/conexion.php");
                                                            $cnn = new conexion();
                                                            $conn = $cnn->conectar();
                                                            $sql = "SELECT * FROM tbl_ruta";
                                                            $resultado = mysqli_query($conn, $sql);
                                                            if ($resultado) {
                                                                if (mysqli_num_rows($resultado) > 0) {
                                                                    while ($rowTipo = mysqli_fetch_array($resultado)) :
                                                                        ?>
                                                                        <option value="<?php echo $rowTipo['id_ruta']; ?>"><?php echo ($rowTipo['nombre_ruta']); ?></option>
                                                                        <?php
                                                                    endwhile;
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    
                                                    <label for="chkEstadodelUsuario" class="control-label col-md-2">Estado del usuario</label>
                                                    <div class="col-md-4">
                                                        <input type="checkbox" checked="checked" id="chkEstadodelUsuario"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="btnGuardar" class="control-label col-md-5"></label>
                                                    <div class="col-md-3">
                                                        <button type="button" id="btnGuardar" class="btn btn-success" onclick="fnGuardarUsuarioNuevo()">
                                                            <i class="icon-save"> Guardar</i>
                                                        </button>

                                                        <button type="button" id="btnActualizar" class="btn btn-success" style="display: none;" onclick="fnActualizarUsuario()">
                                                            <i class="icon-refresh"> Actualizar</i>
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="admin">
                                            <form action="administrar_usuarios.php" method="post" class="form-horizontal"> 
                                                <div class="form-group">
                                                    <label for="textIdAdmin" class="control-label col-md-2">Identificador</label>
                                                    <div class="col-md-4">
                                                        <input type="text" id="textIdAdmin" class="form-control" disabled=""/>
                                                    </div> 
                                                </div>

                                                <div class="form-group">

                                                    <label for="textNombreAdmin" class="control-label col-md-2">Nombre</label>
                                                    <div class="col-md-4">
                                                        <input type="text" id="textNombreAdmin" class="form-control"/>
                                                    </div>

                                                    <label for="textApellidosAdmin" class="control-label col-md-2">Apellido</label>
                                                    <div class="col-md-4">
                                                        <input type="text" id="textApellidosAdmin" class="form-control"/> 
                                                    </div>
                                                </div>                                               

                                                <div class="form-group">

                                                    <label for="textPasswordAdmin" class="control-label col-md-2">Contraseña</label>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="password" id="textPasswordAdmin"/>
                                                    </div> 

                                                    <label for="textConfirmPasswAdmin" class="control-label col-md-2">Confirmar contraseña</label>
                                                    <div class="col-md-4">
                                                        <input type="password" id="textConfirmPasswAdmin" class="form-control" />
                                                    </div>

                                                </div>
                                                
                                                 <div class="form-group">
                                                    <label for="textEmailAdmin" class="control-label col-md-2">Correo Electrónico</label>
                                                    <div class="col-md-4">
                                                        <input type="email" id="textEmailAdmin" class="form-control"/>
                                                    </div>
                                                    
                                                     <label for="chkEstadodelAdmin" class="control-label col-md-2">Estado del usuario</label>
                                                    <div class="col-md-4">
                                                        <input type="checkbox" checked="checked" id="chkEstadodelAdmin"/>
                                                    </div>
                                                     
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="btnGuardarAdmin" class="control-label col-md-5"></label>
                                                    <div class="col-md-3">
                                                        <button type="button" id="btnGuardarAdmin" class="btn btn-success" onclick="fnGuardarUsuarioNuevoAdmin()">
                                                            <i class="icon-save"> Guardar</i>
                                                        </button>

                                                        <button type="button" id="btnActualizarAdmin" class="btn btn-success" style="display: none;" onclick="fnActualizarUsuario()">
                                                            <i class="icon-refresh"> Actualizar</i>
                                                        </button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a>Lista de Usuarios</a>
                                    </h4>
                                </div>

                                <div class="panel-body">

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-condensed" id="dataTables">
                                            <thead>
                                                <tr>
                                                    <th>Nombre Completo</th>
                                                    <th>Correo</th>
                                                    <th>Rol</th>
                                                    <th>Estado</th>
                                                    <th>Acciones</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM `tbl_edatel_usuarios`";
                                                $resultado = mysqli_query($conn, $sql);
                                                if ($resultado) {
                                                    while ($rowUsuario = mysqli_fetch_array($resultado)) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $rowUsuario["NombreUsuario"]; ?></td>
                                                            <td><?php echo $rowUsuario["Email"]; ?></td>
                                                            <td><?php echo $rowUsuario["Rol"]; ?></td>
                                                            <td><?php echo $rowUsuario["Estado"] == 1 ? "Activo" : "Inactivo"; ?></td>
                                                            <td>
                                                                <div>
                                                                    <button class="btn btn-success btn-small" id="btnEditUsuario" data-toggle="tooltip" title="Editar" onclick="fnObtenerUsuario('<?php echo $rowUsuario["idUsuario"]; ?>')"><i class="icon-edit"></i></button>
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
        <script src="assets/plugins/jasny/js/bootstrap-inputmask.js"></script>

        <script src="funcionesjs/administrar_usuarios.js" type="text/javascript"></script>
        <!--END PAGE LEVEL SCRIPT-->

    </body>
    <!-- END BODY -->
</html>