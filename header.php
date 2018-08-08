<?php
$idUsuario = $_SESSION["sUserId"];
$TipoUsuario = $_SESSION["sIdTipoUsuario"];

require_once("conexion/conexion.php");
$cnn = new conexion();
$conn = $cnn->conectar();
?>

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
        </div>
        <br />
    </div>

    <ul id="menu" class="collapse">
        <?php
        $SqlMenu = "select distinct `ui`.`idMenu` AS `idMenu`,`m`.`DescMenu` AS `DescMenu`,`m`.`claseIcono` AS `claseIcono`,`m`.`MenuPosicion` AS `MenuPosicion` "
                . "from `tbl_sistweb_usuario_items` `ui` inner join `tbl_sistweb_menu` `m` on `ui`.`idMenu` = `m`.`idMenu` "
                . "WHERE idUsuario = $idUsuario AND EstadoPermitido = 1 "
                . "order by `m`.`MenuPosicion`";
        if ($result = mysqli_query($conn, $SqlMenu)) {

            $posicMenu = 1;
            $posicItem = 1;

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <li class="panel <?php echo $_SESSION["seccion"] == $posicMenu ? "active" : ""; ?>">
                    <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#pagesr-nav<?php echo $row["idMenu"]; ?>">
                        <i class="<?php echo $row["claseIcono"]; ?>"></i> <?php echo $row["DescMenu"]; ?>
                        <span class="pull-right">
                            <i class=" icon-double-angle-right"></i>
                        </span>

                    </a>
                    <ul class="<?php echo $_SESSION["seccion"] == $posicMenu ? "in" : "collapse"; ?>" id="pagesr-nav<?php echo $row["idMenu"]; ?>">

                        <?php
                        $sqlItem = "SELECT ui.`idUsuItem`, m.DescMenu, mi.DescItem, mi.claseIcono, mi.urlForm "
                                . "FROM `tbl_sistweb_usuario_items` ui INNER JOIN "
                                . "tbl_sistweb_menu_items mi ON ui.`idMenuItem` = mi.idMenuItem INNER JOIN "
                                . "tbl_sistweb_menu m ON ui.`idMenu` = m.idMenu "
                                . "WHERE ui.`idUsuario` = '$idUsuario' AND ui.`idMenu` = '".$row["idMenu"]."' AND `EstadoPermitido` = '1' "
                                . "ORDER BY mi.itemPosic";
                        if ($resultItem = mysqli_query($conn, $sqlItem)) {
                            while ($rowItem = mysqli_fetch_assoc($resultItem)) {
                                ?>
                                <li class = "<?php echo ($_SESSION["seccion"] == $posicMenu and $_SESSION["item"] == $posicItem) ? "active" : "" ?>">
                                    <a href = "<?php echo $rowItem["urlForm"]; ?>"><i class = "<?php echo $rowItem["claseIcono"]; ?>"></i> <?php echo $rowItem["DescItem"]; ?> </a>
                                </li>                                

                                <?php
                                $posicItem ++;
                            }
                            $posicItem = 1;
                        }
                        ?>
                    </ul>
                </li>
                <?php
                $posicMenu ++;
            }
        }
        ?>
                
        <li class="panel">
            <a href="logout.php" ><i class="icon-off"></i> Cerrar Sesión</a>    
        </li>
    </ul>
</div>
<!--END MENU SECTION -->