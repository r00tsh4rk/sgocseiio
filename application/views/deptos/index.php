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
                <a class="navbar-brand" href="<?php echo base_url(); ?>Departamentos/PanelDeptos">SGOCSEIIO</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a style="color: #FC8A62;" href="" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('nombre'); ?> <b class="caret"></b></a>
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
                        <a href="<?php echo base_url(); ?>Departamentos/PanelDeptos"><i class="fa fa-desktop"></i> Inicio</a>
                    </li>
                   <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Externo/RecepcionDeptos"><i class="fa fa-exchange"></i> Oficios Externos</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/BuzonInterno"><i class="fa fa-university"></i> Oficios Internos</a>
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
                            <?php 
                                foreach ($infodepto as $row) {
                                    echo $row->nombre_area;
                                }
                            ?> <small>Sistema de Gestión de Oficios del CSEIIO</small>
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
                    <h1 style="text-align: center;">Proceso Externo</h1>
                    <br>
                     <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-envelope fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $pendientesext; ?></div>
                                        <div>Pendientes</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Departamentos/Externo/PendientesDeptos">
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
                                        <div class="huge"><?php echo $nocontestadosext; ?></div>
                                        <div>No Contestados</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Departamentos/Externo/NoContestadosDeptos">
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
                                        <div class="huge"><?php echo $contestadosext; ?></div>
                                        <div>Contestados en Tiempo y Forma</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Departamentos/Externo/ContestadosDeptos">
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
                                        <div class="huge"><?php echo $fueratiempoext; ?></div>
                                        <div>Contestados Fuera de Tiempo</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Departamentos/Externo/ContestadosFueraTiempoDeptos">
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
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $conteoTotalext; ?></div>
                                        <div>Total de Oficios Recibidos</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Departamentos/Externo/RecepcionDeptos">
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
                    <h1 style="text-align: center;">Proceso Interno</h1>
                    <br>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-envelope fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $pendientesint+$nocontestadosint; ?></div>
                                        <div>Pendientes</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/PendientesInternos">
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
                                        <div class="huge"><?php echo $nocontestadosint; ?></div>
                                        <div>No Contestados</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/NoContestadosInterno">
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
                                        <div class="huge"><?php echo $contestadosint; ?></div>
                                        <div>Contestados en Tiempo y Forma</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/ContestadosInterno">
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
                                        <div class="huge"><?php echo $fueratiempoint; ?></div>
                                        <div>Contestados Fuera de Tiempo</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/FueraDeTiempoInterno">
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
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $conteoTotalint; ?></div>
                                        <div>Total de Oficios Recepcionados</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/BuzonInterno">
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
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $emitidosint; ?></div>
                                        <div>Total de Oficios Emitidos</div>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo base_url(); ?>Departamentos/Interno/RecepcionInterna">
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