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
    $("#empleado_id").val("");
    $("#nombre").val("");
    $("#apellidos").val("");
    $("#documento_numero").val("");
    $("#telefono").val("");
    $("#codigo").val("");
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
            url: '../controlador/Empleado.php?op=listar',
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
        url: "../controlador/Empleado.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            limpiar(); // Movemos la función limpiar aquí
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
}

function mostrar(empleado_id) {
    $.post("../controlador/Empleado.php?op=mostrar", {empleado_id: empleado_id}, 
        function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#nombre").val(data.nombre);
        $("#apellidos").val(data.apellidos);
        $("#documento_numero").val(data.documento_numero);
        $("#telefono").val(data.telefono);
        $("#apellidos").val(data.apellidos);
        $("#codigo").val(data.codigo);
        $("#empleado_id").val(data.id);
    });
}


init(); //ejecutar la function init al cargar el documento