<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Require meta TAGS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit-no">
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <!-- Bootsrap 3.3.5 -->
     <link rel="stylesheet" href="../admin/public/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../admin/public/css/font-awesome.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="../admin/public/css/AdminLTE.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="../admin/public/css/blue.css">
    <link rel="shortcut icon" href="../admin/public/img/favicon.ico">
    <link rel="stylesheet" href="../admin/public/css/_all-skins.min.css">
<style>
    #preview{
        width: 80%;

        margin: auto;
    }

    .main-footer{
        position:fixed;
        bottom:0;
        width:100%;
    }
  </style>
  <title>Asistencia</title>
</head>

<body class="hold-transition skin-blue layout-top-nav">


    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="../admin/vistas/login.html" class="navbar-brand"><b>SIS</b>ASISTENCIA QR</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class=""><a href="../admin/">ADMIN</a></li>
                    </ul>
                </div>

                <!-- /.navbar-collapse -->
            </div>
                <!-- /.container fluid -->
        </nav>
</header>


                <div class="container text-center">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <h4>Registro de asistencia</h4>
                        </div>
                        <div id="camara">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <div id="cuadro">
                                    <video class="border border-primary" id="preview"></video>
                                </div>
                            </div>
                        </div>
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <button type="button" id="btnIngreso" onclick="iniciaCamara()" class="btn btn-success">Iniciar cámara</button>

                        <button type="button" id="btnSalida" onclick="apagaCamara()" class="btn btn-warning">Apagar cámara</button>
                        </div>

                      </div>
                    </div>    

                <footer class="main-footer">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> 0.0.1
                    </div>
                    <strong>Copyright &copy; 2025-2026 <a target="_blank" href="https://github.com/ElBryton12">Brayan De Jesús Castillo</a></strong> Derechos Reservados
                </footer>    

                <!-- Fin modales -->
                <!-- Optional JavaScript -->
                <!-- JQuery -->
                <script src="../admin/public/js/jquery-3.1.1.min.js"></script>
                <!-- Bootstrap 3.3.5 -->
                <script src="../admin/public/js/bootstrap.min.js"></script>
                <script type="text/javascript" src="scripts/asistencia.js?<?php echo time(); ?>"></script>

                </body>
                </html>
  