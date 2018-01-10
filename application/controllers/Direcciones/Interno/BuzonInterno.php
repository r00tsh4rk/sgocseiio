<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BuzonInterno extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctosinternos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Panel de Direcciones';
			$data['entradas'] = $this -> Modelo_direccion -> getBuzonDeOficiosEntrantes($this->session->userdata('id_direccion'));
			$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
				$data['codigos'] = $this -> Modelo_direccion-> getCodigos();
			
			date_default_timezone_set('America/Mexico_City');
			$fecha_hoy = date('Y-m-d');
			$hora_hoy =  date("H:i:s");
			
			$consulta = $this -> Modelo_direccion -> getBuzonDeOficiosEntrantes($this->session->userdata('id_direccion'));
			foreach ($consulta as $key) {
				$idoficio = $key->id_recepcion_int;
				if ($fecha_hoy > $key->fecha_termino AND $key->status=='Pendiente') {
					$this->db->query("CALL comparar_fechas_internas('".$idoficio."')");
				}
				
			}

			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/internos/index');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 	
	}

	public function Descargar($name)
	{
		$data = file_get_contents($this->folder.$name); 
		force_download($name,$data); 
	}

	public function agregarRespuesta()
	{
		$this -> form_validation -> set_rules('num_oficio_h','Número de Oficio','required');
		$this -> form_validation -> set_rules('asunto_h','Asunto','required');
		$this -> form_validation -> set_rules('emisor_h','Emisor','required');
		$this -> form_validation -> set_rules('receptor_h','Fecha de Termino','required');
		//$this -> form_validation -> set_rules('archivo','Archivo','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Panel de Direcciones';
			$data['entradas'] = $this -> Modelo_direccion -> getAllEntradasInternas($this->session->userdata('nombre'));
			$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/internos/index');
			$this->load->view('plantilla/footer');		

		}
		else
		{

			$data =  array(
				$id_oficio_recepcion = $this -> input -> post('txt_idoficio'),
				$num_oficio = $this -> input -> post('num_oficio_h'),
				$asunto = $this -> input -> post('asunto_h'),
				$tipo_recepcion = $this -> input -> post('tipo_recepcion'),
				$tipo_documento = $this -> input -> post('tipo_documento'),
				$numoficio_salida = $this -> input -> post('numoficio_salida'),
				$emisor = $this -> input -> post('emisor_h'),
				$cargo = $this -> input -> post('cargo_h'),
				$dependencia = $this -> input -> post('dependencia_h'),
				$receptor = $this -> input -> post('receptor_h'),
				$codigo_archivistico = $this -> input -> post('codigo_archivistico')
				);

			if (isset($_POST['btn_enviar']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
				if (!empty($_FILES['ofrespuesta']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './doctosrespuestainterna/';
					$config['allowed_types'] = 'pdf|docx|rar|png|jpg|gif|xlsx|zip';
					$config['remove_spaces']=TRUE;
					$config['max_size']    = '2048';
					$config['overwrite'] = TRUE;
					$config['file_name'] = 'Folio_'.$id_oficio_recepcion.'_Oficio_de_respuesta';

            				// Cargamos la configuración del Archivo 1
					$this->upload->initialize($config);

           				 // Subimos archivo 1
					if ($this->upload->do_upload('ofrespuesta'))
					{
						$data = $this->upload->data();
					}
					else
					{
						$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
					}
					$respuesta = $this->upload->data('file_name');

				}


			    // CARGANDO ANEXOS
				if (!empty($_FILES['anexos']['name']))
				{
             // La configuración del Archivo 2, debe ser diferente del archivo 1
            // si configuras como el Archivo 1 no hará nada
					$config['upload_path'] = './doctosanexosinternos/';
					$config['allowed_types'] = 'pdf|docx|rar|png|jpg|gif|xlsx|zip';
					$config['remove_spaces']=TRUE;
					$config['max_size']    = '2048';
					$config['overwrite'] = TRUE;
					$config['file_name'] = 'Folio_'.$id_oficio_recepcion.'_Anexos';

            // Cargamos la nueva configuración 'Folio_'.$id_oficio_recepcion.'_'.'Oficio_de_respuesta'.'_'.$num_oficio;
					$this->upload->initialize($config);

            // Subimos el segundo Archivo
					if ($this->upload->do_upload('anexos'))
					{
						$data = $this->upload->data();
					}
					else
					{
						$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
					}

					$anexos = $this->upload->data('file_name');

					//$respuesta = $_FILES['ofrespuesta']['name'];
					//$anexos = $_FILES['anexos']['name'];



	//fecha y hora de recepcion se generan basado en el servidor 
					date_default_timezone_set('America/Mexico_City');
					$fecha_respuesta = date('Y-m-d');
					$hora_respuesta =  date("H:i:s");

					// Se agrega la respuesta junto con los documentos de anexos y oficio de respuesta
					$agregar = $this->Modelo_direccion->agregarRespuestaInterna($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $numoficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico);
					// Actualizar bandera de respuesta
					$this->Modelo_direccion->actualizarBanderaInt($id_oficio_recepcion);
					// Habiendo actualizado la bandera de respuesta, se debe validar lo siguiente:
					// 
					// si (respondido = 1)
					// 			si, entonces:
					//                 si (fecha_actual > fecha_recepcion)
					// 				 			si, entonces: Actualiza status: "Respondido Fuera de Tiempo"
					// 				 			si no: Oficio dentro de tiempo
					// 	si no
					// 		Oficio no respondido
					// 	-------------	AQUI TE QUEDASTE -------
					$fecha_r = $this->Modelo_direccion->consultarFechaRecepcionInt($id_oficio_recepcion);
					foreach ($fecha_r as $key) {

						$fecha_termino_of = $key->fecha_termino;

						if ($fecha_respuesta > $fecha_termino_of) {
							$this->Modelo_direccion->actualizarStatusFueraDeTiempoInt($id_oficio_recepcion);
						}

						else
							if ($fecha_respuesta < $fecha_termino_of) {
								$this->Modelo_direccion->actualizarStatusContesadoInt($id_oficio_recepcion);
							}
							else
								if ($fecha_respuesta = $fecha_termino_of) {
									$this->Modelo_direccion->actualizarStatusContesadoInt($id_oficio_recepcion);
								}


							}

							if($agregar)
							{ 	
								$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong> '.$num_oficio. ' </strong> correctamente');
								redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
							}
							else
							{
								$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio: <strong> '.$num_oficio. ' </strong> verifique la información');
								redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
							}

						}
				//Si el usuario no carga el anexo el sistema le asignará uno por defecto, el cual es un pdf con la leyenda: "EL OFICIO NO TIENE ANEXOS"
						else
						{
      		 		//$respuesta = $_FILES['ofrespuesta']['name'];
							$anexos = 'default.pdf';

	//fecha y hora de recepcion se generan basado en el servidor 
							date_default_timezone_set('America/Mexico_City');
							$fecha_respuesta = date('Y-m-d');
							$hora_respuesta =  date("H:i:s");
							$flag_contestado = 1;
		// Estatus por defecto es : Pendiente

				//Agrega las respuestas
							$agregar = $this->Modelo_direccion->agregarRespuestaInterna($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento,$numoficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico);
				//Actualiza la bandera de respuesta
							$this->Modelo_direccion->actualizarBanderaInt($id_oficio_recepcion);
				//Si las fecha de respuesta es mayor a la fecha de recepcion el status cambia a Fuera de tiempo 
				// Si la fecha de respuesta es menor a la fecha de termino el estatus cambia 
							$fecha_r = $this->Modelo_direccion->consultarFechaRecepcionInt($id_oficio_recepcion);
							foreach ($fecha_r as $key) {

								$fecha_termino_of = $key->fecha_termino;

								if ($fecha_respuesta > $fecha_termino_of) {
									$this->Modelo_direccion->actualizarStatusFueraDeTiempoInt($id_oficio_recepcion);
								}

								else
									if ($fecha_respuesta < $fecha_termino_of) {
										$this->Modelo_direccion->actualizarStatusContesadoInt($id_oficio_recepcion);
									}
									else
										if ($fecha_respuesta = $fecha_termino_of) {
											$this->Modelo_direccion->actualizarStatusContesadoInt($id_oficio_recepcion);
										}

									}

									if($agregar)
									{ 	
										$this->session->set_flashdata('exito', 'Se ha enviado la respuesta del oficio: <strong>'.$num_oficio. ' </strong> correctamente');
										redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
									}
									else
									{
										$this->session->set_flashdata('error', 'No se ha podido realizar la respuesta del oficio:  <strong> '.$num_oficio. ' </strong> verifique la información');
										redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
									}
								}

							}
							else
							{
				//En caso de no haber archivos en el formulario, envia un error a la vista ssad indicando que no hay archivos
								$data['titulo'] = 'Panel de Direcciones';
								$data['entradas'] = $this -> Modelo_direccion -> getAllEntradasInternas($this->session->userdata('nombre'));
								$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
								$this->load->view('plantilla/header', $data);
								$this->load->view('directores/internos/index');
								$this->load->view('plantilla/footer');		
							}
						}

					}

					public function asignarOficio()
					{
						$this -> form_validation -> set_rules('iddir','Dirección','required');
						$this -> form_validation -> set_rules('area_destino','Departamento','required');
						$this -> form_validation -> set_rules('txt_idoficio_a','Oficio de Recepción','required');

						if ($this->form_validation->run() == FALSE) {
			# code...
							$data['titulo'] = 'Recepción de Oficios';
							$data['entradas'] = $this -> Modelo_direccion -> getAllEntradas($this->session->userdata('id_direccion'));
							$data['deptos'] = $this -> Modelo_direccion -> getDeptos($this->session->userdata('id_direccion'));
							$this->load->view('plantilla/header', $data);
							$this->load->view('directores/internos/recepciondir');
							$this->load->view('plantilla/footer');	

						}
						else
						{
							$data =  array(
								$num_oficio = $this-> input -> post('num_oficio_h'),
								$id_oficio_recepcion = $this -> input -> post('txt_idoficio_a'),
								$id_direccion = $this -> input -> post('iddir'),
								$id_departamento = $this -> input -> post('area_destino'),
								$observaciones = $this -> input -> post('observaciones'),
								);

							$flag_departamento = 1;

							date_default_timezone_set('America/Mexico_City');
							$fecha_respuesta = date('Y-m-d');
							$hora_respuesta =  date("H:i:s");
			// Obtener el nombre del departamento mediante el id que se selecciona en el formulario
			// Consulta: Obtiene el departamento cuando el id_departamento sea igual a = ?
							$depto = $this->Modelo_direccion->consultarNombreDepartamento($id_departamento);
							foreach ($depto as $key) {

								$nombre_depto= $key->nombre_area;
							}

							$asignar = $this->Modelo_direccion->asignarOficioInterno($id_direccion,$id_departamento,$id_oficio_recepcion,$observaciones, $hora_respuesta, $fecha_respuesta);


				// La bandera de asignacion debe cambiar para que se muestre en la tabla de recepcion del director y de la recepcionista 
							$this->Modelo_direccion->ModificarBanderaDeptosInt($id_oficio_recepcion);

							if($asignar)
							{ 	
								$this->session->set_flashdata('exito', 'El oficio con nº <strong>: '.$num_oficio. '</strong> Se ha asignado al: <strong> ' .$nombre_depto. ' </strong> con éxito');
								redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
							}
							else
							{
								$this->session->set_flashdata('error', 'No se ha podido asignar el oficio con nº <strong>:   '.$num_oficio. ' </strong> al: <strong>'.$nombre_depto.' </strong> verifique su información.');
								redirect(base_url() . 'Direcciones/Interno/BuzonInterno/');
							}
						}

					}


				}

				/* End of file BuzonInterno.php */
/* Location: ./application/controllers/BuzonInterno.php */