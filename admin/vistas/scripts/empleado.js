var tabla;

// Función que se ejecuta al inicio
function init() {
    mostrarform(false); // ocultar el formulario
    listar();           // listar los registros

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
}

// Limpiar formulario
function limpiar() {
    $("#empleado_id").val("");
    $("#nombre").val("");
    $("#apellidos").val("");
    $("#documento_numero").val("");
    $("#telefono").val("");
    $("#codigo").val(""); // solo lectura, pero lo dejamos limpio
}

// Mostrar / ocultar formulario
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

// Cancelar form
function cancelarform() {
    limpiar();
    mostrarform(false);
}

// Listar empleados
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true,      // activamos el procesamiento del datatables
        "aServerSide": true,      // paginación y filtrado del lado servidor
        dom: 'Bfrtip',            // elementos del control de tabla
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
        "iDisplayLength": 10,     // paginación
        "order": [[0, "desc"]]    // ordenar (columna, orden)
    }).DataTable();
}

// Guardar y editar
function guardaryeditar(e) {
    e.preventDefault(); // no se activará la acción predeterminada
    $("#btnGuardar").prop("disabled", true); // desactivar el botón guardar
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controlador/Empleado.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos);
            limpiar();
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
}

// Mostrar datos de un empleado en el formulario
function mostrar(empleado_id) {
    $.get("../controlador/Empleado.php?op=mostrar&id=" + empleado_id, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#empleado_id").val(data.id);
        $("#nombre").val(data.nombre);
        $("#apellidos").val(data.apellidos);
        $("#documento_numero").val(data.documento_numero);
        $("#telefono").val(data.telefono);
        $("#codigo").val(data.codigo); // para ver qué código tiene asignado
    });
}

// Eliminar empleado
function eliminar(empleado_id) {
    bootbox.confirm("¿Está seguro de eliminar al empleado?", function (result) {
        if (result) {
            $.get("../controlador/Empleado.php?op=eliminar&id=" + empleado_id, function (resp) {
                bootbox.alert(resp);
                tabla.ajax.reload();
            });
        }
    });
}

// Ver QR desde el botón de la primera columna
function verQR(empleado_id) {
    $.get("../controlador/Empleado.php?op=mostrar&id=" + empleado_id, function (data) {
        data = JSON.parse(data);
        if (data.imagen_qr) {
            verQRGrande(data.imagen_qr, data.nombre + " " + data.apellidos);
        } else {
            bootbox.alert("Este empleado todavía no tiene código QR generado.");
        }
    });
}

// Ver QR en grande (se usa también desde la imagen de la tabla)
function verQRGrande(nombreArchivo, nombreEmpleado) {
    var imageUrl = "../files/qrcodes/" + nombreArchivo;

    bootbox.dialog({
        title: "Código QR de " + nombreEmpleado,
        message:
            "<div class='text-center'>" +
                "<img src='" + imageUrl + "' style='max-width:100%; height:auto;'>" +
            "</div>",
        size: "large"
    });
}

// Imprimir QR
function imprimirQR(nombreArchivo, nombreEmpleado) {
    var imageUrl = "../files/qrcodes/" + nombreArchivo;
    var ventana = window.open('', '_blank', 'width=400,height=450');

    ventana.document.write(
        "<html><head><title>QR de " + nombreEmpleado + "</title></head><body>" +
        "<div style='text-align:center;'>" +
        "<h3>QR de " + nombreEmpleado + "</h3>" +
        "<img src='" + imageUrl + "' style='max-width:100%; height:auto;'>" +
        "</div>" +
        "</body></html>"
    );

    ventana.document.close();
    ventana.focus();
    ventana.print();
    // ventana.close(); // opcional
}

// Regenerar QR (cuando no existe)
function regenerarQR(empleado_id) {
    bootbox.confirm("¿Desea generar/regenerar el código QR de este empleado?", function (result) {
        if (result) {
            $.get("../controlador/Empleado.php?op=regenerarQR&id=" + empleado_id, function (resp) {
                bootbox.alert(resp);
                tabla.ajax.reload();
            });
        }
    });
}

// Ejecutar al cargar el documento
init();
