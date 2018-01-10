<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContestadosInterno extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_direccion');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
		$data['titulo'] = 'Contestados';
		$data['contestados'] = $this -> Modelo_direccion -> getAllContestadosInternos($this->session->userdata('id_direccion'));
		$this->load->view('plantilla/header', $data);
		$this->load->view('directores/internos/contestadosdir');
		$this->load->view('plantilla/footer');	
		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}
	}

	public function Descargar($name)
	{
			$data = file_get_contents(base_url().'doctosinternos/'.$name); 
        	force_download($name,$data); 
	}

      function DescargarAnexos($name)
		{
			//$this->folder = './doctosanexos/';
			$data = file_get_contents(base_url().'doctosanexosinternos/'.$name); 
        	force_download($name,$data); 
		}
			function DescargarRespuesta($name)
		{
			//$this->folder = './doctosrespuesta/';
			$data = file_get_contents(base_url().'doctosrespuestainterna/'.$name); 
        	force_download($name,$data); 
		}


}

/* End of file ContestadosInterno.php */
/* Location: ./application/controllers/ContestadosInterno.php */