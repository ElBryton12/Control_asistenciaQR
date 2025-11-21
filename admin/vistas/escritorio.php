<?php
//Activamos almacenamiento en el buffer 
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.html"); 
} else {

 require 'header.php';
 require_once ('../modelos/Usuario.php');
 $usuario = new Usuario();
 $rsptan = $usuario->cantidad_usuario();
 $reg = $rsptan->fetch_object();


 // Modelo Empleado SOLO para el contador
require_once ('../modelos/Empleado.php');
$empleado = new Empleado();
$rsptaEmp = $empleado->cantidad_empleado();
$regEmp = $rsptaEmp->fetch_object();
?>

<!--CONTENIDO -->
<div class="content-wrapper">
  <!-- Page Header -->
  <div class="page-header">
    <h1 class="page-title">
      <span class="material-symbols-rounded" style="vertical-align: middle; margin-right: 10px;">dashboard</span>
      Panel de Control
    </h1>
    <p class="page-subtitle">Bienvenido al sistema de control de asistencia</p>
  </div>

  <!-- Main content -->
  <section class="content">
    <!-- Stats Boxes -->
    <div class="row">
      <!-- Lista Asistencia -->
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <a href="asistencia.php" class="modern-stat-card card-green">
          <div class="stat-icon">
            <span class="material-symbols-rounded">fact_check</span>
          </div>
          <div class="stat-content">
            <h3>Lista de Asistencia</h3>
            <p>Registrar entrada/salida</p>
          </div>
          <div class="stat-arrow">
            <span class="material-symbols-rounded">arrow_forward</span>
          </div>
        </a>
      </div>

      <!-- Empleados -->
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <a href="empleado.php" class="modern-stat-card card-orange">
          <div class="stat-icon">
            <span class="material-symbols-rounded">group</span>
          </div>
          <div class="stat-content">
            <h3>Empleados</h3>
            <p>Total: <strong><?php echo $regEmp->total; ?></strong></p>
          </div>
          <div class="stat-arrow">
            <span class="material-symbols-rounded">arrow_forward</span>
          </div>
        </a>
      </div>

      <!-- Reportes -->
      <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <a href="rptasistencia.php" class="modern-stat-card card-blue">
          <div class="stat-icon">
            <span class="material-symbols-rounded">insert_chart</span>
          </div>
          <div class="stat-content">
            <h3>Reporte de Asistencias</h3>
            <p>Ver estadísticas</p>
          </div>
          <div class="stat-arrow">
            <span class="material-symbols-rounded">arrow_forward</span>
          </div>
        </a>
      </div>
    </div>

    <!-- Additional Info Cards -->
    <div class="row" style="margin-top: 30px;">
      <div class="col-md-12">
        <div class="info-card">
          <div class="info-card-header">
            <span class="material-symbols-rounded">info</span>
            <h3>Información del Sistema</h3>
          </div>
          <div class="info-card-body">
            <p>
              <strong>Sistema de Control de Asistencia QR</strong><br>
              Gestiona la entrada y salida de empleados mediante códigos QR. 
              Genera reportes detallados y mantén un control preciso de las asistencias.
            </p>
            <div class="quick-actions">
              <a href="empleado.php" class="quick-action-btn">
                <span class="material-symbols-rounded">person_add</span>
                Agregar Empleado
              </a>
              <a href="asistencia.php" class="quick-action-btn">
                <span class="material-symbols-rounded">qr_code_scanner</span>
                Registrar Asistencia
              </a>
              <a href="rptasistencia.php" class="quick-action-btn">
                <span class="material-symbols-rounded">download</span>
                Descargar Reporte
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- /.content -->
</div>
<!--FIN CONTENIDO -->

<style>
/* Modern Dashboard Styles */
.page-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid var(--color-border-hr);
}

.page-title {
    font-size: 2rem;
    font-weight: 600;
    color: var(--color-text-primary);
    margin: 0 0 5px 0;
    display: flex;
    align-items: center;
}

.page-subtitle {
    color: var(--color-text-placeholder);
    margin: 0;
    font-size: 1rem;
}

.modern-stat-card {
    display: flex;
    align-items: center;
    padding: 25px;
    border-radius: 12px;
    text-decoration: none;
    color: white;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.modern-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    text-decoration: none;
    color: white;
}

.card-green {
    background: linear-gradient(135deg, #00c853 0%, #00e676 100%);
}

.card-orange {
    background: linear-gradient(135deg, #ff6f00 0%, #ff9800 100%);
}

.card-blue {
    background: linear-gradient(135deg, #00b0ff 0%, #00e5ff 100%);
}

.stat-icon {
    font-size: 3rem;
    margin-right: 20px;
    opacity: 0.9;
}

.stat-icon .material-symbols-rounded {
    font-size: 3rem;
}

.stat-content {
    flex: 1;
}

.stat-content h3 {
    margin: 0 0 5px 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.stat-content p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.stat-arrow {
    font-size: 2rem;
    opacity: 0.7;
    transition: transform 0.3s ease;
}

.modern-stat-card:hover .stat-arrow {
    transform: translateX(5px);
}

.info-card {
    background: var(--color-bg-sidebar);
    border-radius: 12px;
    box-shadow: 0 2px 8px var(--color-shadow);
    overflow: hidden;
}

.info-card-header {
    padding: 20px 25px;
    background: var(--color-bg-secondary);
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 1px solid var(--color-border-hr);
}

.info-card-header h3 {
    margin: 0;
    font-size: 1.2rem;
    color: var(--color-text-primary);
}

.info-card-header .material-symbols-rounded {
    color: var(--color-hover-primary);
    font-size: 1.5rem;
}

.info-card-body {
    padding: 25px;
    color: var(--color-text-primary);
}

.quick-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: var(--color-hover-primary);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.quick-action-btn:hover {
    background: #5548d9;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(105, 92, 254, 0.3);
    color: white;
    text-decoration: none;
}

.quick-action-btn .material-symbols-rounded {
    font-size: 1.2rem;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 1.5rem;
    }
    
    .modern-stat-card {
        padding: 20px;
    }
    
    .stat-icon .material-symbols-rounded {
        font-size: 2.5rem;
    }
    
    .quick-actions {
        flex-direction: column;
    }
    
    .quick-action-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<?php 
require 'footer.php';
}
ob_end_flush();
?>