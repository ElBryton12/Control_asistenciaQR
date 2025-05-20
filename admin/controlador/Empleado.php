<?php
require_once "../modelos/Empleado.php"; //Sse incluye el archivo que contiene la clase de Empleado

$empleado = new Empleado(); //Se instancia un objeto de la clase Empleado

//Se obtienen los datos del formulario y se limpian para evitar inyeccion de codigo
$empleado_id = isset($_POST["empleado_id"]) ? limpiarCadena($_POST["empleado_id"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$documento_numero = isset($_POST["documento_numero"]) ? limpiarCadena($_POST["documento_numero"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";

//Se ejecuta unb switch para determinar la accion a realizar segun el parametro 'op' enviado por GET
switch ($_GET["op"]) {
    case 'guardaryeditar': //Caso para guardar o editar un empleado
        if (empty($empleado_id)) { //Si el ID del empleado esta vacio, se inserta un nuevo empleado 
            $rspta = $empleado->insertar($nombre, $apellidos, $documento_numero, $telefono, $codigo);
            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar  los datos";
        } else { //Si el ID del empleado no esta vacio, se edita un empleado existente
            $rspta = $empleado->editar($empleado_id, $nombre, $apellidos, $documento_numero, $telefono, $codigo);
            //Se devuelve un mensaje segun el resultado de la operacion
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        }
        break;
    
    case 'mostrar': //Caso para mostrar los datos de un empleado especifico
        $rspta = $empleado->mostrar($empleado_id); 
        echo json_encode($rspta); //Se devuelve la respuesta en formato JSON
        break;

    case 'listar': //Caso para listar todos los empleados
        $rspta = $empleado->listar(); 
        $data = Array(); //Se crea un array para almacenar los datos de los empleados 
    
        while ($reg = $rspta->fetch_object()) { //Se recorre el resultado de la consulta
            $data[] = array( //Se almacenan los datos de cada empoleado al array
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $reg->id . ')"><i class="fa fa-pencil"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->apellidos,
                "3" => $reg->documento_numero,
                "4" => $reg->telefono,
                "5" => $reg->codigo,
            );
        }
        
        //Se crea un array con la infomracion necesaria para el datatables
        $results = array(
            "sEcho" => 1, //Informacion para el datatables
            "iTotalRecords" => count($data), //Enviamos el total de registros al datatables
            "iTotalDisplayRecords" => count($data), //Enviamos el total de registros a visualizar
            "aaData" => $data //Los datos de los empleados para Datatables
        );
        echo json_encode($results); //Se devuelve la respuesta en formato JSON
        break;

    case 'select_empleado': //Caso para generar un select conla lista de empleados
        $rspta = $empleado->select(); //Se llama al metodo select de la clase Empleado
        
        //Se crea un array para almacenar los datos de los empleados
        while ($reg = $rspta->fetch_object()) { //Se recorre el resultado de la consulta
            echo '<option value=' . $reg->id . '>' . $reg->nombre . ' ' . $reg->apellidos .  '</option>'; //Se generan las opciones del select
        }
        break;
}
