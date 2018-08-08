<?php
session_start();
//Importamos el archivo con las validaciones.
require_once ('funciones/validaciones.php');
require_once("conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    redirect('login.php');
    exit;
}


//PARA LOS PUNTOS EN EL MAPA
$val1 = "";
$idpdv = 0;
$z = array();
$n = 0;

$sql2 = mysqli_query($conn, "SELECT CoordenadasGPS, NombrePdV, NombrePropietario, idpdv, tbl_puntosdeventa.id_ruta, nombre_ruta FROM tbl_puntosdeventa INNER JOIN tbl_ruta ON tbl_puntosdeventa.id_ruta = tbl_ruta.id_ruta where EstadoActivo = 1");

if ($sql2) {
    
    while ($row2 = mysqli_fetch_array($sql2)) {
        $y = array();

        $coordenada = $row2["CoordenadasGPS"];
        $myArray = explode(',', $coordenada);

        $y[] = $row2["nombre_ruta"];
        $y[] = $myArray[0];
        $y[] = $myArray[1];
        $y[] = $row2["idpdv"];
        $y[] = ($row2["NombrePdV"]);
        $y[] = $row2["NombrePropietario"];
        $y[] = $row2["id_ruta"];
        $z[$n] = $y;
        $n++;
    }
}
 else {
    echo mysqli_error($conn);    
}
?>

