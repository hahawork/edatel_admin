
var idUsuario = 0;

$(document).ready(function () {
    //set initial state.
    //$('#textbox1').val(this.checked);

    $('#checkbox1').change(function () {
        if (this.checked) {
            var returnVal = confirm("Are you sure?");
            $(this).prop("checked", returnVal);
        }
        $('#textbox1').val(this.checked);
    });
});

function get_selected_checkboxes_array() {
    var ch_list = Array();
    $("input:checkbox[name=chkIdItem]:checked").each(function () {
        ch_list.push($(this).val());
    });
    console.log(ch_list);
    //return ch_list; 
}

function onRBUsuariosChange(rbUsuarios) {
    idUsuario = 0;
    //se limpian todos los checbox, para luego mostrar los permitidos
    $("input:checkbox[name=chkIdItem]").prop('checked', false);
    idUsuario = rbUsuarios;

    $.ajax({
        type: 'POST',
        cache: false,
        dataType: 'text',
        url: "funciones/ObtenerRolesPermisosPorUsuario.php",
        data: {
            idUsuario: idUsuario
        },
        success: function (data) {

            var a = data.split(",");
            for (var i = 0; i < a.length -1; i++) {    //se pone -1 porque el ultimo viene vacio
                //retorna los id de los checkbos
                var b = a[i];
                console.log(b);
                //segun el id retornado se pone checked
                document.getElementById(b).checked = true;
            }
        }
    });
}

function onCHKItemChanged(idSeccion, idItem, isActivo) {

    if (idUsuario > 0) {

        if (idSeccion > 0 & idItem > 0) {

            var activo = isActivo.checked ? 1 : 0;
            console.log("se procede a guardar usuario: " + idUsuario + ", seccion: " + idSeccion + ", item: " + idItem + ", estado: " + activo);
            $.ajax({
                type: "post",
                cache: false,
                dataType: 'json',
                url: "funciones/ActivarDesactAccesoItemUsuario.php",
                data: {
                    idUsuario: idUsuario,
                    idMenu: idSeccion,
                    idMenuItem: idItem,
                    EstadoActivo: activo
                },
                success: function (data) {
                    if (data.success == 1) {
                        MostrarNotificacion(
                                'Acceso cambiado!',
                        activo == 1 ?'success':'error',
                        activo == 1 ? 'Se ha concedido el permiso con éxito' : 'Se ha restringido el permiso con éxito',
                        
                        );
                    } else {
                        MostrarNotificacion();
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);
                }
            }).fail();
        }
    } else {
        isActivo.checked = !isActivo.checked;
        alert("Primero seleccione un usuario");
    }
}

function MostrarNotificacion(title, image, text) {

    $.gritter.add({
        // (string | mandatory) the heading of the notification
        title: title,
        // (string | optional) the image to display on the left
        image: image == "error" ? 'assets/img/img_error.png' : 'assets/img/img_success.png',
        // (string | mandatory) the text inside the notification
        text: '<a href="#" style="color:#fff">' + text + '</a>',
        fade_in_speed: 100, // how fast notifications fade in (string or int)
        fade_out_speed: 100, // how fast the notices fade out
        time: 2000 // hang on the screen for...
    });

}

function postAjax(url, data, success) {
    var params = typeof data == 'string' ? data : Object.keys(data).map(
            function (k) {
                return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
            }
    ).join('&');

    var xhr = window.XurlMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xhr.open('POST', );
    xhr.onreadystatechange = function () {
        if (xhr.readyState > 3 && xhr.status == 200) {
            success(xhr.responseText);
        }
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
    return xhr;


    /*   EJEMPLOS DE USO
     1.
     // example request
     postAjax('http://foo.bar/', 'p1=1&p2=Hello+World', function (data) {
     console.log(data);
     });
     
     2.
     // example request with data object
     
     postAjax('http://foo.bar/', {p1: 1, p2: 'Hello World'}, function (data) {
     console.log(data);
     });*/
}