<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendientes extends CI_Controller {

function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Pendientes';
			$data['pendientes'] = $this -> Modelo_recepcion -> getAllPendientes();
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/entradas/pendientes');
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

}

/* End of file Respuestas.php */
/* Location: ./application/controllers/RecepcionGral/Respuestas.php */