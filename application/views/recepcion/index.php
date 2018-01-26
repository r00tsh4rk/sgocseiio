  
<?php
foreach ($contestadosDatos as $row) {
   
    $mensajes = '<script  type="text/javascript" charset="utf-8" async defer>
    Push.create("Notificación", {
     body: "'.$row->emisor." ha respondido el oficio: ".$row->num_oficio.'",
     icon: "'.base_url()."/assets/img/apple-touch-icon-60x60.png".'"
 });
 </script>';

 echo $mensajes;
}
?>


<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>RecepcionGral/PanelRecepGral">SGOCSEIIO</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a style="color: #FC8A62;" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('nombre'); ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Perfil</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo base_url() ?>Login/salir"><i class="fa fa-fw fa-power-off"></i> Cerrar Sesión</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li class="active">
                    <a href="<?php echo base_url(); ?>RecepcionGral/PanelRecepGral"><i class="fa fa-desktop"></i> Inicio</a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion"><i class="fa fa-arrow-down"></i> Oficios de Entrada</a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/PanelSalidas"><i class="fa fa-arrow-up"></i> Oficios de Salida</a>
                </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?php echo $this->session->userdata('descripcion'); ?>  <small>Sistema de Gestión de Oficios del CSEIIO</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                        <i class="fa fa-dashboard"></i> Incio
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="row">
            <h1 style="text-align: center;">Oficios de Entrada</h1>
            <br>

              <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-envelope fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $pendientes+$nocontestados; ?></div>
                                <div>Pendientes</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Pendientes">
                        <div class="panel-footer">
                            <span class="pull-left">Más Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-times-circle fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $pendientes+$nocontestados; ?></div>
                                <div>No Contestados</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/NoContestados">
                        <div class="panel-footer">
                            <span class="pull-left">Más Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-check-circle fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $contestados; ?></div>
                                <div>Contestados en Tiempo y Forma</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Contestados">
                        <div class="panel-footer">
                            <span class="pull-left">Más Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
          

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-orange">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-clock-o fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $fueratiempo; ?></div>
                                <div>Contestados Fuera de Tiempo</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/ContestadosFueraTiempo">
                        <div class="panel-footer">
                            <span class="pull-left">Más Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
                 <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-plus-circle fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $conteoTotal; ?></div>
                                <div>Total de Oficios Recibidos</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion">
                        <div class="panel-footer">
                            <span class="pull-left">Ver mas Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-info-circle fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $totalinformativos; ?></div>
                                <div>Total de Oficios Informativos</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/OficiosInformativos">
                        <div class="panel-footer">
                            <span class="pull-left">Ver mas Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <hr>


        <div class="row">
            <h1 style="text-align: center;">Oficios de Salida</h1>
            <br>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-level-up fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $totalsalientes+$contestados+$fueratiempo; ?></div>
                                <div>Total de Oficios Salientes</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Salidas/PanelSalidas">
                        <div class="panel-footer">
                            <span class="pull-left">Ver mas Información</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
    
        </div>
        
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
    <!-- /#wrapper -->