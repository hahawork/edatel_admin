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
    if (isset($_POST["idProveedor"]) and
            isset($_POST["NombreProveedor"]) and
            isset($_POST["metodo"])
    ) {

        try {
            //se obtiene los valores y se guardan wen variables
            $idProveedor = $_POST["idProveedor"];
            $NombreProveedor = $_POST["NombreProveedor"];
            $Telefono = $_POST["Telefono"];
            $Estado = $_POST["Estado"];
            $metodo = $_POST["metodo"];

            // si viene en guardar  o editar
            if ($metodo == "GUARDAR") {
                $sqlinsertar = "INSERT INTO `tbl_invent_proveedores` (`idProveedor`, `NombreProveedor`, `Telefono`, `Estado`) VALUES (NULL, '$NombreProveedor', '$Telefono', '$Estado');";
            } else {
                $sqlinsertar = "UPDATE `tbl_invent_proveedores` SET `NombreProveedor` = '$NombreProveedor', `Telefono` = '$Telefono', `Estado` = '$Estado' WHERE `idProveedor` = $idProveedor;";
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
} elseif (isset($_GET["modo"]) and
        $_GET["modo"] == "obtener") {

    $idProveedor = $_POST["idProveedor"];
    // se obtiene los datos del proveedro segun el id enviado
    $sql = "SELECT * FROM `tbl_invent_proveedores` WHERE `idProveedor` = '$idProveedor'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $nameValue = array(
                'success' => 1, 
                'message' => "Se han recuperado los datos con éxito.",
                'idProveedor' => $row["idProveedor"],
                'NombreProveedor' => $row["NombreProveedor"],
                'Telefono' => $row["Telefono"],
                'Estado' => $row["Estado"],
                );
            
                echo json_encode($nameValue);
        }
    }
}
?>