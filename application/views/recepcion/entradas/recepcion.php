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


    function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);

        // Incremento en 1 dia
        $diainc = 24*60*60;

        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();

        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                    if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                        array_push($diashabiles, date('Y-m-d', $midia));
                    }
                }
            }

            return $diashabiles;
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
                    <li >
                        <a href="<?php echo base_url(); ?>RecepcionGral/PanelRecepGral"><i class="fa fa-desktop"></i> Inicio</a>
                    </li>
                    <li class="active">
                        <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion"><i class="fa fa-plus"></i> Recepción de Oficios</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Pendientes"><i class="fa fa-clock-o"></i> Pendientes</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Contestados"><i class="fa fa-check-circle"></i> Contestados</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/ContestadosFueraTiempo"><i class="fa fa-bell-slash"></i> Contestados Fuera de Tiempo</a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/NoContestados"><i class="fa  fa-times-circle"></i> No Contestados</a>
                    </li>
                    
                         <li>
                            <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/OficiosInformativos"><i class="fa fa-info"></i> Oficios Informativos</a>
                        </li>

                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-arrow-right"></i>Turnado de Copias</a>
                        <ul class="dropdown-menu" role="menu">
                           <li><a href="<?php echo base_url(); ?>RecepcionGral/Entradas/CopiasDirecciones" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Direcciones</a></li>
                           <li><a href="<?php echo base_url(); ?>RecepcionGral/Entradas/CopiasDeptos" ><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Copias enviadas a Departamentos</a></li>
                       </ul>
                   </li>

        
                <li>
                    <a href="<?php echo base_url(); ?>RecepcionGral/Entradas/Reportes"><i class="fa fa-book"></i> Reportes</a>
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
                        <?php echo $this->session->userdata('descripcion'); ?>  <small>Recepción de Oficios</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-dashboard"></i> Recepción de Oficios
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

                <div align="right" class="row">
                 <div class="col-lg-12">
                   <button type="button" onclick="mostrarModal();"  class="btn btn-success" >
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                    <strong>Nuevo Oficio</strong>
                </button>
            </div>
        </div>



        <div align="left" class="row">
         <div class="col-lg-12">
            <h4>Simbología de estatus</h4>
            <span class="label label-success">Oficio Contestado</span>
            <span style="background-color: #FFEA3C;" class="label label-warning">Oficio Pendiente por Responder</span>
            <span style="background-color: #FF9752;" class="label label-danger">Oficio Contestado Fuera de Tiempo</span>
            <span class="label label-danger">Oficio No Respondido</span>

        </div>
    </div>
    <hr>
    <div class="row">
        <div class="table-responsive">
          <table id="tabla" class="table table-bordered table-hover table-responsive">
            <thead style="background-color:#8A8F8F; color:#FFFFFF; font-size: smaller; text-aling:center;">
                <tr>
                    <th>Folio</th>
                    <th>Número de Oficio</th>
                     <th>Fecha de Recepcion Física</th>
                    <th>Hora de Recepcion Física</th>
                    <th>Asunto</th>
                    <th>Tipo de Recepción</th>
                    <th>Tipo de Documento</th>
                    <th>Fecha de Subida</th>
                    <th>Hora de Subida</th>
                    <th>Funcionario que emite</th>
                    <th>Cargo</th>
                    <th>Dependencia</th>
                    <th>Asignado a: </th>
                    <th>Fecha de Termino</th>
                    <th>Archivo</th>
                    <th>Observaciones</th>
                    <th>Días Restantes</th>
                    <th>Editar</th>
                    <th>C.c.p Direcciones</th>
                    <th>C.c.p Departamentos</th>
                    
                </tr>
            </thead >
            <tbody style="font-size:smaller; font-weight: bold ;">
                <?php foreach ($entradas as $row) { 
                    ?>
                    <tr>
                        <td><?php echo $row->id_recepcion; ?></td>
                        <td><?php echo $row->num_oficio; ?></td>
                        <td><?php echo $row->fecha_recep_fisica; ?></td>
                        <td><?php echo $row->hora_recep_fisica; ?></td>
                        <td><?php echo $row->asunto; ?></td>
                        <td><?php echo $row->tipo_recepcion; ?></td>
                        <td><?php echo $row->tipo_documento; ?></td>
                        <td><?php echo $row->fecha_recepcion; ?></td>
                        <td><?php echo $row->hora_recepcion; ?></td>
                        <td><?php echo $row->emisor; ?></td>
                        <td><?php echo $row->cargo; ?></td>
                        <td><?php echo $row->dependencia_emite; ?></td>
                        <td><?php echo $row->nombre_direccion; ?></td>
                        <td><?php echo $row->fecha_termino; ?></td>
                        <td>
                            <a href="<?php echo base_url()?>RecepcionGral/Entradas/Recepcion/Descargar/<?php echo $row->archivo_oficio; ?>">
                             <img src="<?php echo base_url(); ?>assets/img/download.png" alt="Descargar">
                         </a>
                     </td>
                     <td><?php echo $row->observaciones; ?></td>
                     <td>
                        <?php

                        if ($row->tipo_dias == 0) 
                        {
                            if ($row->requiereRespuesta == 1) {

                                if ($row->fecha_recepcion == $row->fecha_recep_fisica) {
                                 date_default_timezone_set('America/Mexico_City');
                                 $hoy = date('Y-m-d');

                                 $date1 = $hoy;
                                 $date2 = $row->fecha_termino;
                                 $diff = abs(strtotime($date2) - strtotime($date1));

                                 $years = floor($diff / (365*60*60*24));
                                 $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                 $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                                 if ( $row->status == 'Fuera de Tiempo') {
                                   printf("El oficio fué respondido fuera de tiempo");
                               }


                               else
                                if ( $row->status == 'Contestado') {
                                   printf("Oficio respondido a tiempo");
                               }

                               else
                                if ($date2 < $date1) {
                                   printf("Se han agotado los días de respuesta");

                               }

                               else
                               {
                                  printf("%d días naturales\n", $days );  
                              } 
                          }
                          else 
                            if($row->fecha_recep_fisica < $row->fecha_recepcion)
                            {
                             date_default_timezone_set('America/Mexico_City');
                             $hoy = date('Y-m-d');

                             $subida = $row->fecha_recepcion;
                             $recepcion = $row->fecha_recep_fisica;
                             $diferencia = abs(strtotime($recepcion) - strtotime($subida));

                             $years = floor($diferencia / (365*60*60*24));
                             $months = floor(($diferencia - $years * 365*60*60*24) / (30*60*60*24));
                             //numero de días entre la fecha de recepcion y la fecha de subida, en el caso de que el oficio se suba días despues de su recepcion
                             $dias_entre_fechas = floor(($diferencia - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                             // días que hay entre el día de hoy y la fecha de termino
                             $date1 = $hoy;
                             $date2 = $row->fecha_termino;
                             $diff = abs(strtotime($date2) - strtotime($date1));

                             $years = floor($diff / (365*60*60*24));
                             $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                             $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                                 if ( $row->status == 'Fuera de Tiempo') {
                                   printf("El oficio fué respondido fuera de tiempo");
                               }


                               else
                                if ( $row->status == 'Contestado') {
                                   printf("Oficio respondido a tiempo");
                               }

                               else
                                if ($date2 < $date1) {
                                   printf("Se han agotado los días de respuesta");

                               }

                               else
                               {
                                  printf("%d días naturales\n", $days-$dias_entre_fechas);  
                              } 

                            }


                      }   
                      else
                      {
                        echo "El oficio no requiere respuesta";
                      }

                  }
                  else
                    if ($row->tipo_dias == 1) {

                        if ($row->requiereRespuesta == 1) {

                           if ($row->fecha_recepcion == $row->fecha_recep_fisica) {

                            date_default_timezone_set('America/Mexico_City');
                            $hoy = date('Y-m-d');

                            $date1 = $hoy;
                            $date2 = $row->fecha_termino;
                            $dias_habiles = getDiasHabiles($date1 , $date2);

                            if ( $row->status == 'Fuera de Tiempo') {
                             printf("El oficio fué respondido fuera de tiempo");
                         }


                         else
                            if ( $row->status == 'Contestado') {
                               printf("Oficio respondido a tiempo");
                           }

                           else
                             if ($date2 < $date1) {
                               printf("Se han agotado los días de respuesta");
                           }
                           else
                           {
                            $num_dias = count($dias_habiles);
                            if ($num_dias == 1) {
                                echo $num_dias." día hábil";
                            }
                            else
                            {
                                echo $num_dias." días hábiles";
                            }


                        }
                    }
                        else
                            if ($row->fecha_recep_fisica < $row->fecha_recepcion) {
                             date_default_timezone_set('America/Mexico_City');
                             $hoy = date('Y-m-d');

                             $subida = $row->fecha_recepcion;
                             $recepcion = $row->fecha_recep_fisica;
                             $diferencia = abs(strtotime($recepcion) - strtotime($subida));

                             $years = floor($diferencia / (365*60*60*24));
                             $months = floor(($diferencia - $years * 365*60*60*24) / (30*60*60*24));
                             //numero de días entre la fecha de recepcion y la fecha de subida, en el caso de que el oficio se suba días despues de su recepcion
                             $dias_entre_fechas = floor(($diferencia - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                             $date1 = $hoy;
                             $date2 = $row->fecha_termino;
                             $dias_habiles = getDiasHabiles($date1 , $date2);

                             if ( $row->status == 'Fuera de Tiempo') {
                               printf("El oficio fué respondido fuera de tiempo");
                           }


                           else
                            if ( $row->status == 'Contestado') {
                             printf("Oficio respondido a tiempo");
                         }

                         else
                           if ($date2 < $date1) {
                             printf("Se han agotado los días de respuesta");
                         }
                         else
                         {
                            $num_dias = count($dias_habiles);
                            $total_dias = $num_dias - $dias_entre_fechas;
                            if ($num_dias == 1) {
                                echo $total_dias." día hábil";
                            }
                            else
                                if($total_dias < 1)
                                {
                                 if ( $row->status == 'Fuera de Tiempo') {
                                     printf("El oficio fué respondido fuera de tiempo");
                                 }


                                 else
                                    if ( $row->status == 'Contestado') {
                                       printf("Oficio respondido a tiempo");
                                   }

                                   else
                                     if ($date2 < $date1) {
                                       printf("Se han agotado los días de respuesta");
                                   }

                               }
                               else
                               {
                                 echo $total_dias." días hábiles";
                               }


                        }

                    }
                    }
                    else
                    {
                        echo "El oficio no requiere respuesta";
                    }

                }

                ?>        
            </td>
            <td>
                <button type="button" onclick="EditarOficio('<?php echo $row->id_recepcion; ?>','<?php echo $row->num_oficio; ?>','<?php echo $row->asunto; ?>','<?php echo $row->tipo_recepcion; ?>','<?php echo $row->tipo_documento; ?>','<?php echo $row->emisor; ?>','<?php echo $row->direccion_destino; ?>','<?php echo $row->fecha_termino; ?>','<?php echo $row->status; ?>','<?php echo $row->prioridad; ?>','<?php echo addcslashes($row->observaciones,"\\\"\"\n\r"); ?>');" class="form-control btn btn-danger btn-sm">
                 <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar 
             </button>
         </td>

         <td>
            <button type="button" onclick="mostrarTurnadoDirecciones('<?php echo $row->id_recepcion; ?>','<?php echo $row->num_oficio; ?>');" class="form-control btn btn-warning btn-sm">
             <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> C.c.p Direcciones
         </button>
     </td>
     <td>
        <button type="button" onclick="mostrarTurnadoDepartamentos('<?php echo $row->id_recepcion; ?>','<?php echo $row->direccion_destino; ?>','<?php echo $row->num_oficio; ?>');" class="form-control btn btn-primary btn-sm">
         <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> C.c.p Deptos  
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
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- MODAL DE NUEVA ENTRADA DE OFICIO-->

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Registrar Oficio</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmRegistroOficio" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/agregarEntrada">
        <div class="col-lg-12">
          <br>
        
        <!-- Numero de oficio: -->
          <div class="form-group has-feedback">
            <label for="noficio" class="control-label">Número de Oficio</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="num_oficio" id="noficio" class="form-control" placeholder="Ej. CSEIIO/DP/078/2017" required>
            </div>  
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div> 
        </div>

       <!-- Asunto: -->
        <div class="form-group has-feedback">
            <label for="asunto" class="control-label">Asunto</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="asunto" id="asunto" class="form-control" placeholder="Ej. Solicitud de Información" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div> 
        </div>

        <div class="form-group">
            <label>Tipo de Recepción</label>
            <select class="form-control" name="tipo_recepcion">
                <option value="Externo">Externo</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tipo de Documento</label>
            <select class="form-control" name="tipo_documento">
                <option value="Oficio">Oficio</option>
                <option value="Memorandúm">Memorandúm</option>
                <option value="Circular">Circular</option>
            </select>
        </div>

        <div class="form-group has-feedback">
            <label for="funcionario" class="control-label">Funcionario que emite el oficio</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="emisor" id="funcionario" class="form-control" placeholder="Ej. Lic. Raul López Hernández"  required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div> 
        </div>


        <div class="form-group has-feedback">
            <label for="cargof" class="control-label">Cargo del funcionario que emite</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="cargo" id="cargof" class="form-control" placeholder="Ej. Coordinador Estatal de la SEMS"  required>
            </div> 
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>  
        </div>

        <div class="form-group has-feedback">
            <label for="dependenciaf" class="control-label">Dependencia que emite</label>
            <div class="input-group">
                 <span class="input-group-addon"></span>
                <input name="dependencia" id="dependenciaf" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior"  required>
            </div>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>  
        </div>

        <div class="form-group has-feedback">
            <label for="fecha_fisica" class="control-label">Fecha de Recepción Física</label>
            <div class="input-group">
               <span class="input-group-addon"></span>
               <input type="date" id="fecha_fisica" name="fecha_recepcion_fisica" class="form-control" required>
           </div>
           <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
           <div class="help-block with-errors"></div>  
       </div>


        <div class="form-group has-feedback">
            <label for="hora_fisica" class="control-label">Hora de Recepción Física</label>
            <div class="input-group">
               <span class="input-group-addon"></span>
               <input type="time" id="hora_fisica" name="hora_recepcion_fisica"  class="form-control"  value="<?php echo date("H:i:s") ?>"/ required>
           </div>
           <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
           <div class="help-block with-errors"></div>  
       </div>

        <div class="form-group has-feedback">
            <label for="tieneRespuesta" class="control-label">¿El oficio requiere respuesta?</label>
            <div class="input-group">
                <label class="radio-inline">
                    <input  onclick="enable()" type="radio" name="ReqRespuesta" value="1">Si
                </label>
                <label class="radio-inline">
                    <input  onclick="disable()" type="radio" name="ReqRespuesta" value="0">No
                </label>
            </div>
        </div>

        <script>
            function disable() {
                document.getElementById("direccion5").disabled = true;
            }
            function enable() {
                document.getElementById("direccion5").disabled = false;
            }
        </script>

        <div class="form-group">
            <label>Dirección de Destino</label>
            <select class="form-control" id="direccion5" name="direccion[]" multiple>
                <option value="">- Seleccione una Dirección -</option>
                <option value="1">Dirección General</option>
                <option value="2">Dirección Administrativa</option>
                <option value="3">Dirección de Estudios Superiores</option>
                <option value="4">Dirección de Planeación</option>
                <option value="5">Unidad Jurídica</option>
                <option value="6">Unidad de Acervo</option>
                <option value="7">Dirección de Desarrollo Académico</option>
            </select>
        </div>


        <div class="form-group">
            <label>Tipo de días para termino</label>
            <select class="form-control" name="tipo_dias">
             <option value="1">Días Hábiles</option>
             <option value="0">Días Naturales</option>       
         </select>
     </div>



     <div class="form-group has-feedback">
        <label for="fecha" class="control-label">Fecha de Termino</label>
        <div class="input-group">
             <span class="input-group-addon"></span>
            <input type="date" id="fecha" name="fecha_termino" class="form-control" required>
        </div>
         <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>  
    </div>

    


    <div class="form-group has-feedback">
        <label for="archivof" class="control-label">Archivo Escaneado</label>
        <div class="input-group">
            <span class="input-group-addon"></span>
            <input type="file" id="archivof" name="archivo" class="form-control"  required>
           
        </div>
         <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
          <div class="help-block with-errors"></div>  
           <span class="label label-danger">*El archivo debe estar en formato PDF</span>
            <span class="label label-danger">*El archivo no debe de pesar mas de 2MB</span>
    </div>


    <div class="form-group">
        <label>Prioridad</label>
        <select class="form-control" name="prioridad">
            <option value="Alta">Alta</option>
            <option value="Media">Media</option>
            <option value="Baja">Baja</option>
        </select>
    </div>


    <div class="form-group">
       <label>Observaciones</label>
       <textarea name="observaciones" class="form-control" placeholder="Ej. Se recibe oficio sin sello de la dependencia" >    
       </textarea>
    </div>   

    <button name="btn_enviar" type="submit" class="btn btn-info">
      <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Registrar Información
  </button>

</div>
</form>


<div class="modal-footer">
  <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>
</div>
</div>
</div>


<div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Modificar Información del Oficio</h4>
    </div>
    <form data-toggle="validator" enctype="multipart/form-data" role="form" method="POST" name="frmEditarOficio" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/ModificarOficio">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">

          <div class="form-group has-feedback">
            <label for="noficio_a" class="control-label">Número de Oficio</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="num_oficio_a" id="noficio_a" class="form-control" placeholder="Ej. CSEIIO/DP/078/2017" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>  
        </div>


        <div class="form-group has-feedback">
            <label for="asunto_af" class="control-label">Asunto</label>
            <div class="input-group">
                <span class="input-group-addon"></span>
                <input name="asunto_a" id="asunto_af" class="form-control" placeholder="Ej. Solicitud de Información" required>
            </div>
             <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
        </div>

        <div class="form-group">
            <label>Tipo de Recepción</label>
            <select class="form-control" name="tipo_recepcion_a">
                <option value="Externo">Externo</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tipo de Documento</label>
            <select class="form-control" name="tipo_documento_a">
                <option value="Oficio">Oficio</option>
                <option value="Memorandúm">Memorandúm</option>
                <option value="Circular">Circular</option>
            </select>
        </div>

        <div class="form-group has-feedback">
            <label for="emisorf" class="control-label">Emisor</label>
            <div class="input-group">
                 <span class="input-group-addon"></span>
                <input name="emisor_a" id="emisorf" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior"  required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
        </div>

        <div class="form-group">
            <label>Dirección de Destino</label>
            <select class="form-control" name="direccion_a">
                <option value="1">Dirección General</option>
                <option value="2">Dirección Administrativa</option>
                <option value="3">Dirección de Estudios Superiores</option>
                <option value="4">Dirección de Planeación</option>
                <option value="5">Unidad Jurídica</option>
                <option value="6">Unidad de Acervo</option>
                <option value="7">Dirección de Desarrollo Académico</option>
                <option value="8">No requiere respuesta</option>
            </select>
        </div>


        <div class="form-group">
            <label>Tipo de días para termino</label>
            <select class="form-control" name="tipo_dias_a">
                <option value="1">Días Hábiles</option>
                <option value="0">Días Naturales</option>
            </select>
        </div>

        <div class="form-group has-feedback">
            <label for="emisorf" class="control-label">Fecha de Termino</label>
            <div class="input-group">
                 <span class="input-group-addon"></span>
                <input type="date" name="fecha_termino_a" class="form-control" required>
            </div>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
        </div>


        <div class="form-group">
            <label>Estatus</label>
            <select class="form-control" name="status_a">
                <option value="Pendiente">Pendiente</option>
                <option value="Contestado">Contestado</option>
                <option value="Fuera de Tiempo">Contestado Fuera de Timpo</option>
                <option value="No Contestado">No Contestado</option>
            </select>
        </div>


        <div class="form-group">
            <label>Prioridad</label>
            <select class="form-control" name="prioridad_a">
                <option value="Alta">Alta</option>
                <option value="Media">Media</option>
                <option value="Baja">Baja</option>
            </select>
        </div>

       <!--  <div class="form-group">
            <label>Observaciones</label>
            <input name="observaciones_a" class="form-control" placeholder="Ej. Se recibe oficio sin sello de la dependencia"  required>
        </div> -->

        <div class="form-group">
         <label>Observaciones</label>
         <textarea name="observaciones_a" class="form-control" placeholder="Ej. Se recibe oficio sin sello de la dependencia" >    
         </textarea>
     </div>   


        <button name="btn_enviar_a" type="submit" class="btn btn-info">
          <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Registrar Información
      </button>

  </div>
</form>
<div class="modal-footer">
  <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>
</div>
</div>
</div>


<div class="modal fade" id="modalDir" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Turnar Copia a Direcciones</h4>
    </div>
    <form enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDir" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/TurnarCopiaDir">
        <div class="col-lg-12">
          <br>

        <input  type="hidden" name="txt_idoficio">
        <input  type="hidden" name="txt_num_oficio">

          <div class="form-group">
            <label>Emisor</label>
            <input name="emisor" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior" value="<?php echo $this->session->userdata('nombre');  ?>" disabled>
        </div>

        <input type="hidden" name="emisor_h" value="<?php echo $this->session->userdata('nombre');  ?>">



      <div class="form-group">
            <label>Dirección:</label>
            <select class="form-control" name="direccion_a">
                <option value="1">Dirección General</option>
                <option value="2">Dirección Administrativa</option>
                <option value="3">Dirección de Estudios Superiores</option>
                <option value="4">Dirección de Planeación</option>
                <option value="5">Unidad Jurídica</option>
                <option value="6">Unidad de Acervo</option>
                <option value="7">Dirección de Desarrollo Académico</option>
            </select>
        </div>



  <div class="form-group">
    <label>Observaciones</label>
    <input name="observaciones_a" class="form-control" placeholder="Para su conocimiento"  required>
</div>

<button name="btn_enviar_a" type="submit" class="btn btn-info">
  <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Registrar Información
</button>

</div>
</form>
<div class="modal-footer">
  <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>
</div>
</div>
</div>


<div class="modal fade" id="modalDeptos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 align="center" class="modal-title">Turnar Copia a Departamentos</h4>
    </div>
    <form enctype="multipart/form-data" role="form" method="POST" name="frmTurnarDepto" action="<?php echo base_url(); ?>RecepcionGral/Entradas/Recepcion/TurnarCopiaDeptos">
        <div class="col-lg-12">
          <br>

          <input  type="hidden" name="txt_idoficio">
          <input  type="hidden" name="txt_id_direccion">
          <input  type="hidden" name="txt_num_oficio">

          <div class="form-group">
            <label>Emisor</label>
            <input name="emisor" class="form-control" placeholder="Ej. Subsecretaria de Educación Media Superior" value="<?php echo $this->session->userdata('nombre');  ?>" disabled>
        </div>

        <input type="hidden" name="emisor_h" value="<?php echo $this->session->userdata('nombre');  ?>">



        <div class="form-group">
           <?php 
           echo "<p><label for='area_destino'>Área de destino </label>";
           echo "<select class='form-control' name='area_destino' id='area_destino'>";
           if (count($deptos)) {
            foreach ($deptos as $list) {
              echo "<option value='". $list->id_area. "'>" . $list->nombre_area . "</option>";
          }
      }
      echo "</select><br/>";
      ?>
  </div>


  <div class="form-group">
    <label>Observaciones</label>
    <select class="form-control" name="observaciones_a">
        <option value="conocimiento">Para su conocimiento</option>
        <option value="atencion">Para su atención</option>
    </select>
</div>

<!-- <div class="form-group">
    <label>Observaciones</label>
    <input name="observaciones_a" class="form-control" placeholder="Para su conocimiento"  required>
</div> -->

<button name="btn_enviar_a" type="submit" class="btn btn-info">
  <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Registrar Información
</button>

</div>
</form>
<div class="modal-footer">
  <button type="button" class="btn btn-danger btn-circle" data-dismiss="modal"><i class="fa fa-times"></i></button>
</div>
</div>
</div>
</div>


<!-- JAVASCRITP PARA MOSTRAR MODALES -->
<script type="text/javascript">
  function mostrarModal()
  {
    $('#modal').modal('show');
}


function mostrarTurnadoDirecciones(id,$num_oficio)
{
    document.frmTurnarDir.txt_idoficio.value = id;
    document.frmTurnarDir.txt_num_oficio.value = $num_oficio;
    $('#modalDir').modal('show');
}

function mostrarTurnadoDepartamentos(id,id_direccion,num_oficio)
{
    //txt_id_direccion
    document.frmTurnarDepto.txt_idoficio.value = id;
    document.frmTurnarDepto.txt_id_direccion.value = id_direccion;
    document.frmTurnarDepto.txt_num_oficio.value = num_oficio;
    $('#modalDeptos').modal('show');
}

function EditarOficio(id,num_oficio, asunto, tipo_recepcion,  tipo_documento, emisor, direccion, fecha_termino,status, prioridad, observaciones)
{
    document.frmEditarOficio.txt_idoficio.value = id;
    document.frmEditarOficio.num_oficio_a.value = num_oficio;
    document.frmEditarOficio.asunto_a.value = asunto;
    document.frmEditarOficio.tipo_recepcion_a.value = tipo_recepcion;
    document.frmEditarOficio.tipo_documento_a.value = tipo_documento;
    document.frmEditarOficio.emisor_a.value = emisor;
    document.frmEditarOficio.direccion_a.value = direccion;
    document.frmEditarOficio.fecha_termino_a.value = fecha_termino;
    document.frmEditarOficio.status_a.value = status;
    document.frmEditarOficio.prioridad_a.value = prioridad;
    document.frmEditarOficio.observaciones_a.value = observaciones;

    $('#modalActualizar').modal('show');
}
</script>

<script type="text/javascript">
  function confirma(){
    if (confirm("¿Realmente desea eliminarlo?")){ 
    }
    else { 
      return false
  }
}

</script>
<script>
    function enviar(){
     document.frmActualizar.submit();
 }
</script>
