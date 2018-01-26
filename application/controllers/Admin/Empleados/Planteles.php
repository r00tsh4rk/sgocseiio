<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planteles extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		//Load Dependencies
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Directores de Plantel';
			$data['planteles'] = $this -> Model_admin-> getAllDirectoresPlantel();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/empleados/planteles');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file Planteles.php */
/* Location: ./application/controllers/Admin/Empleados/Planteles.php */