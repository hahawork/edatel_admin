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
$managua = new DateTimeZone("America/Managua");
$fechahoy = new DateTime("now", $managua);
$diahoy = $fechahoy->format("Y-m-d");

$mapzoom = 10;

mysqli_query($conn, "CREATE TEMPORARY TABLE nombreTablaTemporal SELECT tbl_edatel_usuarios.idUsuario, tbl_edatel_usuarios.NombreUsuario, EtiquetaMapa, tbl_puntosdeventa.NombrePdV,tbl_puntosdeventa.CoordenadasGPS, tbl_entradasmarcadas.Fecharegistro FROM `tbl_entradasmarcadas` INNER join tbl_edatel_usuarios on tbl_entradasmarcadas.IdUsuario=tbl_edatel_usuarios.idUsuario INNER JOIN tbl_puntosdeventa on tbl_entradasmarcadas.idPdV=tbl_puntosdeventa.idpdv where tbl_edatel_usuarios.Estado=1 ORDER BY Fecharegistro DESC");

$consulta = "SELECT * FROM nombreTablaTemporal GROUP BY idUsuario ORDER BY Fecharegistro DESC;";
$sql2 = mysqli_query($conn, $consulta) or die(mysqli_error($conn));

$z = array();
$indice = 0;

$VariarLong = 0.00006;

while ($row2 = mysqli_fetch_array($sql2)) {
    $y = array();

    $coordenada = $row2["CoordenadasGPS"];
    $myArray = explode(',', $coordenada);

    if (sizeof($myArray) == 2) {
        $y[] = utf8_encode($row2["NombreUsuario"]);
        $y[] = $myArray[0];
        $y[] = $myArray[1];
        $y[] = $row2["Fecharegistro"];
        $y[] = utf8_encode($row2["NombrePdV"]);
        $y[] = $mapzoom;
        $y[] = $row2["EtiquetaMapa"];
        $y[] = $row2["idUsuario"];
        $z[$indice] = $y;
        $indice++;
    }
}
?>

