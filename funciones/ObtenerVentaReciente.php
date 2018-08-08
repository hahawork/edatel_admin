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

$FechaVenta = isset($_POST['FechaVenta']) ? $_POST['FechaVenta'] : null;

try {

    $sql = "SELECT NombreUsuario, NombrePdV, Cantidad, tbl_ventasrealizadas.NumeroPOS, FechaVenta "
            . "FROM `tbl_ventasrealizadas` INNER JOIN "
            . "tbl_puntosdeventa ON tbl_ventasrealizadas.idPdV = tbl_puntosdeventa.idpdv INNER JOIN "
            . "tbl_edatel_usuarios ON tbl_ventasrealizadas.IdUsuario = tbl_edatel_usuarios.idUsuario "
            . "WHERE  tbl_ventasrealizadas.FechaVenta > '$FechaVenta'";

    $resultado = mysqli_query($conn, $sql);
    if ($resultado) {
        if (mysqli_num_rows($resultado) > 0) {

            $row = mysqli_fetch_assoc($resultado);

            echo json_encode(
                    array(
                        "success" => "1",
                        "NombrePdV" => $row["NombrePdV"],
                        "NombreUsuario" => $row["NombreUsuario"],
                        "Cantidad" => $row["Cantidad"],
                        "FechaVenta" => $row["FechaVenta"],
                        "NumeroPOS" => $row["NumeroPOS"],
                    ));
        } else {
            //echo json_encode(array("success" => "0", "error" => "no hay ventas recientes ala fecha actual."));
        }
    } else {
        //echo json_encode(array("success" => "0", "error" => mysqli_error($conn)));
    }
} catch (Exception $exc) {

    //echo json_encode(array("success" => "0", "error" => $exc->getTraceAsString()));
}
?>