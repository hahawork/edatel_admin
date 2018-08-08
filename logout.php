<?php

session_start();

//Importamos el archivo con las validaciones.
require_once ('funciones/validaciones.php');
session_unset();

session_destroy();

redirect("login.php");
?>