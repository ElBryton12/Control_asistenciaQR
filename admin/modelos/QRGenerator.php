<?php
class QRGenerator {
    private $qr_path = '../files/qrcodes/';
    
    public function __construct() {
        // Crear carpeta si no existe
        if (!file_exists($this->qr_path)) {
            mkdir($this->qr_path, 0777, true);
        }
    }
    
    /**
     * Genera un código único para el empleado
     * @param int $idempleado
     * @return string Código único
     */
    public function generarCodigo($idempleado) {
        // Generar código único basado en ID + timestamp
        $codigo = strtoupper(substr(md5($idempleado . time()), 0, 8));
        return $codigo;
    }
    
    /**
     * Genera imagen QR para un empleado
     * @param string $codigo Código del empleado
     * @param int $idempleado ID del empleado
     * @return string Nombre del archivo generado
     */
    public function generarQR($codigo, $idempleado) {
        // Incluir librería
        require_once '../libs/phpqrcode/qrlib.php';
        
        // Nombre del archivo
        $filename = 'qr_' . $idempleado . '.png';
        $filepath = $this->qr_path . $filename;
        
        // Generar QR
        // Parámetros: texto, archivo, nivel corrección, tamaño, margen
        QRcode::png($codigo, $filepath, QR_ECLEVEL_L, 10, 2);
        
        return $filename;
    }
    
    /**
     * Elimina QR existente
     * @param string $filename
     */
    public function eliminarQR($filename) {
        $filepath = $this->qr_path . $filename;
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }
    
    /**
     * Obtiene la ruta pública del QR
     * @param string $filename
     * @return string URL del QR
     */
    public function obtenerUrlQR($filename) {
        return '../files/qrcodes/' . $filename;
    }
}
?>