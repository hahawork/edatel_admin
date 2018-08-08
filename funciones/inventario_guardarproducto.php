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

if (isset($_POST["idMarca"]) and
        isset($_POST["id_cat_tipoproducto"]) and
        isset($_POST["NombreModelo"])
) {

    try {
        $idMarca = $_POST["idMarca"];
        $Modelo = $_POST["Modelo"];
        $NombreModelo = $_POST["NombreModelo"];
        $Color = $_POST["Color"];
        $id_cat_tipoproducto = $_POST["id_cat_tipoproducto"];
        $Stock = $_POST["Stock"];
        $StockMinimo = $_POST["StockMinimo"];
        $Precio = $_POST["Precio"];
        $Estado_activo = $_POST["Estado_activo"];

        //fecha *****************************************
        $managua = new DateTimeZone("America/Managua");
        $fechahoy = new DateTime("now", $managua);
        $diahoy = $fechahoy->format("Y-m-d  H:i:s");
        //***********************************************
        $idUsuario = $_SESSION["sUserId"];

        $sqlinsertar = "INSERT INTO `tbl_invent_producto` (`id_producto`, `idMarca`, `Modelo`, `NombreModelo`, `Color`, `id_cat_tipoproducto`, `Stock`, `StockMinimo`, `Precio`, `Estado_activo`, `fecha_registro`, `usuario_registro`) "
                . "VALUES (NULL, '$idMarca', '$Modelo', '$NombreModelo', '$Color', '$id_cat_tipoproducto', '$Stock', '$StockMinimo', '$Precio', '$Estado_activo', '$diahoy', '$idUsuario')";
        $resinsertar = mysqli_query($conn, $sqlinsertar);
        if ($resinsertar) {

            $nameValue = array('success' => 1, 'message' => "Se ha registrado el nuevo producto con éxito.");
            echo json_encode($nameValue);
        } else {

            $nameValue = array('success' => 0, 'error' => "No se ha podido guardr" . mysqli_error($conn));
            echo json_encode($nameValue);
        }
    } catch (Exception $exc) {

        echo json_encode(array("success" => 0, "error" => $exc->getTraceAsString()));
    }
}
?>