var tabla;

//function que se ejecuta al inicio
function init() {
    listar(); //listar los registros
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
            url: '../controlador/Asistencia.php?op=listar',
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