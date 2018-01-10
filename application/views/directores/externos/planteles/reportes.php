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
            <a style="color: #FC8A62;" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('nombre_direccion'); ?> <b class="caret"></b></a>
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
              <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/PanelPlanteles"><i class="fa fa-desktop"></i> Inicio</a>
            </li>
            <li >
              <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/RecepcionPlanteles"><i class="fa fa-plus"></i> Oficios de Salida</a>
            </li>

            <li>
              <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/OficiosInformativos"><i class="fa fa-info"></i> Oficios Informativos</a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/Respuesta_salidas"><i class="fa fa-book"></i> Respuestas a Oficios de Salida</a>
            </li>
            <li class="active">
              <a href="<?php echo base_url(); ?>Direcciones/Externos/Planteles/Reportes"><i class="fa fa-book"></i> Reportes</a>
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
                    <?php echo $this->session->userdata('nombre_direccion'); ?>  <small>Sistema de Gestión de Oficios del CSEIIO</small>
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
            <li><a data-toggle="tab" href="#menu1">Reportes de Oficios Externos</a></li>
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
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales1">Oficios Salientes</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales2">Oficios Informativos</a></li>
              <li style="color: #B7156D;"><a data-toggle="tab" href="#generales3">Oficios Contestados</a></li>
            </ul>

            <div class="tab-content">
              <div id="inicioGeneral" class="tab-pane fade in active">
                <h3>Panel de Reportes de Oficios Salientes</h3>
                <p>Bienvenido al Panel de Reportes por Plantel del Sistema de Oficios del CSEIIO</p>
              </div>

              <div id="generales1" class="tab-pane fade">
                <h3>Total de Oficios Salientes</h3>
                <br>
                <h4>Genera el total de oficios salientes capturados por el <?php echo $this->session->userdata('nombre_direccion'); ?> </h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/Planteles/Reportes/reporteAllCapturadosSalidas">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios capturados por plantel</p>
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

                <h3>Total de Oficios Informativos</h3>
                <br>
                <h4>Genera el reporte de los oficios informativos en la modalidad Exterior</h4>

                <br>

                <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/Planteles/Reportes/informativos">
                  <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios informativos</p>
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
               <h4>Genera el reporte de los oficios contestados por dependencias externas</h4>

               <br>

               <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url(); ?>Direcciones/Externos/Planteles/Reportes/reporteContestados">
                <p style="color: #EF4444; font-weight: bold;">*Seleccione el periodo de fechas en el que desee conocer el total de oficios contestados por dependencias externas</p>
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




            <!-- /.row -->

          </div>
          <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

      </div>
      <!-- /#wrapper -->
    </div>
  </div>
</div>
