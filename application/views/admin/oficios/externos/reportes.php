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
            <li>
              <a href="<?php echo base_url(); ?>Admin/PanelAdmin/"><i class="fa fa-desktop"></i> Inicio</a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/PanelOfExternos"><i class="fa fa-plus"></i> Oficios Externos</a>
            </li>
            <li >
              <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/Pendientes"><i class="fa fa-clock-o"></i> Pendientes</a>
            </li>
            <li >
              <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/Contestados"><i class="fa fa-check-circle"></i> Contestados</a>
            </li>

            <li >
              <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/FueraTiempo"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
            </li>

            <li>
              <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/NoContestados"><i class="fa  fa-times-circle"></i> No Contestados</a>
            </li>

            <li>
              <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/Informativos"><i class="fa fa-info"></i> Oficios Informativos</a>
            </li>

            <li class="active">
              <a href="<?php echo base_url(); ?>Admin/Oficios/Externos/Reportes"><i class="fa fa-book"></i> Reportes</a>
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
              <?php echo $this->session->userdata('descripcion'); ?>  <small>Reportes</small>
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
          <li><a data-toggle="tab" href="#menu1">Reportes Generales</a></li>
          <li><a data-toggle="tab" href="#menu2">Reportes por Direcciones</a></li>
          <li><a data-toggle="tab" href="#menu3">Reportes por Departamentos</a></li>
        </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            <h3>Panel de Reportes</h3>
            <p>Bienvenido al Panel de Reportes del Sistema de Oficios del CSEIIO</p>
          </div>
          <!-- REPORTES GENERALES 
          -->
          <div id="menu1" class="tab-pane fade">
            <ul  class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#inicioGeneral">Inicio</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales1">Oficios Recepcionados</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales2">Oficios Contestados dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales3">Oficios Contestados Fuera del Rango Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales4">Oficios Pendientes dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales5">Oficios No Contestados en el Tiempo de Respuesta</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales6">Oficios Informativos Capturados por la Unidad</a></li>
            </ul>

            <div class="tab-content">
              <div id="inicioGeneral" class="tab-pane fade in active">
                <h3>Panel de Reportes Generales</h3>
                <p>Bienvenido al Panel de Reportes Generales del Sistema de Oficios del CSEIIO</p>
              </div>

              <div id="generales1" class="tab-pane fade">
                <h3>Total de Oficios Recepcionados</h3>
                <br>
                <h4>Genera el total de oficios recepcionados por la Unidad Central de Correspondencia</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteAllOficiosExt">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios recibidos</p>
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

                <h3>Total de Oficios Contestados dentro del Rango de Tiempo</h3>
                <br>
                <h4>Genera el reporte de los oficios contestados en la modalidad externa</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteContestadoExt">
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


              <div id="generales3" class="tab-pane fade">
               <h3>Total de Oficios Contestados Fuera del Rango Tiempo</h3>
               <br>
               <h4>Genera el reporte de los oficios contestados fuera de tiempo en la modalidad externa</h4>

               <br>

               <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteContestadoFueraDeTiempo">
                <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios fuera de tiempo</p>
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
              <h3>Total de Oficios Pendientes dentro del Rango de Tiempo</h3>
              <br>
              <h4>Genera el reporte de los oficios pendientes por responder, en la modalidad externa</h4>

              <br>

              <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reportePendientes">
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

            <div id="generales5" class="tab-pane fade">

              <h3>Oficios No Contestados en el Tiempo de Respuesta</h3>
              <br>
              <h4>Genera el reporte de los oficios no contestados en la modalidad externa</h4>

              <br>

              <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteNoContestados">
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


               <div id="generales6" class="tab-pane fade">

              <h3>Oficios Informativos Capturados por la Unidad</h3>
              <br>
              <h4>Genera el reporte de los oficios informativos que se han capturados por la Unidad</h4>

              <br>

              <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteInformativosExternos">
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

          </div>
        </div>
        <!-- REPORTES POR DIRECCIONES -->

        <div id="menu2" class="tab-pane fade">
          <ul  class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#incioDir">Inicio</a></li>
            <li style="color: #B7156D;"><a data-toggle="tab" href="#dir1">Oficios Recepcionados</a></li>
            <li style="color: #B7156D;"><a data-toggle="tab" href="#dir2">Oficios Contestados dentro del Rango de Tiempo</a></li>
            <li style="color: #B7156D;"><a data-toggle="tab" href="#dir3">Oficios Contestados Fuera del Rango Tiempo</a></li>
            <li style="color: #B7156D;"><a data-toggle="tab" href="#dir4">Oficios Pendientes dentro del Rango de Tiempo</a></li>
            <li style="color: #B7156D;"><a data-toggle="tab" href="#dir5">Oficios No Contestados en el Tiempo de Respuesta</a></li>
            <!--  -->
          </ul>

          <div class="tab-content">
            <div id="incioDir" class="tab-pane fade in active">
              <h3>Panel de Reportes por Direcciones</h3>
              <p>Bienvenido al Panel de Reportes por Direcciones del Sistema de Oficios del CSEIIO</p>
            </div>

            <div id="dir1" class="tab-pane fade">
              <h3>Total de Oficios Oficios Recepcionados</h3>
              <br>
              <h4>Genera el total de oficios recepcionados por la dirección</h4>

              <br>

              <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteAllPorDirecciones">

                <p style="color: #EF4444; font-weight: bold;">*Seleccione la Dirección</p>

                <div class="form-group">
                  <label for="direccion" class="col-lg-2 control-label">Direcciones del CSEIIO: </label>
                  <div class="col-lg-6">
                    <select class="form-control" name="direccion">
                      <option value="1">Dirección General</option>
                      <option value="2">Dirección Administrativa</option>
                      <option value="3">Dirección de Estudios Superiores</option>
                      <option value="4">Dirección de Planeación</option>
                      <option value="5">Unidad Jurídica</option>
                      <option value="6">Unidad de Acervo</option>
                      <option value="7">Dirección de Desarrollo Académico</option>
                    </select>
                  </div>
                </div>

                <hr>

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

            <div id="dir2" class="tab-pane fade">
              <h3>Total de Oficios Contestados dentro del Rango de Tiempo</h3>
              <br>
              <h4>Genera el reporte de los oficios contestados en la modalidad exterior</h4>

              <br>

              <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteContestadosPorDirecciones">

                <p style="color: #EF4444; font-weight: bold;">*Seleccione la Dirección</p>

                <div class="form-group">
                  <label for="direccion" class="col-lg-2 control-label">Direcciones del CSEIIO: </label>
                  <div class="col-lg-6">
                    <select class="form-control" name="direccion">
                      <option value="1">Dirección General</option>
                      <option value="2">Dirección Administrativa</option>
                      <option value="3">Dirección de Estudios Superiores</option>
                      <option value="4">Dirección de Planeación</option>
                      <option value="5">Unidad Jurídica</option>
                      <option value="6">Unidad de Acervo</option>
                      <option value="7">Dirección de Desarrollo Académico</option>
                    </select>
                  </div>
                </div>

                <hr>

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


            <div id="dir3" class="tab-pane fade">
             
              <h3>Total de Oficios Contestados Fuera del Rango Tiempo</h3>
              <br>
              <h4>Genera el reporte de los oficios contestados fuera de tiempo en la modalidad exterior</h4>

              <br>

              <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteContestadoFueraDeTiempoDir">


               <p style="color: #EF4444; font-weight: bold;">*Seleccione la Dirección</p>

               <div class="form-group">
                <label for="direccion" class="col-lg-2 control-label">Direcciones del CSEIIO: </label>
                <div class="col-lg-6">
                  <select class="form-control" name="direccion">
                    <option value="1">Dirección General</option>
                    <option value="2">Dirección Administrativa</option>
                    <option value="3">Dirección de Estudios Superiores</option>
                    <option value="4">Dirección de Planeación</option>
                    <option value="5">Unidad Jurídica</option>
                    <option value="6">Unidad de Acervo</option>
                    <option value="7">Dirección de Desarrollo Académico</option>
                  </select>
                </div>
              </div>

              <hr>

              <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios contestados fuera de tiempo</p>
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


          <div id="dir4" class="tab-pane fade">
            <h3>Total de Oficios Pendientes dentro del Rango de Tiempo</h3>
            <br>
            <h4>Genera el reporte de los oficios pendientes por responder, en la modalidad exterior</h4>

            <br>

            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reportePendientesDir">

             <p style="color: #EF4444; font-weight: bold;">*Seleccione la Dirección</p>

             <div class="form-group">
              <label for="direccion" class="col-lg-2 control-label">Direcciones del CSEIIO: </label>
              <div class="col-lg-6">
                <select class="form-control" name="direccion">
                  <option value="1">Dirección General</option>
                  <option value="2">Dirección Administrativa</option>
                  <option value="3">Dirección de Estudios Superiores</option>
                  <option value="4">Dirección de Planeación</option>
                  <option value="5">Unidad Jurídica</option>
                  <option value="6">Unidad de Acervo</option>
                  <option value="7">Dirección de Desarrollo Académico</option>
                </select>
              </div>
            </div>

            <hr>

            <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios pendientes por responder</p>
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

        <div id="dir5" class="tab-pane fade">

          <h3>Total de Oficios No Contestados en el Tiempo de Respuesta</h3>
          <br>
          <h4>Genera el reporte de los oficios no contestados en la modalidad exterior</h4>

          <br>

          <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteNoContestadosDir">

            <p style="color: #EF4444; font-weight: bold;">*Seleccione la Dirección</p>

            <div class="form-group">
              <label for="direccion" class="col-lg-2 control-label">Direcciones del CSEIIO: </label>
              <div class="col-lg-6">
                <select class="form-control" name="direccion">
                  <option value="1">Dirección General</option>
                  <option value="2">Dirección Administrativa</option>
                  <option value="3">Dirección de Estudios Superiores</option>
                  <option value="4">Dirección de Planeación</option>
                  <option value="5">Unidad Jurídica</option>
                  <option value="6">Unidad de Acervo</option>
                  <option value="7">Dirección de Desarrollo Académico</option>
                </select>
              </div>
            </div>

            <hr>

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
      </div>
    </div>

          <!-- REPORTES POR DEPARTAMENTOS 
             
            <ul  class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#inicioGeneral">Inicio</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales1">Oficios Recepcionados</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales2">Oficios Contestados dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales3">Oficios Contestados Fuera del Rango Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales4">Oficios Pendientes dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales5">Oficios No Contestados en el Tiempo de Respuesta</a></li>
            </ul>

          -->
          <div id="menu3" class="tab-pane fade">
            <ul  class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#inicioDeptos">Inicio</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#deptos1">Oficios Recepcionados</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#deptos2">Oficios Contestados dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#deptos3">Oficios Contestados Fuera del Rango Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#deptos4">Oficios Pendientes dentro del Rango de Tiempo</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#deptos5">Oficios No Contestados en el Tiempo de Respuesta</a></li>
            </ul>

            <div class="tab-content">
              <div id="inicioDeptos" class="tab-pane fade in active">
                <h3>Panel de Reportes Generales</h3>
                <p>Bienvenido al Panel de Reportes Generales del Sistema de Oficios del CSEIIO</p>
              </div>

              <div id="deptos1" class="tab-pane fade">
                <h3>Oficios Recepcionados</h3>
                <br>
                <h4>Genera el total de oficios recepcionados por el departamento</h4>
                
                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteAllPorDepartamento">

                 <p style="color: #EF4444; font-weight: bold;">*Seleccione la Dirección</p>

                 <div class="form-group">
                  <label for="direccion" class="col-lg-2 control-label">Direcciones del CSEIIO: </label>
                  <div class="col-lg-6">
                    <select class="form-control" id="direccion" name="direccion">
                      <option value="">Seleccione una Dirección</option>
                      <option value="1">Dirección General</option>
                      <option value="2">Dirección Administrativa</option>
                      <option value="3">Dirección de Estudios Superiores</option>
                      <option value="4">Dirección de Planeación</option>
                      <option value="7">Dirección de Desarrollo Académico</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                </select>
                <label for="departamentos_cmb" class="col-lg-2 control-label">Departamentos del CSEIIO: </label>
                <div class="col-lg-6">
                  <select class="form-control" name="departamentos_cmb" id="departamentos_cmb">
                    <!-- <option value="">Selecciona un Departamento</option> -->
                  </select>
                </div>
              </div>

              <hr>

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

          <div id="deptos2" class="tab-pane fade">
            <h3>Total de Oficios Contestados dentro del Rango de Tiempo</h3>
            <br>
            <h4>Genera el total de oficios contestados por el departamento en la modalidad exterior.</h4>
            
            <br>

            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteContestadosPorDepartamento">

             <p style="color: #EF4444; font-weight: bold;">*Seleccione la Dirección</p>

             <div class="form-group">
              <label for="direccion1" class="col-lg-2 control-label">Direcciones del CSEIIO: </label>
              <div class="col-lg-6">
                <select class="form-control" id="direccion1" name="direccion1">
                  <option value="">Seleccione una Dirección</option>
                  <option value="1">Dirección General</option>
                  <option value="2">Dirección Administrativa</option>
                  <option value="3">Dirección de Estudios Superiores</option>
                  <option value="4">Dirección de Planeación</option>
                  <option value="7">Dirección de Desarrollo Académico</option>
                </select>
              </div>
            </div>

            <div class="form-group">
            </select>
            <label for="departamentos_cmb1" class="col-lg-2 control-label">Departamentos del CSEIIO: </label>
            <div class="col-lg-6">
              <select class="form-control" name="departamentos_cmb1" id="departamentos_cmb1">
                <!-- <option value="">Selecciona un Departamento</option> -->
              </select>
            </div>
          </div>

          <hr>

          <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios recibidos</p>
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


      <div id="deptos3" class="tab-pane fade">
        <h3>Total de Oficios Contestados Fuera del Rango Tiempo</h3>
        <br>
        <h4>Genera el reporte de los oficios contestados fuera de tiempo en la modalidad exterior</h4>

        <br>

        <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteContestadosFueraDepartamento">

         <p style="color: #EF4444; font-weight: bold;">*Seleccione la Dirección</p>

         <div class="form-group">
          <label for="direccion4" class="col-lg-2 control-label">Direcciones del CSEIIO: </label>
          <div class="col-lg-6">
            <select class="form-control" id="direccion4" name="direccion4">
              <option value="">Seleccione una Dirección</option>
              <option value="1">Dirección General</option>
              <option value="2">Dirección Administrativa</option>
              <option value="3">Dirección de Estudios Superiores</option>
              <option value="4">Dirección de Planeación</option>
              <option value="7">Dirección de Desarrollo Académico</option>
            </select>
          </div>
        </div>

        <div class="form-group">
        </select>
        <label for="departamentos_cmb4" class="col-lg-2 control-label">Departamentos del CSEIIO: </label>
        <div class="col-lg-6">
          <select class="form-control" name="departamentos_cmb4" id="departamentos_cmb4">
            <!-- <option value="">Selecciona un Departamento</option> -->
          </select>
        </div>
      </div>

      <hr>

      <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios recibidos</p>
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

  <div id="deptos4" class="tab-pane fade">
    <h3>Total de Oficios Pendientes dentro del Rango de Tiempo</h3>
    <br>
    <h4>Genera el reporte de los oficios pendientes por responder, en la modalidad exterior</h4>

    <br>

    <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reportePendientesDepto">

     <p style="color: #EF4444; font-weight: bold;">*Seleccione la Dirección</p>

     <div class="form-group">
      <label for="direccion3" class="col-lg-2 control-label">Direcciones del CSEIIO: </label>
      <div class="col-lg-6">
        <select class="form-control" id="direccion3" name="direccion3">
          <option value="">Seleccione una Dirección</option>
          <option value="1">Dirección General</option>
          <option value="2">Dirección Administrativa</option>
          <option value="3">Dirección de Estudios Superiores</option>
          <option value="4">Dirección de Planeación</option>
          <option value="7">Dirección de Desarrollo Académico</option>
        </select>
      </div>
    </div>

    <div class="form-group">
    </select>
    <label for="departamentos_cmb3" class="col-lg-2 control-label">Departamentos del CSEIIO: </label>
    <div class="col-lg-6">
      <select class="form-control" name="departamentos_cmb3" id="departamentos_cmb3">
        <!-- <option value="">Selecciona un Departamento</option> -->
      </select>
    </div>
  </div>

  <hr>

  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios pendientes por responder</p>
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

