<?php 
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.html"); 
} else {
    require 'header.php';
 ?>

<!--CONTENIDO -->
<div class="main-content content-wrapper">

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="row">

      <div class="col-md-12">

        <div class="box">

          <div class="box-header with-border">
            <h1 class="box-title">
              Lista de empleados 
              <button class="btn btn-success" onclick="mostrarform(true)" id="btnAgregar">
                <i class="fa fa-plus-circle"></i> Agregar
              </button>
            </h1>
            <div class="box-tools pull-right">
            </div>
          </div>

          <!-- LISTADO -->
          <div class="panel-body table-responsive" id="listadoregistros">

            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                <th>Opciones</th>           <!-- 0: botones -->
                <th>Nombre</th>             <!-- 1: nombre completo -->
                <th>Matrícula</th>          <!-- 2 -->
                <th>Teléfono</th>           <!-- 3 -->
                <th>Código</th>             <!-- 4 -->
                <th>QR</th>                 <!-- 5: imagen QR -->
                <th>Acciones QR</th>        <!-- 6: descargar / imprimir / generar -->
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Matrícula</th>
                <th>Teléfono</th>
                <th>Código</th>
                <th>QR</th>
                <th>Acciones QR</th>
              </tfoot>   
            </table>

          </div>
          <!-- /LISTADO -->

          <!-- FORMULARIO -->
          <div class="panel-body" id="formularioregistros">
            <form action="" name="formulario" id="formulario" method="POST">
              
              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label>Nombre ( * ):</label>
                <input type="hidden" name="empleado_id" id="empleado_id">
                <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
              </div>

              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label>Apellidos ( * ):</label>
                <input class="form-control" type="text" name="apellidos" id="apellidos" maxlength="100" placeholder="Apellidos" required>
              </div>

              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label>N° Matrícula:</label>
                <!-- id corregido para coincidir con JS -->
                <input class="form-control" type="text" name="documento_numero" id="documento_numero" maxlength="70" placeholder="Documento">
              </div>

              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label>Teléfono ( * ):</label>
                <input class="form-control" type="text" name="telefono" id="telefono" maxlength="20" placeholder="999999999" required>
              </div>

              <!-- Campo de código SOLO LECTURA (opcional) -->
              <div class="form-group col-lg-6 col-md-6 col-xs-12">
                <label>Código de asistencia:</label>
                <input class="form-control" type="text" name="codigo" id="codigo" maxlength="64"
                       placeholder="Se genera automáticamente" readonly>
              </div>

              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button class="btn btn-primary" type="submit" id="btnGuardar">
                  <i class="fa fa-save"></i> Guardar
                </button>
                <button class="btn btn-danger" onclick="cancelarform()" type="button">
                  <i class="fa fa-arrow-circle-left"></i> Cancelar
                </button>
              </div>

            </form>
          </div>
          <!-- /FORMULARIO -->

        </div>

      </div>

    </div>

  </section>

</div>
<!--FIN CONTENIDO -->

<?php 
require 'footer.php';
?>

<script src="scripts/empleado.js"></script>
<?php 
}
ob_end_flush();
?>
