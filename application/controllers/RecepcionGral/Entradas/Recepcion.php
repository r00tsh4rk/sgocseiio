<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recepcion extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
		$this -> load -> model('Modelo_direccion');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			
			$data['titulo'] = 'Recepción de Oficios';
			$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
			$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
			// Actualiza los oficios que han sobrepasado el tiempo de res
			date_default_timezone_set('America/Mexico_City');
			$fecha_hoy = date('Y-m-d');
			$hora_hoy =  date("H:i:s");
			
			$consulta = $this->Modelo_recepcion->getAllEntradas();
			foreach ($consulta as $key) {
				$idoficio = $key->id_recepcion;
				if ($fecha_hoy > $key->fecha_termino AND $key->status=='Pendiente') {
					$this->db->query("CALL comparar_fechas('".$idoficio."')");
				}
				
			}
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/entradas/recepcion');
			$this->load->view('plantilla/footer');	

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

	// public function consultarOficios()
	// {
	// 	$data['titulo'] = 'Recepción de Oficios';
	// 	$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
	// 	$this->load->view('plantilla/header', $data);
	// 	$this->load->view('recepcion/recepcion');
	// 	$this->load->view('plantilla/footer');	
	// }

	public function agregarEntrada()
	{
		$this -> form_validation -> set_rules('num_oficio','Número de Oficio','required');
		$this -> form_validation -> set_rules('asunto','Asunto','required');
		$this -> form_validation -> set_rules('emisor','Emisor','required');
		$this -> form_validation -> set_rules('cargo','Cargo','required');
		$this -> form_validation -> set_rules('dependencia','Dependencia','required');
		$this -> form_validation -> set_rules('fecha_termino','Fecha de Termino','required');
		$this -> form_validation -> set_rules('fecha_recepcion_fisica','Fecha de Recepcion','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
			$data['titulo'] = 'Recepción de Oficios';
			$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/entradas/recepcion');
			$this->load->view('plantilla/footer');	

		}
		else
		{
			
			$data =  array(
				$num_oficio = $this -> input -> post('num_oficio'),
				$asunto = $this -> input -> post('asunto'),
				$tipo_recepcion = $this -> input -> post('tipo_recepcion'),
				$tipo_documento = $this -> input -> post('tipo_documento'),
				$emisor = $this -> input -> post('emisor'),
				$cargo = $this -> input -> post('cargo'),
				$dependencia = $this -> input -> post('dependencia'),
				$direccion = $this -> input -> post('direccion'),
				$fecha_termino = $this -> input -> post('fecha_termino'),
				$prioridad = $this -> input -> post('prioridad'),
				$observaciones = $this -> input -> post('observaciones'),
				$tipo_dias = $this -> input -> post('tipo_dias'),
				//$correo = $this -> input -> post('email'),
				//$correo_personal =  $this -> input -> post('email_personal'),
				$requiereRespuesta =  $this -> input -> post('ReqRespuesta'),
				$fecha_recepcion_fisica =  $this -> input -> post('fecha_recepcion_fisica'),
				$hora_recepcion_fisica = $this -> input -> post('hora_recepcion_fisica')
			);


			if (isset($_POST['btn_enviar']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
				if (!empty($_FILES['archivo']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './doctos/';
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
							redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
						}

					}

				}

				//fecha y hora de recepcion se generan basado en el servidor 
				date_default_timezone_set('America/Mexico_City');
				$fecha_subida = date('Y-m-d');
				$hora_recepcion =  date("H:i:s");
				$flag_direccion = 1;
		// Estatus por defecto es : Pendiente
				$status = 'Pendiente';

				
				if ($fecha_recepcion_fisica < $fecha_subida) {
					$date1 = $fecha_subida;
					$date2 = $fecha_recepcion_fisica;
					$diff = abs(strtotime($date2) - strtotime($date1));

					$years = floor($diff / (365*60*60*24));
					$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
					$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
					if ($days = 1) {
						$observaciones = 'El oficio se ha subido un '.$days. ' día después de su recepción';
					}
					else
					{
						$observaciones = 'El oficio se ha subido '.$days. ' días después de su recepción';
					}
					
				}

				// Si el Oficio no requiere respuesta, se agrega con estatus contestado
				// Y con direccion numero 8 que representa a un oficio sin

				if ($requiereRespuesta == 0) {
					
					$correo =  '';
					$correo_personal = '';
					$direccion = '8';
					$status = 'Informativo';

					$agregar = $this->Modelo_recepcion->insertarEntrada($num_oficio,$fecha_subida,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor,$dependencia, $cargo, $direccion, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $requiereRespuesta, $fecha_recepcion_fisica, $hora_recepcion_fisica);
				}
				else
				{
					foreach ($_POST['direccion'] as $indice => $valor){ 
					//echo "indice: ".$indice." => ".$valor."<br>"; 
						$agregar = $this->Modelo_recepcion->insertarEntrada($num_oficio,$fecha_subida,$hora_recepcion,$asunto,$tipo_recepcion, $tipo_documento, $emisor,$dependencia, $cargo, $valor, $fecha_termino, $archivo_of, $status, $prioridad, $observaciones,$flag_direccion,$tipo_dias, $requiereRespuesta, $fecha_recepcion_fisica, $hora_recepcion_fisica);
					}
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
					foreach ($_POST['direccion'] as $indice => $valor){ 
						$correos = $this->Modelo_recepcion->obtenerCorreoMultiple($valor);
						foreach ($correos as $key) {

							$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion

							$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
							$this->email->cc($key->email_personal);
							$this->email->subject('Nuevo Oficio');
							$this->email->message('<h2>Has recibido el oficio externo: '.$num_oficio.'  , ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios Externos"</h2><hr><br> Correo informativo libre de SPAM');
							$this->email->send();
					 //con esto podemos ver el resultado
							var_dump($this->email->print_debugger());
						}
					}

					$this->session->set_flashdata('exito', 'El número de oficio:  '.$num_oficio. ' se ha ingresado correctamente');
					redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
				}
				else
				{
					$this->session->set_flashdata('error', 'El número de oficio:  '.$num_oficio. ' no se ingresó, verifique la información');
					redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
				}
			}
		}


					// Funcion para llenar el combo de departamentos 
		public function llenarComboEmial()
		{
			$options="";
			if ($_POST["dir"]== 1) 
			{
				$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(1);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';    
					echo $options; 
				}
			}
			if ($_POST["dir"]==2) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(2);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';    
					echo $options;  
				}
			}

			if ($_POST["dir"]==3) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(3);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';   
					echo $options;   
				}
			}


			if ($_POST["dir"]==4) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(4);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';   
					echo $options;   
				}   
			}


			if ($_POST["dir"]==5) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(5);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';   
					echo $options;   
				}  
			}

			if ($_POST["dir"]==6) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(6);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';   
					echo $options;   
				}  
			}


			if ($_POST["dir"]==7) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoDireccion(7);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email.'>'.$row->email.'</option>
					';   
					echo $options;   
				}  
			}




		}


		public function llenarComboPersonal()
		{
			$options="";
			if ($_POST["dir2"]== 1) 
			{
				$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(1);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';    
					echo $options; 
				}
			}
			if ($_POST["dir2"]==2) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(2);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';    
					echo $options;  
				}
			}

			if ($_POST["dir2"]==3) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(3);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';   
					echo $options;   
				}
			}


			if ($_POST["dir2"]==4) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(4);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';   
					echo $options;   
				}   
			}


			if ($_POST["dir2"]==5) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(5);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';   
					echo $options;   
				}  
			}

			if ($_POST["dir2"]==6) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(6);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';   
					echo $options;   
				}  
			}


			if ($_POST["dir2"]==7) {
				$deptos = $this ->Modelo_recepcion->obtenerCorreoPersonal(7);

				foreach ($deptos as $row){
					$options= '
					<option value='.$row->email_personal.'>'.$row->email_personal.'</option>
					';   
					echo $options;   
				}  
			}




		}
		//Funcion para emitir alertas a los directores de area via correo electronico, basado en el id del oficio recepcionado
		public function emitirAlertas()
		{
			$this -> form_validation -> set_rules('txt_idoficio','Número de Oficio','required');

			if ($this->form_validation->run() == FALSE) {
			# code...
				$data['titulo'] = 'Recepción de Oficios';
				$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
				$this->load->view('plantilla/header', $data);
				$this->load->view('recepcion/entradas/recepcion');
				$this->load->view('plantilla/footer');	
			}
			else
			{
				$data =  array(
					$id =  $this -> input -> post('txt_idoficio'),
					$mensaje = $this -> input -> post('mensaje')
				);

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

				$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
				$correos = $this ->Modelo_recepcion->obtenerCorreo($id);
				foreach ($correos as $key) {
					 	# code...
					$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
					$this->email->cc($key->email_personal);

					$this->email->subject('Alerta de Término');
					$this->email->message('<h2>Has recibido una notificación de alerta del oficio: '.$key->num_oficio.'  , con el siguiente mensaje adjunto: " '.$mensaje.' ". <hr><br> Ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios Externos"</h2><hr><br> Correo informativo libre de SPAM');
				}
				$this->email->send();
					 //con esto podemos ver el resultado
				var_dump($this->email->print_debugger());

				$this->session->set_flashdata('exito', 'Se ha emitido la alerta correctamente');
				redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');

			}

		}


		public function emitirAlertasNC()
		{
			$this -> form_validation -> set_rules('txt_idoficio','Número de Oficio','required');

			if ($this->form_validation->run() == FALSE) {
			# code...
				$data['titulo'] = 'Recepción de Oficios';
				$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
				$this->load->view('plantilla/header', $data);
				$this->load->view('recepcion/entradas/recepcion');
				$this->load->view('plantilla/footer');	
			}
			else
			{
				$data =  array(
					$id =  $this -> input -> post('txt_idoficio'),
					$mensaje = $this -> input -> post('mensaje')
				);

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

				$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
					 //Consultar el correo del id de direccion que se esta recibiendo por el formulario de recpecion
				$correos = $this ->Modelo_recepcion->obtenerCorreo($id);
				foreach ($correos as $key) {
					 	# code...

					$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
					$this->email->cc($key->email_personal);

					$this->email->subject('Alerta de Oficio No Contestado');
					$this->email->message('<h2>Has recibido una notificación de alerta del oficio: '.$key->num_oficio.'  , con el siguiente mensaje adjunto: " '.$mensaje.' ". <hr><br> Ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios Externos"</h2><hr><br> Correo informativo libre de SPAM');
				}
				$this->email->send();
					 //con esto podemos ver el resultado
				var_dump($this->email->print_debugger());

				$this->session->set_flashdata('exito', 'Se ha emitido la alerta correctamente');
				redirect(base_url() . 'RecepcionGral/Entradas/NoContestados/');

			}

		}


		public function ModificarOficio()
		{
		# code..

			$this -> form_validation -> set_rules('num_oficio_a','Número de Oficio','required');
			$this -> form_validation -> set_rules('asunto_a','Asunto','required');
			$this -> form_validation -> set_rules('emisor_a','Emisor','required');
			$this -> form_validation -> set_rules('fecha_termino_a','Fecha de Termino','required');

			if ($this->form_validation->run() == FALSE) {
			# code...
				$data['titulo'] = 'Recepción de Oficios';
				$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
				$this->load->view('plantilla/header', $data);
				$this->load->view('recepcion/entradas/recepcion');
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
					$emisor = $this -> input -> post('emisor_a'),
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
								redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
							}

						}

					}

					$actualizar = $this->Modelo_recepcion->modificarRegistro($id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $status, $prioridad, $observaciones, $tipo_dias);
               //si la actualización ha sido correcta creamos una sesión flashdata para decirlo
					if($actualizar)
					{ 	
						$this->session->set_flashdata('actualizado', 'El número de oficio:  '.$num_oficio. ' fué modificado correctamente');
						redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
					}

					else
					{
						$this->session->set_flashdata('error_actualizacion', 'El número de oficio:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
						redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
					}		
				}	

			}

			public function TurnarCopiaDir()
			{
				$this -> form_validation -> set_rules('txt_idoficio','Id de Oficio','required');
				$this -> form_validation -> set_rules('direccion_a','Direccion de destino','required');

				if ($this->form_validation->run() == FALSE) {
			# code...
					$data['titulo'] = 'Turnado de Copias ';
					$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
					$data['deptos'] = $this -> Modelo_recepcion -> getAllDeptos();
					$this->load->view('plantilla/header', $data);
					$this->load->view('recepcion/entradas/recepcion');
					$this->load->view('plantilla/footer');
				}
				else
				{
					$data =  array(
						$direccion_destino = $this -> input -> post('direccion_a'),
						$id_oficio = $this -> input -> post('txt_idoficio'),
						$num_oficio = $this -> input -> post('txt_num_oficio'),
						$observaciones = $this -> input -> post('observaciones_a'),
						$nombre_emisor = $this -> input -> post('emisor_h')
					);

					$consulta = $this->Modelo_recepcion->seleccionarDir($id_oficio);
					foreach ($consulta as $key) {
						$direccion = $key->id_direccion_destino;
					}

					if ($direccion_destino != $direccion) {

						$turnar = $this->Modelo_recepcion->TurnarADireccion($direccion_destino,$id_oficio,$observaciones,$nombre_emisor);

						if($turnar)
						{ 	
						// ENVIO DE NOTIFICACION VIA CORREO 
							$this->load->library("email");
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

							$this->email->initialize($configGmail);
							$this->email->from('Sistema de Gestion de Oficios del CSEIIO');

							$correos = $this ->Modelo_recepcion->obtenerCorreos($direccion_destino);
							foreach ($correos as $key) {
								$this->email->to($key->email);
					 //Agregar el correo personal de los usuarios 
								$this->email->cc($key->email_personal);
							}					
							$this->email->subject('Copia turnada a esta dirección');
							$this->email->message('<h2>Has recibido una copia del oficio: '.$num_oficio.', para su conocimiento o atención. <hr><br> Ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Oficios con Copia a esta Dirección."</h2><hr><br> Correo informativo libre de SPAM');
							$this->email->send();
					 //con esto podemos ver el resultado
							var_dump($this->email->print_debugger());

						//enviar correo a la direccion en turno indicandole que se le ha turnado una copia del oficio
							$this->session->set_flashdata('actualizado', 'Se ha turnado copia a la dirección seleccionada');
							redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
						}

						else
						{
							$this->session->set_flashdata('error_actualizacion', 'No se ha turnado copia a la direccion seleccionada, verifique');
							redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
						}
					}
					else
					{
						$this->session->set_flashdata('error', ' Se esta tratando de turnar copia la misma dirección.');
						redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
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
					$data['entradas'] = $this -> Modelo_recepcion -> getAllEntradas();
					$data['deptos'] = $this -> Modelo_direccion -> getAllDeptos();
					$this->load->view('plantilla/header', $data);
					$this->load->view('recepcion/entradas/recepcion');
					$this->load->view('plantilla/footer');

				}
				else
				{
					$data =  array(
						$depto_destino = $this -> input -> post('area_destino'),
						$id_oficio = $this -> input -> post('txt_idoficio'),
						$observaciones = $this -> input -> post('observaciones_a'),
						$num_oficio = $this -> input -> post('txt_num_oficio'),
						$nombre_emisor = $this -> input -> post('emisor_h'),
						$id_direccion = $this -> input -> post('txt_id_direccion')
					);

					if ($observaciones == 'atencion') {
						# code...

						$consulta = $this->Modelo_direccion->seleccionarDepto($id_oficio);
						foreach ($consulta as $key) {
							$area = $key->id_area;
						}

						date_default_timezone_set('America/Mexico_City');
						$fecha_recepcion = date('Y-m-d');
						$hora_recepcion =  date("H:i:s");
						$observaciones = 'Para su atención y respuesta';

						if ($depto_destino != $area) {
						# code...
							$turnar = $this->Modelo_recepcion->TurnarADeptos($depto_destino,$id_oficio,$observaciones,$nombre_emisor);

							if($turnar)
							{ 	
						//Asigna el oficio
								$asignar = $this->Modelo_direccion->asignarOf($id_direccion,$depto_destino,$id_oficio,$observaciones,$fecha_recepcion,$hora_recepcion);

								$habilitar = $this->Modelo_recepcion->cambiarBanderaHabilitado($id_oficio);

								// ENVIO DE NOTIFICACION VIA CORREO 
								$this->load->library("email");
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

								$this->email->initialize($configGmail);
								$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
								// Obtención de corres del departamento
								$correos = $this ->Modelo_recepcion->obtenerCorreosPorDepartamento($depto_destino);
								foreach ($correos as $key) {
									$this->email->to($key->email);
								 //Agregar el correo personal de los usuarios 
									$this->email->cc($key->email_personal);
								}					
								$this->email->subject('Copia turnada este departamento');
								$this->email->message('<h2>Has recibido una copia del oficio: '.$num_oficio.', para antención o respuesta. Solicita que tu Dirección habilite el oficio para su respuesta. <hr><br> Ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Buzón de Oficios."</h2><hr><br> Correo informativo libre de SPAM');
								$this->email->send();
					 			//con esto podemos ver el resultado
								var_dump($this->email->print_debugger());

								//enviar correo a la direccion en turno indicandole que se le ha turnado una copia del oficio

								$this->session->set_flashdata('actualizado', 'Se ha turnado copia al departamento seleccionado');
								redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
							}

							else
							{
								$this->session->set_flashdata('error_actualizacion', 'No se ha turnado copia al departamento seleccionado, verifique');
								redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
							}	

						}
						else
						{
							$this->session->set_flashdata('error', ' Se esta tratando de turnar copia al mismo departamento');
							redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
						}
					}
					else
						if ($observaciones == 'conocimiento') {
							$consulta = $this->Modelo_direccion->seleccionarDepto($id_oficio);
							foreach ($consulta as $key) {
								$area = $key->id_area;
							}

							date_default_timezone_set('America/Mexico_City');
							$fecha_recepcion = date('Y-m-d');
							$hora_recepcion =  date("H:i:s");
							$observaciones = 'Para su conocimiento';

							if ($depto_destino != $area) {
						# code...
								$turnar = $this->Modelo_recepcion->TurnarADeptos($depto_destino,$id_oficio,$observaciones,$nombre_emisor);

								if($turnar)
								{ 	
						
								// ENVIO DE NOTIFICACION VIA CORREO 
								$this->load->library("email");
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

								$this->email->initialize($configGmail);
								$this->email->from('Sistema de Gestion de Oficios del CSEIIO');
								// Obtención de corres del departamento
								$correos = $this ->Modelo_recepcion->obtenerCorreosPorDepartamento($depto_destino);
								foreach ($correos as $key) {
									$this->email->to($key->email);
								 //Agregar el correo personal de los usuarios 
									$this->email->cc($key->email_personal);
								}					
								$this->email->subject('Copia turnada este departamento');
								$this->email->message('<h2>Has recibido una copia del oficio: '.$num_oficio.', para conocimiento. <hr><br> Ingresa al sistema de control de oficios dando clic <a href="http://localhost/sgocseiio">aquí</a> y revisa el panel "Turnado de Copias."</h2><hr><br> Correo informativo libre de SPAM');
								$this->email->send();
					 			//con esto podemos ver el resultado
								var_dump($this->email->print_debugger());


									$this->session->set_flashdata('actualizado', 'Se ha turnado copia al departamento seleccionado');
									redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
								}

								else
								{
									$this->session->set_flashdata('error_actualizacion', 'No se ha turnado copia al departamento seleccionado, verifique');
									redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
								}	

							}
							else
							{
								$this->session->set_flashdata('error', ' Se esta tratando de turnar copia al mismo departamento');
								redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
							}
						}
					}
				}


				public function Descargar($name)
				{
					$data = file_get_contents($this->folder.$name); 
					force_download($name,$data); 
				}

		 /* Cambia el estatus de recepcion cuando la fecha actual ha sobrepasado la fecha de termino del oficio
  
		      BEGIN
				DECLARE fecha_actual DATE default DATE_FORMAT(now(),'%Y-%m-%d');
				DECLARE termino DATE;
				DECLARE nuevo_estatus VARCHAR(90);

				SELECT fecha_termino from recepcion_oficios where id_recepcion = idcurso into termino;

				IF (fecha_actual > termino)
					THEN
						UPDATE recepcion_oficios as t SET t.`status`='No Contestado' where t.id_recepcion = idcurso;
					END IF;
					
			 END
     */
			 public function CambiaEstatus()
			 {
			 	$consulta = $this->Modelo_recepcion->getAllEntradas();

			 	foreach ($consulta as $key) {
			 		$idoficio = $key->id_recepcion;

			 		if($this->db->query("CALL comparar_fechas('".$idoficio."')"))
			 		{
			 			echo 'Ejecutando Cambios';
			 		}else{
			 			show_error('Error! al ejecutar');
			 		}
			 	}

			 	redirect(base_url() . 'RecepcionGral/Entradas/Recepcion/');
			 }

			}