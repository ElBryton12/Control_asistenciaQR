// Referencias a elementos del DOM
var videoElement   = document.getElementById('preview');
var cameraOverlay  = document.getElementById('cameraOverlay');

// Proteger por si el script se carga antes del HTML
if (!videoElement) {
    console.error("No se encontró el elemento de video con id 'preview'.");
}

// Crear scanner de Instascan
var scanner = new Instascan.Scanner({
    continuous: true,              // Escaneo continuo
    video: videoElement,           // Elemento de video para mostrar la vista previa
    mirror: false,                 // No invertir la imagen del video
    captureImage: false,           // No capturar imágenes
    backgroundScan: false,         // No escanear en segundo plano
    refractoryPeriod: 5000,        // Período refractario de 5 segundos
    scanPeriod: 5                  // Frecuencia de escaneo (ms)
});

// Cambia el estado visual de la cámara (overlay)
function setCameraState(isOn) {
    if (!cameraOverlay) return;

    if (isOn) {
        cameraOverlay.classList.remove('camera-off');
        cameraOverlay.classList.add('camera-on');
    } else {
        cameraOverlay.classList.remove('camera-on');
        cameraOverlay.classList.add('camera-off');
    }
}

// Al inicio: cámara apagada
setCameraState(false);

// Evento cuando se escanea un código QR
scanner.addListener('scan', function (content) {
    // Solicitud POST al backend para registrar asistencia
    $.post("../controlador/Asistencia.php?op=registrar", { "codigo": content }, function (data) {
        Swal.fire({
            title: "Asistencia",
            text: data,
            icon: "success"
        });
    });
});

// Inicia la cámara para el escaneo de códigos QR
function iniciaCamara() {
    Instascan.Camera.getCameras()
        .then(function (cameras) {
            if (cameras.length > 0) {
                // Puedes cambiar el índice si quieres usar la frontal
                scanner.start(cameras[cameras.length - 1]);
                setCameraState(true);
            } else {
                alert('No se encontró una cámara disponible');
                console.error('No se encontró una cámara disponible');
                setCameraState(false);
            }
        })
        .catch(function (e) {
            console.error(e);
            setCameraState(false);
        });
}

// Detiene la cámara y muestra el overlay de "apagada"
function apagaCamara() {
    try {
        scanner.stop();
    } catch (e) {
        console.warn("Error al detener el scanner:", e);
    }
    setCameraState(false);
}
