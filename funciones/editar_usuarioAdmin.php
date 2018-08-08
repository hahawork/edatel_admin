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
        isset($_POST["Id_usuario"])
) {

    try {
        $Id_usuario = $_POST['Id_usuario'];
        $Nombres = $_POST["Nombres"];
        $Apellidos = $_POST["Apellidos"];
        $Email = $_POST["Email"];
        $Password = $_POST["Password"];
        $Estado = $_POST["Estado"];

        //verificando si el correo o el numero ya existe
        $sqlverificador = "select * from tbl_usuariosaccesos where Id_usuario = '$Id_usuario'";
        // se realiza la consulta
        $resverificador = mysqli_query($conn, $sqlverificador);
        // si se realizo la conslta
        if ($resverificador) {
            // se  el numero de filas es igual a cero es por que no existe
            if (mysqli_num_rows($resverificador) > 0) {

                $sqlupdate = "UPDATE `tbl_usuariosaccesos` set `Nombres`='$Nombres', `Apellidos`='$Apellidos', `Email`='$Email', `Password`='$Password',`Estado`='$Estado' where Id_usuario='$Id_usuario'";
                $resupdate = mysqli_query($conn, $sqlupdate);
                if ($resupdate) {

                    $nameValue = array('success' => 1, 'message' => "Se ha actualizado el usuario con éxito.");
                    echo json_encode($nameValue);
                } else {

                    $nameValue = array('success' => 0, 'error' => "No se ha podido actualizar" . mysqli_error($conn));
                    echo json_encode($nameValue);
                }
            } else {

                $nameValue = array('success' => 0, 'error' => "El Usuario no existe");
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
?>
