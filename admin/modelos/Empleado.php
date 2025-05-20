<?php
//incluir la conexion de base de datos 
require_once "../config/conexion.php";

class Empleado
{


    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //metodo para insertar un registro
    public function insertar($nombre, $apellidos, $documento_numero, $telefono, $codigo)
    {

        $sql = "INSERT INTO empleados (nombre, apellidos, documento_numero, telefono, codigo) VALUES ('$nombre','$apellidos','$documento_numero','$telefono','$codigo')";
        return ejecutarConsulta($sql);
    }

    //metodo para editar registros
    public function editar($empleado_id, $nombre, $apellidos, $documento_numero, $telefono, $codigo)
    {
        $sql = "UPDATE empleados SET nombre='$nombre',apellidos='$apellidos',documento_numero='$documento_numero',telefono='$telefono', codigo='$codigo' WHERE id='$empleado_id'";
        return ejecutarConsulta($sql);      
    }

    //metodo para mostrar los datos de un registro a modificar
    public function mostrar($empleado_id)
    {
        $sql = "SELECT * FROM empleados WHERE id='$empleado_id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Método para listar registros
    public function listar()
    {
        $sql = "SELECT * FROM empleados";
        return ejecutarConsulta($sql);
    }

    //Método para listar y mostrar en un select los registros de empleados
    public function select()
    {
        $sql = "SELECT * FROM empleados";
        return ejecutarConsulta($sql);
    }
}