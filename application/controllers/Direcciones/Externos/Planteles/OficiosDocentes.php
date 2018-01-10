<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OficiosDocentes extends CI_Controller {

public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_planteles');
		$this -> load -> model('Modelo_recepcion');
		$this->folder = './doctosdocentes/';
	}

	public function index()
	{
		
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Oficios de Docentes';
			$data['docentes'] = $this -> Modelo_planteles -> getAllOficiosDocentes($this->session->userdata('id_direccion'));
			$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/planteles/docentes');
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
		$this -> form_validation -> set_rules('emisor_principal','Emisor','required');
		$this -> form_validation -> set_rules('cargo','Cargo','required');
		$this -> form_validation -> set_rules('dependencia','Dependencia','required');
		$this -> form_validation -> set_rules('remitente','Remitente','required');
		$this -> form_validation -> set_rules('cargo_remitente','Cargo Remitente','required');
		$this -> form_validation -> set_rules('dependencia_remitente','Dependencia Remitente','required');

		if ($this->form_validation->run() == FALSE) {
			# code...
				$data['titulo'] = 'Oficios de Docentes';
			$data['docentes'] = $this -> Modelo_planteles -> getAllOficiosDocentes($this->session->userdata('id_direccion'));
			$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/planteles/docentes');
			$this->load->view('plantilla/footer');	
		}
		else
		{
			
			$data =  array(
				$num_oficio = $this -> input -> post('num_oficio'),
				$asunto = $this -> input -> post('asunto'),
				$tipo_emision = $this -> input -> post('tipo_emision'),
				$tipo_documento = $this -> input -> post('tipo_documento'),
				$emisor_principal = $this -> input -> post('emisor_principal'),
				$dependencia = $this -> input -> post('dependencia'),	
				$cargo = $this -> input -> post('cargo'),
				$remitente = $this -> input -> post('remitente'),
				$cargo_remitente = $this -> input -> post('cargo_remitente'),
				$dependencia_remitente = $this -> input -> post('dependencia_remitente'),
				$observaciones = $this -> input -> post('observaciones'),
				$codigo_archivistico = $this -> input -> post('codigo_archivistico'),
				$requiere_respuesta = $this -> input -> post('ReqRespuesta'),
				$id_bachillerato = $this -> input -> post('id_bachillerato') 
			);


			if (isset($_POST['btn_enviar']))
			{
			// Cargamos la libreria Upload
				$this->load->library('upload');

        //CARGANDO SLIDER
				if (!empty($_FILES['archivo']['name']))
				{
            // Configuración para el Archivo 1
					$config['upload_path'] = './doctosdocentes/';
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
							redirect(base_url() . 'Direcciones/Externos/Planteles/OficiosDocentes');
						}

					}

				}

				//fecha y hora de recepcion se generan basado en el servidor 
				date_default_timezone_set('America/Mexico_City');
				$fecha_emision = date('Y-m-d');
				$hora_emision =  date("H:i:s");
				$status = 'Pendiente';
				if ($requiere_respuesta == 0) {
					$status = 'Contestado';
				}

				// Estatus por defecto es : Pendiente
				$agregar = $this->Modelo_planteles->agregarOficioDocentes($num_oficio,$fecha_emision,$hora_emision,$asunto,$tipo_emision, $tipo_documento, $emisor_principal, $dependencia,$cargo, $remitente, $cargo_remitente, $dependencia_remitente, $archivo_of,  $observaciones, $status, $codigo_archivistico,$requiere_respuesta, $id_bachillerato);


				if($agregar)
				{ 	

					$this->session->set_flashdata('exito', 'El número de oficio de salida:  '.$num_oficio. ' se ha ingresado correctamente');
					redirect(base_url() . 'Direcciones/Externos/Planteles/OficiosDocentes');
				}
				else
				{
					$this->session->set_flashdata('error', 'El número de oficio:  '.$num_oficio. ' no se ingresó, verifique la información');
					redirect(base_url() . 'Direcciones/Externos/Planteles/OficiosDocentes');
				}
			}
		}


		public function ModificarOficio()
		{

		$this -> form_validation -> set_rules('num_oficio','Número de Oficio','required');
		$this -> form_validation -> set_rules('asunto','Asunto','required');
		$this -> form_validation -> set_rules('remitente','Remitente','required');
		$this -> form_validation -> set_rules('emisor','Emisor','required');
		$this -> form_validation -> set_rules('cargo_emisor','Cargo del Emisor','required');
		$this -> form_validation -> set_rules('bachillerato_emisor','Bachillerato del Emisor','required');
		$this -> form_validation -> set_rules('cargo_remitente','Cargo Remitente','required');
		$this -> form_validation -> set_rules('dependencia_remitente','Dependencia Remitente','required');

			if ($this->form_validation->run() == FALSE) {
			# code...
		$data['titulo'] = 'Oficios de Docentes';
			$data['docentes'] = $this -> Modelo_planteles -> getAllOficiosDocentes($this->session->userdata('id_direccion'));
			$data['codigos'] = $this -> Modelo_recepcion-> getCodigos();
			$this->load->view('plantilla/header', $data);
			$this->load->view('directores/externos/planteles/docentes');
			$this->load->view('plantilla/footer');	
		}
		else
		{
			
				$data =  array(
				$id =  $this -> input -> post('txt_idoficio'),
				$num_oficio = $this -> input -> post('num_oficio'),
				$asunto = $this -> input -> post('asunto'),
				$tipo_emision = $this -> input -> post('tipo_emision'),
				$tipo_documento = $this -> input -> post('tipo_documento'),	
				$emisor = $this -> input -> post('emisor'),
				$cargo_emisor = $this -> input -> post('cargo_emisor'),
				$bachillerato_emisor = $this -> input -> post('bachillerato_emisor'),
				$remitente = $this -> input -> post('remitente'),
				$cargo_remitente = $this -> input -> post('cargo_remitente'),
				$dependencia_remitente = $this -> input -> post('dependencia_remitente'),
				$observaciones = $this -> input -> post('observaciones')
					);


					$actualizar = $this->Modelo_planteles->modificarOficioPlanteles($id, $num_oficio,$asunto,$tipo_emision, $tipo_documento, $emisor, $cargo_emisor, $bachillerato_emisor, $remitente, $cargo_remitente, $dependencia_remitente, $observaciones);
         

					if($actualizar)
					{ 	
						$this->session->set_flashdata('actualizado', 'El número de oficio de salida:  '.$num_oficio. ' fué modificado correctamente');
					redirect(base_url() . 'Direcciones/Externos/Planteles/OficiosDocentes');
					}

					else
					{
					$this->session->set_flashdata('error_actualizacion', 'El número de oficio de salida:  '.$num_oficio. ' no se modificó correctamente, verifique la información');
					redirect(base_url() . 'Direcciones/Externos/Planteles/OficiosDocentes');
					}		
				}	
			
		}

		public function Descargar($name)
		{
			$data = file_get_contents($this->folder.$name); 
        	force_download($name,$data); 
		}


}

/* End of file OficiosLocales.php */
/* Location: ./application/controllers/Direcciones/Externos/Planteles/OficiosLocales.php */