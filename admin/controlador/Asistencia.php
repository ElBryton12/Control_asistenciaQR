<?php
require_once '../modelos/Asistencia.php'; //Se incluye el archivo que contiene la clase Asistencia 

$asistencia = new Asistencia(); //Se instancia un objeto de la clase Asistencia

$empleado_id = isset($_POST["empleado_id"]) ? limpiarCadena($_POST["empleado_id"]) : ""; //Se obtiene el ID del empleado y se limpia para evitar inyeccion de codigo

//Se ejecuta un switch para determinar la accion a realizar segun el parametro 'op' enviado por GET
switch ($_GET["op"]) {
    case 'listar': //Caso para listar todas las asistencias
        $rspta = $asistencia->listar(); //Se llama al metodo listar de la clase Asistencia
        $data = Array(); //Se crea un array para almacenar los datos de las asistencias

        $item = 0; //variable para contar los items en el listado 
        while ($reg = $rspta->fetch_object()) { //Se recorre el resultado de la consulta
            $item++; //Se incrementa el contador de items
            $data[] = array( //Se almacenan los datos de cada asistencia al array
                "0" => $item,
                "1" => $reg->codigo,
                "2" => $reg->empleado,
                "3" => $reg->fecha,
                "4" => $reg->hora,
                "5" => ($reg->tipo == 'Entrada') ? '<span class="label bg-green">' . $reg->tipo . '</span>' : '<span class="label bg-orange">' . $reg->tipo . '</span>',
            );
            $item++; //Se incrementa el contador de items
        
        }

        //Se crea un array con la infomracion necesaria para el datatables
        $results = array(
            "sEcho" => 1, //Informacion para el datatables
            "iTotalRecords" => count($data), //Enviamos el total de registros al datatables
            "iTotalDisplayRecords" => count($data), //Enviamos el total de registros a visualizar
            "aaData" => $data //Los datos de las asistencias para Datatables
        );
        echo json_encode($results); //Se devuelve la respuesta en formato JSON

        break;

        case 'listar_asistencia': //Caso para listar todas las asistencias dentro de unnrango de fechas y para un empleado en especifico
            $fecha_inicio = $_REQUEST["fecha_inicio"]; //Se obtiene la fecha de inicio del rango
            $fecha_fin = $_REQUEST["fecha_fin"]; //Se obtiene la fecha de fin del rango  
            $empleado_id = $_REQUEST["empleado_id"]; //Se obtiene el ID del empleado
            $rspta = $asistencia->listar_reporte($fecha_inicio, $fecha_fin, $empleado_id); //Se llama al metodo listar_reporte de la clase Asistencia
            
            $data = array(); //Se crea un array para almacenar los datos de las asistencias
            
            $item = 0; //variable para contar los items en el listado
            while ($reg = $rspta->fetch_object()) { //Se recorre el resultado de la consulta
                $data[] = array( //Se almacenan los datos de cada asistencia al array
                    "0" => $item,
                    "1" => $reg->codigo,
                    "2" => $reg->empleado,
                    "3" => $reg->fecha,
                    "4" => $reg->hora,
                    "5" => ($reg->tipo == 'Entrada') ? '<span class="label bg-green">' . $reg->tipo . '</span>' : '<span class="label bg-orange">' . $reg->tipo . '</span>',
                );
                $item++; //Se incrementa el contador de items
            
            }

            //Se crea un array con la infomracion necesaria para el datatables
            $results = array(
                "sEcho" => 1, //Informacion para el datatables
                "iTotalRecords" => count($data), //Enviamos el total de registros al datatables
                "iTotalDisplayRecords" => count($data), //Enviamos el total de registros a visualizar
                "aaData" => $data //Los datos de las asistencias para Datatables
            );
            echo json_encode($results); //Se devuelve la respuesta en formato JSON

            break;
}