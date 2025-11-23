<?php
session_start();
$estaLogueado = isset($_SESSION['empleado_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control Asistencia QR - Portal Empleado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="admin/public/img/favicon.ico" type="image/x-icon">
    <!-- Bootstrap básico + tu fuente -->
    <link rel="stylesheet" href="admin/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <!-- Iconos Material -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Script crítico anti-flash de tema claro -->
    <script>
      (function () {
        const savedTheme = localStorage.getItem("theme");
        const systemPrefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
        const shouldUseDarkTheme = savedTheme ? savedTheme === "dark" : systemPrefersDark;
        if (shouldUseDarkTheme) {
          document.documentElement.classList.add("dark-theme");
        }
      })();
    </script>

<style>
    :root {
        /* Light theme colors */
        --bg-body: #f4f6fb;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --card-bg: #ffffff;
        --card-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
        --input-bg: #ffffff;
        --input-border: #cbd5e1;
        --primary: #695CFE;
        --primary-hover: #5548d9;
        --success: #10b981;
        --error: #ef4444;
    }

    html.dark-theme {
        /* Dark theme colors */
        --bg-body: #0f172a;
        --text-primary: #f1f5f9;
        --text-secondary: #94a3b8;
        --card-bg: #1e293b;
        --card-shadow: 0 24px 60px rgba(0, 0, 0, 0.5);
        --input-bg: #334155;
        --input-border: #475569;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Poppins", sans-serif;
        background: var(--bg-body);
        color: var(--text-primary);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
        transition: background 0.3s ease, color 0.3s ease;
    }

    /* Animated background */
    body::before {
        content: '';
        position: fixed;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 30% 40%, rgba(105, 92, 254, 0.15), transparent 50%),
                    radial-gradient(circle at 70% 60%, rgba(59, 130, 246, 0.1), transparent 50%);
        animation: float 20s ease-in-out infinite;
        pointer-events: none;
        z-index: 0;
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    html:not(.dark-theme) body::before {
        opacity: 0.3;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, -30px) rotate(5deg); }
        66% { transform: translate(-20px, 20px) rotate(-5deg); }
    }

    .portal-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
        z-index: 1;
    }

    .portal-card {
        background: var(--card-bg);
        border-radius: 28px;
        box-shadow: var(--card-shadow);
        max-width: 500px;
        width: 100%;
        padding: 40px;
        position: relative;
        border: 1px solid rgba(148, 163, 184, 0.2);
        transition: all 0.3s ease;
    }

    html.dark-theme .portal-card {
        border-color: rgba(255, 255, 255, 0.1);
    }

    /* Theme toggle */
    .theme-toggle {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .theme-toggle:hover {
        background: var(--primary);
        border-color: var(--primary);
        transform: rotate(15deg);
    }

    /* Admin link */
    .admin-entry {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-secondary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .admin-entry:hover {
        background: rgba(105, 92, 254, 0.2);
        border-color: var(--primary);
        color: var(--primary);
        text-decoration: none;
    }

    .admin-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--success);
    }

    /* Header */
    .portal-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .logo-wrapper {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, var(--primary), #818cf8);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 12px 32px rgba(105, 92, 254, 0.3);
        animation: pulse 3s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 12px 32px rgba(105, 92, 254, 0.3); }
        50% { transform: scale(1.05); box-shadow: 0 16px 40px rgba(105, 92, 254, 0.4); }
    }

    .logo-wrapper .material-symbols-rounded {
        font-size: 40px;
        color: white;
    }

    .portal-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
        background: linear-gradient(135deg, var(--text-primary), var(--text-secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .portal-subtitle {
        font-size: 14px;
        color: var(--text-secondary);
    }

    /* Custom tabs */
    .custom-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 32px;
        background: rgba(148, 163, 184, 0.1);
        padding: 6px;
        border-radius: 14px;
        transition: background 0.3s ease;
    }

    html.dark-theme .custom-tabs {
        background: rgba(255, 255, 255, 0.05);
    }

    .tab-btn {
        flex: 1;
        padding: 12px;
        background: transparent;
        border: none;
        border-radius: 10px;
        color: var(--text-secondary);
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .tab-btn.active {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(105, 92, 254, 0.3);
    }

    .tab-btn:hover:not(.active) {
        background: rgba(148, 163, 184, 0.15);
        color: var(--text-primary);
    }

    html.dark-theme .tab-btn:hover:not(.active) {
        background: rgba(255, 255, 255, 0.08);
    }

    /* Tab content */
    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Form styles */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 500;
        color: var(--text-secondary);
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px 14px 48px;
        background: var(--input-bg);
        border: 2px solid var(--input-border);
        border-radius: 12px;
        color: var(--text-primary);
        font-size: 15px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }

    .form-control::placeholder {
        color: var(--text-secondary);
        opacity: 0.6;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
    }

    html.dark-theme .form-control:focus {
        background: rgba(51, 65, 85, 0.8);
    }

    html:not(.dark-theme) .form-control:focus {
        background: #ffffff;
    }

    .form-control:focus ~ .input-icon {
        color: var(--primary);
    }

    /* Buttons */
    .btn-submit {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, var(--primary), #818cf8);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 16px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 24px rgba(105, 92, 254, 0.3);
        margin-top: 10px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(105, 92, 254, 0.4);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    /* Alert messages */
    .alert {
        padding: 14px 16px;
        border-radius: 12px;
        margin-top: 20px;
        font-size: 14px;
        display: none;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #fca5a5;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #6ee7b7;
    }

    /* Credential card (when logged in) */
    .credential-card {
        background: rgba(148, 163, 184, 0.08);
        border-radius: 24px;
        padding: 30px;
        text-align: center;
        border: 1px solid rgba(148, 163, 184, 0.2);
        transition: all 0.3s ease;
    }

    html.dark-theme .credential-card {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .credential-badge {
        display: inline-block;
        padding: 6px 12px;
        background: rgba(105, 92, 254, 0.2);
        border-radius: 999px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 16px;
    }

    .credential-name {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .credential-code {
        font-size: 14px;
        color: var(--text-secondary);
        margin-bottom: 24px;
    }

    .credential-code span {
        display: inline-block;
        padding: 4px 12px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        font-weight: 700;
        letter-spacing: 0.1em;
        margin-left: 8px;
    }

    .qr-frame {
        margin: 24px 0;
        padding: 16px;
        background: linear-gradient(145deg, #1e293b, #0f172a);
        border-radius: 20px;
        display: inline-block;
    }

    .qr-frame-inner {
        background: white;
        padding: 12px;
        border-radius: 14px;
    }

    .qr-frame img {
        max-width: 240px;
        display: block;
        border-radius: 10px;
    }

    .credential-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 24px;
    }

    .btn-download,
    .btn-logout {
        flex: 1;
        min-width: 140px;
        padding: 14px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-download {
        background: var(--primary);
        color: white;
    }

    .btn-download:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(105, 92, 254, 0.3);
        text-decoration: none;
        color: white;
    }

    .btn-logout {
        background: rgba(148, 163, 184, 0.1);
        color: var(--text-primary);
        border: 1px solid rgba(148, 163, 184, 0.3);
    }

    html.dark-theme .btn-logout {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .btn-logout:hover {
        background: rgba(239, 68, 68, 0.15);
        border-color: var(--error);
        color: var(--error);
        text-decoration: none;
    }

    @media (max-width: 600px) {
        .portal-card {
            padding: 24px;
        }

        .portal-title {
            font-size: 24px;
        }

        .logo-wrapper {
            width: 70px;
            height: 70px;
        }
    }
</style>

</head>
<body>

<div class="portal-container">
    <div class="portal-card">

        <!-- Theme toggle -->
        <button type="button" class="theme-toggle" id="themeToggle" aria-label="Cambiar tema">
            <span class="material-symbols-rounded" id="themeIcon">dark_mode</span>
        </button>

        <!-- Admin link (solo visible cuando NO está logueado) -->
        <?php if (!$estaLogueado): ?>
        <a href="admin/vistas/login.html" class="admin-entry">
            <span class="admin-dot"></span>
            Admin
        </a>
        <?php endif; ?>

        <?php if (!$estaLogueado): ?>

        <!-- Header -->
        <div class="portal-header">
            <div class="logo-wrapper">
                <span class="material-symbols-rounded">qr_code_scanner</span>
            </div>
            <h1 class="portal-title">Control de Asistencia QR</h1>
            <p class="portal-subtitle">Accede a tu credencial digital</p>
        </div>

        <!-- Custom tabs -->
        <div class="custom-tabs">
            <button class="tab-btn active" onclick="switchTab('login')">Iniciar Sesión</button>
            <button class="tab-btn" onclick="switchTab('register')">Registrarme</button>
        </div>

        <!-- Tab content -->
        <div class="tab-content-wrapper">
            <!-- LOGIN -->
            <div class="tab-pane active" id="loginTab">
                <form id="formLogin">
                    <div class="form-group">
                        <label>Matrícula</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-rounded input-icon">badge</span>
                            <input type="text" name="documento_numero" class="form-control" placeholder="Ingresa tu matrícula" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-rounded input-icon">phone</span>
                            <input type="text" name="telefono" class="form-control" placeholder="Ingresa tu teléfono" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Entrar</button>
                </form>
            </div>

            <!-- REGISTRO -->
            <div class="tab-pane" id="registerTab">
                <form id="formRegistro">
                    <div class="form-group">
                        <label>Nombre</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-rounded input-icon">person</span>
                            <input type="text" name="nombre" class="form-control" placeholder="Tu nombre" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Apellidos</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-rounded input-icon">person</span>
                            <input type="text" name="apellidos" class="form-control" placeholder="Tus apellidos" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Matrícula</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-rounded input-icon">badge</span>
                            <input type="text" name="documento_numero" class="form-control" placeholder="Tu matrícula" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <div class="input-wrapper">
                            <span class="material-symbols-rounded input-icon">phone</span>
                            <input type="text" name="telefono" class="form-control" placeholder="Tu teléfono" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Crear Cuenta y Generar QR</button>
                </form>
            </div>
        </div>

        <div id="mensaje" class="alert"></div>

        <?php else: ?>

        <!-- Logged in view -->
        <div class="credential-card">
            <div class="credential-badge">Empleado Registrado</div>
            
            <h2 class="credential-name"><?php echo htmlspecialchars($_SESSION['empleado_nombre']); ?></h2>
            
            <div class="credential-code">
                Código: <span><?php echo htmlspecialchars($_SESSION['empleado_codigo']); ?></span>
            </div>

            <div class="qr-frame">
                <div class="qr-frame-inner">
                    <?php if (!empty($_SESSION['empleado_imagen'])): ?>
                        <img src="admin/files/qrcodes/<?php echo htmlspecialchars($_SESSION['empleado_imagen']); ?>" alt="QR Code">
                    <?php else: ?>
                        <p>No se generó el QR</p>
                    <?php endif; ?>
                </div>
            </div>

            <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 8px;">
                Muestra este código para registrar tu asistencia
            </p>

            <div class="credential-actions">
                <a href="admin/files/qrcodes/<?php echo htmlspecialchars($_SESSION['empleado_imagen']); ?>" 
                   download="QR_<?php echo htmlspecialchars($_SESSION['empleado_nombre']); ?>.png" 
                   class="btn-download">
                    <span class="material-symbols-rounded" style="font-size: 18px;">download</span>
                    Descargar QR
                </a>
                <a href="user/EmpleadoPortal.php?op=logout" class="btn-logout">
                    <span class="material-symbols-rounded" style="font-size: 18px;">logout</span>
                    Cerrar Sesión
                </a>
            </div>
        </div>

        <?php endif; ?>

    </div>
</div>

<script src="admin/public/js/jquery-3.1.1.min.js"></script>

<script>
// Theme toggle
(function() {
    const htmlEl = document.documentElement;
    const toggleBtn = document.getElementById('themeToggle');
    const iconEl = document.getElementById('themeIcon');

    function updateIcon() {
        const isDark = htmlEl.classList.contains('dark-theme');
        iconEl.textContent = isDark ? 'light_mode' : 'dark_mode';
    }

    toggleBtn.addEventListener('click', function() {
        const isDark = htmlEl.classList.toggle('dark-theme');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        updateIcon();
    });

    updateIcon();
})();

// Tab switching
function switchTab(tab) {
    const buttons = document.querySelectorAll('.tab-btn');
    const panes = document.querySelectorAll('.tab-pane');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    panes.forEach(pane => pane.classList.remove('active'));
    
    if (tab === 'login') {
        buttons[0].classList.add('active');
        document.getElementById('loginTab').classList.add('active');
    } else {
        buttons[1].classList.add('active');
        document.getElementById('registerTab').classList.add('active');
    }
}

// Form submissions
$(function() {
    // LOGIN
    $("#formLogin").on("submit", function(e) {
        e.preventDefault();
        $.post("user/EmpleadoPortal.php?op=login", $(this).serialize(), function(res) {
            let data = {};
            try { data = (typeof res === "string") ? JSON.parse(res) : res; } catch (e) {}

            $("#mensaje").removeClass("alert-success alert-danger").show();
            if (data.success) {
                $("#mensaje").addClass("alert-success").text(data.message);
                setTimeout(() => location.reload(), 800);
            } else {
                $("#mensaje").addClass("alert-danger").text(data.message || "Error al iniciar sesión.");
            }
        });
    });

    // REGISTRO
    $("#formRegistro").on("submit", function(e) {
        e.preventDefault();
        $.post("user/EmpleadoPortal.php?op=registrar", $(this).serialize(), function(res) {
            let data = {};
            try { data = (typeof res === "string") ? JSON.parse(res) : res; } catch (e) {}

            $("#mensaje").removeClass("alert-success alert-danger").show();
            if (data.success) {
                $("#mensaje").addClass("alert-success").text(data.message);
                setTimeout(() => location.reload(), 800);
            } else {
                $("#mensaje").addClass("alert-danger").text(data.message || "No se pudo registrar.");
            }
        });
    });
});
</script>

</body>
</html>