<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JefesDepto extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Jefes de Departamento';
			$data['jefes'] = $this -> Model_admin-> getAllJefesDepto();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/empleados/jefesdepto');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file JefesDepto.php */
/* Location: ./application/controllers/Admin/Empleados/JefesDepto.php */