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
                <a class="navbar-brand" href="index.html">SGOCSEIIO</a>
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
                <li>
                    <a href="<?php echo base_url(); ?>Admin/Usuarios/GestUsuarios"><i class="fa fa-user"></i> Gestión de Usuarios</a>
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
                       Usuarios <small> Gestor de Información de Usuarios</small>
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
                <?php

                $exito = $this->session->flashdata('exito');
                $error = $this->session->flashdata('error');
                $actualizado = $this->session->flashdata('actualizado');
                $error_actualizacion = $this->session->flashdata('error_actualizacion');
                $errornoarchivo = $this->session->flashdata('errorarchivo');

                if($exito) { ?>

                <div class="alert alert-success alert-dismissible" style="text-aling:center; color:#8c8c8c"  role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Éxito!</strong> <?php echo $exito;  ?>
                </div>

                <?php } 
                if (validation_errors()) { ?>
                <div class="alert alert-danger alert-dismissible" onchange="mostrarModal();" style="text-aling:center; color:#FF1E1E"  role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong> <?php echo validation_errors();  ?>
                </div>
                <?php }
                if ($error) { ?>
                <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#FF1E1E"  role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Error!</strong><?php echo $error; ?>
                </div>
                <?php } 
                if ($actualizado) { ?>
                <div class="alert alert-success alert-dismissible" style="text-aling:center; color:#8c8c8c"  role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Éxito!</strong> <?php echo $actualizado; ?>
                </div>
                <?php } 
                if ($errornoarchivo) { 
                    ?>  <!-- Seccion de errores -->
                    <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#FF1E1E"  role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error!</strong> <?php echo $errornoarchivo; ?>
                    </div>
                    <?php } 
                    if ($error_actualizacion) {     
                       ?>

                       <div class="alert alert-danger alert-dismissible" style="text-aling:center; color:#8c8c8c"  role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error!</strong> <?php echo $error_actualizacion; ?>
                    </div>

                    <?php  } ?>
                </div>

            <hr>
            <div class="row">
                <div class="table-responsive">
                  <table id="tabla" class="table table-bordered table-hover table-responsive">
                    <thead style="background-color:#8A8F8F; color:#FFFFFF; font-size: smaller; ">
                        <tr>
                            <th>Folio de Usuario</th>
                            <th>Clave del Área</th>
                            <th>Password</th>
                            <th>Nivel</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead >
                    <tbody style="font-size:smaller; font-weight: bold ;">
                        <?php foreach ($usuarios as $row) { 
                            ?>
                            <tr>
                                <td><?php echo $row->id_usuario; ?></td>
                                <td><?php echo $row->clave_area; ?></td>
                                <td><?php echo $row->password; ?></td>
                                <td><?php echo $row->nivel; ?></td>
                                <td>
                                    <button type="button" onclick="EditarUsuario();" class="form-control btn btn-warning btn-sm">
                                     <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar 
                                 </button>
                             </td>
                             <td>
                                 <button type="button" onclick="EliminarUsario();" class="form-control btn btn-danger btn-sm">
                                     <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminar 
                                 </button>
                             </td>
                            </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>

                <!-- /.row -->
            </div>

        </div>

        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
    <!-- /#wrapper -->