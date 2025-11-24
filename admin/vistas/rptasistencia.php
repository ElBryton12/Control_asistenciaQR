  <?php 
  ob_start();
  session_start();
  if (!isset($_SESSION['nombre'])) {
      header("Location: login.html"); 
  } else {
  require_once "../config/global.php";
  date_default_timezone_set(ZONA_HORARIA);
  require 'header.php';
  ?>
<!--CONTENIDO -->
<div class="main-content content-wrapper">

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="row">

      <!-- /.col-md12 -->
      <div class="col-md-12">

        <!--fin box-->
        <div class="box">

          <!--box-header-->
          <div class="box-header with-border">
            <h1 class="box-title">Reporte de Asistencia por fecha </h1>
            <div class="box-tools pull-right">
              
            </div>
          </div>
          <!--box-header-->

          <!--centro-->

          <!--tabla para listar datos-->
          <div class="panel-body table-responsive" id="listadoregistros">
            
          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <label>Fecha Inicio</label>
              <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <label>Fecha Fin</label>
              <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d");?>">
            </div>
            <div class="form-inline col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <label>Empleado</label>
                <select name="empleado_id" id="empleado_id" class="form-control selectpicker" data-live-search="true" required>
                </select>
                <br>
                <button class="btn btn-success" onclick="listar();">    
                  Mostrar</button>
            </div>

            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                <th>#</th>
                <th>Código</th>
                <th>Empleado</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Tipo</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>#</th>
                <th>Código</th>
                <th>Empleado</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Tipo</th>
              </tfoot>   
            </table>

          </div>
          <!--fin tabla para listar datos-->


          <!--fin centro-->

        </div>
        <!--fin box-->

      </div>
      <!-- /.col-md12 -->

    </div>
    <!-- fin Default-box -->

  </section>
  <!-- /.content -->

</div>
<!--FIN CONTENIDO -->

<?php 
require 'footer.php';
 ?>

 <script src='scripts/rptasistencia.js'></script>
<?php }

ob_end_flush();
?>