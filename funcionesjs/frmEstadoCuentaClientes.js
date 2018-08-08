var table;

$(document).ready(function () {



    //se rellena la tabla con datos iniciales
    $.ajax({
        url: "funciones/frmEstadoCuentaClientes_funciones.php",
        dataType: 'html',
        type: 'POST',
        cache: false,
        data: {
            opcion: 1
        },
        beforeSend: function (xhr) {

        },
        success: function (data, textStatus, jqXHR) {
            $("#text").hide();
            //se llena el body de la table
            $("#tblUsuarios tbody").html(data);
            //convertir la tabla en datatable para agregarle funciones
            table = $('#tblUsuarios').dataTable({
                "paging": false
            });

        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#text").hide();
        }
    });

    //esto es para cuado cambia el tipo de vista de la tabla
    $('input[type=radio][name=editList]').change(function () {
        if ($("input[name='editList']").val() == 'N') { //nombre
            alert("Allot");
        } else if ($("input[name='editList']").val() == 'T') { //telefono
            alert("Transfer");
        } else if ($("input[name='editList']").val() == 'R') { //rutas
            alert("ruta");
        }
    });



    $('#rbclientes input[type=radio]').change(function () {
        if ($(this).val() == 'todos') {

            $(".checkSingle").each(function () {
                this.checked = true;
            })
        } else {
            $(".checkSingle").each(function () {
                this.checked = false;
            })
        }

        if ($(this).val() == 'ruta') {

            $('#tblUsuarios').DataTable().search($('#selectrutas').val()).draw();
            $('input[type=search]').val($('#selectrutas').val());
        }

        if ($(this).val() == 'quitar') {
            $('#tblUsuarios').DataTable().search('').draw();
            $(".checkSingle").each(function () {
                this.checked = false;
            })
        }

    })

//cuando canbia el select rutas
    $('#selectrutas').on('change', function () {
        $('#tblUsuarios').DataTable().search($(this).val()).draw();
        $('input[type=search]').val($(this).val());
    });


    $('#btnLimpiarCreditos').on('click', function () {
        //cantidad de checkbox checkados
        var cantidad = $('.checkSingle:checked').size();
        if (cantidad > 0) {

            //por cada checkbox
            $(".checkSingle").each(function () {
                //si este checkbox estacheckado
                if (this.checked) {

                    var idcliente = $('.checkSingle').attr('id');
                    console.log("id del cliente: " + idcliente);
                }
            });

        } else {
            alert("No hay seleccionados");
        }
    })

//    $("#checkedAll").change(function () {
//        if (this.checked) {
//            $(".checkSingle").each(function () {
//                this.checked = true;
//            })
//        } else {
//            $(".checkSingle").each(function () {
//                this.checked = false;
//            })
//        }
//    });
//
//    $(".checkSingle").click(function () {
//        if ($(this).is(":checked")) {
//            var isAllChecked = 0;
//            $(".checkSingle").each(function () {
//                if (!this.checked)
//                    isAllChecked = 1;
//            })
//            if (isAllChecked == 0) {
//                $("#checkedAll").prop("checked", true);
//            }
//        } else {
//            $("#checkedAll").prop("checked", false);
//        }
//    });
});

function fnObtenerDetallesVentasCreditoCliente(idcliente, nombre, telefono, ruta) {

    $("#txtmodalIdCliente").val(idcliente);
    $("#txtmodalRuta").val(ruta);
    $("#txtmodalNombre").val(nombre);
    $("#txtmodalNumPOS").val(telefono);

    //se rellena la tabla con datos iniciales
    $.ajax({
        url: "funciones/frmEstadoCuentaClientes_funciones.php",
        dataType: 'html',
        type: 'POST',
        cache: false,
        data: {
            opcion: 2,
            idcliente: idcliente,
        },
        beforeSend: function (xhr) {

        },
        success: function (data, textStatus, jqXHR) {
            //se llena el body de la table
            $("#tblmodalDetalleventasClientes tbody").html(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });


}

function fnLimparCreditoVentaModal(idcliente, idventa, saldo) {
    //se manda a abonar con el saldo total y  se deja el saldo en blanco
    $.ajax({
        url: "funciones/frmEstadoCuentaClientes_funciones.php",
        dataType: 'JSON',
        type: 'POST',
        cache: false,
        data: {
            opcion: 3,
            idVenta: idventa,
            idCliente: idcliente,
            cantidad_abono: saldo,
            cantidad_saldo: 0
        },
        beforeSend: function (xhr) {

        },
        success: function (data, textStatus, jqXHR) {

            if (data.status == 1) {
                alert(data.message);
                $('#' + idventa).remove();
            } else {
                alert(data.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("erorr: " + textStatus + ", descripcion: " + errorThrown);
        }
    }).fail(function () {
        //alert("error");
    }).always(function () {
        //alert("completado");
    });
}

/**
 * Esta funcion es para setear las variables al iniciar el dialog de abonar
 * @param {type} idVenta
 * @param {type} idCliente
 * @param {type} abonado
 * @param {type} deudaventa
 * @returns {undefined}
 */
function fnAbonarVentaCredito_setvariables(idVenta, idCliente, abonado, deudaventa) {
    //se pone en el placeholder la deuida de esa venta
    $("#txtcantAbonar").attr("placeholder", "Debe: " + deudaventa);
    $("#HiddentxtIdVenta").val(idVenta);
    $("#HiddentxtIdcliente").val(idCliente);
    $("#HiddentxtAbonado").val(abonado);
    $("#HiddentxtSaldo").val(deudaventa);
    $("#txtcantAbonar").val(deudaventa);
}

/*
 * Esta funcion es llamada desd el boton abonar del dialog abonar en estadocuenta del cliente
 */
function fnAbonarVentaCredito() {

    var idventa = parseFloat($("#HiddentxtIdVenta").val()),
            idcliente = parseFloat($("#HiddentxtIdcliente").val()),
            abonado = parseFloat($("#HiddentxtAbonado").val()),
            saldo = parseFloat($("#HiddentxtSaldo").val());

    var cantAbonar = parseFloat($("#txtcantAbonar").val());


    if (cantAbonar > 0) {

        if (cantAbonar <= saldo) {
            $.ajax({
                url: "funciones/frmEstadoCuentaClientes_funciones.php",
                dataType: 'JSON',
                type: 'POST',
                cache: false,
                data: {
                    opcion: 4,
                    idVenta: idventa,
                    idCliente: idcliente,
                    cantidad_abono: cantAbonar,
                    cantidad_saldo: (saldo - cantAbonar)
                },
                beforeSend: function (xhr) {

                },
                success: function (data, textStatus, jqXHR) {

                    if (data.status == 1) {
                        alert(data.message);  
                        $("#txtcantAbonar").val("");
                        $('#modalAbonarCredito').modal('hide');                        
                    } else {
                        alert(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("erorr: " + textStatus + ", descripcion: " + errorThrown);
                }
            }).fail(function () {
                //alert("error");
            }).always(function () {
                //alert("completado");
            });

        } else {
            alert("No puedes abonar mas de la cuenta.");
        }
    } else {
        alert("Por favor ingrese una cantidad válida");
    }



}