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
            <h1 class="box-title">Lista de usuarios <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
            <div class="box-tools pull-right">
              
            </div>
          </div>
          <!--box-header-->

          <!--centro-->

          <!--tabla para listar datos-->
          <div class="panel-body table-responsive" id="listadoregistros">

            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Login</th>
                <th>Email</th>
                <th>Imagen</th>
                <th>Estado</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Login</th>
                <th>Email</th>
                <th>Imagen</th>
                <th>Estado</th>
              </tfoot>   
            </table>

          </div>
          <!--fin tabla para listar datos-->

          <!--formulatio para datos-->
          <div class="panel-body" id="formularioregistro">

          <form action='' name='formulario' id='formulario' method='POST'>
            <div class='form-group col-lg-6 col-md-6 col-xs-12'>
              <label for="">Nombre( * ):</label>
              <input class='form-control' type='hidden' name='idusuario' id='idusuario'>
              <input class='form-control' type='text' name='nombre' id='nombre' maxlength='100' placeholder='Nombre' required>
            </div>
            <div class='form-group col-lg-6 col-md-6 col-xs-12'>
              <label for="">Apellidos( * ):</label>
              <input class='form-control' type='text' name='apellidos' id='apellidos' maxlength='100' placeholder='Apellidos' required>
            </div>
            <div class='form-group col-lg-6 col-md-6 col-xs-12'>
              <label for="">Email( * ):</label>
              <input class='form-control' type='email' name='email' id='email' maxlength='70' placeholder='email'>
            </div>
            <div class='form-group col-lg-6 col-md-6 col-xs-12'>
              <label for="">Login( * ):</label>
              <input class='form-control' type='text' name='login' id='login' maxlength='20' placeholder='nombre de usuario' required>
            </div>
            <div class='form-group col-lg-6 col-md-6 col-xs-12'>
              <label for="">Clave de ingreso( * ):</label>
              <input class='form-control' type='password' name='clave' id='clave' maxlength='64' placeholder='Clave'>
            </div>
            <div class='form-group col-lg-6 col-md-6 col-xs-12'>
              <label for="">Imagen:</label>
              <input class='form-control filestyle' data-buttonText='Seleccionar foto' type='file' name='imagen' id='imagen'>
              <input type='hidden' name='imagenactual' id='imagenactual'>
              <img src='' alt='' width='150px' height='120' id='imagenmuestra'>
            </div>

            <div class='form-group col-lg-12 col-md-12 col-sm-12 col-xs-12'>
              <button class='btn btn-primary' type='submit' id='btnGuardar'><i class='fa fa-save'></i>Guardar</button>
              <button class='btn btn-danger' onclick='cancelarform()' type='button'><i class='fa fa-arrow-circle-left'></i>Cancelar</button>
            </div>
          </form>
        </div>
          <!--fin formulatio para datos-->

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

<script src='scripts/usuario.js'></script>
<?php }

ob_end_flush();
?>