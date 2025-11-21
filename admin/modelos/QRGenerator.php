<?php
// Ruta absoluta al archivo de la librería
$qrLibPath = __DIR__ . '/../libs/phpqrcode/qrlib.php';

if (!file_exists($qrLibPath)) {
    die("NO ENCUENTRO qrlib.php en: " . $qrLibPath);
}

// Cargamos la librería una sola vez
require_once $qrLibPath;

class QRGenerator
{
    // Ruta absoluta en el sistema de archivos donde se guardan los PNG
    private $qr_path;

    public function __construct()
    {
        // __DIR__ = .../admin/modelos
        $this->qr_path = __DIR__ . '/../files/qrcodes/'; // => .../admin/files/qrcodes/

        // Crear carpeta si no existe
        if (!is_dir($this->qr_path)) {
            mkdir($this->qr_path, 0777, true);
        }
    }

    /**
     * Genera un código único para el empleado
     */
    public function generarCodigo($idempleado)
    {
        return strtoupper(substr(md5($idempleado . time()), 0, 8));
    }

    /**
     * Genera imagen QR para un empleado
     * @param string $codigo  Código del empleado
     * @param int    $idempleado ID del empleado
     * @return string Nombre del archivo generado (ej: qr_11.png)
     */
    public function generarQR($codigo, $idempleado)
    {
        // Nombre del archivo
        $filename = 'qr_' . $idempleado . '.png';
        $filepath = $this->qr_path . $filename;

        // Generar QR (texto, archivo destino, nivel, tamaño, margen)
        QRcode::png($codigo, $filepath, QR_ECLEVEL_L, 10, 2);

        return $filename;
    }

    /**
     * Elimina QR existente
     */
    public function eliminarQR($filename)
    {
        $filepath = $this->qr_path . $filename;
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }

    /**
     * URL pública para mostrar el QR
     * (ajusta según desde dónde se muestre la página)
     */
    public function obtenerUrlQR($filename)
    {
        // Si la vista del portal está en /user/, esta ruta funciona:
        return '../admin/files/qrcodes/' . $filename;
    }
}
