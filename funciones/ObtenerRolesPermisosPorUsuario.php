<?php

require_once("../conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (isset($_REQUEST["idUsuario"])) {

    $idUsuario = $_REQUEST["idUsuario"];

    if ($idUsuario > 0) {

        $response="";

        $sql = "SELECT * FROM `tbl_sistweb_usuario_items` WHERE idUsuario = '$idUsuario' AND EstadoPermitido = '1'";
        $result = mysqli_query($conn, $sql);
        if ($result and mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $response .= "Item" . $row["idMenuItem"] . ",";                
            }
            echo ($response);
        } 
    } 
}
?>