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

$Fecharegistro = isset($_POST['Fecharegistro']) ? $_POST['Fecharegistro'] : null;

try {

    $sql = "SELECT tbl_edatel_usuarios.NombreUsuario, tbl_puntosdeventa.NombrePdV, tbl_entradasmarcadas.Fecharegistro FROM `tbl_entradasmarcadas` INNER JOIN tbl_puntosdeventa ON tbl_entradasmarcadas.idPdV = tbl_puntosdeventa.idpdv INNER JOIN tbl_edatel_usuarios ON tbl_entradasmarcadas.IdUsuario = tbl_edatel_usuarios.idUsuario WHERE  tbl_entradasmarcadas.Fecharegistro > '$Fecharegistro'";
    $resultado = mysqli_query($conn, $sql);
    if ($resultado) {
        if (mysqli_num_rows($resultado) > 0) {

            $row = mysqli_fetch_assoc($resultado);

            echo json_encode(array("success" => "1", "NombrePdV"=> $row["NombrePdV"], "NombreUsuario"=> $row["NombreUsuario"], "Fecharegistro" => $row["Fecharegistro"] ));
        }
        else{
            //echo json_encode(array("success" => "0", "error" => "no hay visitas recientes ala fecha actual."));
        }
    }
    else{
        //echo json_encode(array("success" => "0", "error" => mysqli_error($conn)));
    }
} catch (Exception $exc) {

    //echo json_encode(array("success" => "0", "error" => $exc->getTraceAsString()));
}
?>