﻿<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="es" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="es"> <!--<![endif]-->

    <!-- BEGIN HEAD -->
    <head>
        <meta charset="UTF-8" />
        <title>EDATEL Admin Recargas | Principal </title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="Tania Lumbi Vallecillo" />
        <!--[if IE]>
           <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
       <![endif]-->
        <!-- GLOBAL STYLES -->
        <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="assets/css/theme.css" />
        <link rel="stylesheet" href="assets/css/MoneAdmin.css" />
        <link rel="stylesheet" href="assets/plugins/Font-Awesome/css/font-awesome.css" />
        <!--END GLOBAL STYLES -->

        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <!-- PAGE LEVEL STYLES -->
        <link href="assets/css/layout2.css" rel="stylesheet" />
        <!--        Esto es para las tablas, si no tiene tablas, quitar la sig. linea-->
        <link href="assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

        <link href="assets/plugins/flot/examples/examples.css" rel="stylesheet" />
        <link rel="stylesheet" href="assets/plugins/timeline/timeline.css" />
        <!-- END PAGE LEVEL  STYLES -->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->

        <style>
            @-webkit-keyframes spinnerRotate
            {
                from{-webkit-transform:rotate(0deg);}
                to{-webkit-transform:rotate(360deg);}
            }
            @-moz-keyframes spinnerRotate
            {
                from{-moz-transform:rotate(0deg);}
                to{-moz-transform:rotate(360deg);}
            }
            @-ms-keyframes spinnerRotate
            {
                from{-ms-transform:rotate(0deg);}
                to{-ms-transform:rotate(360deg);}
            }
            #spinner{                
                -webkit-animation-name: spinnerRotate;
                -webkit-animation-duration: 5s;
                -webkit-animation-iteration-count: infinite;
                -webkit-animation-timing-function: linear;
                -moz-animation-name: spinnerRotate;
                -moz-animation-duration: 5s;
                -moz-animation-iteration-count: infinite;
                -moz-animation-timing-function: linear;
                -ms-animation-name: spinnerRotate;
                -ms-animation-duration: 5s;
                -ms-animation-iteration-count: infinite;
                -ms-animation-timing-function: linear;
            }
        </style>
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="padTop53 " >

        <!-- MAIN WRAPPER -->
        <div id="wrap">
            <!-- HEADER SECTION -->
           <?php
            $_SESSION["seccion"] = 1;
            $_SESSION["item"] = 1;
            include './header.php';
            ?>
            <!--END MENU SECTION -->

            <!--PAGE CONTENT -->
            <div id="content">

                <div class="inner">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2> Panel de Administración </h2>
                        </div>
                    </div>
                    <hr/>
                    <!--BLOCK SECTION -->

                    <!--END BLOCK SECTION -->
                    <hr />
                    <!-- SECCION DE MAPA -->
                    <div class="row">

                        <div class="col-sm-12 col-md-8">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Ubicacion de mis vendedores.
                                </div> 
                                <div class="panel-body" style="height: 500px;">
                                    <div id="map" style="width:100%;height:100%;" ></div>   
                                </div>                                                            
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">

                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <i class="icon-cloud-upload"></i> Nuevas visitas y Ventas

                                    <div class="overlay pull-right" id="spinner">
                                        <i class="icon-repeat"></i>
                                    </div>
                                </div>

                                <div class="panel-body" style="height: 400px; overflow-y: hidden;">

                                    <ul class="chat" id="original_ul">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-panel panel panel-primary">
                        <div class="panel-heading">
                            <i class="icon-asterisk"></i>
                            VENTAS

                        </div>

                        <div class="panel-body">
                            <ul class="chat">

                                <?php
                                $sql = "SELECT * FROM `vw_ventasrealizadas` where FechaVenta LIKE '$diahoy%'";

                                $res3 = mysqli_query($conn, $sql);
                                if ($res3) {
                                    if (mysqli_num_rows($res3) > 0) {
                                        while ($row = mysqli_fetch_array($res3)) {
                                            ?>
                                            <li class="left clearfix">
                                                <span class="chat-img pull-left">
                                                    <img src="assets/img/cordoba_nicaragua.png" alt="User Avatar" class="img-circle" />
                                                </span>
                                                <div class="chat-body clearfix">
                                                    <div class="header">
                                                        <strong class="primary-font"><?php echo $row['NombrePdV'] . " (" . $row['NumeroPOS'] . ")" ?></strong>
                                                        <small class="pull-right text-muted">
                                                            <i class="icon-money"></i> <?php echo "C$" . $row['Cantidad'] ?>
                                                        </small>
                                                    </div>

                                                    <p>
                                                        <?php echo $row['NombreUsuario'] ?>
                                                    </p>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                ?>


                            </ul>
                        </div>

                    </div>
                    <!-- END COMMENT AND NOTIFICATION  SECTION -->
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

        <!-- PAGE LEVEL SCRIPTS -->
        <script src="assets/plugins/flot/jquery.flot.js"></script>
        <script src="assets/plugins/flot/jquery.flot.resize.js"></script>
        <script src="assets/plugins/flot/jquery.flot.time.js"></script>
        <script src="assets/js/for_index.js"></script>

        <!-- END PAGE LEVEL SCRIPTS -->

        <script>

            var FechaVisita = getTimestamp();
            var FechaVenta = getTimestamp();

            //funcion para obtener las visita mas reciente
            (function ObtenerVisitaReciente() {

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {Fecharegistro: FechaVisita},
                    url: 'funciones/ObtenerVisitaReciente.php',
                    success: function (res) {
                        if (res.success == '1') {

                            $('#original_ul').prepend(
                                    "<li class='left clearfix' id='new_li'>\n\
                                <span class='chat-img pull-left'>\n\
                                <img src='assets/img/pina.png' alt='User Avatar' class='img-circle' />\n\
                                </span>\n\
                                <div class='chat-body clearfix'>\n\
                                <div class='header'>\n\
                                <strong class='primary-font '>" + res.NombreUsuario + "</strong>\n\
                                <small class='pull-right text-muted label label-info'>\n\
                                <i class='icon-time'></i> " + res.Fecharegistro + "\n\
                                </small>\n\
                                </div>\n\
                                <br />\n\
                                <p>\n\
                                " + res.NombrePdV + "\n\
                                </p>\n\
                                </div>\n\
                                </li>"
                                    ).show('slow');

                            FechaVisita = res.Fecharegistro;
                        } else {
                            //console.log(res.error + " " + FechaVisita);
                        }
                    }
                });

                setTimeout(arguments.callee, 5000);
            })();

            //funcion para obtener las visita mas reciente
            (function ObtenerVentaReciente() {

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {FechaVenta: FechaVenta},
                    url: 'funciones/ObtenerVentaReciente.php',
                    success: function (res) {
                        if (res.success == '1') {

                            $('#original_ul').prepend(
                                    "<li class='left clearfix' id='new_li'>\n\
                                <span class='chat-img pull-right'>\n\
                                <img src='assets/img/cordoba_nicaragua.png' alt='User Avatar' class='img-circle' />\n\
                                </span>\n\
                                <audio id='play' src='http://www.soundjay.com/button/beep-07.wav'></audio>\n\
                                <div class='chat-body clearfix'>\n\
                                <div class='header'>\n\
                                <strong class='primary-font '>" + res.NombreUsuario + "</strong>\n\
                                <small class='pull-right text-muted label label-info'>\n\
                                <i class='icon-time'></i> " + res.FechaVenta + "\n\
                                </small>\n\
                                </div>\n\
                                <br />\n\
                                <p>\n\
                                " + res.NombrePdV + " - " + res.NumeroPOS + " (C$" + res.Cantidad + ")\n\
                                </p>\n\
                                </div>\n\
                                </li>"
                                    ).show('slow');

                            FechaVenta = res.FechaVenta;
                            playSound();
                        } else {
                            //console.log(res.error +" "+ FechaVenta);
                        }
                    }
                });

                setTimeout(arguments.callee, 5000);
            })();

            function playSound() {
                document.getElementById('play').play();
            }

            function getTimestamp() {
                var dateNow = new Date();
                var dateMM = dateNow.getMonth() + 1;
                var dateDD = dateNow.getDate();
                var dateYY = dateNow.getFullYear();
                var h = dateNow.getHours();
                var m = dateNow.getMinutes();
                var s = dateNow.getSeconds();
                return dateNow.getFullYear() + '-' +
                        (dateMM <= 9 ? '0' + dateMM : dateMM) + '-' +
                        (dateDD <= 9 ? '0' + dateDD : dateDD) + ' ' +
                        (h <= 9 ? '0' + h : h) + ':' +
                        (m <= 9 ? '0' + m : m) + ':' +
                        (s <= 9 ? '0' + s : s);
            }
        </script>



        <script type="text/javascript">

            function myMap() {
                var arrDataPHP = <?php echo json_encode($z); ?>;
                var n = 0;
                var myCenter = new google.maps.LatLng(arrDataPHP[n][1], arrDataPHP[n][2]);
                var mapCanvas = document.getElementById("map");
                var mapOptions = {
                    center: myCenter,
                    /*mapTypeId: google.maps.MapTypeId.SATELLITE,
                     scrollwheel: true,*/
                    zoom: arrDataPHP [n][5],
                    /*heading : 90,
                     tilt : 45*/
                };
                var map = new google.maps.Map(mapCanvas, mapOptions);
                var image = {
                    url: 'assets/img/pina.png',
                    // This marker is 20 pixels wide by 32 pixels high.
                    size: new google.maps.Size(23, 35),
                    // The origin for this image is (0, 0).
                    origin: new google.maps.Point(0, 0),
                    // The anchor for this image is the base of the flagpole at (0, 32).
                    anchor: new google.maps.Point(0, 35)
                };
                // Shapes define the clickable region of the icon. The type defines an HTML
                // <area> element 'poly' which traces out a polygon as a series of X,Y points.
                // The final coordinate closes the poly by connecting to the first coordinate.
                var shape = {
                    coords: [1, 1, 1, 23, 18, 35, 18, 10],
                    type: 'poly'
                };

                var marker1 = [];

                for (n = 0; n < arrDataPHP.length; n++) {
                    marker1[n] = new google.maps.Marker({
                        position: new google.maps.LatLng(arrDataPHP[n][1], arrDataPHP[n][2]),
                        title: arrDataPHP[n][4],
                        map: map,
                        label: arrDataPHP[n][6],
                        draggable: false,
                        icon: image,
                        shape: shape,
                        id: arrDataPHP[n][7]
                    });

                    google.maps.event.addListener(marker1[n], 'click', (function (marker1, n) {
                        return function () {

                            modal.style.display = "block";
                            /*infowindow.setContent("usuario: "+arrDataPHP[n][0] + ".<br/>Fecha: " + arrDataPHP[n][3] + ".<br/>Lugar: " + arrDataPHP[n][4]);
                             infowindow.open(map, marker1);
                             modal.style.display = "block";
                             
                             document.getElementById("NombreUsuarioModal").textContent = arrDataPHP[n][0];
                             document.getElementById("enlaceVerCompleto").innerHTML = "<a style='color: #fff;' href='pages/asistencia-detalles.php?idSupervisor="+ arrDataPHP[n][7] + "'>Ver Todo</a>";*/


                        }
                    })(marker1[n], n));

                    console.log(marker1[n].id);

                    google.maps.event.addListener(marker1[n], 'click', function (event) {
                    });
                    google.maps.event.addListener(marker1[n], 'drag', function (event) {
                    });
                    //marker1.setMap(map);
                }


                /*var infowindow = new google.maps.InfoWindow({
                 content: ""
                 });
                 infowindow.open(map,marker1);*/
            }
        </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeAPkXd6qY2mg2QJ0bdMWbqO7Wjgs3diM&callback=myMap" async defer></script>




    </body>



    <!-- END BODY -->
</html>
