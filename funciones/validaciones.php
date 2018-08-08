<?php

function validaRequerido($valor) {
    if (trim($valor) == '') {
        return false;
    } else {
        return true;
    }
}

function validarEntero($valor, $opciones = null) {
    if (filter_var($valor, FILTER_VALIDATE_INT, $opciones) === FALSE) {
        return false;
    } else {
        return true;
    }
}

function validaEmail($valor) {
    if (filter_var($valor, FILTER_VALIDATE_EMAIL) === FALSE) {
        return false;
    } else {
        return true;
    }
}

function redirect($url) {
    if (!headers_sent()) {
        header('Location: ' . $url);
        exit;
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
        exit;
    }
}

?>