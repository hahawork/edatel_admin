<?php
session_start();

//Importamos el archivo con las validaciones.
require_once ('funciones/validaciones.php');


require_once("conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: ../login/index.php');
    exit;
}

$date = date("Y-m-d");
$dateSelected = isset($_POST["dateSelected"]) ? $_POST["dateSelected"] : $date;
$idUsuarioSelected = isset($_POST["selectUsuario"]) ? $_POST["selectUsuario"] : '0';
$nombreSeleccionado = isset($_POST["NombreUsuario"]) ? $_POST["NombreUsuario"] : '';

$consulta = "SELECT * FROM `vw_rutaxfecha` WHERE idUsuario = '$idUsuarioSelected' AND date_format(Fecharegistro, '%Y-%m-%d') like '$dateSelected%' ORDER by Fecharegistro";

$sql2 = mysqli_query($conn, $consulta) or die(mysqli_error($conn));

$z = array();
$path = array();
$indice = 0;
while ($row2 = mysqli_fetch_array($sql2)) {
    $y = array();

    $coordenada = $row2["CoordenadasGPS"];
    $myArray = explode(',', $coordenada);

    $y[] = ($row2["NombreUsuario"]);
    $y[] = $myArray[0];
    $y[] = $myArray[1];
    $y[] = $row2["Fecharegistro"];
    $y[] = ($row2["NombrePdV"]);
    $y[] = $row2["Etiqueta"];
    $y[] = $row2["idUsuario"];
    $z[$indice] = $y;
    $indice++;


    $coord = array();
    $coord["lat"] = $myArray[0] + 0;
    $coord["lng"] = $myArray[1] + 0;
    array_push($path, $coord);
}
?>
<html lang="es"> <!--<![endif]-->

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

       <!--         Material Design  -->
       <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
       <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">

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
            $_SESSION["item"] = 3;
            include './header.php';
            ?>
            <!--END MENU SECTION -->
            
                <!--PAGE CONTENT -->
                <div id="content">

                    <div class="inner">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2> Recorrido de Rutas </h2>
                            </div>
                        </div>
                        <hr/>
                        <!--BLOCK SECTION -->

                        <!--END BLOCK SECTION -->
                        <hr />
                        <!-- SECCION DE MAPA -->
                        <div class="row">                        

                            <div class="col-sm-12 col-md-4">

                                <div class="panel panel-info">
                                    <form class="form-inline" name="frmConsultar" action="recorrido_rutas.php" method="POST">
                                        <div class="input-group">

                                            <label for="selectUsuario" class="input-group-addon label-info">Usuario</label>
                                            <select class="form-control" name="selectUsuario" id="selectUsuario"  class="validate[required] form-control">                                                
                                                <option value="0" selected="selected" disabled="disabled">Seleccione un usuario...</option>
                                                <?php
                                                require_once("conexion/conexion.php");
                                                $cnn = new conexion();
                                                $conn = $cnn->conectar();
                                                $sql = "SELECT * FROM tbl_edatel_usuarios where Estado=1";
                                                $resultado = mysqli_query($conn, $sql);
                                                if ($resultado) {
                                                    if (mysqli_num_rows($resultado) > 0) {
                                                        while ($rowTipo = mysqli_fetch_array($resultado)) :
                                                            ?>
                                                            <option value="<?php echo $rowTipo['idUsuario']; ?>"><?php echo ($rowTipo['NombreUsuario']); ?></option>
                                                            <?php
                                                        endwhile;
                                                    }
                                                }
                                                ?>
                                            </select>

                                            <!-- Script para tomar el nombre de la persona seleccionada en la lista-->
                                            <input id="NombreUsuario" type = "hidden" name = "NombreUsuario" value = "" />
                                            <script type="text/javascript">
                                                function setTextField(ddl) {
                                                    document.getElementById('NombreUsuario').value = ddl.options[ddl.selectedIndex].text;
                                                }
                                            </script>  
                                        </div>

                                        <div class="input-group">
                                            <label for="dateSelected" class="input-group-addon label-info">Fecha</label>
                                            <input type="date" name="dateSelected" class="form-control" id="dateSelected" value="<?php echo $dateSelected; ?>" max="<?php echo $date; ?>">
                                        </div>
                                        <button class="btn btn-success">Consultar</button>
                                    </form>

                                </div>

                            </div>

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
                        </div>
                        <!-- END COMMENT AND NOTIFICATION  SECTION -->
                        <div class="col-xs-12">
                            <div class="panel panel-primary" >
                                <div class="panel-heading">
                                    <h3 class="box-title pull-left">Puntos de Venta (<span class="label-warning"><?php echo $nombreSeleccionado; ?></span>)</h3>                                    

                                </div>
                                <!-- /.box-header -->
                                <div class="panel-body w3-theme">                                      
                                    <?php
                                    $pos = 0;
                                    foreach ($z as $value) :
                                        ?>
                                        <div class="col-sm-6 col-md-4 col-lg-3 btn-link" onclick="showPosicion(<?php echo $pos; ?>)">
                                            <div class="w3-white w3-card" style="margin: 4px; padding: 5px;"><?php echo "Ent:" . $value[3] . " - " . $value[4]?><i class="fa fa-arrow-right pull-right" style="color: #00f;"></i></div>
                                        </div>                                   
                                        <?php
                                        $pos = $pos + 1;
                                    endforeach;
                                    ?>
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

            <!-- PAGE LEVEL SCRIPTS -->
            <script src="assets/plugins/flot/jquery.flot.js"></script>
            <script src="assets/plugins/flot/jquery.flot.resize.js"></script>
            <script src="assets/plugins/flot/jquery.flot.time.js"></script>
            <script src="assets/js/for_index.js"></script>

            <!-- END PAGE LEVEL SCRIPTS -->


            <script>

                var arreglo = <?php echo json_encode($z); ?>;
                console.log(arreglo);
                var coorden = <?php echo json_encode($path); ?>;
                var markers = [];
                var map;
                var flightPath;
                var marcador;

                function myMap() {

                    var mapCanvas = document.getElementById("map");
                    var myCenter = new google.maps.LatLng(arreglo[0][1], arreglo[0][2]);
                    var mapOptions = {center: myCenter, zoom: 13};
                    map = new google.maps.Map(mapCanvas, mapOptions);

                    flightPath = new google.maps.Polyline({
                        path: coorden,
                        geodesic: true,
                        strokeColor: "#0000FF",
                        strokeOpacity: 0.8,
                        strokeWeight: 2
                    });

                    clearMarkers();
                    flightPath.setMap(map);
                    for (var i = 0; i < coorden.length; i++) {
                        addMarkerWithTimeout(i, coorden[i], i * 1500);
                    }
                }

                function drop() {
                    clearMarkers();
                    flightPath.setMap(map);
                    for (var i = 0; i < coorden.length; i++) {
                        addMarkerWithTimeout(i, coorden[i], i * 1500);
                    }
                }
                function addMarkerWithTimeout(i, position, timeout) {
                    window.setTimeout(function() {
                        markers.push(new google.maps.Marker({
                            position: position,
                            label: arreglo[i][5],
                            map: map,
                            title: arreglo[i][4],
                            animation: google.maps.Animation.DROP
                        }));

                        map.panTo(position);

                    }, timeout);
                }

                function clearMarkers() {
                    for (var i = 0; i < markers.length; i++) {
                        markers[i].setMap(null);
                    }
                    flightPath.setMap(null);
                    markers = [];
                }

                function showPosicion(position) {
                    try {
                        marcador.setMap(null);
                    } catch (err) {
                        console.log(err.message);
                    }
                    map.panTo(coorden[position]);

                    var image = {
                        url: 'https://cdn0.vox-cdn.com/dev/uploads/chorus_asset/file/8108508/sandbox-www-data-ip-10-0-0-66_/sandbox_favicon-32x32.0.png',
                        size: new google.maps.Size(32, 32),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(0, 32)
                    };
                    var shape = {
                        coords: [0, 0, 0, 32, 18, 20, 18, 1],
                        type: 'poly'
                    };

                    marcador = new google.maps.Marker({
                        map: map,
                        draggable: true,
                        icon: image,
                        animation: google.maps.Animation.BOUNCE,
                        shape: shape,
                        position: coorden[position]
                    });
                }
            </script>

            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeAPkXd6qY2mg2QJ0bdMWbqO7Wjgs3diM&callback=myMap" async defer></script>

        </body>



        <!-- END BODY -->
        </html>

