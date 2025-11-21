<?php
/**
 * Controlador de Empleado
 * Ubicación: admin/controlador/Empleado.php
 */

require_once "../modelos/Empleado.php";

$empleado = new Empleado();

// Capturar operación
$op = isset($_GET["op"]) ? limpiarCadena($_GET["op"]) : "";

switch ($op) {
    
    case 'guardaryeditar':
        // Capturar datos del formulario
        $empleado_id = isset($_POST["empleado_id"]) ? limpiarCadena($_POST["empleado_id"]) : "";
        $nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
        $apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
        $documento_numero = isset($_POST["documento_numero"]) ? limpiarCadena($_POST["documento_numero"]) : "";
        $telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
        
        if (empty($empleado_id)) {
            // INSERTAR nuevo empleado (se genera QR automáticamente)
            $rspta = $empleado->insertar($nombre, $apellidos, $documento_numero, $telefono);
            echo $rspta ? "Empleado registrado correctamente con código QR" : "No se pudo registrar el empleado";
        } else {
            // EDITAR empleado existente
            $rspta = $empleado->editar($empleado_id, $nombre, $apellidos, $documento_numero, $telefono);
            echo $rspta ? "Empleado actualizado correctamente" : "No se pudo actualizar el empleado";
        }
        break;

    case 'eliminar':
        $empleado_id = limpiarCadena($_GET["id"]);
        $rspta = $empleado->eliminar($empleado_id);
        echo $rspta ? "Empleado eliminado correctamente" : "No se pudo eliminar el empleado";
        break;

    case 'mostrar':
        $empleado_id = limpiarCadena($_GET["id"]);
        $rspta = $empleado->mostrar($empleado_id);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $empleado->listar();
        $data = Array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => '<button class="btn btn-warning btn-sm" onclick="mostrar(' . $reg->id . ')"><i class="fa fa-pencil"></i></button>' .
                       ' <button class="btn btn-danger btn-sm" onclick="eliminar(' . $reg->id . ')"><i class="fa fa-trash"></i></button>' .
                       ' <button class="btn btn-info btn-sm" onclick="verQR(' . $reg->id . ')"><i class="fa fa-qrcode"></i></button>',
                "1" => $reg->nombre . ' ' . $reg->apellidos,
                "2" => $reg->documento_numero,
                "3" => $reg->telefono,
                "4" => '<span class="badge bg-primary">' . $reg->codigo . '</span>',
                "5" => !empty($reg->imagen_qr) 
                       ? '<img src="../files/qrcodes/' . $reg->imagen_qr . '" height="60px" style="cursor:pointer;" onclick="verQRGrande(\'' . $reg->imagen_qr . '\', \'' . $reg->nombre . ' ' . $reg->apellidos . '\')">'
                       : '<span class="label label-warning">Sin QR</span>',
                "6" => !empty($reg->imagen_qr)
                       ? '<a href="../files/qrcodes/' . $reg->imagen_qr . '" download="QR_' . $reg->nombre . '.png" class="btn btn-success btn-xs"><i class="fa fa-download"></i></a> ' .
                         '<button class="btn btn-primary btn-xs" onclick="imprimirQR(\'' . $reg->imagen_qr . '\', \'' . $reg->nombre . ' ' . $reg->apellidos . '\')"><i class="fa fa-print"></i></button>'
                       : '<button class="btn btn-warning btn-xs" onclick="regenerarQR(' . $reg->id . ')"><i class="fa fa-refresh"></i> Generar</button>'
            );
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );

        echo json_encode($results);
        break;

    case 'selectEmpleado':
        $rspta = $empleado->select();
        echo '<option value="">Seleccione</option>';
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->id . '>' . $reg->nombre_completo . '</option>';
        }
        break;

    case 'regenerarQR':
        $empleado_id = limpiarCadena($_GET["id"]);
        $rspta = $empleado->regenerarQR($empleado_id);
        echo $rspta ? "Código QR regenerado correctamente" : "No se pudo regenerar el código QR";
        break;

    case 'buscarPorCodigo':
        // Para el sistema de lectura de QR
        $codigo = limpiarCadena($_GET["codigo"]);
        $rspta = $empleado->buscarPorCodigo($codigo);
        echo json_encode($rspta);
        break;

    case 'estadisticas':
        $rspta = $empleado->obtenerEstadisticas();
        echo json_encode($rspta);
        break;

    case 'generarQRMasivo':
        // Generar QRs para todos los empleados que no tienen
        $generados = $empleado->generarQRMasivo();
        echo json_encode([
            'success' => true,
            'generados' => $generados,
            'mensaje' => "Se generaron $generados códigos QR correctamente"
        ]);
        break;

        case 'registrar_public':
        // Registro de empleado desde la parte pública (inicio)
        $nombre           = isset($_POST["nombre"])           ? limpiarCadena($_POST["nombre"])           : "";
        $apellidos        = isset($_POST["apellidos"])        ? limpiarCadena($_POST["apellidos"])        : "";
        $documento_numero = isset($_POST["documento_numero"]) ? limpiarCadena($_POST["documento_numero"]) : "";
        $telefono         = isset($_POST["telefono"])         ? limpiarCadena($_POST["telefono"])         : "";

        // Insertar empleado (el modelo genera código y QR)
        $idempleado = $empleado->insertar($nombre, $apellidos, $documento_numero, $telefono);

        if ($idempleado) {
            // Obtenemos datos completos (incluye codigo e imagen_qr)
            $emp = $empleado->mostrar($idempleado);

            echo json_encode([
                "ok"        => true,
                "mensaje"   => "Empleado registrado correctamente",
                "id"        => $idempleado,
                "nombre"    => $emp["nombre"] . " " . $emp["apellidos"],
                "codigo"    => $emp["codigo"],
                "imagen_qr" => $emp["imagen_qr"]
            ]);
        } else {
            echo json_encode([
                "ok"      => false,
                "mensaje" => "No se pudo registrar el empleado"
            ]);
        }
        break;


    default:
        echo "Operación no válida";
        break;
}
?>