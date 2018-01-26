<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContestadosDeptos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_departamentos');
		$this->folder = './doctos/';
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Contestados';
		$data['contestados'] = $this -> Modelo_departamentos-> getAllContestados($this->session->userdata('id_area'));
		$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
		$this->load->view('plantilla/header', $data);
		$this->load->view('deptos/externos/contestadosdeptos');
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

	  function DescargarAnexos($name)
		{
			//$this->folder = './doctosanexos/';
			$data = file_get_contents(base_url().'doctosanexos/'.$name); 
        	force_download($name,$data); 
		}
			function DescargarRespuesta($name)
		{
			//$this->folder = './doctosrespuesta/';
			$data = file_get_contents(base_url().'doctosrespuesta/'.$name); 
        	force_download($name,$data); 
		}

}

/* End of file Contestados.php */
/* Location: ./application/controllers/Contestados.php */