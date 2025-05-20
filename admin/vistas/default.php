<?php 
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
            <h1 class="box-title">Datos <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
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
                <th>Dato1</th>
                <th>Dato2</th>
                <th>Dato3</th>
                <th>Dato4</th>
                <th>Dato5</th>
                <th>Dtao6</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Opciones</th>
                <th>Dato1</th>
                <th>Dato2</th>
                <th>Dato3</th>
                <th>Dato4</th>
                <th>Dato5</th>
                <th>Dtao6</th>
              </tfoot>   
            </table>

          </div>
          <!--fin tabla para listar datos-->

          <!--formulatio para datos-->
          <div class="panel-body" id="formularioregistro">

            <form action="" name="formulario" id="formulario" method="POST">
              <div class="form-group col-lg-4 col-md-4 col-xs-12">
                <label for="">campo(*): </label>
                <input class="form-control" type="text" name="campo" id="campo" required>
              </div>

              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
                <button class="btn btn-danger"  type="button" id="btnCancelar"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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