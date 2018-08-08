<?php

require_once("../conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (isset($_POST["Descripcion"])) {

    try {
        $id_catproducto = $_POST["id_catproducto"];
        $Descripcion = $_POST["Descripcion"];

        //verificando si la familia ya existe
        $sqlverificador = "select * from tbl_invent_cat_tipoproducto where id_catproducto = '$id_catproducto'";
        // se realiza la consulta
        $resverificador = mysqli_query($conn, $sqlverificador);
        // si se realizo la conslta
        if ($resverificador) {
            // se  el numero de filas es igual a cero es por que no existe
            if (mysqli_num_rows($resverificador) == 0) {

                $sqlinsertar = "INSERT INTO tbl_invent_cat_tipoproducto (`id_catproducto`, `Descripcion`) VALUES (NULL, '$Descripcion')";
                $resinsertar = mysqli_query($conn, $sqlinsertar);
                if ($resinsertar) {
                    $last_id = mysqli_insert_id($conn);
                    if ($last_id > 0) {
                        $nameValue = array('success' => 1, 'last_id' => $last_id, 'message' => "Se ha registrado la nueva familia con éxito.");
                        echo json_encode($nameValue);
                    } else {
                        $nameValue = array('success' => 0, 'error' => "supuestamente Se ha registrado la nueva familia con éxito.");
                        echo json_encode($nameValue);
                    }
                } else {

                    $nameValue = array('success' => 0, 'error' => "No se ha podido guardar" . mysqli_error($conn));
                    echo json_encode($nameValue);
                }
            } else {// si ya existe se actualiza
                
                $sqlactualizar = "UPDATE `tbl_invent_cat_tipoproducto` SET `Descripcion` = '$Descripcion' WHERE `id_catproducto` = '$id_catproducto';";
                $resActualizar = mysqli_query($conn, $sqlactualizar);
                if ($resActualizar) {                    
                        $nameValue = array('success' => 1, 'message' => "Se ha actualizado la familia con éxito.");
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