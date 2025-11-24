var tabla;

// function que se ejecuta al inicio
function init() {
    mostrarform(false); // ocultar el formulario

    listar(); // listar los registros

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });

    // Ocultar imagen de muestra al inicio
    $("#imagenmuestra").hide();

    // Previsualizar imagen cuando se selecciona un archivo
    $("#imagen").change(function () {
        var file = this.files[0];
        if (!file) {
            $("#imagenmuestra").attr("src", "").hide();
            return;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#imagenmuestra").attr("src", e.target.result).show();
        };
        reader.readAsDataURL(file);
    });
}

function limpiar(){
    $("#nombre").val("");
    $("#apellidos").val("");
    $("#email").val("");
    $("#login").val("");
    $("#clave").val("");

    // 🔹 limpiar el input file
    $("#imagen").val("");             

    // 🔹 limpiar y ocultar la previsualización
    $("#imagenmuestra").attr("src","").hide(); 

    $("#imagenactual").val("");
    $("#idusuario").val("");
}


//function mostrar formulario
function mostrarform(flag) {
    limpiar();

    if (flag) {
        // Mostrar el formulario, pero NO ocultar la tabla
        $("#formularioregistro").slideDown();     // o .show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").prop("disabled", true);  // opcional: lo deshabilitas
        // Si prefieres ocultar el botón en vez de deshabilitarlo:
        // $("#btnagregar").hide();
    } else {
        // Ocultar el formulario, tabla siempre visible
        $("#formularioregistro").slideUp();       // o .hide();
        $("#btnagregar").prop("disabled", false);
        // Si usaste hide():
        // $("#btnagregar").show();
    }
}


// cancelar form
function cancelarform() {
    limpiar();
    mostrarform(false);
}

// function listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true,// activamos el procesamiento del datatables
        "aServerSide": true,// paginacion y filtrado realizado por el servidor
        dom: 'Bfrtip', // definimos los elementos del control de tabla
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
        "iDisplayLength": 10, // paginacion
        "order": [[0, "desc"]] // ordenar (columna,orden)
    }).DataTable();
}

// function guardar y editar
function guardaryeditar(e) {
    e.preventDefault(); // No se activara la accion predeterminada del evento
    $("#btnGuardar").prop("disabled", true); // Desactivar el boton guardar
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
    $.post("../controlador/Usuario.php?op=mostrar", { idusuario: idusuario }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#nombre").val(data.nombre);
        $("#apellidos").val(data.apellidos);
        $("#email").val(data.email);
        $("#login").val(data.login);
        if (data.imagen) {
            $("#imagenmuestra").attr("src", "../files/usuarios/" + data.imagen).show();
            $("#imagenactual").val(data.imagen);
        } else {
            $("#imagenmuestra").attr("src", "").hide();
            $("#imagenactual").val("");
        }
        $("#idusuario").val(data.id);
    });
}

// function desactivar
function desactivar(idusuario) {
    bootbox.confirm("¿Está Seguro de desactivar el usuario?", function (result) {
        if (result) {
            $.post("../controlador/Usuario.php?op=desactivar", { idusuario: idusuario }, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

// function activar
function activar(idusuario) {
    bootbox.confirm("¿Está Seguro de activar el usuario?", function (result) {
        if (result) {
            $.post("../controlador/Usuario.php?op=activar", { idusuario: idusuario }, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

init(); // ejecutar la function init al cargar el documento