﻿<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="es" class="ie9"> <![endif]-->
<!--[if !IE]><!--> 
<html lang="es"> <!--<![endif]-->

    <!-- BEGIN HEAD -->
    <head>
        <meta charset="UTF-8" />
        <title>EDATEL | Ubicación de los clientes</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!--[if IE]>
           <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
       <![endif]-->
        <!-- GLOBAL STYLES -->
        <!-- GLOBAL STYLES -->
        <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="assets/css/theme.css" />
        <link rel="stylesheet" href="assets/css/MoneAdmin.css" />
        <link rel="stylesheet" href="assets/plugins/Font-Awesome/css/font-awesome.css" />
        <!--END GLOBAL STYLES -->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
    </head>
    <!-- BEGIN HEAD -->

    <!-- BEGIN BODY -->
    <body class="padTop53 ">

        <!-- MAIN WRAPPER -->
        <div id="wrap">
            <!-- HEADER SECTION -->
            <div id="top">
                <nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
                    <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                        <i class="icon-align-justify"></i>
                    </a>
                    <!-- LOGO SECTION -->
                    <header class="navbar-header" style="margin-left: -5px;">

                        <a href="index.php" class="navbar-brand">
                            <img src="assets/img/logo1.png" alt="" /></a>
                    </header>
                    <!-- END LOGO SECTION -->                   
                </nav>
            </div>
            <!-- END HEADER SECTION -->
            <!-- MENU SECTION -->
            <div id="left">
                <div class="media user-media well-small">
                    <a class="user-link" href="#">
                        <img class="media-object img-thumbnail user-img" alt="User Picture" src="assets/img/perfil-default.png" />
                    </a>
                    <br />
                    <div class="media-body">
                        <p><?php echo $_SESSION["sUserName"]; ?></p>
                        <ul class="list-unstyled user-info">

                            <li>
                                <a href="logout.php">
                                    <span class="btn btn-success btn-xs btn-circle" style="width: 10px;height: 12px;"> </span> Cerrar Sesión
                                </a>
                            </li>

                        </ul>
                    </div>
                    <br />
                </div>

                <ul id="menu" class="collapse">
                    <li class="panel">
                        <a href="index.php" ><i class="icon-dashboard"></i> Panel de Control</a>                   
                    </li>
                    <li class="panel"> 
                        <a href="visitas_lineatiempo.php" ><i class="icon-eye-open"></i> Visitas</a>                   
                    </li>
                    <li class="panel"> 
                        <a href="recorrido_rutas.php" ><i class="icon-map-marker"></i> Recorrido</a>                   
                    </li>
                    <li class="panel">
                        <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#pagesr-nav">
                            <i class="icon-table"></i> Reportes

                            <span class="pull-right">
                                <i class="icon-angle-right"></i>
                            </span>

                        </a>
                        <ul class="collapse" id="pagesr-nav">
                            <li><a href="rpte_marcacion.php"><i class=" icon-map-marker"></i> Reporte de Visitas </a></li>
                            <li><a href="rpte_ventas.php"><i class=" icon-money"></i> Reporte de Ventas </a></li>
                        </ul>
                    </li>
                    <li class="panel">
                        <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#DDL-nav">
                            <i class=" icon-male"></i> Clientes

                            <span class="pull-right">
                                <i class="icon-angle-rigth"></i>
                            </span>
                        </a>
                        <ul class="collapse" id="DDL-nav">
                            <li>
                            <li><a href="mis_clientes.php"><i class="icon-file"></i>Mi Listado de Clientes</a></li>
                            <li><a href="ubicacion_clientes.php"><i class="icon-globe"></i> Ubicación Geografica</a></li>

                        </ul>
                    </li>
                    <li class="panel">
                        <a href="administrar_usuarios.php" ><i class="icon-group"></i> Administrar usuarios</a>                   
                    </li>

                    <li class="panel">
                        <a href="logout.php" ><i class="icon-off"></i> Cerrar Sesión</a>                   
                    </li>
                </ul>
            </div>
            <!--END MENU SECTION -->

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2> Clientes </h2>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <i class="icon-asterisk"></i>
                                    Ubicación
                                </div>
                                <div class="panel-body">

                                    <div id="map" style="width:100%;height:100%;" ></div>

                                    <script>
                                        function myMap() {
                                            var locationsb = <?php echo json_encode($z); ?>
                                            var n = 0;
                                            var myCenter = new google.maps.LatLng(locationsb[n][1], locationsb[n][2]);
                                            var mapCanvas = document.getElementById("map");
                                            var mapOptions = {center: myCenter, zoom: 10};
                                            var map = new google.maps.Map(mapCanvas, mapOptions);

                                            var image = {
                                                url: 'assets/img/pina.png',
                                                // This marker is 20 pixels wide by 32 pixels high.
                                                size: new google.maps.Size(20, 32),
                                                // The origin for this image is (0, 0).
                                                origin: new google.maps.Point(0, 0),
                                                // The anchor for this image is the base of the flagpole at (0, 32).
                                                anchor: new google.maps.Point(0, 32)
                                            };
                                            // Shapes define the clickable region of the icon. The type defines an HTML
                                            // <area> element 'poly' which traces out a polygon as a series of X,Y points.
                                            // The final coordinate closes the poly by connecting to the first coordinate.
                                            var shape = {
                                                coords: [1, 1, 1, 20, 18, 20, 18, 1],
                                                type: 'poly'
                                            };

                                            var marker1;
                                            for (n = 0; n < locationsb.length; n++) {
                                                var ur = '';
                                                //segun la ruta se colocca el color del pin
                                                if (locationsb[n][6] == "1") {
                                                    ur = 'assets/img/pin-ruta-ema10.png';
                                                } else if (locationsb[n][6] == "2") {
                                                    ur = 'assets/img/pin-ruta-ema11.png';
                                                } else if (locationsb[n][6] == "3") {
                                                    ur = 'assets/img/pin-ruta-ema12.png';
                                                } else if (locationsb[n][6] == "4") {
                                                    ur = 'assets/img/pin-ruta-ema13.png';
                                                } else if (locationsb[n][6] == "5") {
                                                    ur = 'assets/img/pin-ruta-ema14.png';
                                                } else if (locationsb[n][6] == "6") {
                                                    ur = 'assets/img/pin-ruta-ema15.png';
                                                } else if (locationsb[n][6] == "7") {
                                                    ur = 'assets/img/pin-ruta-ema16.png';
                                                } else if (locationsb[n][6] == "8") {
                                                    ur = 'assets/img/pin-ruta-ema17.png';
                                                } else if (locationsb[n][6] == "9") {
                                                    ur = 'assets/img/pin-ruta-ema18.png';
                                                }
                                                else {
                                                    ur = 'assets/img/pin-ruta-neutra.png';
                                                }
                                                var img = {
                                                    url: ur,
                                                    size: new google.maps.Size(20, 32),
                                                    origin: new google.maps.Point(0, 0),
                                                    anchor: new google.maps.Point(0, 32)
                                                };
                                                marker1 = new google.maps.Marker({
                                                    position: new google.maps.LatLng(locationsb[n][1], locationsb[n][2]),
                                                    title: locationsb[n][4],
                                                    map: map,
                                                    icon: img
                                                            //shape: shape
                                                });

                                                google.maps.event.addListener(marker1, 'click', (function(marker1, n) {
                                                    return function() {
                                                        infowindow.setContent("id: " + locationsb[n][3] +
                                                                ".<br/>N. Local: " + locationsb[n][4] +
                                                                ".<br/>N. Prop.: " + locationsb[n][5] +
                                                                ".<br/>Ruta: " + locationsb[n][0]);
                                                        infowindow.open(map, marker1);
                                                    }
                                                })(marker1, n));

                                                //marker1.setMap(map);
                                            }
                                            var infowindow = new google.maps.InfoWindow({
                                                content: "Puntos de ventas registrados."
                                            });
                                            infowindow.open(map, marker1);
                                        }
                                    </script>

                                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeAPkXd6qY2mg2QJ0bdMWbqO7Wjgs3diM&callback=myMap" async defer></script>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>

            </div>
            <!--END PAGE CONTENT -->
        </div>
        <!--END MAIN WRAPPER -->
        <!-- FOOTER -->
        <div id="footer">
            <p>&copy;  EDATEL &nbsp;2018 &nbsp;</p>
        </div>
        <!--END FOOTER -->
        <!-- GLOBAL SCRIPTS -->
        <script src="assets/plugins/jquery-2.0.3.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <!-- END GLOBAL SCRIPTS -->


    </body>
    <!-- END BODY -->
</html>
