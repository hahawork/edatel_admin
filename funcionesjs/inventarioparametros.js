$(document).ready(function () {

    //esto es para el mensajito encima de un controol al pasar el mouse
    $('[data-toggle="tooltip"]').tooltip();

    $('#dataTablesFamilia').dataTable();
    $('#dataTablesMarcas').dataTable();
    $('#dataTablesUM').dataTable();
    
    $(function () {
            $('#dataTablesFamilia').DataTable({
            "paging": false,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true
            });
    
    $('#dataTablesFamilia').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#dataTablesMarcas').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#dataTablesUM').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    //dataTablesUM
});

//para las familias*************************************************************
function fnGuardarFamilia() {
    //get
    var IdFamilia = $('#txtIdFamilia').val();
    var Descripcion = $('#txtDescFamilia').val();
    //Set
    //$('#txt_name').val(bla);
    if (Descripcion.length > 0) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            cache: false,
            url: "funciones/inventario_guardanuevafamilia.php",
            data: {
                Descripcion: Descripcion,
                id_catproducto: IdFamilia
            },
            success: function (result) {
                console.log(result);
                if (result.success === 1) {
                    $('#txtIdFamilia').val("");
                    $('#txtDescFamilia').val("");
                    //refresca la tabla despues de insertar
                    $("#dataTablesFamilia").load("frmInventarioParametros.php #dataTablesFamilia");
                    alert(result.message);
                } else {
                    alert("erorr: " + result.error);
                }
            }
        });
    } else {
        alert("Por favor llene todos los campos.");
    }
}
function fnLimpiarLlenarCamposFamilia(idFamilia = "", Descripcion = "") {
    $('#txtIdFamilia').val(idFamilia);
    $('#txtDescFamilia').val(Descripcion);
}
//******************************************************************************

// para las marcas -------------------------------------------------------------
function fnGuardarMarca() {
//get
    var idMarca = $('#txtIdMarca').val();
    var IdFamilia = $('#selectFamilia').val();
    var Descripcion = $('#txtMarca').val();
    //Set
    //$('#txt_name').val(bla);
    if (Descripcion.length > 0 && IdFamilia > 0) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            cache: false,
            url: "funciones/inventario_guardanuevamarca.php",
            data: {
                id_marca: idMarca,
                DescMarca: Descripcion,
                id_catproducto: IdFamilia
            },
            success: function (result) {
                console.log(result);
                if (result.success === 1) {
                    $('#txtIdMarca').val("");
                    $('#selectFamilia').val("0");
                    $('#txtMarca').val("");
                    //refresca la tabla despues de insertar
                    $("#dataTablesMarcas").load("frmInventarioParametros.php #dataTablesMarcas");
                    alert(result.message);
                } else {
                    alert("erorr: " + result.error);
                }
            }
        });
    } else {
        alert("Por favor llene todos los campos o seleccione una familia.");
    }
}
function fnLimpiarLlenarCamposMarca(idMarca = "", Familia = "0", Descripcion = "") {
    $('#txtIdMarca').val(idMarca);
    $('#selectFamilia').val(Familia);
    $('#txtMarca').val(Descripcion);
}
//------------------------------------------------------------------------------

// para las unidades de medida +++++++++++++++++++++++++++++++++++++++++++++++++
function fnGuardarUnddMedida() {
    //get
    var idUndmedida = $('#txtIdUM').val();
    var NombreMedida = $('#txtNombreUM').val();
    var Abreviatura = $('#txtAbrevUM').val();
    
    var metodo = idUndmedida > 0 ? "EDITAR" : "GUARDAR";
    //Set
    //$('#txt_name').val(bla);
    if (NombreMedida.length > 0) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            cache: false,
            url: "funciones/inventario_guardarunidadmedida.php?modo=administrar",
            data: {
                idUndmedida: idUndmedida,
                NombreMedida: NombreMedida,
                Abreviatura: Abreviatura,
                metodo: metodo
            },
            success: function (result) {
                console.log(result);
                if (result.success == 1) {
                    $('#txtIdUM').val("");
                    $('#txtNombreUM').val("");
                    $('#txtAbrevUM').val("");
                    //refresca la tabla despues de insertar
                    $("#dataTablesUM").load("frmInventarioParametros.php #dataTablesUM");
                    alert(result.message);
                } else {
                    alert("erorr: " + result.error);
                }
            }

        }).fail(function (jqXHR, textStatus, error) {
            // Handle error here
            alert("Error: " + jqXHR.responseText + ", .:. " + error);
            //$('#editor-content-container').html(jqXHR.responseText);
            //$('#editor-container').modal('show');
        });
    } else {
        alert("Por favor llene todos los campos.");
    }
}
function fnObtenerUndsMedida(idUndmedida = 0) {
    if (idUndmedida > 0) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            cache: false,
            url: "funciones/inventario_guardarunidadmedida.php?modo=obtener",
            data: {
                idUndmedida: idUndmedida
            },
            success: function (result) {
                console.log(result);
                if (result.success == 1) {
                    $('#txtIdUM').val(result.idUndmedida);
                    $('#txtNombreUM').val(result.NombreMedida);
                    $('#txtAbrevUM').val(result.Abreviatura);                    
                    alert(result.message);
                } else {
                    alert("erorr: " + result.error);
                }
            }
        }).fail(function (jqXHR, textStatus, error) {
            // Handle error here
            alert("Error: " + jqXHR.responseText + ", .:. " + error);
            //$('#editor-content-container').html(jqXHR.responseText);
            //$('#editor-container').modal('show');
        });
    }
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++