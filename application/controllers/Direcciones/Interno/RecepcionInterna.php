<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RecepcionInterna extends CI_Controller {


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
			$data['entradas'] = $this -> Modelo_direccion -> getAllEntradasInternas($this->session->userdata('nombre'));
			$data['deptos'] = $this -> Modelo_direccion -> getAllDeptos();
		
			$consulta = $this->Modelo_direccion->getAllEntradasInternas($this->session->userdata('nombre'));
			foreach ($consulta as $key) {
				$idoficio = $key->id_recepcion_int;
				if (!$key->status == 'Fuera de Tiempo') {
					$this->db->query("CALL comparar_fechas_internas('".$idoficio."')");
				}

			}
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/internos/recepciondir');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

	public function agregarEntrada()
	{
		$this -> form_validation -> set_rules('num_oficio','Número de Oficio','required');
		$this -> form_validation -> set_rules('asunto','Asunto','required');
		$this -> form_validation -> set_rules('emisor_h','Emisor','required');
		$this -> form_validation -> set_rules('fecha_termino','Fecha de Termino','required');
		//$this -> form_validation -> set_rules('archivo','Archivo','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Recepción de Oficios';
			$data['entradas'] = $this -> Modelo_direccion -> getAllEntradasInternas($this->session->userdata('nombre'));
			$data['deptos'] = $this -> Modelo_direccion -> getAllDeptos();
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/internos/recepciondir');
			$this->load->view('plantilla/footer');

		}
		else
		{
			// $correo = array();
			// $correo_personal = array();
			$data =  array(
				$num_oficio = $this -> input -> post('num_oficio'),
				$asunto = $this -> input -> post('asunto'),
				$tipo_recepcion = $this -> input -> post('tipo_recepcion'),
				$tipo_documento = $this -> input -> post('tipo_documento'),
				$emisor = $this -> input -> post('emisor_h'),
				$cargo = $this -> input -> post('cargo_h'),
				$dependencia = $this -> input -> post('dependencia_h'),
				$direccion = $this -> input -> post('direccion'),
				$fecha_termino = $this -> input -> post('fecha_termino'),
				$prioridad = $this -> input -> post('prioridad'),
				$observaciones = $this -> input -> post('observaciones'),
				$tipo_dias = $this -> input -> post('tipo_dias'),
				//$correo = $this -> input -> post('email'),
				//$correo_personal  = $this -> input -> post('email_personal'),
				$requiere_respuesta = $this -> input -> post('ReqRespuesta')
				);


			if (isset($_POST['btn_enviar']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
				if (!empty($_FILES['archivo']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './doctosinternos/';
					$config['allowed_types'] = 'pdf|docx';
					$config['remove_spaces']=FALSE;
					$config['max_size']    = '2048';
					$config['overwrite'] = TRUE;

					if ($config['allowed_types'] = 'pdf|PDF') {
						$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo']['name']);
						$_FILES['archivo']['name'] = $pdf_formateado.'.'.'pdf';
						$archivo_of = $pdf_formateado.'.'.'pdf';
					}
					else
						if ($config['allowed_types'] = 'docx|DOCX') {
							$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo']['name']);
							$_FILES['archivo']['name'] = $pdf_formateado.'.'.'docx';
							$archivo_of = $pdf_formateado.'.'.'docx';
						}

            				// Cargamos la configuración del Archivo 1
						$this->upload->initialize($config);

           				 // Subimos archivo 1
						if ($this->upload->do_upload('archivo'))
						{
							$data = $this->upload->data();
						}
						else
						{
							$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
							redirect(base_url() . 'Direcciones/Interno/RecepcionInterna/');
						}

					}

				}

				//fecha y hora de recepcion se generan basado en el servidor 
				date_default_timezone_set('America/Mexico_City');
				$fecha_recepcion = date('Y-m-d');
				$hora_recepcion =  date("H:i:s");
				$flag_direccion = 1;
		// Estatus por defecto es : Pendiente
				$status = 'Pendiente';
				
			

			
				// METODO DE ENVIO MULTIPLE, SERVIDOR 
				foreach ($_POST['direccion'] as $indice => $valor){ 
					//echo "indice: ".$indice." => ".$valor."<br>"; 
					$agregar = $this->Modelo_direccion->insertarEntrada($num_oficio,$fecha_recepcion,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $cargo, $dependencia, $valor, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $requiere_respuesta);
				}

		
				if($agregar)
				{ 	
					// Aqui se enviaria el correo para notificar al usuario correspondiente
					// tomando los datos de sesion del emisor y os datos del recpetor del oficio 
					 //cargamos la libreria email de ci
					$this->load->library("email");

					 //configuracion para gmail - Servidor de correo homologado para el sistema
					$configGmail = array(
						'protocol' => 'smtp',
						'smtp_host' => 'ssl://smtp.gmail.com',
						'smtp_port' => 465,
						'smtp_user' => 'sgocseiiomail@gmail.com',
						'smtp_pass' => 'cseiio2017',
						'mailtype' => 'html',
						'charset' => 'utf-8',
						'newline' => "\r\n"
					);    

					 //cargamos la configuración para enviar con gmail
					$this->email->initialize($configGmail);
					
					
					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
					 
					foreach ($_POST['direccion'] as $indice => $valor){ 
						$correos = $this->Modelo_direccion->obtenerCorreoMultiple($valor);
						foreach ($correos as $key) {

							$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
							$this->email->to($key->email);
							$this->email->cc($key->email_personal);
					
					//$this->email->to($correo);
					 //Agregar el correo personal de los usuarios 
					
					$this->email->subject('Nuevo Oficio Interno');
					$this->email->message('<h2>Has recibido el oficio interno: '.$num_oficio.'  , ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios Internos"</h2><hr><br> Correo informativo libre de SPAM');
					$this->email->send();
					 //con esto podemos ver el resultado
					var_dump($this->email->print_debugger());
						}

					}

					$this->session->set_flashdata('exito', 'El número de oficio:  '.$num_oficio. ' se ha ingresado correctamente');
					redirect(base_url() . 'Direcciones/Interno/RecepcionInterna/');
				}
				else
				{
					$this->session->set_flashdata('error', 'El número de oficio:  '.$num_oficio. ' no se ingresó, verifique la información');
					redirect(base_url() . 'Direcciones/Interno/RecepcionInterna/');
				}
			}
		}

		public function Descargar($name)
		{
			$data = file_get_contents($this->folder.$name); 
			force_download($name,$data); 
		}


		public function TurnarCopiaDir()
		{
				$this -> form_validation -> set_rules('txt_idoficio','Id de Oficio','required');
				$this -> form_validation -> set_rules('direccion_a','Direccion de destino','required');

					if ($this->form_validation->run() == FALSE) {
			# code...
						$data['titulo'] = 'Recepción de Oficios';
						$data['entradas'] = $this -> Modelo_direccion -> getAllEntradasInternas($this->session->userdata('nombre'));
						$data['deptos'] = $this -> Modelo_direccion -> getAllDeptos();
						$this->load->view('plantilla/header', $data);
						$this->load->view('directores/internos/recepciondir');
						$this->load->view('plantilla/footer');
				}
				else
				{
					$data =  array(
						$direccion_destino = $this -> input -> post('direccion_a'),
						$id_oficio = $this -> input -> post('txt_idoficio'),
						$observaciones = $this -> input -> post('observaciones_a')
						);

					$turnar = $this->Modelo_direccion->TurnarADireccion($direccion_destino,$id_oficio,$observaciones);

					if($turnar)
					{ 	
						$this->session->set_flashdata('actualizado', 'Se ha turnado copia a la dirección seleccionada');
					redirect(base_url() . 'Direcciones/Interno/RecepcionInterna/');
					}

					else
					{
					$this->session->set_flashdata('error_actualizacion', 'No se ha turnado copia a la direccion seleccionada, verifique');
					redirect(base_url() . 'Direcciones/Interno/RecepcionInterna/');
					}
				}
		
		}

		public function TurnarCopiaDeptos()
		{
			$this -> form_validation -> set_rules('txt_idoficio','Id de Oficio','required');
			$this -> form_validation -> set_rules('area_destino','Direccion de destino','required');

				if ($this->form_validation->run() == FALSE) {
			# code...
					$data['titulo'] = 'Recepción de Oficios';
					$data['entradas'] = $this -> Modelo_direccion -> getAllEntradasInternas($this->session->userdata('nombre'));
					$data['deptos'] = $this -> Modelo_direccion -> getAllDeptos();
					$this->load->view('plantilla/header', $data);
					$this->load->view('directores/internos/recepciondir');
					$this->load->view('plantilla/footer');

				}
				else
				{
					$data =  array(
						$depto_destino = $this -> input -> post('area_destino'),
						$id_oficio = $this -> input -> post('txt_idoficio'),
						$observaciones = $this -> input -> post('observaciones_a')
						);

					$turnar = $this->Modelo_direccion->TurnarADeptos($depto_destino,$id_oficio,$observaciones);

					if($turnar)
					{ 	
						$this->session->set_flashdata('actualizado', 'Se ha turnado copia al departamento seleccionado');
						redirect(base_url() . 'Direcciones/Interno/RecepcionInterna/');
					}

					else
					{
					$this->session->set_flashdata('error_actualizacion', 'No se ha turnado copia al departamento seleccionado, verifique');
						redirect(base_url() . 'Direcciones/Interno/RecepcionInterna/');
					}
				}
		}


		public function ModificarOficio()
		{
		# code..

				$this -> form_validation -> set_rules('num_oficio_a','Número de Oficio','required');
				$this -> form_validation -> set_rules('asunto_a','Asunto','required');
				$this -> form_validation -> set_rules('emisor_h','Emisor','required');
				$this -> form_validation -> set_rules('fecha_termino_a','Fecha de Termino','required');

				if ($this->form_validation->run() == FALSE) {
			# code...
					$data['titulo'] = 'Recepción de Oficios';
					$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradasInternas($this->session->userdata('nombre'));
					$data['deptos'] = $this -> Modelo_direccion -> getAllDeptos();
					$this->load->view('plantilla/header', $data);
					$this->load->view('directores/internos/recepciondir');
					$this->load->view('plantilla/footer');

				}
				else
				{
					$data =  array(
					$id =  $this -> input -> post('txt_idoficio'),
					$num_oficio = $this -> input -> post('num_oficio_a'),
					$asunto = $this -> input -> post('asunto_a'),
					$tipo_recepcion = $this -> input -> post('tipo_recepcion_a'),
					$tipo_documento = $this -> input -> post('tipo_documento_a'),
					$emisor = $this -> input -> post('emisor_h'),
					$direccion = $this -> input -> post('direccion_a'),
					$fecha_termino = $this -> input -> post('fecha_termino_a'),
					$status = $this -> input -> post('status_a'),
					$prioridad = $this -> input -> post('prioridad_a'),
					$observaciones = $this -> input -> post('observaciones_a'),
					$tipo_dias = $this -> input -> post('tipo_dias_a')
					);


			if (isset($_POST['btn_enviar_a']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
				if (!empty($_FILES['archivo_a']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './doctos/';
					$config['allowed_types'] = 'pdf|docx';
					$config['remove_spaces']=FALSE;
					$config['max_size']    = '2048';
					$config['overwrite'] = TRUE;

					if ($config['allowed_types'] = 'pdf|PDF') {
						$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo_a']['name']);
						$_FILES['archivo_a']['name'] = $pdf_formateado.'.'.'pdf';
						$archivo_actualizable = $pdf_formateado.'.'.'pdf';
					}
					else
						if ($config['allowed_types'] = 'docx|DOCX') {
							$pdf_formateado = preg_replace('([^A-Za-z0-9])', '', $_FILES['archivo_a']['name']);
							$_FILES['archivo_a']['name'] = $pdf_formateado.'.'.'docx';
							$archivo_actualizable = $pdf_formateado.'.'.'docx';
						}

            				// Cargamos la configuración del Archivo 1
						$this->upload->initialize($config);

           				 // Subimos archivo 1
						if ($this->upload->do_upload('archivo_a'))
						{
							$data = $this->upload->data();
						}
						else
						{
							$this->session->set_flashdata('errorarchivo', $this->upload->display_errors());
							redirect(base_url() . 'Direcciones/Interno/RecepcionInterna/');
						}

					}

				}

					$actualizar = $this->Modelo_direccion->modificarInfoOficioInterno($id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $status, $prioridad, $observaciones, $tipo_dias);
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
					if($actualizar)
					{ 	
						$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
					redirect(base_url() . 'Direcciones/Interno/RecepcionInterna/');
					}

					else
					{
					$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
					redirect(base_url() . 'Direcciones/Interno/RecepcionInterna/');
					}		
				}	
			
		}


				// Funcion para llenar el combo de departamentos 
		public function llenarComboEmailInterno()
		{
			// 			METODO DINAMICO BASADO EN ARREGLOS 
			$options="";
			foreach ($_POST['dirinterno'] as $indice => $valor){ 
					//echo "indice: ".$indice." => ".$valor."<br>"; 
				$deptos = $this ->Modelo_direccion->obtenerCorreoDireccionInterno($valor);
				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';    
					echo $options; 
				}
			}


			// 			METODO ESTATICO BASADO EN ID´S
			// $options="";
			// if ($_POST["dirinterno"]== 1) 
			// {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoDireccionInterno(1);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email.'>'.$row->email.'</option>
			// 		';    
			// 		echo $options; 
			// 	}
			// }
			// if ($_POST["dirinterno"]==2) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoDireccionInterno(2);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email.'>'.$row->email.'</option>
			// 		';    
			// 		echo $options;  
			// 	}
			// }

			// if ($_POST["dirinterno"]==3) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoDireccionInterno(3);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email.'>'.$row->email.'</option>
			// 		';   
			// 		echo $options;   
			// 	}
			// }


			// if ($_POST["dirinterno"]==4) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoDireccionInterno(4);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email.'>'.$row->email.'</option>
			// 		';   
			// 		echo $options;   
			// 	}   
			// }


			// if ($_POST["dirinterno"]==5) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoDireccionInterno(5);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email.'>'.$row->email.'</option>
			// 		';   
			// 		echo $options;   
			// 	}  
			// }

			// if ($_POST["dirinterno"]==6) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoDireccionInterno(6);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email.'>'.$row->email.'</option>
			// 		';   
			// 		echo $options;   
			// 	}  
			// }


			// if ($_POST["dirinterno"]==7) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoDireccionInterno(7);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email.'>'.$row->email.'</option>
			// 		';   
			// 		echo $options;   
			// 	}  
			// }
		}
//LEER EL ARREGLO

	    public function llenarComboPersonalInterno()
		{
			// METODO DINAMICO BASADO EN ARREGLOS

			$options="";
			foreach ($_POST['dirinterno2'] as $indice => $valor){ 
					//echo "indice: ".$indice." => ".$valor."<br>"; 
				$deptos = $this ->Modelo_direccion->obtenerCorreoPersonalInterno($valor);
				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
			// 		';       
					echo $options; 
				}
			}

			// 					METODO ESTATICO
			// $options="";
			// if ($_POST["dirinterno2"]== 1) 
			// {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoPersonalInterno(1);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
			// 		';    
			// 		echo $options; 
			// 	}
			// }
			// if ($_POST["dirinterno2"]==2) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoPersonalInterno(2);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
			// 		';    
			// 		echo $options;  
			// 	}
			// }

			// if ($_POST["dirinterno2"]==3) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoPersonalInterno(3);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
			// 		';   
			// 		echo $options;   
			// 	}
			// }


			// if ($_POST["dirinterno2"]==4) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoPersonalInterno(4);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
			// 		';   
			// 		echo $options;   
			// 	}   
			// }


			// if ($_POST["dirinterno2"]==5) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoPersonalInterno(5);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
			// 		';   
			// 		echo $options;   
			// 	}  
			// }

			// if ($_POST["dirinterno2"]==6) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoPersonalInterno(6);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
			// 		';   
			// 		echo $options;   
			// 	}  
			// }


			// if ($_POST["dirinterno2"]==7) {
			// 	$deptos = $this ->Modelo_direccion->obtenerCorreoPersonalInterno(7);

			// 	foreach ($deptos as $row){
			// 		$options= '
			// 		<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
			// 		';   
			// 		echo $options;   
			// 	}  
			// }




		}
		
	}

