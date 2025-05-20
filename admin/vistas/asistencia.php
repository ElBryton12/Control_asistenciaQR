<?php 
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.html"); 
} else {
    require 'header.php';
 ?>
<!--CONTENIDO -->
<div class="content-wrapper">

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
            <h1 class="box-title">Lista de asistencias </h1>
            <div class="box-tools pull-right">
              
            </div>
          </div>
          <!--box-header-->

          <!--centro-->

          <!--tabla para listar datos-->
          <div class="panel-body table-responsive" id="listadoregistros">

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

 <script src='scripts/asistencia.js'></script>
<?php }

ob_end_flush();
?>