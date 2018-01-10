<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_planteles extends CI_Model {

	public function __construct()
	{
		parent::__construct();		
	}

	function getAllOficiosSalidaPlanteles($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('oficios_salida_planteles');
		$this->db->join('codigos_archivisticos', 'oficios_salida_planteles.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->where('oficios_salida_planteles.id_direccion', $id_direccion);
		$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllContestados()
	{
			$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('recepcion_oficios');
			 $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');

			$where = "recepcion_oficios.status = 'Contestado'";

			$this->db->where($where, NULL, FALSE);	

			//$this->db->where('recepcion_oficios.status', 'Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllFueraTiempo()
	{
			$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('recepcion_oficios');
			 $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
			  $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->join('direcciones', 'recepcion_oficios.direccion_destino = direcciones.id_direccion');
			$this->db->join('departamentos', 'departamentos.direccion = direcciones.id_direccion');
			$this->db->where('recepcion_oficios.status', 'Fuera de Tiempo');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllInformativosSalida($id_direccion)
	{
			$this->db->select('*');
			$this->db->from('oficios_salida_planteles');
			$this->db->join('codigos_archivisticos', 'codigo_archivistico = id_codigo');
			$this->db->where('tieneRespuesta', 0);
			$this->db->where('oficios_salida_planteles.id_direccion', $id_direccion);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	public function getAllRespuestasASalidas($id_direccion)
	{
		$this->db->select('*');
		$this->db->select('oficios_salida_planteles.cargo as cargoemisor');
		$this->db->from('oficios_salida_planteles');
		$this->db->join('codigos_archivisticos', 'oficios_salida_planteles.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->join('respuesta_salida_planteles', 'oficios_salida_planteles.id_oficio_salida = respuesta_salida_planteles.oficio_emision');
		$this->db->where('oficios_salida_planteles.id_direccion', $id_direccion);
		$consulta = $this->db->get();
			return $consulta -> result();
	}

	//OPERACIONES
	
	public function agregarOficioSalida($num_oficio,$fecha_emision,$hora_emision,$asunto,$tipo_emision, $tipo_documento, $emisor_principal,$dependencia,$cargo, $remitente, $cargo_remitente, $dependencia_remitente, $archivo,$observaciones,$status, $codigo_archivistico, $requiere_respuesta, $id_direccion)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'fecha_emision' => $fecha_emision,
				'hora_emision' => $hora_emision,
				'asunto' => $asunto,
				'tipo_emision' => $tipo_emision,
				'tipo_documento' => $tipo_documento,
				'emisor' => $emisor_principal,
				'bachillerato' => $dependencia,
				'cargo' => $cargo,
				'remitente' => $remitente,
				'cargo_remitente' => $cargo_remitente,
				'dependencia_remitente' => $dependencia_remitente,
				'archivo' => $archivo,
				'observaciones' =>  $observaciones,
				'status' =>  $status,
				'codigo_archivistico' => $codigo_archivistico,
				'tieneRespuesta' => $requiere_respuesta,
				'id_direccion' => $id_direccion
				);	

		return $this -> db -> insert('oficios_salida_planteles', $data);
	}

		public function modificarOficioSalida($id, $num_oficio,$asunto,$tipo_emision, $tipo_documento,  $remitente, $cargo_remitente, $dependencia_remitente, $observaciones )
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'asunto' => $asunto,
				'tipo_emision' => $tipo_emision,
				'tipo_documento' => $tipo_documento,
				'remitente' => $remitente,
				'cargo_remitente' => $cargo_remitente,
				'dependencia_remitente' => $dependencia_remitente,
				'observaciones' =>  $observaciones
				);	

		$this->db->where('id_oficio_salida', $id);
		return $this -> db -> update('oficios_salida_planteles', $data);
	}


	   public function agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico)
    {
    	$data = array(
				'num_oficio' => $num_oficio,
				'fecha_respuesta' => $fecha_respuesta,
				'hora_respuesta' => $hora_respuesta,
				'asunto' => $asunto,
				'tipo_respuesta' => $tipo_recepcion,
				'tipo_documento' => $tipo_documento,
				'num_oficio_salida' => $oficio_salida,
				'emisor' => $emisor,
				'cargo' => $cargo,
				'dependencia_emisor' => $dependencia,
				'receptor' => $receptor,
				'acuse_respuesta' =>  $respuesta,
				'anexos' =>  $anexos,
				'oficio_emision' =>  $id_oficio_recepcion,
				'codigo_archivistico' => $codigo_archivistico
				);
		//
			return $this -> db -> insert('respuesta_salida_planteles', $data);
    }

    function actualizarStatusContesado($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Contestado'
                );

            $this->db->where('id_oficio_salida', $id_oficio_recepcion);
            return $this->db->update('oficios_salida_planteles', $data);
	}

	function actualizarBandera($id_oficio_recepcion)
	{
			$data = array(
                'fue_respondido' => 1
                );

            $this->db->where('id_oficio_salida', $id_oficio_recepcion);
            return $this->db->update('oficios_salida_planteles', $data);
	}

	//ESTADISTICA
	
	public function conteo_totalExt($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('oficios_salida_planteles');
		$this->db->join('codigos_archivisticos', 'oficios_salida_planteles.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->where('oficios_salida_planteles.id_direccion', $id_direccion);
		return $this->db->count_all_results();
	}

	 public function conteo_totalInt($id_direccion)
    {
    		$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);
			 return $this->db->count_all_results();
    }


     function emitidosInt($id_direccion)
	{


			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);

			// $this->db->select('*');
			// $this->db->from('emision_interna');
		 //    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			// $this->db->where('emision_interna.emisor', $nombre);
			return $this->db->count_all_results();
	}

	function pendientesInt($id_direccion)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //   $this->db->where('emision_interna.emisor', $nombre);
		// $where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado'";
		// $this->db->where($where, NULL, FALSE);
		// //$this->db->where('emision_interna.status', 'Pendiente');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);

			$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

	function contestadosInt($id_direccion)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Contestado');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		
			$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
		$this->db->from('emision_interna');
		$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		$this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
		$this->db->where('direcciones.id_direccion', $id_direccion);
		$where = "emision_interna.status = 'Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
		$this->db->where($where, NULL, FALSE);
		
		return $this->db->count_all_results();
	}

	function nocontestadosInt($id_direccion)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
	 //    $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'No Contestado');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);

			$where = "emision_interna.status = 'No Contestado' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

	function fuera_de_tiempoInt($id_direccion)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Fuera de Tiempo');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('emision_interna');
			$this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		$this->db->join('codigos_archivisticos', 'codigos_archivisticos.id_codigo = respuesta_interna.codigo_archivistico');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('direcciones.id_direccion', $id_direccion);
			$where = "emision_interna.status = 'Fuera de Tiempo' AND direcciones.id_direccion = '".$id_direccion."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}
	//Proceso interno del plantel: Relación Docentes - Director 
	public function getAllOficiosDocentes($id_direccion)
	{
		$this->db->select('*');
		$this->db->from('oficios_docentes');
		$this->db->join('codigos_archivisticos', 'oficios_docentes.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->where('oficios_docentes.id_direccion', $id_direccion);
		$consulta = $this->db->get();
			return $consulta -> result();
	}

	public function getAllRespuestaDocentes($id_direccion)
	{
		$this->db->select('*');
		//$this->db->select('oficios_docentes.cargo as cargoemisor');
		$this->db->from('oficios_docentes');
		$this->db->join('codigos_archivisticos', 'oficios_docentes.codigo_archivistico = codigos_archivisticos.id_codigo');
		$this->db->join('respuesta_docentes', 'oficios_docentes.id_oficio_salida = respuesta_docentes.oficio_emision');
		$this->db->where('oficios_docentes.id_direccion', $id_direccion);
		$consulta = $this->db->get();
			return $consulta -> result();
	}



	public function agregarOficioDocentes($num_oficio,$fecha_emision,$hora_emision,$asunto,$tipo_emision, $tipo_documento, $emisor_principal,$dependencia,$cargo, $remitente, $cargo_remitente, $dependencia_remitente, $archivo,$observaciones,$status, $codigo_archivistico, $requiere_respuesta, $id_direccion)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'fecha_emision' => $fecha_emision,
				'hora_emision' => $hora_emision,
				'asunto' => $asunto,
				'tipo_emision' => $tipo_emision,
				'tipo_documento' => $tipo_documento,
				'emisor_docente' => $emisor_principal,
				'bachillerato' => $dependencia,
				'cargo_docente' => $cargo,
				'remitente' => $remitente,
				'cargo_remitente' => $cargo_remitente,
				'dependencia_remitente' => $dependencia_remitente,
				'archivo' => $archivo,
				'observaciones' =>  $observaciones,
				'status' =>  $status,
				'codigo_archivistico' => $codigo_archivistico,
				'tieneRespuesta' => $requiere_respuesta,
				'id_direccion' => $id_direccion
				);	

		return $this -> db -> insert('oficios_docentes', $data);
	}

	public function modificarOficioPlanteles($id, $num_oficio,$asunto,$tipo_emision, $tipo_documento, $emisor, $cargo_emisor, $bachillerato_emisor, $remitente, $cargo_remitente, $dependencia_remitente, $observaciones)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'asunto' => $asunto,
				'tipo_emision' => $tipo_emision,
				'tipo_documento' => $tipo_documento,
				'emisor_docente' => $emisor,
				'cargo_docente' => $cargo_emisor,
				'bachillerato' => $bachillerato_emisor,
				'remitente' => $remitente,
				'cargo_remitente' => $cargo_remitente,
				'dependencia_remitente' => $dependencia_remitente,
				'observaciones' =>  $observaciones
				);	

		$this->db->where('id_oficio_salida', $id);
		return $this -> db -> update('oficios_docentes', $data);
	}

	public function agregarRespuestaDocentes($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $cargo_receptor, $plantel_receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico)
    {
    	$data = array(
				'num_oficio' => $num_oficio,
				'fecha_respuesta' => $fecha_respuesta,
				'hora_respuesta' => $hora_respuesta,
				'asunto' => $asunto,
				'tipo_respuesta' => $tipo_recepcion,
				'tipo_documento' => $tipo_documento,
				'num_oficio_salida' => $oficio_salida,
				'emisor' => $emisor,
				'cargo' => $cargo,
				'dependencia_emisor' => $dependencia,
				'receptor' => $receptor,
				'cargo_receptor' => $cargo_receptor,
				'bachillerato_receptor' => $plantel_receptor,
				'acuse_respuesta' =>  $respuesta,
				'anexos' =>  $anexos,
				'oficio_emision' =>  $id_oficio_recepcion,
				'codigo_archivistico' => $codigo_archivistico
				);
		//
			return $this -> db -> insert('respuesta_docentes', $data);
    }

    function actualizarBanderaDocentes($id_oficio_recepcion)
	{
			$data = array(
                'fue_respondido' => 1
                );

            $this->db->where('id_oficio_salida', $id_oficio_recepcion);
            return $this->db->update('oficios_docentes', $data);
	}

	 function actualizarStatusContesadoDocentes($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Contestado'
                );

            $this->db->where('id_oficio_salida', $id_oficio_recepcion);
            return $this->db->update('oficios_docentes', $data);
	}
}

/* End of file Modelo_planteles.php */
/* Location: ./application/models/Modelo_planteles.php */