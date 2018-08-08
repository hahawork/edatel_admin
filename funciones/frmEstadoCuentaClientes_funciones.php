<?php

session_start();

define("defGETCLIENTES", 1);
define("defGETCREDITOS", 2);
define("defLIMPIARVENTA", 3);
define("defABONARVENTA", 4);

//cadena de conexion a la base de datos
require_once '../conexion/conexion.php';
$cnn = new conexion;
$conn = $cnn->conectar();

if (isset($_POST["opcion"])) {

    $opcion = $_POST["opcion"];

    switch ($opcion) {

        case defGETCLIENTES:
            fnGetClientesToTable();
            break;

        case defGETCREDITOS:
            if (isset($_POST["idcliente"])) {
                $idc = $_POST["idcliente"];
                fngetCreditosCliente($idc);
            }
            break;

        case defLIMPIARVENTA:
            fnLimpiarSaldoSegunVenta();
            break;
        
        case defABONARVENTA:
            fnAbonarSaldoSegunVenta();
            break;
        
        default:
            break;
    }
}

function fnGetClientesToTable() {

    //como es una variable fuera del metodo se usa global.
    global $conn;

    $sql = "SELECT idpdv, NombrePdV, NumeroPOS,nombre_ruta FROM `tbl_puntosdeventa` INNER JOIN tbl_ruta ON tbl_puntosdeventa.id_ruta = tbl_ruta.id_ruta WHERE EstadoActivo = 1 ORDER BY `NombrePdV`";

    if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row["idpdv"];
            $nombre = $row["NombrePdV"];
            $telefono = $row["NumeroPOS"];
            $ruta = $row["nombre_ruta"];
            $saldo = fnGetSaldoDelCliente($id);

            if ($saldo > 0) {
                echo "<tr>
                    <td>$id</td>
                    <td>$nombre</td>
                    <td>$telefono</td>
                    <td>$ruta</td>
                    <td>$saldo.00</td>
                    <td>                    
                    <button type='button' class='btn btn-success btn-circle' data-toggle='modal' data-target='#modalDetalleCliente'  
                        onclick='fnObtenerDetallesVentasCreditoCliente(\"$id\", \"$nombre\", \"$telefono\", \"$ruta\")'>
                        <i class='icon-eye-open'></i>
                    </button>
                    </td>
                </tr>";
            }
        }
    }
}

function fngetCreditosCliente($param) {
    //como es una variable fuera del metodo se usa global.
    global $conn;

    $sql = "SELECT idVenta, idPdV, FechaVenta, Cantidad, TotalCobrarse "
            . "FROM `tbl_ventasrealizadas` "
            . "WHERE idPdv = '$param' AND TipoVenta = 'CREDITO'"
            . "ORDER BY FechaVenta DESC";

    if ($result = mysqli_query($conn, $sql)) {

        if (mysqli_num_rows($result)>0) {

            while ($row = mysqli_fetch_assoc($result)) {

                $idVenta = $row["idVenta"];
                $idPdV = $row["idPdV"];
                $FechaVenta = $row["FechaVenta"];
                $Cantidad = $row["Cantidad"];
                $TotalCobrarse = $row["TotalCobrarse"];

                $saldo = getCreditoPendientedeAbono($idVenta, $TotalCobrarse);
                $abonado = $TotalCobrarse - $saldo;

                if ($saldo > 0) {
                    echo "<tr id='$idVenta'>
                    <td>$idVenta</td>
                    <td>$FechaVenta</td>
                    <td>$Cantidad.00</td>
                    <td>$TotalCobrarse.00</td>
                    <td>$abonado.00</td>
                    <td>$saldo.00</td>  
                    <td>
                    <button class='btn btn-success btn-circle popover-test' id='btnLimparCreditoModal' title='Abonar' data-content='Abonar' data-toggle='modal' data-target='#modalAbonarCredito'
                        onclick='fnAbonarVentaCredito_setvariables(\"$idVenta\", \"$idPdV\", \"$abonado\", \"$saldo\")'>
                        <i class='icon-plus-sign'></i>
                    </button>
                    <button class='btn btn-danger  btn-circle popover-test' title='Limpiar' data-content='Limpiar'
                        onclick='fnLimparCreditoVentaModal(\"$idPdV\", \"$idVenta\", \"$saldo\")'>
                        <i class='icon-remove-sign'></i>
                    </button>
                    </td>
                </tr>";
                }
            }
        }else{
            echo "<tr>
                    <td>No</td>
                    <td>hay</td>
                    <td>saldo</td>
                    <td>en</td>
                    <td>la</td>  
                    <td>base</td>
                </tr>";
        }
    }
}

