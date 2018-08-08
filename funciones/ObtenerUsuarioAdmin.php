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
if (isset($_POST['idUsuario'])) {
try {
    $idUsuarioEdit = $_POST['idUsuario'];
    $SQLusuario = "SELECT * FROM `tbl_usuariosaccesos` where Id_usuario =" . $idUsuarioEdit;
    $resultado = mysqli_query($conn, $SQLusuario);
    if ($resultado) {
        if (mysqli_num_rows($resultado) > 0) {
            $row = mysqli_fetch_assoc($resultado);
            
            echo json_encode(
                    array(
                       "success" => 1,
                        "Id_usuario"=>$row["Id_usuario"],
                        "Nombres"=>$row["Nombres"],
                        "Email"=>$row["Email"],
                        "Apellidos"=>$row["Apellidos"],
                        "IdTipoUsuario"=>$row["IdTipoUsuario"],
                        "Estado"=>$row["Estado"],
                        "UrlFotoPerfil"=>$row["UrlFotoPerfil"],
                        "Password"=>$row["Password"],
                        "message"=>"Se ha recuperado la informacion con exito"
                    ));
                    
        }
    }
} catch (Exception $ex) {
    
}
}
?>
