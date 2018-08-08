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
// si viene en modo de insertar nuevo o editar
if (isset($_GET["modo"]) and
        $_GET["modo"] == "administrar") {

    //se validan parametros requeridos
    if (isset($_POST["idUndmedida"]) and
            isset($_POST["NombreMedida"]) and
            isset($_POST["metodo"])
    ) {

        try {
            //se obtiene los valores y se guardan wen variables
            $idUndmedida = $_POST["idUndmedida"];
            $NombreMedida = $_POST["NombreMedida"];
            $Abreviatura = $_POST["Abreviatura"];
            $metodo = $_POST["metodo"];

            // si viene en guardar  o editar
            if ($metodo == "GUARDAR") {
                $sqlinsertar = "INSERT INTO `tbl_invent_undmedida` (`idUndmedida`, `NombreMedida`, `Abreviatura`) "
                        . "VALUES (NULL, '$NombreMedida', '$Abreviatura');";
            } else {
                $sqlinsertar = "UPDATE `tbl_invent_undmedida` SET `NombreMedida` = '$NombreMedida', `Abreviatura` = '$Abreviatura' WHERE `idUndmedida` = $idUndmedida;";
            }

            $resinsertar = mysqli_query($conn, $sqlinsertar);
            if ($resinsertar) {

                $nameValue = array('success' => 1, 'message' => "Se ha realizado con éxito.");
                echo json_encode($nameValue);
            } else {

                $nameValue = array('success' => 0, 'error' => "No se ha podido guardar" . mysqli_error($conn));
                echo json_encode($nameValue);
            }
        } catch (Exception $exc) {

            echo json_encode(array("success" => 0, "error" => $exc->getTraceAsString()));
        }
    }
 else {
        echo json_encode(array("success" => 0, "error" => "Parámatros no encontrados"));
    }
} elseif (isset($_GET["modo"]) and
        $_GET["modo"] == "obtener") {

    $idUndmedida = $_POST["idUndmedida"];
    // se obtiene los datos de la unidad de medida segun el id enviado
    $sql = "SELECT * FROM `tbl_invent_undmedida` WHERE `idUndmedida` = '$idUndmedida'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $nameValue = array(
                'success' => 1, 
                'message' => "Se han recuperado los datos con éxito.",
                'idUndmedida' => $row["idUndmedida"],
                'NombreMedida' => $row["NombreMedida"],
                'Abreviatura' => $row["Abreviatura"],
                );
            
                echo json_encode($nameValue);
        }
    }
}
?>