<?php
//Incluir la conexion a la base de datos
require_once "../admin/config/conexion.php";
class Asistencia
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    public function verificarcodigo_persona($codigo_persona)
    {
        $sql = "SELECT * FROM empleados WHERE codigo = '$codigo_persona'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function buscar_asistencia($codigo_persona, $fecha)
    {
        $sql = "SELECT a. *, e.codigo FROM asistencias a INNER JOIN empleados e ON a.empleado_id = e.id WHERE e.codigo = '$codigo_persona' 
        AND a.fecha = '$fecha' 
        ORDER BY a.id DESC 
        LIMIT 1";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function registrar_asistencia($empleado_id, $hora, $fecha, $tipo)
    {
        $sql = "INSERT INTO asistencias (empleado_id, hora, fecha, tipo) VALUES ('$empleado_id', '$hora', '$fecha', '$tipo')";
        return ejecutarConsulta($sql);
    }

}
