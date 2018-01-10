<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanelAdmin extends CI_Controller {

	public function index()
	{
		if ($this->session->userdata('nombre')) {
			$data['titulo'] = 'Calendario Escolar';
			$this->load->view('plantilla/header', $data);
			$this->load->view('admin/index');
			$this->load->view('plantilla/footer');
			}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		}  
	}

}