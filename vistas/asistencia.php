<?php
ob_start();
session_start();

// Sólo admin
if (!isset($_SESSION['nombre'])) {
    header("Location: ../admin/vistas/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Escáner de Asistencia - APP QR</title>

    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Instascan -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <!-- Google Fonts + Icons (mismo estilo que admin) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Bootstrap / AdminLTE desde admin -->
    <link rel="stylesheet" href="../admin/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin/public/css/font-awesome.css">
    <link rel="stylesheet" href="../admin/public/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../admin/public/css/_all-skins.min.css">
    <link rel="stylesheet" href="../admin/public/css/blue.css">
    <link rel="shortcut icon" href="../admin/public/img/favicon.ico">

    <!-- 🔹 MISMO CSS DEL SIDEBAR (variables, tema oscuro, etc.) -->
<link rel="stylesheet" href="../admin/public/css/modern-sidebar.css">

    <style>
        :root {
            --primary: #695CFE;   /* azul AdminLTE */
            --primary-dark: #695CFE;
            --bg: #f4f6f9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", Arial, sans-serif;
            background: var(--bg);
            margin: 0;
        }

        /* Barra superior minimal */
        .top-bar {
            background: var(--primary);
            color: #fff;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .top-bar-title {
            font-weight: 600;
            letter-spacing: .5px;
        }

        .top-bar-title span {
            font-weight: 700;
        }

        .top-bar-right a {
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            margin-left: 10px;
        }

        .top-bar-right a:hover {
            text-decoration: underline;
        }

        /* Layout central */
        .scanner-page {
            min-height: calc(100vh - 60px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .scanner-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            max-width: 700px;
            width: 100%;
            padding: 25px 30px 20px;
        }

        .scanner-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .scanner-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(0, 115, 183, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        .scanner-icon .material-symbols-rounded {
            color: var(--primary);
        }

        .scanner-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .scanner-subtitle {
            font-size: 13px;
            color: #777;
            margin: 2px 0 0;
        }

        /* Video */
        #preview-wrapper {
            margin-top: 15px;
            display: flex;
            justify-content: center;
        }

        #preview {
            width: 100%;
            max-width: 420px;
            border-radius: 12px;
            background: #111;
            border: 3px solid rgba(0, 0, 0, 0.08);
        }

        /* Botones */
        .scanner-actions {
            margin-top: 18px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-primary-custom {
            background: #00a65a;
            border-color: #008d4c;
            font-weight: 500;
        }

        .btn-primary-custom:hover {
            background: #008d4c;
            border-color: #006f3b;
        }

        .btn-warning-custom {
            background: #f39c12;
            border-color: #e08e0b;
            font-weight: 500;
        }

        .btn-warning-custom:hover {
            background: #e08e0b;
            border-color: #c97d07;
        }

        .scanner-footer-note {
            margin-top: 14px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }

        /* Footer */
        .main-footer {
            background: #fff;
            padding: 8px 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #555;
        }

        .main-footer .pull-right {
            color: #999;
        }

        @media (max-width: 576px) {
            .scanner-card {
                padding: 18px 15px;
            }
        }
    </style>
</head>

<body>

    <!-- Barra superior sencilla -->
    <div class="top-bar">
        <div class="top-bar-title">
            <span>SIS</span>ASISTENCIA QR
        </div>
        <div class="top-bar-right">
            <a href="../admin">Panel admin</a>
            <a href="../admin/controlador/Usuario.php?op=salir">Cerrar sesión</a>
        </div>
    </div>

      <!-- 🔹 Botón flotante de tema -->
    <button id="fabThemeToggle" class="fab-theme-toggle" title="Cambiar tema">
      <span class="material-symbols-rounded">dark_mode</span>
    </button>

    <!-- Contenido principal -->
    <div class="scanner-page">
        <div class="scanner-card">

            <div class="scanner-header">
                <div class="scanner-icon">
                    <span class="material-symbols-rounded">qr_code_scanner</span>
                </div>
                <div>
                    <h2 class="scanner-title">Registro de asistencia</h2>
                    <p class="scanner-subtitle">
                        Apunta la cámara al código QR de la credencial del empleado.
                    </p>
                </div>
            </div>

            <div id="preview-wrapper">
            <div class="camera-container">
                <video id="preview" playsinline></video>

                <!-- Overlay para mostrar estado -->
                <div id="cameraOverlay" class="camera-overlay camera-off">
                <span class="material-symbols-rounded">videocam_off</span>
                <p>Cámara desactivada</p>
                <small>Haz clic en “Iniciar cámara” para comenzar.</small>
                </div>
            </div>
            </div>


            <div class="scanner-actions">
                <button type="button" id="btnIngreso" onclick="iniciaCamara()" class="btn btn-success btn-primary-custom">
                    Iniciar cámara
                </button>

                <button type="button" id="btnSalida" onclick="apagaCamara()" class="btn btn-warning btn-warning-custom">
                    Apagar cámara
                </button>
            </div>

            <div class="scanner-footer-note">
                Cuando el código sea leído, se registrará la asistencia y verás una notificación en pantalla.
            </div>

        </div>
    </div>
    
    <!-- 🔹 Sincronizar el tema con el panel (claro/oscuro) -->
<script>
  (function() {
    const savedTheme = localStorage.getItem("theme");
    const systemPrefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    const shouldUseDarkTheme = savedTheme ? savedTheme === "dark" : systemPrefersDark;

    if (shouldUseDarkTheme) {
      document.documentElement.classList.add("dark-theme");
      document.body.classList.add("dark-theme");
    }
  })();
</script>

    <!-- JS -->
    <script src="../admin/public/js/jquery-3.1.1.min.js"></script>
    <script src="../admin/public/js/bootstrap.min.js"></script>
    <script src="scripts/asistencia.js?<?php echo time(); ?>"></script>
  <!-- 🔹 Script para botón flotante de tema -->
    <script>
      (function() {
        const fab = document.getElementById('fabThemeToggle');
        if (!fab) return;

        function isDark() {
          return document.documentElement.classList.contains('dark-theme');
        }

        function setIcon() {
          const icon = fab.querySelector('.material-symbols-rounded');
          if (!icon) return;
          icon.textContent = isDark() ? 'light_mode' : 'dark_mode';
        }

        function toggleTheme() {
          if (isDark()) {
            document.documentElement.classList.remove('dark-theme');
            document.body.classList.remove('dark-theme');
            localStorage.setItem('theme', 'light');
          } else {
            document.documentElement.classList.add('dark-theme');
            document.body.classList.add('dark-theme');
            localStorage.setItem('theme', 'dark');
          }
          setIcon();
        }

        // Inicializar icono según tema actual
        setIcon();

        fab.addEventListener('click', toggleTheme);
      })();
    </script>
</body>
</html>
<?php
ob_end_flush();
?>
