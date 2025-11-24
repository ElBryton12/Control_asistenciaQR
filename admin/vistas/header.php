<?php
//Activamos almacenamiento en el buffer 
ob_start();

// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['nombre'])) {
    header("Location: login.html");
    exit();
}

// 🔹 Rol del usuario en sesión
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'GUARDIA';  // default GUARDIA
$esAdmin = ($rol === 'ADMIN');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Proyecto QR - Panel de Control</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;0,700;1,500&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/css/font-awesome.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../public/css/_all-skins.min.css">
  
  <!-- DATATABLES -->
  <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
  <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
  <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
  
  <!-- Modern Sidebar Styles -->
  <link rel="stylesheet" href="../public/css/modern-sidebar.css">
  
  <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
  <link rel="shortcut icon" href="../public/img/favicon.ico">
  
  <!-- Script crítico para prevenir flash de tema claro -->
  <script>
    (function() {
      const savedTheme = localStorage.getItem("theme");
      const systemPrefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
      const shouldUseDarkTheme = savedTheme ? savedTheme === "dark" : systemPrefersDark;
      
      if (shouldUseDarkTheme) {
        document.documentElement.classList.add("dark-theme");
      }
    })();
  </script>
</head>

<body>
  <!-- Site navigation bar (Mobile) -->
  <nav class="site-nav">
    <button class="sidebar-toggle">
      <span class="material-symbols-rounded">menu</span>
    </button>
    <div class="site-nav-title">
      <span><b>APP</b> QR</span>
    </div>
    <div class="site-nav-user">
      <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" alt="<?php echo htmlspecialchars($_SESSION['nombre']); ?>">
    </div>
  </nav>

  <div class="container">
    <!-- Modern Sidebar -->
    <aside class="sidebar collapsed">
      <!-- Sidebar header -->
      <header class="sidebar-header">
        <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" alt="<?php echo htmlspecialchars($_SESSION['nombre']); ?>" class="header-logo">
        <button class="sidebar-toggle">
          <span class="material-symbols-rounded">chevron_left</span>
        </button>
      </header>

      <div class="sidebar-content">

        
        <!-- Menu list -->
      <ul class="menu-list">
        <!-- TODOS ven esto -->
        <li class="menu-item">
          <a href="escritorio.php" class="menu-link" data-page="escritorio">
            <span class="material-symbols-rounded">dashboard</span>
            <span class="menu-label">Escritorio</span>
          </a>
        </li>

        <li class="menu-item">
          <a href="asistencia.php" class="menu-link" data-page="asistencia">
            <span class="material-symbols-rounded">fact_check</span>
            <span class="menu-label">Asistencias</span>
          </a>
        </li>

        <li class="menu-item">
          <a href="../../vistas/asistencia.php" class="menu-link" data-page="scanner">
            <span class="material-symbols-rounded">qr_code_scanner</span>
            <span class="menu-label">Escáner</span>
          </a>
        </li>

        <li class="menu-item">
          <a href="rptasistencia.php" class="menu-link" data-page="rptasistencia">
            <span class="material-symbols-rounded">insert_chart</span>
            <span class="menu-label">Reportes</span>
          </a>
        </li>

        <?php if ($esAdmin): ?>
          <!-- SOLO ADMIN ve esto -->
          <li class="menu-item">
            <a href="empleado.php" class="menu-link" data-page="empleado">
              <span class="material-symbols-rounded">group</span>
              <span class="menu-label">Empleados</span>
            </a>
          </li>

          <li class="menu-item">
            <a href="usuario.php" class="menu-link" data-page="usuario">
              <span class="material-symbols-rounded">lock</span>
              <span class="menu-label">Usuarios</span>
            </a>
          </li>

          <li class="menu-item">
            <a href="https://github.com/ElBryton12/Control_asistenciaQR" target="_blank" class="menu-link">
              <span class="material-symbols-rounded">code</span>
              <span class="menu-label">GitHub</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>


        <!-- User Info Section -->
        <div class="sidebar-user-info">
          <div class="user-info-content">
            <img src="../files/usuarios/<?php echo $_SESSION['imagen']; ?>" alt="Usuario" class="user-avatar">
            <div class="user-details">
              <span class="user-name"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
              <span class="user-role">
                <?php echo $esAdmin ? 'Administrador' : 'Guardia'; ?>
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar footer -->
      <div class="sidebar-footer">
        <button class="theme-toggle">
          <div class="theme-label">
            <span class="theme-icon material-symbols-rounded">dark_mode</span>
            <span class="theme-text">Modo Oscuro</span>
          </div>
          <div class="theme-toggle-track">
            <div class="theme-toggle-indicator"></div>
          </div>
        </button>
        
        <a href="../controlador/Usuario.php?op=salir" class="logout-btn">
          <span class="material-symbols-rounded">logout</span>
          <span class="logout-text">Cerrar Sesión</span>
        </a>
      </div>
    </aside>
    
    <!-- Aquí termina el header.php -->
    <!-- Cada página debe abrir su propio <div class="main-content"> -->