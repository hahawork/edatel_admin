$(document).ready(function () {
    //cuando el select de tipo de rol cambie el value
    $('#select_rol').on('change', function () {
        alert(this.value);
    })
});

function fnGuardarUsuarioNuevo() {
    //Get
    var NombreUsuario = $('#textNombreCompleto').val();
    var Email = $('#textCorreoElectronico').val();
    var Telefono = $('#textNumeroCelular').val();
    var select_rol = "Vendedor";
    var Estado = ($('#chkEstadodelUsuario').is(":checked")) ? 1 : 0;
    var EtiquetaMapa = $('#textEtiquetaMapa').val();
    var select_ruta = $('#select_ruta').val();
    //Set
    //$('#txt_name').val(bla);

    if (
            NombreUsuario.length > 0 &&
            Email.length > 0 &&
            Telefono.length > 0 &&
            select_rol.length > 0 &&
            select_ruta.length > 0
            ) {

        $.ajax({
            type: 'post',
            dataType: 'json',
            cache: false,
            url: "funciones/guardar_nuevo_usuario.php",
            data: {
                NombreUsuario: NombreUsuario,
                Email: Email,
                Telefono: Telefono,
                Rol: select_rol,
                Estado: Estado,
                EtiquetaMapa: EtiquetaMapa,
                id_ruta: select_ruta
            },
            beforeSend: function (xhr) {

            },
            success: function (result) {
                if (result.success === 1) {

                    alert(result.message);

                    $('#textNombreCompleto').val("");
                    $('#textCorreoElectronico').val("");
                    $('#textNumeroCelular').val("");
                    $('#select_rol').val("");
                    $('#textEtiquetaMapa').val("");
                    $('#select_ruta').val("");
                } else {
                    alert(result.error);
                }
            }
        });
    } else {
        alert("Por favor llene todos los campos.");
    }
}

function fnObtenerUsuario(idUsuario) {
    //Set
    //$('#txt_name').val(bla);
    $.ajax({
        type: 'post',
        dataType: 'json',
        cache: false,
        url: "funciones/ObtenerUsuario.php",
        data: {
            idUsuario: idUsuario
        },
        beforeSend: function (xhr) {
        },
        success: function (result) {
            if (result.success === 1) {
                alert(result.message);
                $('#textId').val(result.idUsuario);
                $('#textNombreCompleto').val(result.NombreUsuario);
                $('#textCorreoElectronico').val(result.Email);
                $('#textNumeroCelular').val(result.Telefono);
                $('#select_rol').val(result.Rol);
                $('#textEtiquetaMapa').val(result.EtiquetaMapa);
                $('#select_ruta').val(result.id_ruta);
                $("#chkEstadodelUsuario").prop('checked', result.Estado == 1 ? true : false);
                $("#btnGuardar").hide();
                $("#btnActualizar").show();
            } else {
                alert(result.error);
            }
        }
    });
}

function fnActualizarUsuario() {
    //Get
    var idUsuario = $('#textId').val();
    var NombreUsuario = $('#textNombreCompleto').val();
    var Email = $('#textCorreoElectronico').val();
    var Telefono = $('#textNumeroCelular').val();
    var select_rol = $('#select_rol').val();
    var Estado = ($('#chkEstadodelUsuario').is(":checked")) ? 1 : 0;
    var EtiquetaMapa = $('#textEtiquetaMapa').val();
    var select_ruta = $('#select_ruta').val();
    //Set
    //$('#txt_name').val(bla);

    if (
            idUsuario > 0 &&
            NombreUsuario.length > 0 &&
            Email.length > 0 &&
            Telefono.length > 0 &&
            select_rol.length > 0 &&
            select_ruta.length > 0
            ) {

        $.ajax({
            type: 'post',
            dataType: 'json',
            cache: false,
            url: "funciones/editar_usuario.php",
            data: {
                idUsuario: idUsuario,
                NombreUsuario: NombreUsuario,
                Email: Email,
                Telefono: Telefono,
                Rol: select_rol,
                Estado: Estado,
                EtiquetaMapa: EtiquetaMapa,
                id_ruta: select_ruta
            },
            beforeSend: function (xhr) {

            },
            success: function (result) {
                if (result.success === 1) {

                    alert(result.message);
                    $('#textId').val("");
                    $('#textNombreCompleto').val("");
                    $('#textCorreoElectronico').val("");
                    $('#textNumeroCelular').val("");
                    $('#select_rol').val("");
                    $('#textEtiquetaMapa').val("");
                    $('#select_ruta').val("");
                    $("#btnGuardar").show();
                    $("#btnActualizar").hide();
                } else {
                    alert(result.error);
                }
            }
        });
    } else {
        alert("Por favor llene todos los campos.");
    }
}


