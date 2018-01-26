<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		//Load Dependencies

	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Monitor de Accesos';
			$data['accesos'] = $this -> Model_admin-> getAllAccesos();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/accesos/monitor');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}
	}

}

/* End of file Monitor.php */
/* Location: ./application/controllers/Admin/Accesos/Monitor.php */