$("#frmAcceso").on('submit', function (e) {
    //Evita que el formulario se envíe de forma predeterminada
    e.preventDefault();

    //Obtiene los valores de los campos de entrada
    logina = $("#logina").val();
    clavea = $("#clavea").val();

    //Verifica si los campos están vacíos
    if ($("#logina").val() == "" || $("#clavea").val() == "") {
        //Muestra un mensaje de error si los campos están vacíos
        bootbox.alert("Asegurate de llenar todos los campos");
    } else {
        //Realiza una solicitud POST al script PHP para verificar las credenciales
        $.post("../controlador/Usuario.php?op=verificar", {"logina": logina, "clavea": clavea}, function (data) {
            console.log(data); //Imprime la respuesta del servidor en la consola para depuración

            //Comprueba si el usuario y la contraseña son correctos
            if (data != "null") {
                //Redirige al usuario a la página de inicio si las credenciales son correctas
                $(location).attr("href", "escritorio.php");
            } else {
                //Muestra una alerta si las credenciales son incorrectas
                bootbox.alert("Usuario y/o contraseña incorrecta");
            }
        });
    }
});    
