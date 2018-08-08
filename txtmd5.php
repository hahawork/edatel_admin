<?php
if (isset($_POST['btnEncriptar']))
    echo "Encriptado: <p id='texto'>" . md5($_POST['txtClave']) . "</p><button onclick='copyToClipboard('#texto')'>Copiar</button>";
?>

<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    <body>
        <div>
            <form method="post" action="txtmd5.php">
                <label for="txtClave">Ingrese el texto</label>
                <input type="text" name="txtClave" id="txtClave" >
                <input type="submit" name="btnEncriptar" value="Encriptar">
            </form>
        </div>

        <script>
            function copyToClipboard(element) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(element).text()).select();
                document.execCommand("copy");
                $temp.remove();
            }
        </script>
    </body>
</html>