<div id="deptos5" class="tab-pane fade">

  <h3>Total de Oficios No Contestados en el Tiempo de Respuesta</h3>
  <br>
  <h4>Genera el reporte de los oficios no contestados en la modalidad exterior</h4>

  <br>
  <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes/reporteNoContestadosDepto">

   <p style="color: #EF4444; font-weight: bold;">*Seleccione la Dirección</p>

   <div class="form-group">
    <label for="direccion2" class="col-lg-2 control-label">Direcciones del CSEIIO: </label>
    <div class="col-lg-6">
      <select class="form-control" id="direccion2" name="direccion2">
        <option value="">Seleccione una Dirección</option>
        <option value="1">Dirección General</option>
        <option value="2">Dirección Administrativa</option>
        <option value="3">Dirección de Estudios Superiores</option>
        <option value="4">Dirección de Planeación</option>
        <option value="7">Dirección de Desarrollo Académico</option>
      </select>
    </div>
  </div>

  <div class="form-group">
  </select>
  <label for="departamentos_cmb2" class="col-lg-2 control-label">Departamentos del CSEIIO: </label>
  <div class="col-lg-6">
    <select class="form-control" name="departamentos_cmb2" id="departamentos_cmb2">
      <!-- <option value="">Selecciona un Departamento</option> -->
    </select>
  </div>
</div>

<hr>

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
</div>
</div>

<!-- /.row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
    <!-- /#wrapper -->