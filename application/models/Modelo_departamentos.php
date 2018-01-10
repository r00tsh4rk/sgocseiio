<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_departamentos extends CI_Model {

	public function __construct()
	{
		parent::__construct();		
	}

	function getAllEntradas($iddepartamento)
	{
			$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.respondido', '0');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getInfoDepartamento($iddepartamento)
	{
			$this->db->select('*');
			$this->db->from('departamentos');
			$this->db->where('id_area', $iddepartamento);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

    function getAllPendientes($iddepartamento)
	{
			$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'Pendiente');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllContestados($iddepartamento)
	{
			$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		     $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		     $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllNoContestados($iddepartamento)
	{
			$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'No Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllFueraTiempo($iddepartamento)
	{
			$this->db->select('*');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		     $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		     $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'Fuera de Tiempo');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			$consulta = $this->db->get();
			return $consulta -> result();
}
	
	function agregarRespuesta($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $oficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico)
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
				'dependencia' => $dependencia,
				'receptor' => $receptor,
				'acuse_respuesta' =>  $respuesta,
				'anexos' =>  $anexos,
				'oficio_recepcion' =>  $id_oficio_recepcion,
				'codigo_archivistico' => $codigo_archivistico
				);
		//
			return $this -> db -> insert('respuesta_oficios', $data);
	}

	function actualizarBandera($id_oficio_recepcion)
	{
			$data = array(
                'respondido' => 1
                );

            $this->db->where('id_recepcion', $id_oficio_recepcion);
            return $this->db->update('recepcion_oficios', $data);
	}

 	function consultarFechaRecepcion($id_oficio_recepcion)
	{
		$this->db->select('fecha_termino');
		$this->db->from('recepcion_oficios');
		$this->db->where('id_recepcion', $id_oficio_recepcion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function actualizarStatusFueraDeTiempo($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Fuera de Tiempo'
                );

            $this->db->where('id_recepcion', $id_oficio_recepcion);
            return $this->db->update('recepcion_oficios', $data);
	}

	function actualizarStatusContesado($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Contestado'
                );

            $this->db->where('id_recepcion', $id_oficio_recepcion);
            return $this->db->update('recepcion_oficios', $data);
	}

	function asignarOf($id_direccion,$id_departamento,$id_oficio_recepcion,$observaciones)
	{
		$data = array(
				'id_direccion' => $id_direccion,
				'id_area' => $id_departamento,
				'id_recepcion' => $id_oficio_recepcion,
				'observaciones' => $observaciones
				);	

		return $this -> db -> insert('asignacion_oficio', $data);
	}

    function consultarNombreDepartamento($id_depto)
    {
    	$this->db->select('nombre_area');
		$this->db->from('departamentos');
		$this->db->where('id_area', $id_depto);
		$consulta = $this->db->get();
		return $consulta -> result();
    }

    function ModificarBanderaDeptos($idoficio)
    {
    	$data = array(
                'flag_deptos' => 1
                );

            $this->db->where('id_recepcion', $idoficio);
            return $this->db->update('recepcion_oficios', $data);
    }

     function getAsignaciones($id_direccion)
    {
    	$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('departamentos', 'direcciones.id_direccion = departamentos.direccion');
		$this->db->join('asignacion_oficio', 'departamentos.id_area = asignacion_oficio.id_area');
		$this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		$this->db->where('direcciones.id_direccion', $id_direccion);
		$consulta = $this->db->get();
		return $consulta -> result();
    }

    function eliminarAsignacionOf($idasignacion)
    {
    	$this->db->where('id_asignacion',$idasignacion);
		return $this->db->delete('asignacion_oficio');
    }

    function editarAsignacion($idasignacion, $depto)
    {
    	$data = array(
                'id_area' => $depto
                );

            $this->db->where('id_asignacion', $idasignacion);
            return $this->db->update('asignacion_oficio', $data);
    }

    // FUNCIONES PARA EL PROCESO INTERNO DE EMISION Y RESPUESTA OFICIOS PARA DIRECCIONES
    // 
    	function getDeptos($id_direccion) {
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->where('direccion', $id_direccion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	 function getAllEntradasInternas($nombre)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('emision_interna.emisor', $nombre);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getBuzonDeOficiosEntrantes($iddepartamento)
	{
		
			$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			$this->db->where('departamentos.id_area', $iddepartamento);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllPendientesInternos($iddepartamento)
	{
		$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();

		// $this->db->select('*');
		// $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //   $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Pendiente');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		// $consulta = $this->db->get();
		// return $consulta -> result();

	}

	function getAllContestadosInternos($iddepartamento)
	{

		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Contestado' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();

		 
	}

	function getAllNoContestadosInternos($iddepartamento)
	{
		$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();
	}

	function getAllFueraTiempoInternos($iddepartamento)
	{
			$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Fuera de Tiempo' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
			$consulta = $this->db->get();
			return $consulta -> result();

		// $this->db->select('*');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Fuera de Tiempo');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		// $consulta = $this->db->get();
		// return $consulta -> result();
	}

	function insertarEntrada($num_oficio, $fecha_recepcion, $hora_recepcion, $asunto, $tipo_recepcion,  $tipo_documento, $emisor, $cargo, $dependencia, $direccion, $fecha_termino, $archivo, $status, $prioridad, $observaciones, $flag_direccion, $tipo_dias, $reqRespuesta)
	{
		$data = array(
			'num_oficio' => $num_oficio,
			'fecha_emision' => $fecha_recepcion,
			'hora_emision' => $hora_recepcion,
			'asunto' => $asunto,
			'tipo_recepcion' => $tipo_recepcion,
			'tipo_documento' => $tipo_documento,
			'emisor' => $emisor,
			'cargo' => $cargo,
			'dependencia' => $dependencia,
			'direccion_destino' => $direccion,
			'fecha_termino' =>  $fecha_termino,
			'archivo_oficio' =>  $archivo,
			'status' =>  $status,
			'prioridad' =>  $prioridad,
			'observaciones' =>  $observaciones,
			'flag_direciones' =>  $flag_direccion,
			'tipo_dias' =>  $tipo_dias,
			'tieneRespuesta' => $reqRespuesta
		);
		//
		return $this -> db -> insert('emision_interna', $data);
	}


     function getAsignacionesInternas($id_direccion)
    {
    	$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('departamentos', 'direcciones.id_direccion = departamentos.direccion');
		$this->db->join('asignacion_interna', 'departamentos.id_area = asignacion_interna.id_area');
		$this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		$this->db->where('direcciones.id_direccion', $id_direccion);
		$consulta = $this->db->get();
		return $consulta -> result();
    }

    function eliminarAsignacionOfInternas($idasignacion)
    {
    	$this->db->where('id_asignacion_int',$idasignacion);
		return $this->db->delete('asignacion_interna');
    }

    function editarAsignacionInternas($idasignacion, $depto)
    {
    	$data = array(
                'id_area' => $depto
                );

            $this->db->where('id_asignacion_int', $idasignacion);
            return $this->db->update('asignacion_interna', $data);
    }

    function agregarRespuestaInterna($num_oficio,$fecha_respuesta,$hora_respuesta,$asunto,$tipo_recepcion, $tipo_documento, $numoficio_salida, $emisor, $cargo, $dependencia, $receptor, $respuesta, $anexos, $id_oficio_recepcion, $codigo_archivistico)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'fecha_respuesta' => $fecha_respuesta,
				'hora_respuesta' => $hora_respuesta,
				'asunto' => $asunto,
				'tipo_respuesta' => $tipo_recepcion,
				'tipo_documento' => $tipo_documento,
				'num_oficio_respuesta' => $numoficio_salida,
				'emisor' => $emisor,
				'cargo' => $cargo,
				'dependencia' => $dependencia,
				'receptor' => $receptor,
				'acuse_respuesta' =>  $respuesta,
				'anexos' =>  $anexos,
				'oficio_emision' =>  $id_oficio_recepcion,
				'codigo_archivistico' => $codigo_archivistico
				);
		//
			return $this -> db -> insert('respuesta_interna', $data);
	}

	function actualizarBanderaInt($id_oficio_recepcion)
	{
			$data = array(
                'respondido' => 1
                );

            $this->db->where('id_recepcion_int', $id_oficio_recepcion);
            return $this->db->update('emision_interna', $data);
	}

 	function consultarFechaRecepcionInt($id_oficio_recepcion)
	{
		$this->db->select('fecha_termino');
		$this->db->from('emision_interna');
		$this->db->where('id_recepcion_int', $id_oficio_recepcion);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function actualizarStatusFueraDeTiempoInt($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Fuera de Tiempo'
                );

            $this->db->where('id_recepcion_int', $id_oficio_recepcion);
            return $this->db->update('emision_interna', $data);
	}

	function actualizarStatusContesadoInt($id_oficio_recepcion)
	{
		$data = array(
                'status' => 'Contestado'
                );

            $this->db->where('id_recepcion_int', $id_oficio_recepcion);
            return $this->db->update('emision_interna', $data);
	}


	function modificarInfoOficioInterno($id,$num_oficio,$asunto,$tipo_recepcion, $tipo_documento, $emisor, $direccion, $fecha_termino, $status, $prioridad, $observaciones, $tipo_dias)
	{
		$data = array(
				'num_oficio' => $num_oficio,
				'asunto' => $asunto,
				'tipo_recepcion' => $tipo_recepcion,
				'tipo_documento' => $tipo_documento,
				'emisor' => $emisor,
				'direccion_destino' => $direccion,
				'fecha_termino' =>  $fecha_termino,
				'status' =>  $status,
				'prioridad' =>  $prioridad,
				'observaciones' =>  $observaciones, 
				'tipo_dias'  =>  $tipo_dias
				);

			$this->db->where('id_recepcion_int', $id);
			return $this -> db -> update('emision_interna', $data);
	}

		function asignarOficioInterno($id_direccion,$id_departamento,$id_oficio_recepcion,$observaciones)
	{
		$data = array(
				'id_direccion' => $id_direccion,
				'id_area' => $id_departamento,
				'id_recepcion' => $id_oficio_recepcion,
				'observaciones' => $observaciones
				);	

		return $this -> db -> insert('asignacion_interna', $data);
	}

	 function ModificarBanderaDeptosInt($idoficio)
    {
    	$data = array(
                'flag_deptos' => 1
                );

            $this->db->where('id_recepcion_int', $idoficio);
            return $this->db->update('emision_interna', $data);
    }

    function getAllDeptos() {
		$this->db->select('*');
		$this->db->from('departamentos');
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	function TurnarADireccion($id_depto, $id_oficio, $observaciones)
	{
		$data = array(
				'id_direccion_destino' => $id_depto,
				'id_oficio_emitido' => $id_oficio,
				'observacion' => $observaciones
				);	

		return $this -> db -> insert('turnado_copias_dir', $data);
	}

	function TurnarADeptos($id_depto, $id_oficio, $observaciones)
	{
		$data = array(
				'id_depto_destino' => $id_depto,
				'id_oficio_emitido' => $id_oficio,
				'observacion' => $observaciones
				);	

		return $this -> db -> insert('turnado_copias_deptos', $data);
	}

	function getBuzonDeCopias($id_depto)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('turnado_copias_deptos', 'departamentos.id_area = turnado_copias_deptos.id_depto_destino');
		$this->db->join('emision_interna', 'turnado_copias_deptos.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('turnado_copias_deptos.id_depto_destino', $id_depto);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getBuzonDeCopiasDir($nombre)
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('turnado_copias_dir', 'direcciones.id_direccion= turnado_copias_dir.id_direccion_destino');
		$this->db->join('emision_interna', 'turnado_copias_dir.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('emision_interna.emisor', $nombre);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

		public function getBuzonDeCopiasDepto($nombre)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('turnado_copias_deptos', 'departamentos.id_area= turnado_copias_deptos.id_depto_destino');
		$this->db->join('emision_interna', 'turnado_copias_deptos.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('emision_interna.emisor', $nombre);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getCodigos()
	{
		$this->db->select('*');
		$this->db->from('codigos_archivisticos');
		$this->db->order_by('seccion', 'asc');
		$consulta = $this->db->get();
		return $consulta -> result();
	}


	function getBuzonDeCopiasExt($id_depto)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('turnado_copias_depto_externa', 'departamentos.id_area = turnado_copias_depto_externa.id_depto_destino');
		$this->db->join('recepcion_oficios', 'turnado_copias_depto_externa.id_recepcion = recepcion_oficios.id_recepcion');
		$this->db->where('turnado_copias_depto_externa.id_depto_destino', $id_depto);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function getBuzonDeCopiasDirExt($nombre)
	{
		$this->db->select('*');
		$this->db->from('direcciones');
		$this->db->join('turnado_copias_dir', 'direcciones.id_direccion= turnado_copias_dir.id_direccion_destino');
		$this->db->join('emision_interna', 'turnado_copias_dir.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('emision_interna.emisor', $nombre);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

		public function getBuzonDeCopiasDeptoExt($nombre)
	{
		$this->db->select('*');
		$this->db->from('departamentos');
		$this->db->join('turnado_copias_deptos', 'departamentos.id_area= turnado_copias_deptos.id_depto_destino');
		$this->db->join('emision_interna', 'turnado_copias_deptos.id_oficio_emitido = emision_interna.id_recepcion_int');
		$this->db->where('emision_interna.emisor', $nombre);
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	/* CONSULTAS PARA PANEL ESTADISTICO */


	function conteo_totalExt($iddepartamento)
	{
			$this->db->select('recepcion_oficios.respondido');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.respondido', '0');
			return $this->db->count_all_results();
	}

    function pendientesExt($iddepartamento)
	{
			$this->db->select('recepcion_oficios.id_recepcion');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'Pendiente');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			return $this->db->count_all_results();
	}

	function contestadosExt($iddepartamento)
	{
			$this->db->select('recepcion_oficios.id_recepcion');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		     $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		     $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			return $this->db->count_all_results();
	}

	function nocontestadosExt($iddepartamento)
	{
			$this->db->select('recepcion_oficios.id_recepcion');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'No Contestado');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			return $this->db->count_all_results();
	}

	function fuera_de_tiempoExt($iddepartamento)
	{
			$this->db->select('recepcion_oficios.id_recepcion');
			$this->db->select('recepcion_oficios.emisor as emisor_externo, recepcion_oficios.cargo as cargo_externo, recepcion_oficios.dependencia_emite as dependencia_externo');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_oficio', 'asignacion_oficio.id_area = departamentos.id_area');
		     $this->db->join('recepcion_oficios', 'recepcion_oficios.id_recepcion = asignacion_oficio.id_recepcion');
		     $this->db->join('respuesta_oficios', 'recepcion_oficios.id_recepcion = respuesta_oficios.oficio_recepcion');
		     $this->db->join('codigos_archivisticos', 'respuesta_oficios.codigo_archivistico = codigos_archivisticos.id_codigo');
			$this->db->where('asignacion_oficio.id_area', $iddepartamento);
			$this->db->where('recepcion_oficios.status', 'Fuera de Tiempo');
			$this->db->group_by('recepcion_oficios.id_recepcion');
			return $this->db->count_all_results();
}

// PROCESO INTERNO

	 function emitidosInt($nombre)
	{
			$this->db->select('*');
			$this->db->from('emision_interna');
		    $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
			$this->db->where('emision_interna.emisor', $nombre);
			return $this->db->count_all_results();
	}

	function conteo_totalInt($iddepartamento)
	{
		
			$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			$this->db->where('asignacion_interna.id_area', $iddepartamento);
			return $this->db->count_all_results();
	}

	function pendientesInt($iddepartamento)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //   $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Pendiente');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

	function contestadosInt($iddepartamento)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Contestado');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Contestado' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

	function nocontestadosInt($iddepartamento)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
	 //    $this->db->from('emision_interna');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'No Contestado');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		$this->db->select('*');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Pendiente' OR emision_interna.status = 'No Contestado' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

	function fuera_de_tiempoInt($iddepartamento)
	{
		// $this->db->select('emision_interna.id_recepcion_int');
		// $this->db->from('emision_interna');
		// $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		// $this->db->join('direcciones', 'emision_interna.direccion_destino = direcciones.id_direccion');
	 //    $this->db->where('emision_interna.emisor', $nombre);
		// $this->db->where('emision_interna.status', 'Fuera de Tiempo');
		// $this->db->group_by('emision_interna.id_recepcion_int');
		$this->db->select('*');
		$this->db->select('emision_interna.emisor as emisorexterno, emision_interna.cargo as cargoexterno');
			$this->db->from('departamentos');
		    $this->db->join('asignacion_interna', 'asignacion_interna.id_area = departamentos.id_area');
		    $this->db->join('emision_interna', 'emision_interna.id_recepcion_int = asignacion_interna.id_recepcion');
		    $this->db->join('respuesta_interna', 'emision_interna.id_recepcion_int = respuesta_interna.oficio_emision');
		    $this->db->join('codigos_archivisticos', 'respuesta_interna.codigo_archivistico = codigos_archivisticos.id_codigo');
		    $this->db->join('direcciones', 'asignacion_interna.id_direccion = direcciones.id_direccion');
			//$this->db->where('asignacion_interna.id_area', $iddepartamento);
			$where = "emision_interna.status = 'Fuera de Tiempo' AND asignacion_interna.id_area = '".$iddepartamento."'";
			$this->db->where($where, NULL, FALSE);
		return $this->db->count_all_results();
	}

	public function obtenerCorreoDireccionInterno($id_direccion)
	{
		$this->db->select('email');
		$this->db->from('empleados');
		$where = "direccion='".$id_direccion."' AND isDir = '1'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}

	public function obtenerCorreoPersonalInterno($id_direccion)
	{
		$this->db->select('email_personal');
		$this->db->from('empleados');
		$where = "direccion='".$id_direccion."' AND isDir = '1'";
		$this->db->where($where, NULL, FALSE);	
		$consulta = $this->db->get();
		return $consulta -> result();
	}
}

/* End of file Modelo_departamentos.php */
/* Location: ./application/models/Modelo_departamentos.php */