function fnGuardarUsuarioNuevoAdmin() {
    //Get
    var Nombres = $('#textNombreAdmin').val();
    var Apellidos = $('#textApellidosAdmin').val();
    var Email = $('#textEmailAdmin').val();
    var Password = $('#textPasswordAdmin').val();
    var IdTipoUsuario = "1";
    var Estado = ($('#chkEstadodelAdmin').is(":checked")) ? 1 : 0;
    var UrlFotoPerfil = "assets/img/perfil-default.png";
    //Set
    //$('#txt_name').val(bla);

    if (
            Nombres.length > 0 &&
            Apellidos.length > 0 &&
            Email.length > 0 &&
            Password.length > 0
            ) {

        $.ajax({
            type: 'post',
            dataType: 'json',
            cache: false,
            url: "funciones/guardar_nuevo_usuario_acceso.php",
            data: {
                Nombres: Nombres,
                Apellidos: Apellidos,
                Email: Email,
                Password: Password,
                IdTipoUsuario: IdTipoUsuario,
                Estado: Estado,
                UrlFotoPerfil: UrlFotoPerfil
            },
            beforeSend: function (xhr) {

            },
            success: function (result) {
                console.log(result)
                if (result.success === 1) {

                    alert(result.message);

                    $('#textNombreAdmin').val("");
                    $('#textApellidosAdmin').val("");
                    $('#textEmailAdmin').val("");
                    $('#textPasswordAdmin').val("");
                    $('#textConfirmPasswAdmin').val("");
                } else {
                    alert(result.error);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);
            }
        }).done(function (data) {
            console.log(data);
        }).fail(function (data) {
            console.log(data)
        });
    } else {
        alert("Por favor llene todos los campos.");
    }
}

function fnObtenerUsuarioAdmin(idUsuario) {
    //Set
    //$('#txt_name').val(bla);
    $.ajax({
        type: 'post',
        dataType: 'json',
        cache: false,
        url: "funciones/ObtenerUsuarioAdmin.php",
        data: {
            idUsuario: idUsuario
        },
        beforeSend: function (xhr) {
        },
        success: function (result) {
            if (result.success === 1) {
                alert(result.message);
                $('#textIdAdmin').val(result.Id_usuario);
                $('#textNombreAdmin').val(result.Nombres);
                $('#textApellidosAdmin').val(result.Apellidos);
                $('#textPasswordAdmin').val(result.Password);
                $('#textConfirmPasswAdmin').val(result.Password);
                $('#textPasswordAdmin').attr('disabled','disabled');
                $('#textConfirmPasswAdmin').attr('disabled','disabled');
                //$('#textPasswordAdmin').removeAttr('disabled');
                $('#textEmailAdmin').val(result.Email);
                $("#chkEstadodelAdmin").prop('checked', result.Estado == 1 ? true : false);
                $("#btnGuardarAdmin").hide();
                $("#btnActualizarAdmin").show();
            } else {
                alert(result.error);
            }
        }
    });
}

function fnActualizarUsuarioAdmin() {
    //Get
    var Id_usuario = $('#textIdAdmin').val();
    var Nombres = $('#textNombreAdmin').val();
    var Apellidos = $('#textApellidosAdmin').val();
    var Email = $('#textEmailAdmin').val();
    var Password = $('#textPasswordAdmin').val();
    var Estado = ($('#chkEstadodelAdmin').is(":checked")) ? 1 : 0;
   
    //Set
    //$('#txt_name').val(bla);

    if (
            Id_usuario > 0 &&
            Nombres.length > 0 &&
            Apellidos.length > 0 &&
            Email.length > 0 &&
            Password.length > 0
            ) {

        $.ajax({
            type: 'post',
            dataType: 'json',
            cache: false,
            url: "funciones/editar_usuarioAdmin.php",
            data: {
                Id_usuario: Id_usuario,
                Nombres: Nombres,
                Apellidos: Apellidos,
                Email: Email,
                Password: Password,
                Estado: Estado
            },
            beforeSend: function (xhr) {

            },
            success: function (result) {
                if (result.success === 1) {

                    alert(result.message);
                    $('#textIdAdmin').val("");
                    $('#textNombreAdmin').val("");
                    $('#textApellidosAdmin').val("");
                    $('#textPasswordAdmin').val("");
                    $('#textConfirmPasswAdmin').val("");
                    $('#textPasswordAdmin').removeAttr('disabled');
                    $('#textConfirmPasswAdmin').removeAttr('disabled');
                    $('#textEmailAdmin').val("");
                    $("#btnGuardarAdmin").show();
                    $("#btnActualizarAdmin").hide();
                } else {
                    alert(result.error);
                }
            }
        });
    } else {
        alert("Por favor llene todos los campos.");
    }
}