//Crea un nuevo objeto Scanner de Instacan con las configuraciones especificadas.
var scanner = new Instascan.Scanner({
    continuous: true,   // Escaneo continuo
    video: document.getElementById('preview'), //Elemento de video para mostrar la vista previa
    mirror: false, // No invertir la imagen del video
    captureImage: false, // No capturar imágenes
    backgroundScan: false, // No se escanea en segundo plano
    refractoryPeriod: 5000, // Período refractario de 5 segundos
    scanPeriod: 5 // Frecuencia de escaneo de 1 segundo
});

//Agrega un evento de escaneo que se activa cuando se escanea un código QR
scanner.addListener('scan', function (content) {
    // Realiza una solicitud POST al script PHP para registrar la asistencia con el código QR escaneado
    $.post("../controlador/Asistencia.php?op=registrar", {"codigo": content}, function (data) {
        // Muestra una notificación de exito utilizando la biblioteca SweetAlert
        Swal.fire({
            title: "Asistencia",
            text: data,
            icon: "success"
        });
    });
});

//Inicia la cámara para el escaneo de códigos QR
function iniciaCamara() {
    //Obtiene la lista de dispositivos de entrada de medios (cámaras) disponibles
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[cameras.length - 1]);
        } else {
            alert('No se encontró una cámara disponible'); 
            console.error('No se encontró una cámara disponible');
        }
    }).catch(function (e) {
        console.error(e);
    });
}

//Función para detener el escaneo de códigos QR y apagar la cámara
function apagaCamara() {
    scanner.stop();
}