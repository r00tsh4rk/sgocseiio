<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GestUsuarios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Model_admin');
		//Load Dependencies

	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Gestión de Usuarios';
			$data['usuarios'] = $this -> Model_admin-> getAllUsuarios();
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/usuarios/gestusuarios');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file GestUsuarios.php */
/* Location: ./application/controllers/Admin/Usuarios/GestUsuarios.php */