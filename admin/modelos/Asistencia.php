<?php
//incluir la conexion de base de datos 
require_once "../config/conexion.php";

class Asistencia
{
    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //listar registros
    public function listar()
    {
        $sql = "SELECT a.*, CONCAT(e.nombre, ' ', e.apellidos) AS empleado ,e.codigo FROM asistencias a INNER JOIN empleados e ON a.empleado_id=e.id ORDER BY a.id DESC";
        return ejecutarConsulta($sql);
    }

    //Método para listar y mostrar en un select los registros de empleados
    public function listar_reporte($fecha_inicio, $fecha_fin, $empleado_id)
    {
        $sql = "SELECT a.*, CONCAT(e.nombre, ' ', e.apellidos) AS empleado, e.codigo FROM asistencias a INNER JOIN empleados e ON a.empleado_id=e.id WHERE DATE(a.fecha)>='$fecha_inicio' AND DATE(a.fecha)<='$fecha_fin' AND a.empleado_id='$empleado_id'";
        return ejecutarConsulta($sql);
    }

}