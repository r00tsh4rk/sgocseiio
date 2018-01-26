<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_admin extends CI_Model {

	function __construct()
	{
		
	}

	public function getAllDirectoresArea()
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('empleados', 'direcciones.id_direccion = empleados.direccion');
		$this->db->where('empleados.isDir', 1);
		$this->db->where('direcciones.esOfCentrales', 1);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllDirectoresPlantel()
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('empleados', 'direcciones.id_direccion = empleados.direccion');
		$this->db->where('empleados.isDir', 1);
		$this->db->where('direcciones.esOfCentrales', 0);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllJefesDepto()
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('empleados', 'departamentos.id_area = empleados.departamento');
		$this->db->join('direcciones', 'direcciones.id_direccion = empleados.direccion');
		$this->db->where('isNull', 0);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllAccesos()
	{
		$this->db->select('*');
		$this->db->from('crtl_acceso');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getAllUsuarios()
	{
		$this->db->select('*');
		$this->db->from('usuarios');
		$consulta = $this->db->get();
		return $consulta -> result();
	}


	// -------------  ---- Empleados ----- ----------------
	// Agregar Jefe de Departamento
	public function addJefeDepto()
	{

	}

	//Actualizar o modificar informacion de un jefe de Departamento
	public function updateJefeDepto( $id = NULL )
	{

	}

	//Eliminar la información de un jefe de departamento
	public function deleteJefeDepto( $id = NULL )
	{

	}

	// -------------- ---- Directores de Área ---------------
	// Agregar Director de Área
	public function addDirectorArea()
	{

	}

	//Actualizar o modificar Director de Área
	public function updateDirectorArea( $id = NULL )
	{

	}

	//Eliminar la información de un Director de Área
	public function deleteDirectorArea( $id = NULL )
	{

	}

	// -------------- ---- Director de Plantel ---------------
	// Agregar Director de Área
	public function addDirectorPlantel()
	{

	}

	//Actualizar o modificar Director de Área
	public function updateDirectorPlantel( $id = NULL )
	{

	}

	//Eliminar la información de un Director de Área
	public function deleteDirectorPlantel( $id = NULL )
	{

	}



}

/* End of file Model_admin.php */
/* Location: ./application/models/Model_admin.php */



