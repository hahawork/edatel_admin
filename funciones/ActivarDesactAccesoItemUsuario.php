<?php

require_once("../conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (isset($_REQUEST["idUsuario"]) and isset($_REQUEST["idMenu"]) and isset($_REQUEST["idMenuItem"])) {

    $idUsuario = $_REQUEST["idUsuario"];
    $idMenu = $_REQUEST["idMenu"];
    $idMenuItem = $_REQUEST["idMenuItem"];
    $EstadoActivo = $_REQUEST["EstadoActivo"];

    $sql = "";

    $sqlVerifExist = "SELECT * FROM `tbl_sistweb_usuario_items` WHERE idUsuario = '$idUsuario' AND idMenu = '$idMenu' AND idMenuItem = '$idMenuItem'";
    $resultVerifExis = mysqli_query($conn, $sqlVerifExist);
    
    if ($resultVerifExis and mysqli_num_rows($resultVerifExis) > 0) {
        
        $idMUI = mysqli_fetch_assoc($resultVerifExis);
        
        $sql = "UPDATE `tbl_sistweb_usuario_items` SET `EstadoPermitido` = '$EstadoActivo' WHERE `tbl_sistweb_usuario_items`.`idUsuItem` = ". $idMUI["idUsuItem"];
    } else { // si aun no existe el registro
        
        $sql = "INSERT INTO `tbl_sistweb_usuario_items` (`idUsuItem`, `idUsuario`, `idMenu`, `idMenuItem`, `EstadoPermitido`) "
                . "VALUES (NULL, '$idUsuario', '$idMenu', '$idMenuItem', '$EstadoActivo');";
    }

    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $arrayName = array('success' => "1", 'error' => "");
        echo json_encode($arrayName);
    } else {
        $arrayName = array('success' => "0", 'error' => "");
        echo json_encode($arrayName);
    }
}
?>