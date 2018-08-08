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

if (isset($_POST["id_producto"]) and 
        isset($_POST["idMarca"]) and
        isset($_POST["id_cat_tipoproducto"]) and
        isset($_POST["NombreModelo"])
) {

    try {
        $id_producto = $_POST["id_producto"];
        $idMarca = $_POST["idMarca"];
        $Modelo = $_POST["Modelo"];
        $NombreModelo = $_POST["NombreModelo"];
        $Color = $_POST["Color"];
        $id_cat_tipoproducto = $_POST["id_cat_tipoproducto"];
        $Stock = $_POST["Stock"];
        $StockMinimo = $_POST["StockMinimo"];
        $Precio = $_POST["Precio"];
        $Estado_activo = $_POST["Estado_activo"];

        
        $idUsuario = $_SESSION["sUserId"];

        $sqlinsertar = "UPDATE `tbl_invent_producto` SET "
                . "`idMarca` = '$idMarca', "
                . "`Modelo` = '$Modelo', " 
                . "`NombreModelo` = '$NombreModelo', "
                . "`Color` = '$Color', "
                . "`id_cat_tipoproducto` = '$id_cat_tipoproducto', "
                . "`Stock` = '$Stock', "
                . "`StockMinimo` = '$StockMinimo', "
                . "`Precio` = '$Precio', "
                . "`Estado_activo` = '$Estado_activo', "
                . "`usuario_registro` = '$idUsuario' "
                . "WHERE `id_producto` = $id_producto;";
        
        $resUpdate = mysqli_query($conn, $sqlinsertar);
        if ($resUpdate) {

            $nameValue = array('success' => 1, 'message' => "Se ha actualizado el producto con éxito.");
            echo json_encode($nameValue);
        } else {

            $nameValue = array('success' => 0, 'error' => "No se ha podido actualizar" . mysqli_error($conn));
            echo json_encode($nameValue);
        }
    } catch (Exception $exc) {

        echo json_encode(array("success" => 0, "error" => $exc->getTraceAsString()));
    }
}
?>