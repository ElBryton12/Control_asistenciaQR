<?php
/**
 * Modelo de Empleado con generación automática de QR
 * Ubicación: admin/modelos/Empleado.php
 */

// Incluir la conexión de base de datos
// Incluir la conexión de base de datos **siempre relativa a este archivo**
require_once __DIR__ . "/../config/conexion.php";
require_once "QRGenerator.php";

class Empleado
{
    // Constructor
    public function __construct()
    {
    }

    /**
     * Insertar nuevo empleado con generación automática de QR
     * @return int|false ID del empleado insertado o false si falla
     */
    public function insertar($nombre, $apellidos, $documento_numero, $telefono)
    {
        try {
            // Primero insertar el empleado sin código ni imagen QR
            $sql = "INSERT INTO empleados (nombre, apellidos, documento_numero, telefono, codigo, imagen_qr) 
                    VALUES ('$nombre', '$apellidos', '$documento_numero', '$telefono', '', '')";
            
            $idempleadoNuevo = ejecutarConsulta_retornarID($sql);
            
            if ($idempleadoNuevo) {
                // Generar código único y QR
                $qrGen = new QRGenerator();
                $codigo = $qrGen->generarCodigo($idempleadoNuevo);
                $imagenQR = $qrGen->generarQR($codigo, $idempleadoNuevo);
                
                // Actualizar empleado con código y imagen QR
                $sqlUpdate = "UPDATE empleados 
                             SET codigo = '$codigo', imagen_qr = '$imagenQR' 
                             WHERE id = $idempleadoNuevo";
                
                ejecutarConsulta($sqlUpdate);
                
                return $idempleadoNuevo;
            }
            
            return false;
            
        } catch (Exception $e) {
            error_log("Error en Empleado::insertar - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Editar datos de empleado existente
     * Opcionalmente regenera el QR si cambió el código
     */
    public function editar($empleado_id, $nombre, $apellidos, $documento_numero, $telefono, $regenerarQR = false)
    {
        try {
            // Actualizar datos básicos
            $sql = "UPDATE empleados 
                    SET nombre = '$nombre',
                        apellidos = '$apellidos',
                        documento_numero = '$documento_numero',
                        telefono = '$telefono'
                    WHERE id = '$empleado_id'";
            
            $resultado = ejecutarConsulta($sql);
            
            // Si se solicita regenerar el QR
            if ($regenerarQR && $resultado) {
                $qrGen = new QRGenerator();
                
                // Obtener código actual
                $empleado = $this->mostrar($empleado_id);
                $codigo = $empleado['codigo'];
                
                // Si no tiene código, generar uno nuevo
                if (empty($codigo)) {
                    $codigo = $qrGen->generarCodigo($empleado_id);
                }
                
                // Eliminar QR anterior si existe
                if (!empty($empleado['imagen_qr'])) {
                    $qrGen->eliminarQR($empleado['imagen_qr']);
                }
                
                // Generar nuevo QR
                $imagenQR = $qrGen->generarQR($codigo, $empleado_id);
                
                // Actualizar en BD
                $sqlUpdate = "UPDATE empleados 
                             SET codigo = '$codigo', imagen_qr = '$imagenQR' 
                             WHERE id = '$empleado_id'";
                
                ejecutarConsulta($sqlUpdate);
            }
            
            return $resultado;
            
        } catch (Exception $e) {
            error_log("Error en Empleado::editar - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar empleado y su código QR
     */
    public function eliminar($empleado_id)
    {
        try {
            // Obtener información del QR antes de eliminar
            $sql = "SELECT imagen_qr FROM empleados WHERE id = '$empleado_id'";
            $result = ejecutarConsultaSimpleFila($sql);
            
            if ($result && !empty($result['imagen_qr'])) {
                // Eliminar archivo QR físicamente
                $qrGen = new QRGenerator();
                $qrGen->eliminarQR($result['imagen_qr']);
            }
            
            // Eliminar empleado de la BD
            $sql = "DELETE FROM empleados WHERE id = '$empleado_id'";
            return ejecutarConsulta($sql);
            
        } catch (Exception $e) {
            error_log("Error en Empleado::eliminar - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Mostrar datos de un empleado específico
     */
    public function mostrar($empleado_id)
    {
        $sql = "SELECT * FROM empleados WHERE id = '$empleado_id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    /**
     * Listar todos los empleados
     */
    public function listar()
    {
        $sql = "SELECT * FROM empleados ORDER BY id DESC";
        return ejecutarConsulta($sql);
    }

    /**
     * Listar empleados para select (combo box)
     */
    public function select()
    {
        $sql = "SELECT id, CONCAT(nombre, ' ', apellidos) as nombre_completo FROM empleados ORDER BY nombre ASC";
        return ejecutarConsulta($sql);
    }

    /**
     * Buscar empleado por código QR
     * Útil para el sistema de lectura de QR
     */
    public function buscarPorCodigo($codigo)
    {
        $sql = "SELECT * FROM empleados WHERE codigo = '$codigo' LIMIT 1";
        return ejecutarConsultaSimpleFila($sql);
    }

    /**
     * Regenerar código QR de un empleado
     */
    public function regenerarQR($empleado_id)
    {
        try {
            $qrGen = new QRGenerator();
            
            // Obtener datos del empleado
            $empleado = $this->mostrar($empleado_id);
            
            if (!$empleado) {
                return false;
            }
            
            // Generar nuevo código
            $codigo = $qrGen->generarCodigo($empleado_id);
            
            // Eliminar QR anterior si existe
            if (!empty($empleado['imagen_qr'])) {
                $qrGen->eliminarQR($empleado['imagen_qr']);
            }
            
            // Generar nuevo QR
            $imagenQR = $qrGen->generarQR($codigo, $empleado_id);
            
            // Actualizar en BD
            $sql = "UPDATE empleados 
                    SET codigo = '$codigo', imagen_qr = '$imagenQR' 
                    WHERE id = '$empleado_id'";
            
            return ejecutarConsulta($sql);
            
        } catch (Exception $e) {
            error_log("Error en Empleado::regenerarQR - " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verificar si un empleado tiene código QR generado
     */
    public function tieneQR($empleado_id)
    {
        $empleado = $this->mostrar($empleado_id);
        return !empty($empleado['imagen_qr']) && !empty($empleado['codigo']);
    }

    /**
     * Obtener estadísticas de empleados
     */
    public function obtenerEstadisticas()
    {
        $sql = "SELECT 
                COUNT(*) as total,
                COUNT(CASE WHEN codigo != '' AND imagen_qr != '' THEN 1 END) as con_qr,
                COUNT(CASE WHEN codigo = '' OR imagen_qr = '' THEN 1 END) as sin_qr
                FROM empleados";
        
        return ejecutarConsultaSimpleFila($sql);
    }

    /**
     * Listar empleados sin código QR generado
     */
    public function listarSinQR()
    {
        $sql = "SELECT * FROM empleados 
                WHERE codigo = '' OR imagen_qr = '' OR codigo IS NULL OR imagen_qr IS NULL
                ORDER BY id DESC";
        return ejecutarConsulta($sql);
    }

    // ...

    /**
     * Login de empleado por documento y teléfono
     * (usa los campos que ya existen en la tabla)
     */
    public function login($documento_numero, $telefono)
    {
        $sql = "SELECT * FROM empleados 
                WHERE documento_numero = '$documento_numero'
                  AND telefono = '$telefono'
                LIMIT 1";
        return ejecutarConsultaSimpleFila($sql);
    }

// ...
    public function cantidad_empleado()
{
    $sql = "SELECT COUNT(*) AS total FROM empleados";
    return ejecutarConsulta($sql);
}


    /**
     * Generar QRs masivos para empleados que no tienen
     */
    public function generarQRMasivo()
    {
        try {
            $qrGen = new QRGenerator();
            $empleadosSinQR = $this->listarSinQR();
            $generados = 0;
            
            while ($empleado = $empleadosSinQR->fetch_assoc()) {
                $codigo = $qrGen->generarCodigo($empleado['id']);
                $imagenQR = $qrGen->generarQR($codigo, $empleado['id']);
                
                $sql = "UPDATE empleados 
                        SET codigo = '$codigo', imagen_qr = '$imagenQR' 
                        WHERE id = {$empleado['id']}";
                
                if (ejecutarConsulta($sql)) {
                    $generados++;
                }
            }
            
            return $generados;
            
        } catch (Exception $e) {
            error_log("Error en Empleado::generarQRMasivo - " . $e->getMessage());
            return 0;
        }
    }
}
?>