function fnGetSaldoDelCliente($idcliente) {

    global $conn;
    $totcredit = 0.00;

    $sqlventas = "SELECT * FROM `tbl_ventasrealizadas` WHERE idPdV = '$idcliente' AND TipoVenta = 'CREDITO' ORDER BY `FechaVenta` DESC";
    if ($resultventas = mysqli_query($conn, $sqlventas)) {
        if (mysqli_num_rows($resultventas) > 0) {
            while ($row = mysqli_fetch_assoc($resultventas)) {
                $totcredit += getCreditoPendientedeAbono($row["idVenta"], $row["TotalCobrarse"]);
            }
        }
    }

    return $totcredit;
}

function getCreditoPendientedeAbono($idventa, $TotalCobrarse) {

    global $conn;
    $saldo = 0.0;

    $sqlventas = "SELECT SUM(cantidad_abono) as cantidad_abono FROM `tbl_abonosrealizados` WHERE idVenta = '$idventa'";
    if ($result = mysqli_query($conn, $sqlventas)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $abonado = $row["cantidad_abono"];
            $saldo = $TotalCobrarse - $abonado;
        }
    }
    return $saldo;
}

function fnLimpiarSaldoSegunVenta() {

    global $conn;

    $IdUsuario = $_SESSION["sUserId"];
    $idVenta = $_POST['idVenta'];
    $idCliente = $_POST['idCliente'];
    $cantidad_abono = $_POST['cantidad_abono'];
    $cantidad_saldo = $_POST['cantidad_saldo'];
    $fecha_abono = date("Y-m-d H:i:s");

    if (isset($IdUsuario) and isset($idVenta) and isset($cantidad_abono)) {

        $sql = "INSERT INTO `tbl_abonosrealizados` (`idAbono`, `idVenta`, `idCliente`, `cantidad_abono`, `cantidad_saldo`, `fecha_abono`,  TipoAbono) 
        VALUES (NULL, '$idVenta', '$idCliente', '$cantidad_abono', '$cantidad_saldo', '$fecha_abono', 'AJUSTE_CERO');";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo json_encode(array('status' => '1', 'message' => 'La venta ha sido limpiada con éxito.'));
        } else {
            echo json_encode(array('status' => '0', 'message' => "error mysqli al guardar " . mysqli_error($conn)));
        }
        mysqli_close($conn);
    } else {
        echo json_encode(array('status' => '0', 'message' => "Parametros requeridos no encontrados."));
    }
}

function fnAbonarSaldoSegunVenta() {

    global $conn;

    $IdUsuario = $_SESSION["sUserId"];
    $idVenta = $_POST['idVenta'];
    $idCliente = $_POST['idCliente'];
    $cantidad_abono = $_POST['cantidad_abono'];
    $cantidad_saldo = $_POST['cantidad_saldo'];
    $fecha_abono = date("Y-m-d H:i:s");

    if (isset($IdUsuario) and isset($idVenta) and isset($cantidad_abono)) {

        $sql = "INSERT INTO `tbl_abonosrealizados` (`idAbono`, `idVenta`, `idCliente`, `cantidad_abono`, `cantidad_saldo`, `fecha_abono`,  TipoAbono) 
        VALUES (NULL, '$idVenta', '$idCliente', '$cantidad_abono', '$cantidad_saldo', '$fecha_abono', 'ABONO');";

        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo json_encode(array('status' => '1', 'message' => 'Se ha realizado el abono con éxito'));
        } else {
            echo json_encode(array('status' => '0', 'message' => "error mysqli al guardar " . mysqli_error($conn)));
        }
        mysqli_close($conn);
    } else {
        echo json_encode(array('status' => '0', 'message' => "Parametros requeridos no encontrados."));
    }
}
?>
