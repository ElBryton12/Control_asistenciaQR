<?php
//incluye el archivo global.php que contiene las constantes de configuracion de la base de datos
require_once "global.php";

//Establece la conexion a la base de datos utilizando las constantes definidas en global.php
$conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Establece el conjunto de caracteres para la conexion 
mysqli_query($conexion, 'SET NAMES "' .DB_ENCODE. '"');

//Comprueba si hay errores en la conexion a la base de datos
if (mysqli_connect_errno()) {
    //Si hay un error, muestra un mensaje de error y termina la ejecucion del script
    printf("Fallo la conexion a la base de datos: %s\n", mysqli_connect_error());
    exit();
}

//Verifica si la funcion ejecutarConsulta no eta definida para evitar conflictos de redefinicion
if (!function_exists('ejecutarConsulta')) {
    //Define la funcion ejecutarConsulta que ejecuta consultas SQL y devuelve el resultado      
    function ejecutarConsulta($sql) {
        global $conexion;
        //Ejecuta la consulta SQL y devuelve el resultado
        $query = $conexion->query($sql); 
        return $query; 
    }

    //Define la funcion ejecutarConsultaSimpleFila que ejecuta una consulta SQL y devuelve una fila de resultado
    function ejecutarConsultaSimpleFila($sql) {
        global $conexion;
        //Ejecuta la consulta SQL y devuelve una fila de resultado
        $query = $conexion->query($sql); 
        return $query->fetch_assoc(); 
        return $row;
    }

    //Define la funcion ejecutarConsulta_retornarID que ejecuta una consulta SQL y devuelve el ID de la fila insertada
    function ejecutarConsulta_retornarID($sql) {
        global $conexion;
        //Ejecuta la consulta SQL y devuelve el ID de la fila insertada
        $query = $conexion->query($sql); 
        return $conexion->insert_id; 
    }

    //Define la funcion limpiarCadena que limpia una cadena para evitar inyecciones SQL XSS
    function limpiarCadena($str) {
        global $conexion;
        //Limpia la cadena escapando caracteres especiales y HTML para evitar inyecciones SQL y XSS
        $str = mysqli_real_escape_string($conexion, trim($str));
        return htmlspecialchars($str); 
    }
}
?>