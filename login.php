<?php
session_start();

//Importamos el archivo con las validaciones.
require_once ('funciones/validaciones.php');

//Guardamos los valores de los campos en las siguientes variables
$email = isset($_POST['correo']) ? $_POST['correo'] : null;
$Password = isset($_POST['pass']) ? $_POST['pass'] : null;

$errores = array();
$login_error = null;
$msg_error = null;

if (isset($_POST['btnEntrar'])) {

    require_once("conexion/conexion.php");
    $cnn = new conexion();
    $conn = $cnn->conectar();

// if (!validaRequerida($email)) {
//       $errores[] = 'El correo es Requerido';
// }
// if (!validaEmail($email)) {
//   $errores[] = 'La direccion de correo electronica es incorrecta';
//   }
//  if (!$errores) {

    $sql = "SELECT * FROM tbl_usuariosaccesos WHERE Email = '" . $email . "' AND Password = '" . md5($Password) . "' and Estado = 1";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row_count = $result->num_rows;

        if ($row_count > 0) {

            $user = mysqli_fetch_array($result);
            $_SESSION["sUserName"] = utf8_encode($user['Nombres'] . " " . $user['Apellido']);
            $_SESSION["sUserId"] = $user['Id_usuario'];
            $_SESSION["sUserEmail"] = $user['Email'];
            $_SESSION["sIdTipoUsuario"] = $user['IdTipoUsuario'];

            $login_error = null;

            if (strlen($_SESSION["sRedireccionar"]) > 0) {

                redirect($_SESSION['sRedireccionar']);
                $_SESSION["sRedireccionar"] = "";
            }
            redirect('index.php');
        }
    }else {
        echo mysqli_error($conn);
    }
    
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>EDATEL | Iniciar Sesión</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- GLOBAL STYLES -->
    <!-- PAGE LEVEL STYLES -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/login.css" />
    <link rel="stylesheet" href="assets/plugins/magic/magic.css" />
    <!-- END PAGE LEVEL STYLES -->


    <style type="text/css">

    body{
        background: url(https://sabadosporlatarde.files.wordpress.com/2016/06/d4313cb970fc063fc70638e4dc424fa5_large-1.jpeg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }

    #contenedor{
        background:rgba(255,255,255,0.5);
        border-radius: 50px;
        box-shadow: 4px 8px #aaa;
    }

</style>

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body>

    <!-- PAGE CONTENT --> 
    <div class="container">

        <div class="tab-content" id="contenedor">
            <div id="login" class="tab-pane active">

                <form method="POST" action="login.php" class="form-signin">

                    <img src="assets/img/logo1.png" id="logoimg" alt=" Logo" />
                    
                    
                    <h4>Por favor Ingrese sus Credenciales</h4>
                    <input type="text" placeholder="Correo" class="form-control" name="correo" />
                    <input type="password" placeholder="Password" class="form-control" name="pass"/>
                    <button class="btn text-muted text-center btn-danger" type="submit" name="btnEntrar">Entrar</button>
                </form>
            </div>
            <div style="position: relative;">
                <?php if ($errores): ?>
                    <div id='error_notification'>
                        <ul style="color: #f00;">
                            <?php foreach ($errores as $error): ?>
                                <li> <?php echo $error ?> </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>     
                <?php endif; ?>

            </div>

        </div>



    </div>

    <!-- PAGE LEVEL SCRIPTS -->
    <script src="assets/plugins/jquery-2.0.3.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="assets/js/login.js"></script>
    <!--END PAGE LEVEL SCRIPTS -->

</body>
<!-- END BODY -->
</html>