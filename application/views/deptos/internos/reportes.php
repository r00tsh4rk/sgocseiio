    <?php 

    function bussiness_days($begin_date, $end_date, $type = 'array') {
        $date_1 = date_create($begin_date);
        $date_2 = date_create($end_date);
        if ($date_1 > $date_2) return FALSE;
        $bussiness_days = array();
        while ($date_1 <= $date_2) {
            $day_week = $date_1->format('w');
            if ($day_week > 0 && $day_week < 6) {
                $bussiness_days[$date_1->format('Y-m')][] = $date_1->format('d');
            }
            date_add($date_1, date_interval_create_from_date_string('1 day'));
        }
        if (strtolower($type) === 'sum') {
            array_map(function($k) use(&$bussiness_days) {
                $bussiness_days[$k] = count($bussiness_days[$k]);
            }, array_keys($bussiness_days));
        }
        return $bussiness_days;
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
                <a class="navbar-brand" href="<?php echo base_url(); ?>Departamentos/PanelDeptos">SGOCSEIIO</a>
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
                    <li >
                        <a href="<?php echo base_url(); ?>Departamentos/PanelDeptos"><i class="fa fa-desktop"></i> Inicio</a>
                    </li>
                     <li >
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/BuzonInterno"><i class="fa fa-plus"></i> Buzón de oficios internos</a>
                    </li>
                    <li >
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/RecepcionInterna"><i class="fa fa-plus"></i> Oficios Emitidos</a>
                    </li>
                     <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/PendientesInternos"><i class="fa fa-clock-o"></i> Pendientes</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/ContestadosInterno"><i class="fa fa-check-circle"></i> Contestados</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/FueraDeTiempoInterno"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>Departamentos/Interno/NoContestadosInterno"><i class="fa  fa-times-circle"></i> No Contestados</a>
                    </li>
                     <li class="dropdown">
                    <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-arrow-right"></i>Turnado de Copias</a>
                     <ul class="dropdown-menu" role="menu">
                         <li><a href="<?php echo base_url(); ?>Departamentos/Interno/BuzonCopias" ><i class="fa fa-hand-o-right" aria-hidden="true"></i> Oficios con copia a este Departamento</a></li>
                        <li><a href="<?php echo base_url(); ?>Departamentos/Interno/CopiasDirecciones" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Direcciones</a></li>
                        <li><a href="<?php echo base_url(); ?>Departamentos/Interno/CopiasDeptos" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Departamentos</a></li>
                     </ul>
                </li>
                <li class="active">
                     <a href="<?php echo base_url(); ?>Departamentos/Interno/ReportesDeptoInt"><i class="fa fa-book"></i> Reportes</a>
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
                            ?>
                             <small>Reportes</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Reportes
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#home">Inicio</a></li>
                  <li><a data-toggle="tab" href="#menu1">Reportes Generales del Departamento</a></li>

              </ul>

               <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            <h3>Panel de Reportes</h3>
            <p>Bienvenido al Panel de Reportes del Sistema de Oficios del CSEIIO</p>
          </div>
          <!-- REPORTES GENERALES -->
          <div id="menu1" class="tab-pane fade">
            <ul  class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#inicioGeneral">Inicio</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales1">Oficios Recepcionados</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales2">Oficios Emitidos</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales3">Oficios Contestados dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales4">Oficios No Contestados en el Tiempo de Respuesta</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales5">Oficios Pendientes dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales6">Oficios Contestados Fuera del Rango Tiempo</a></li>
            </ul>

            <div class="tab-content">
              <div id="inicioGeneral" class="tab-pane fade in active">
                <h3>Panel de Reportes Generales </h3>
                <p>Bienvenido al Panel de Reportes Generales  - Sistema de Oficios del CSEIIO</p>
              </div>

              <div id="generales1" class="tab-pane fade">
                <h3>Total de Oficios Recepcionados</h3>
                <br>
                <h4>Genera el total de oficios recepcionados por el departamento.</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Departamentos/Interno/ReportesDeptoInt/reporteAllPorDeptos">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios recepcionados</p>
                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>

              </div>

              <div id="generales2" class="tab-pane fade">
                <h3>Total de Oficios Emitidos</h3>
                <br>
                <h4>Genera el total de oficios emitidos por el departamento.</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Departamentos/Interno/ReportesDeptoInt/reporteEmitidosDeptoInt">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios emitidos</p>
                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>

              </div>

              <div id="generales3" class="tab-pane fade">
                <h3>Total de Oficios Contestados</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados en la modalidad interna</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Departamentos/Interno/ReportesDeptoInt/reporteContestadosDeptoInt">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios contestados</p>
                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>


              <div id="generales4" class="tab-pane fade">
                <h3>Total de Oficios No Contestados</h3>
                <br>
                <h4>Genera el reporte de los oficios no contestados en la modalidad interna</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Departamentos/Interno/ReportesDeptoInt/reporteNoContestadosDeptoInt">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios no contestados</p>
                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>

              <div id="generales5" class="tab-pane fade">
                <h3>Total de Oficios Pendientes</h3>
                <br>
                <h4>Genera el reporte de los oficios pendientes por responder en la modalidad interna</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Departamentos/Interno/ReportesDeptoInt/reportePendientesDireccionesInt">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios pendientes</p>
                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>

              <div id="generales6" class="tab-pane fade">
                <h3>Total de Oficios Contestados Fuera de Tiempo</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados fuera del rango de tiempo de respuesta, en la modalidad interna</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Departamentos/Interno/ReportesDeptoInt/reporteContestadoFueraDeTiempoDepto">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios contestados fuera del rango de tiempo</p>
                  <div class="form-group">
                    <label for="fecha_inicio" class="col-lg-2 control-label">Fecha de Inicio:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_inicio" name="date_inicio"  value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecha_fin" class="col-lg-2 control-label">Fecha de Fin:</label>
                    <div class="col-lg-6">
                      <input type="date" class="form-control" id="date_final" name="date_final" value="<?php echo date('Y-m-d') ?>"/>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-6">
                      <button type="submit" class="btn btn-success">Imprimir Reporte</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

