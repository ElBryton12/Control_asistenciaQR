<?php
session_start();

error_reporting(E_ERROR | E_PARSE);

require_once "../admin/config/conexion.php";
require_once "../admin/modelos/Empleado.php";

$empleadoModel = new Empleado();

$op = isset($_GET["op"]) ? $_GET["op"] : "";

function jsonResponse($arr) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($arr);
    exit;
}

switch ($op) {

    case 'login':
        $documento_numero = isset($_POST["documento_numero"]) ? limpiarCadena($_POST["documento_numero"]) : "";
        $telefono         = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";

        if ($documento_numero === "" || $telefono === "") {
            jsonResponse([
                "success" => false,
                "message" => "Completa documento y teléfono."
            ]);
        }

        $empleado = $empleadoModel->login($documento_numero, $telefono);

        if ($empleado && isset($empleado['id'])) {

            $_SESSION['empleado_id']      = $empleado['id'];
            $_SESSION['empleado_nombre']  = $empleado['nombre'] . ' ' . $empleado['apellidos'];
            $_SESSION['empleado_codigo']  = $empleado['codigo'];
            $_SESSION['empleado_imagen']  = $empleado['imagen_qr'];

            jsonResponse([
                "success"  => true,
                "message"  => "Inicio de sesión correcto.",
                "empleado" => $empleado
            ]);
        } else {
            jsonResponse([
                "success" => false,
                "message" => "Documento o teléfono incorrectos."
            ]);
        }
        break;

    case 'registrar':
        $nombre           = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
        $apellidos        = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
        $documento_numero = isset($_POST["documento_numero"]) ? limpiarCadena($_POST["documento_numero"]) : "";
        $telefono         = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";

        if ($nombre === "" || $apellidos === "" || $documento_numero === "" || $telefono === "") {
            jsonResponse([
                "success" => false,
                "message" => "Completa todos los campos."
            ]);
        }

        $idEmpleado = $empleadoModel->insertar($nombre, $apellidos, $documento_numero, $telefono);

        if ($idEmpleado) {
            $empleado = $empleadoModel->mostrar($idEmpleado);

            $_SESSION['empleado_id']      = $empleado['id'];
            $_SESSION['empleado_nombre']  = $empleado['nombre'] . ' ' . $empleado['apellidos'];
            $_SESSION['empleado_codigo']  = $empleado['codigo'];
            $_SESSION['empleado_imagen']  = $empleado['imagen_qr'];

            jsonResponse([
                "success"  => true,
                "message"  => "Registro completado.",
                "empleado" => $empleado
            ]);
        } else {
            jsonResponse([
                "success" => false,
                "message" => "No se pudo registrar el empleado."
            ]);
        }
        break;

    case 'logout':
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        break;

    default:
        jsonResponse([
            "success" => false,
            "message" => "Operación no válida."
        ]);
}
