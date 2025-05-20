<?php
//incluir la conexion de base de datos 
require_once "../config/conexion.php";
class Usuario
{


    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //metodo para insertar un registro
    public function insertar($nombre, $apellidos, $login, $email, $clavehash, $imagen)
    {

        $sql = "INSERT INTO usuarios (nombre,apellidos,login,email,password,imagen,estado) VALUES ('$nombre','$apellidos','$login','$email','$clavehash','$imagen','1')";
        return ejecutarConsulta($sql);
    }

    //metodo para editar registros
    public function editar($idusuario, $nombre, $apellidos, $login, $email, $clavehash, $imagen)
    {
        if(!empty($clavehash)){
        $sql = "UPDATE usuarios SET nombre = '$nombre', apellidos = '$apellidos', login = '$login', email = '$email', password = '$clavehash',imagen = '$imagen' WHERE id = '$idusuario'";
        } else {
        $sql = "UPDATE usuarios SET nombre='$nombre',apellidos='$apellidos',login='$login',email='$email' 
        WHERE id=$idusuario";
        }   
        return ejecutarConsulta($sql);      
    }


    public function desactivar($idusuario)
    {
        $sql = "UPDATE usuarios SET estado='0' WHERE id='$idusuario'";
        return ejecutarConsulta($sql);
    }
    public function activar($idusuario)
    {
        $sql = "UPDATE usuarios SET estado='1' WHERE id='$idusuario'";
        return ejecutarConsulta($sql);
    }
    //metodo para mostrar los datos de un registro a modificar
    public function mostrar($idusuario)
    {
        $sql = "SELECT * FROM usuarios WHERE id= '$idusuario'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //listar registros
    public function listar()
    {
        $sql = "SELECT * FROM usuarios";
        return ejecutarConsulta($sql);
    }

    public function cantidad_usuario()
    {
        $sql = "SELECT COUNT(*) nombre FROM usuarios";
        return ejecutarConsulta($sql);
    }

    //metodo para verificar el acceso al sistema
    public function verificar($login, $clave)
    {
        $sql = "SELECT * FROM usuarios WHERE login='$login' AND password='$clave' AND estado= '1'";
        return ejecutarConsulta($sql);
    }
    
}