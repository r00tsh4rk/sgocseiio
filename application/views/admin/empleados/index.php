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
                <a class="navbar-brand" href="<?php echo base_url(); ?>Admin/PanelAdmin">SGOCSEIIO</a>
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
                    <a href="<?php echo base_url(); ?>Admin/PanelAdmin"><i class="fa fa-desktop"></i> Inicio</a>
                </li>
                <li >
                    <a href="<?php echo base_url(); ?>Admin/Empleados/Directores"><i class="fa fa-building"></i> Directores de Área</a>
                </li>
                <li >
                    <a href="<?php echo base_url(); ?>Admin/Empleados/JefesDepto"><i class="fa fa-users"></i> Jefes de Departamento</a>
                </li>
                <li >
                    <a href="<?php echo base_url(); ?>Admin/Empleados/Planteles"><i class="fa fa-university"></i> Directores de Plantel</a>
                </li>
            </ul>
        </div>
            <!-- /.n /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Inicio <small> Gestión de Empleados</small>
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
                    <h4 style="text-align: center;">Bienvenid@ al Panel Administrativo de Gestión de Empleados, donde se puede realizar tareas de mantenimiento como altas, bajas y modificación de información de los empleados que conforman la plantilla del Sistema de Gestión de Oficios del CSEIIO, a nivel de Directores de Área, Jefes de Departamento y Directores de Plantel.</h4>    
                </div>
             
                </div>

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->