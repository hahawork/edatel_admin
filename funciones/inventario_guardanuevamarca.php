<?php

require_once("../conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (isset($_POST["DescMarca"]) and isset($_POST["id_marca"])) {

    try {
        $id_marca = $_POST["id_marca"];
        $id_catproducto = $_POST["id_catproducto"];
        $DescMarca = $_POST["DescMarca"];

        //verificando si la marca ya existe
        $sqlverificador = "select * from tbl_invent_cat_marca where id_marca = '$id_marca'";
        // se realiza la consultatbl_invent_cat_marca
        $resverificador = mysqli_query($conn, $sqlverificador);
        // si se realizo la conslt
        if ($resverificador) {
            // se  el numero de filas es igual a cero es por que no existe
            if (mysqli_num_rows($resverificador) == 0) {

                $sqlinsertar = "INSERT INTO `tbl_invent_cat_marca` (`id_marca`, `id_catproducto`, `DescMarca`) VALUES (NULL, '$id_catproducto', '$DescMarca');";
                $resinsertar = mysqli_query($conn, $sqlinsertar);
                if ($resinsertar) {
                    $last_id = mysqli_insert_id($conn);
                    if ($last_id > 0) {
                        $nameValue = array('success' => 1, 'last_id' => $last_id, 'message' => "Se ha registrado la nueva marca con éxito.");
                        echo json_encode($nameValue);
                    } else {
                        $nameValue = array('success' => 0, 'error' => "supuestamente Se ha registrado la nueva marca con éxito.");
                        echo json_encode($nameValue);
                    }
                } else {

                    $nameValue = array('success' => 0, 'error' => "No se ha podido guardar" . mysqli_error($conn));
                    echo json_encode($nameValue);
                }
            } else {// si ya existe se actualiza
                
                $sqlactualizar = "UPDATE `tbl_invent_cat_marca` SET id_catproducto = $id_catproducto, `DescMarca` = '$DescMarca' WHERE `id_marca` = '$id_marca'";
                $resActualizar = mysqli_query($conn, $sqlactualizar);
                if ($resActualizar) {                    
                        $nameValue = array('success' => 1, 'message' => "Se ha actualizado la marca con éxito.");
                        echo json_encode($nameValue);                    
                } else {

                    $nameValue = array('success' => 0, 'error' => "No se ha podido actualizar" . mysqli_error($conn));
                    echo json_encode($nameValue);
                }
            }
        } else { //si no se realizo la consulta
            $nameValue = array('success' => 0, 'error' => "Error verificando: " . mysqli_error($conn));
            echo json_encode($nameValue);
        }
    } catch (Exception $exc) {

        echo json_encode(array("success" => 0, "error" => $exc->getTraceAsString()));
    }
} else {
    echo json_encode(array("success" => 0, "error" => "Parametros no encontrados"));
}
?>


