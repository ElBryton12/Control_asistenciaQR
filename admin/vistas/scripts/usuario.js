var tabla;

//function que se ejecuta al inicio
function init() {
    mostrarform(false); //ocultar el formulario

    listar(); //listar los registros

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })
}

function limpiar(){
    $("#nombre").val("");
    $("#apellidos").val("");
    $("#email").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#imagenmuestra").attr("src","");
    $("#imagenactual").val("");
    $("#idusuario").val("");
}

//function mosrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnAgregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnAgregar").show();
    }
}

//cancelar form
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//function listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true,//activamos el procesamiento del datatables
        "aServerSide": true,//Paginacion y filtrado realizado por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../controlador/Usuario.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, //Paginacion
        "order": [[0, "desc"]] //Ordenar (columna,orden)
    }).DataTable();
}

//function guardar y editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activara la accion predeterminada del evento
    $("#btnGuardar").prop("disabled", true); //Desactivar el boton guardar
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controlador/Usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

function mostrar(idusuario) {
    $.post("../controlador/Usuario.php?op=mostrar", {idusuario: idusuario}, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#nombre").val(data.nombre);
        $("#apellidos").val(data.apellidos);
        $("#email").val(data.email);
        $("#login").val(data.login);
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src", "../files/usuarios/" + data.imagen);
        $("#imagenactual").val(data.imagen);
        $("#idusuario").val(data.id);
    });
}

//function desactivar
function desactivar(idusuario) {
    bootbox.confirm("¿Está Seguro de desactivar el usuario?", function (result) {
        if (result) {
            $.post("../controlador/Usuario.php?op=desactivar", {idusuario: idusuario}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

//function activar
function activar(idusuario) {
    bootbox.confirm("¿Está Seguro de activar el usuario?", function (result) {
        if (result) {
            $.post("../controlador/Usuario.php?op=activar", {idusuario: idusuario}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    })
}

init(); //ejecutar la function init al cargar el documento