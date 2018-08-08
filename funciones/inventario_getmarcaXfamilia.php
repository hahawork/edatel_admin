<?php

session_start();
//Importamos el archivo con las validaciones.
require_once ('../funciones/validaciones.php');

require_once("../conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (empty($_GET['id_catproducto'])) {
    echo json_encode(array("success" => false, "error" => "No se ha enviado el id familia."));
    exit;
}

try {

    $id_catproducto = mysqli_real_escape_string($conn, $_GET['id_catproducto']);
    
    $sql = "SELECT * FROM `tbl_invent_cat_marca` WHERE id_catproducto = '$id_catproducto'";

    $resultado = mysqli_query($conn, $sql);
    if ($resultado) {
        if (mysqli_num_rows($resultado) > 0) {
            $option = "";
            while ($row = mysqli_fetch_assoc($resultado)) {
                $option .= "<option value='".$row["id_marca"]."'>".$row["DescMarca"]."</option>";
            }

            echo json_encode(
                    array(
                        "success" => true,
                        "options" => $option
                    ));
        } else {
            echo json_encode(array("success" => false, "error" => "No hay Marcas."));
        }
    } else {
        echo json_encode(array("success" => false, "error" => mysqli_error($conn)));
    }
} catch (Exception $exc) {

    echo json_encode(array("success" => false, "error" => $exc->getTraceAsString()));
}
?>