<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CopiasDirecciones extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_departamentos');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Copias a Direcciones';
			$data['copias_dir'] = $this -> Modelo_departamentos -> getBuzonDeCopiasDir($this->session->userdata('nombre'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/copiasdir');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file CopiasDirecciones.php */
/* Location: ./application/controllers/Departamentos/Interno/CopiasDirecciones.php */