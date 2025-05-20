var tabla;

//function que se ejecuta al inicio
function init() {
    listar(); //listar los registros

    //cargamos los items al select empleado
    $.post("../controlador/Empleado.php?op=select_empleado", function (r) {
        $("#empleado_id").html(r);
        $('#empleado_id').selectpicker('refresh');
    });
}

//function listar
function listar() {
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();
    var empleado_id = $("#empleado_id").val();

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
        "ajax": 
        {
            url: '../controlador/Asistencia.php?op=listar_asistencia',
            data: { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin, empleado_id: empleado_id },
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


init(); //ejecutar la function init al cargar el documento