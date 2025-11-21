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

    <link rel="shortcut icon" href="../public/img/favicon.ico">
    <!-- Bootstrap básico + tu fuente -->
    <link rel="stylesheet" href="admin/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">


<style>
    body {
        font-family: "Poppins", sans-serif;
        background: #f4f6fb;
    }

    .portal-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .portal-card {
    background: radial-gradient(circle at top left, #ffffff 0, #f7f8ff 35%, #edf2ff 100%);
    border-radius: 26px;
    box-shadow: 0 22px 60px rgba(15, 23, 42, 0.16);
    max-width: 960px;
    width: 100%;
    padding: 28px 34px 30px;
    position: relative; /* 👈 importante para posicionar el botón admin */
    }   

    .portal-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 4px;
        color: #111827;
    }

    .portal-subtitle {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 22px;
    }

    /* Botón/Link de acceso admin */
    .admin-entry {
        position: absolute;
        top: 18px;
        right: 24px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #6b7280;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.02);
        border: 1px dashed rgba(148, 163, 184, 0.7);
        opacity: 0.7;
        transition: all 0.2s ease;
    }

    .admin-entry-dot {
        width: 6px;
        height: 6px;
        border-radius: 999px;
        background: #10b981; /* verde discreto */
    }

    .admin-entry:hover {
        opacity: 1;
        background: rgba(37, 99, 235, 0.06);
        border-style: solid;
        border-color: rgba(37, 99, 235, 0.55);
        color: #1f2937;
    }

    /* --------- CREDENCIAL QR (modo logueado) --------- */

    .credential-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }

    .credential-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 30px 36px 26px;
        max-width: 420px;
        width: 100%;
        box-shadow: 0 18px 50px rgba(15, 23, 42, 0.12);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .credential-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top, rgba(59,130,246,0.12), transparent 55%);
        pointer-events: none;
    }

    .credential-header {
        position: relative;
        margin-bottom: 18px;
    }

    .credential-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 4px 10px;
        border-radius: 999px;
        background: #eff6ff;
        color: #1d4ed8;
        font-weight: 600;
    }

    .credential-name {
        margin-top: 10px;
        font-size: 22px;
        font-weight: 600;
        color: #111827;
    }

    .credential-sub {
        margin-top: 2px;
        font-size: 13px;
        color: #6b7280;
    }

    .credential-code {
        margin-top: 4px;
        font-size: 13px;
        color: #4b5563;
    }

    .credential-code span {
        font-weight: 700;
        letter-spacing: 0.08em;
        padding: 2px 8px;
        border-radius: 999px;
        background: #f1f5f9;
    }

    .qr-frame {
        position: relative;
        margin: 22px auto 12px;
        padding: 12px;
        border-radius: 22px;
        background: linear-gradient(145deg, #111827, #020617);
        display: inline-block;
    }

    .qr-frame-inner {
        background: #ffffff;
        padding: 12px;
        border-radius: 16px;
    }

    .credential-qr-img {
        max-width: 260px;
        width: 100%;
        height: auto;
        display: block;
        border-radius: 12px;
    }

    .credential-footer {
        position: relative;
        margin-top: 10px;
        font-size: 11px;
        color: #9ca3af;
    }

    .credential-actions {
        position: relative;
        margin-top: 10px;
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-main {
        border-radius: 999px;
        padding: 8px 22px;
        font-size: 13px;
        font-weight: 500;
    }

    .btn-ghost {
        border-radius: 999px;
        padding: 8px 22px;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #374151;
    }

    .btn-ghost:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }

    @media (max-width: 600px) {
        .portal-card {
            padding: 18px 18px 22px;
        }
        .credential-card {
            padding: 22px 18px 20px;
        }
    }
</style>

</head>
<body>

<div class="portal-container">
    <div class="portal-card">

         <!-- Acceso “escondido” para administrador -->
        <a href="admin/vistas/login.html" class="admin-entry" title="Acceso administrador">
            <span class="admin-entry-dot"></span>
            Admin
        </a>

        <h1 class="portal-title">Sistema de Control de Asistencia QR</h1>
        <p class="portal-subtitle">
            Regístrate o inicia sesión para obtener tu código QR de acceso.
        </p>


        <?php if (!$estaLogueado): ?>

            <!-- Pestañas: Login / Registro -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#loginTab" role="tab" data-toggle="tab">Iniciar sesión</a></li>
                <li><a href="#registerTab" role="tab" data-toggle="tab">Registrarme</a></li>
            </ul>

            <div class="tab-content" style="margin-top:15px;">
                <!-- LOGIN -->
                <div class="tab-pane fade in active" id="loginTab">
                    <form id="formLogin">
                        <div class="form-group">
                            <label>Documento</label>
                            <input type="text" name="documento_numero" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </form>
                </div>

                <!-- REGISTRO -->
                <div class="tab-pane fade" id="registerTab">
                    <form id="formRegistro">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Apellidos</label>
                            <input type="text" name="apellidos" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Documento</label>
                            <input type="text" name="documento_numero" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Crear cuenta y generar QR
                        </button>
                    </form>

                </div>
            </div>

            <div id="mensaje" class="alert" style="display:none; margin-top:15px;"></div>

            <?php else: ?>

                <div class="credential-wrapper">
                    <div class="credential-card">

                        <div class="credential-header">
                            <div class="credential-badge">
                                <span>Acceso empleado</span>
                            </div>

                            <h2 class="credential-name">
                                <?php echo htmlspecialchars($_SESSION['empleado_nombre']); ?>
                            </h2>

                            <div class="credential-sub">
                                Sistema de Control de Asistencia QR
                            </div>

                            <div class="credential-code">
                                Código:
                                <span><?php echo htmlspecialchars($_SESSION['empleado_codigo']); ?></span>
                            </div>
                        </div>

                        <div class="qr-frame">
                            <div class="qr-frame-inner">
                                <?php if (!empty($_SESSION['empleado_imagen'])): ?>
                                    <img
                                        src="admin/files/qrcodes/<?php echo htmlspecialchars($_SESSION['empleado_imagen']); ?>"
                                        alt="Código QR de acceso"
                                        class="credential-qr-img">
                                <?php else: ?>
                                    <p>No se ha generado imagen QR.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="credential-footer">
                            Muestra este código en el punto de control para registrar tu asistencia.
                        </div>

                        <div class="credential-actions">
                            <a
                                href="admin/files/qrcodes/<?php echo htmlspecialchars($_SESSION['empleado_imagen']); ?>"
                                download="QR_<?php echo htmlspecialchars($_SESSION['empleado_nombre']); ?>.png"
                                class="btn btn-primary btn-main">
                                Descargar QR
                            </a>

                            <a href="user/EmpleadoPortal.php?op=logout" class="btn btn-ghost">
                                Cerrar sesión
                            </a>
                        </div>
                    </div>
                </div>

            <?php endif; ?>


    </div>
</div>

<script src="admin/public/js/jquery-3.1.1.min.js"></script>
<script src="admin/public/js/bootstrap.min.js"></script>
<script>
$(function () {
    // LOGIN
    $("#formLogin").on("submit", function(e) {
        e.preventDefault();
        $.post("user/EmpleadoPortal.php?op=login", $(this).serialize(), function(res) {
            console.log("RESPUESTA LOGIN:", res);
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
            console.log("RESPUESTA REGISTRO:", res); // 👈 mira esto en la consola
            let data = {};
            try { data = (typeof res === "string") ? JSON.parse(res) : res; } catch (e) {}

            $("#mensaje").removeClass("alert-success alert-danger").show();
            if (data.success) {
                $("#mensaje").addClass("alert-success").text(data.message);
                setTimeout(() => location.reload(), 800); // recarga para mostrar el QR
            } else {
                $("#mensaje").addClass("alert-danger").text(data.message || "No se pudo registrar el empleado.");
            }
        });
    });
});
</script>


</body>
</html>
