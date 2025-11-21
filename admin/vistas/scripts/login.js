$("#frmAcceso").on("submit", function (e) {
    e.preventDefault();

    let logina = $("#logina").val().trim();
    let clavea = $("#clavea").val().trim();

    // Función helper para mostrar mensajes (con bootbox si existe, si no alert)
    function mostrarMensaje(msg) {
        if (typeof bootbox !== "undefined") {
            bootbox.alert(msg);
        } else {
            alert(msg);
        }
    }

    if (logina === "" || clavea === "") {
        mostrarMensaje("Asegúrate de llenar todos los campos");
        return;
    }

    $.post(
        "../controlador/Usuario.php?op=verificar",
        { logina: logina, clavea: clavea },
        function (data) {
            console.log("RESPUESTA PHP:", data);

            // El sistema original suele devolver "null" (string) si falla
            if (data != "null" && data != null && data !== "") {
                // Credenciales correctas → redirigimos al escritorio
                $(location).attr("href", "escritorio.php");
            } else {
                mostrarMensaje("Usuario y/o contraseña incorrecta");
            }
        }
    ).fail(function (xhr) {
        console.error("ERROR AJAX:", xhr.status, xhr.statusText, xhr.responseText);
        mostrarMensaje("Error de comunicación con el servidor.");
    });
});
