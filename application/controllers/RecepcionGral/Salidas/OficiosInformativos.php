<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OficiosInformativos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
		$this->folder = './doctos/';
	}


	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Oficios Informativos';
			$data['informativos'] = $this -> Modelo_recepcion -> getAllInformativosSalida();
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/salidas/informativos');
			$this->load->view('plantilla/footer');	

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}  
	}

}

/* End of file OficiosInformativos.php */
/* Location: ./application/controllers/RecepcionGral/Salidas/OficiosInformativos.php */