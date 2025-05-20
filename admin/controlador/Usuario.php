<?php
//Iniciamos la sesion
session_start();
//Incluimos el archivo de la clase Usuario
require_once "../modelos/Usuario.php";

//Creamos una instancia de la clase Usuario
$usuario = new Usuario();

//Recibimos los datos enviados por el formulario
$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$email = isset($_POST["email"]) ? limpiarCadena($_POST["email"]) : "";
$password = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";

//Dependiendo de la variable "op" que se recibe, ejecutamos una u otra acción
switch ($_GET["op"]) {
    case 'guardaryeditar':
        //Inicializamos la variable que contendrá el hash de la contraseña
        $clavehash = '';
        //Verificamos si se ha subido una nueva imagen
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            //Si no se ha subido una nueva imagen, mantenemos la imagen actual
            $imagen = $_POST["imagenactual"];
        } else {
            //Si se ha subido una nueva imagen, la guardamos en la carpeta de imágenes
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES["imagen"]["type"] == "image/jpg" || $_FILES["imagen"]["type"] == "image/jpeg" || $_FILES["imagen"]["type"] == "image/png") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
            }
        }


        //Si se ha ingresado una nueva contraeña
        if (!empty($password)) {
            //Generamos el hash de la contraseña
            $clavehash = hash("SHA256", $password);
        }
        
        //verificamos si se esta insertando un nuevo usuario o editando uno existente
        if (empty($idusuario)) {
            //Si es un nuevo ususario, llamamos al metodo insertar de la clase Usuario
            $rspta = $usuario->insertar($nombre, $apellidos, $login, $email, $clavehash, $imagen);
            //Devolvemos un mensaje segun el resultado de la operacion 
            echo $rspta ? "Datps registrados correctamente" : "No se pudo registrar todos los datos del ususario";
        } else {
            //Si es un usuario existente, llamamos al metodo editar de la clase Usuario
            $rspta = $usuario->editar($idusuario, $nombre, $apellidos, $login, $email, $clavehash, $imagen);
            //Devolvemos un mensaje segun el resultado de la operacion
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        }
       break;

    case 'desactivar':
        //Llamamos al metodo desactivar de la clase Usuario
        $rspta = $usuario->desactivar($idusuario);
        //Devolvemos un mensaje segun el resultado de la operacion
        echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar el usuario";
        break;

    case 'activar':
        //Llamamos al metodo activar de la clase Usuario
        $rspta = $usuario->activar($idusuario);
        //Devolvemos un mensaje segun el resultado de la operacion
        echo $rspta ? "Datos activados correctamente" : "No se pudo activar el usuario";
        break;

    case 'mostrar':
        //Llamamos al metodo mostrar de la clase Usuario
        $rspta = $usuario->mostrar($idusuario);
        //Devolvemos el rezultado como un objeto JSON
        echo json_encode($rspta);
        break;

    case 'listar':
        //Llamamos al metodo listar de la clase Usuario
        $rspta = $usuario->listar();
        //Creamos un array para almacenar los datos
        $data = array();
        //Recorremos el resultado y lo almacenamos en el array
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => ($reg->estado) ? '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->id . ')"><i class="fa fa-pencil"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->id . ')"><i class="fa fa-close"></i></button>' : '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->id . ')"><i class="fa fa-pencil"></i></button>' . ' ' . ' <button class="btn btn-primary btn-xs" onclick="activar(' . $reg->id . ')"><i class="fa fa-check"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->apellidos,
                "3" => $reg->login,
                "4" => $reg->email,
                "5" => "<img src='../files/usuarios/" . $reg->imagen . "' height='50px' width='50px' >",
                "6" => ($reg->estado) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
            );
        }

        //Preparamos la respuesta para Datatables
        $results = array(
            "sEcho" => 1, //Informacion para el datatables
            "iTotalRecords" => count($data), //Enviamos el total de registros al datatables
            "iTotalDisplayRecords" => count($data), //Enviamos el total de registros a visualizar
            "aaData" => $data 
        );
        //Devolvemos la respuesta como un objeto JSON
        echo json_encode($results);
        break;

    case 'verificar':
        //Validamos si el usuario tiene acceso al sistema
        $logina = $_POST['logina'];
        $clavea = $_POST['clavea'];
        //Hash SHA256 para la contraseña
        $clavehash = hash("SHA256", $clavea);
        //Llamamos al metodo verificar de la clase Usuario
        $rspta = $usuario->verificar($logina, $clavehash);
        //Obtenemos el resultado como un objeto
        $fetch = $rspta->fetch_object();
        //Si existe el usuario, declaramos las variables de sesion
        if (isset($fetch)) {
            $_SESSION['idusuario'] = $fetch->idusuario;
            $_SESSION['nombre'] = $fetch->nombre;
            $_SESSION['imagen'] = $fetch->imagen;
            $_SESSION['login'] = $fetch->login;
        }
        //Devolvemosel resultado como un objeto JSON
        echo json_encode($fetch);
        break;

    case 'salir':
        //Limpiamos las variables de sesion
        session_unset();
        //Destruimos la sesion
        session_destroy();
        //Redirigimos al usuario a la pagina de login
        header("Location: ../index.php");
        break;
}
?>