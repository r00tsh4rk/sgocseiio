<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CopiasDeptos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_recepcion');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Copias a Departamentos';
			$data['copias_deptos'] = $this -> Modelo_recepcion -> getBuzonDeCopiasDepto($this->session->userdata('nombre'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/entradas/copiasdepto');
			$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

}

/* End of file CopiasDeptos.php */
/* Location: ./application/controllers/CopiasDeptos.php */