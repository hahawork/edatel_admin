<?php

session_start();
//Importamos el archivo con las validaciones.
require_once ('../funciones/validaciones.php');
require_once("../conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (!$_SESSION["sUserId"]) {
    redirect('login.php');
    exit;
}

if (isset($_POST["Nombres"]) and
        isset($_POST["Email"]) and
        isset($_POST["Password"])
) {

    try {
        $Nombres = $_POST["Nombres"];
        $Apellidos = $_POST["Apellidos"];
        $Email = $_POST["Email"];
        $Password = md5($_POST["Password"]);
        $IdTipoUsuario = $_POST["IdTipoUsuario"];
        $Estado = $_POST["Estado"];
        $UrlFotoPerfil = $_POST["UrlFotoPerfil"];

        //verificando si el correo o el numero ya existe
        $sqlverificador = "select * from tbl_usuariosaccesos where Email = '$Email'";
        // se realiza la consulta
        $resverificador = mysqli_query($conn, $sqlverificador);
        // si se realizo la conslta
        if ($resverificador) {
            // se  el numero de filas es igual a cero es por que no existe
            if (mysqli_num_rows($resverificador) == 0) {

                $sqlinsertar = "INSERT INTO `tbl_usuariosaccesos` (`Id_usuario`, `Nombres`, `Apellidos`, `Email`, `Password`, `IdTipoUsuario`, `UrlFotoPerfil`, `Estado`) "
                        . "VALUES (NULL, '$Nombres', '$Apellidos', '$Email', '$Password', '$IdTipoUsuario', '$UrlFotoPerfil', '$Estado');";
                $resinsertar = mysqli_query($conn, $sqlinsertar);
                if ($resinsertar) {

                    $nameValue = array('success' => 1, 'message' => "Se ha registrado el nuevo usuario con éxito.");
                    echo json_encode($nameValue);
                } else {

                    $nameValue = array('success' => 0, 'error' => "No se ha podido guardr" . mysqli_error($conn));
                    echo json_encode($nameValue);
                }
            } else {

                $nameValue = array('success' => 0, 'error' => "Ya existe un registro con este correo");
                echo json_encode($nameValue);
            }
        } else { //si no se realizo la consulta
            $nameValue = array('success' => 0, 'error' => "Ha saltado:" . mysqli_error($conn));
            echo json_encode($nameValue);
        }
    } catch (Exception $exc) {

        echo json_encode(array("success" => 0, "error" => $exc->getTraceAsString()));
    }
}
 else {
     $nameValue = array('success' => 0, 'error' => "Parametros no encontrados");
            echo json_encode($nameValue);
}
?>