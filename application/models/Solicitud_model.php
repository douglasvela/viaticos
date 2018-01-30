<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitud_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}

	function insertar_mision($data){
		$id = $this->obtener_ultimo_id("vyp_mision_oficial","id_mision_oficial");
		if($this->db->insert('vyp_mision_oficial', array('id_mision_oficial' => $id, 'nr_empleado' => $data['nr'], 'nombre_completo' => $data['nombre_completo'], 'fecha_mision' => $data['fecha_mision'], 'actividad_realizada' => $data['actividad_realizada'], 'detalle_actividad' => $data['detalle_actividad']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function insertar_destino($data){
		$id = $this->obtener_ultimo_id("vyp_empresas_visitadas","id_empresas_visitadas");

		if($this->db->insert('vyp_empresas_visitadas', array('id_empresas_visitadas' => $id, 'id_mision_oficial' => $data['id_mision'], 'id_departamento' => $data['departamento'], 'id_municipio' => $data['municipio'], 'nombre_empresa' => $data['nombre_empresa'], 'direccion_empresa' => $data['direccion_empresa'], 'kilometraje' => $data['distancia'], 'tipo_destino' => $data['tipo'], 'id_destino' => $data['id_destino']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function insertar_ruta($data){
		if($data["tipo"] == "destino_oficina"){
			$query = $this->db->query("SELECT * FROM vyp_oficinas WHERE id_departamento = '".$data['departamento']."' AND id_municipio = '".$data['municipio']."'");
			if($query->num_rows() > 0){
				foreach ($query->result() as $fila) {
					$data['id_oficina_destino'] = $fila->id_oficina;
				}
			}
		}else{
			$data['id_oficina_destino'] = "0";
		}

		$data['id_destino'] = $this->obtener_ultimo_id("vyp_rutas","id_vyp_rutas");
		
		if($this->db->insert('vyp_rutas', array('id_vyp_rutas' => $data['id_destino'],
												'id_oficina_origen_vyp_rutas' => $data['id_oficina_origen'], 
												'id_oficina_destino_vyp_rutas' => $data['id_oficina_destino'], 
												'id_departamento_vyp_rutas' => $data['departamento'], 
												'id_municipio_vyp_rutas' => $data['municipio'],
												'km_vyp_rutas' => $data['distancia'], 
												'descripcion_destino_vyp_rutas' => $data['descripcion_destino'],
												'latitud_destino_vyp_rutas' => $data['latitud_destino'], 
												'longitud_destino_vyp_rutas' => $data['longitud_destino'],
												'opcionruta_vyp_rutas' => $data['tipo'], 
												'nombre_empresa_vyp_rutas' => $data['nombre_empresa'],
												'direccion_empresa_vyp_rutas' => $data['direccion_empresa'],
												'estado_vyp_rutas' => false))){

			return $this->solicitud_model->insertar_destino($data);
		}else{
			return "fracaso";
		}
	}

	function editar_mision($data){
		$this->db->where("id_mision_oficial",$data["id_mision"]);
		if($this->db->update('vyp_mision_oficial', array('fecha_mision' => $data['fecha_mision'], 'actividad_realizada' => $data['actividad_realizada'], 'detalle_actividad' => $data['detalle_actividad']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function estado_revision($data){
		$this->db->where("id_mision_oficial",$data);
		$fecha = date("Y-m-d H:i:s");
		if($this->db->update('vyp_mision_oficial', array('fecha_solicitud' => $fecha, 'estado' => 1))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_mision($data){
		if($this->db->delete("vyp_mision_oficial",array('id_mision_oficial' => $data['id_mision']))){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_empresas_visitadas($data){
		if($this->db->query($data)){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function eliminar_registros_viaticos($data){
		if($this->db->delete("vyp_viatico_empresa_horario",array('id_mision' => $data))){
			return true;
		}else{
			return false;
		}
	}

	function ordenar_empresas_visitadas($data){
		if($this->db->query($data)){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function guardar_registros_viaticos($data){
		if($this->db->query($data)){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function completar_tabla_viatico($data){
		if($this->db->query($data)){
			return "exito";
		}else{
			return "fracaso";
		}
	}

	function verficar_oficina_destino($data){
		$query = $this->db->query("SELECT * FROM vyp_empresas_visitadas WHERE id_mision_oficial = '".$data['id_mision']."' AND tipo_destino = 'destino_oficina' AND id_municipio = '".$data['municipio']."' AND id_departamento = '".$data['departamento']."'");
		if($query->num_rows() > 0){
			return "exito"; 
		}else{
			return $this->insertar_destino($data);
		}
	}

	function verficar_cumpla_kilometros($data){
		$query = $this->db->query("SELECT * FROM vyp_empresas_visitadas WHERE id_mision_oficial = '".$data['id_mision']."' AND kilometraje > 15");
		if($query->num_rows() > 0){
			return true; 
		}else{
			return false;
		}
	}

	function obtener_ultimo_id($tabla,$nombreid){
		$this->db->order_by($nombreid, "asc");
		$query = $this->db->get($tabla);
		$ultimoid = 0;
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila) {
				$ultimoid = $fila->$nombreid; 
			}
			$ultimoid++;
		}else{
			$ultimoid = 1;
		}
		return $ultimoid;
	}

	function obtener_ultima_mision($tabla,$nombreid,$nr){
		$query = $this->db->query("SELECT ".$nombreid." FROM ".$tabla." WHERE nr_empleado = '".$nr."' ORDER BY ".$nombreid." ASC");
		$ultimoid = 0;
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila) {
				$ultimoid = $fila->$nombreid; 
			}
		}else{
			$ultimoid = 1;
		}
		return $ultimoid;
	}

	function obtener_id_municipio($municipio){
		$query = $this->db->query("SELECT * FROM org_municipio WHERE municipio = '".$municipio."'");
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila) {
				$ultimoid = $fila->id_municipio; 
			}
		}else{
			$ultimoid = "fracaso";
		}
		return $ultimoid;
	}

	function obtener_id_departamento($municipio){
		$query = $this->db->query("SELECT * FROM org_municipio WHERE id_municipio = '".$municipio."'");
		if($query->num_rows() > 0){
			foreach ($query->result() as $fila) {
				$ultimoid = $fila->id_departamento_pais; 
			}
		}else{
			$ultimoid = "fracaso";
		}
		return $ultimoid;
	}
}