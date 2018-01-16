<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitud extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('solicitud_model');
	}

	public function index(){
		$this->load->view('templates/header');
		$this->load->view('viaticos/solicitud_viatico');
		$this->load->view('templates/footer');
	}

	public function tabla_solicitudes(){
		$this->load->view('viaticos/complementos/tabla_solicitudes');
	}

	public function combo_oficinas_departamentos(){
		$this->load->view('viaticos/complementos/combo_oficinas_departamentos');
	}

	public function combo_municipios(){
		$this->load->view('viaticos/complementos/combo_municipio');
	}

	public function input_distancia(){
		$this->load->view('viaticos/complementos/input_distancia');
	}

	public function tabla_empresas_visitadas(){
		$this->load->view('viaticos/complementos/tabla_empresas_visitadas');
	}

	public function tabla_empresas_viaticos(){
		$this->load->view('viaticos/complementos/tabla_empresa_viaticos');
	}

	public function imprimir_solicitud(){
		$this->load->view('viaticos/complementos/imprimir_solicitud');
	}

	public function eliminar_destino(){
		$sql = "DELETE FROM vyp_empresas_visitadas WHERE id_empresas_visitadas = '".$this->input->post('id_empresa_visitada')."'";
		echo $this->solicitud_model->eliminar_empresas_visitadas($sql);
	}

	public function obtener_ultima_mision(){
		echo $this->solicitud_model->obtener_ultima_mision("vyp_mision_oficial","id_mision_oficial",$_POST['nr']);
	}

	public function ordenar_empresas_visitadas(){
		echo $this->solicitud_model->ordenar_empresas_visitadas($_POST['query']);
	}

	public function guardar_registros_viaticos(){
		if($this->solicitud_model->eliminar_registros_viaticos($_POST['id_mision'])){
			echo $this->solicitud_model->guardar_registros_viaticos($_POST['query']);
		}
	}

	public function completar_tabla_viatico(){
		//if($this->solicitud_model->eliminar_registros_viaticos($_POST['id_mision'])){
			echo $this->solicitud_model->completar_tabla_viatico($_POST['query']);
		//}
	}

	public function estado_revision(){
		//if($this->solicitud_model->eliminar_registros_viaticos($_POST['id_mision'])){
			echo $this->solicitud_model->estado_revision($_POST['id_mision']);
		//}
	}

	function cargar_viaticos(){
		$id_mision = $_POST['id_mision'];
        $horario_viaticos = $this->db->query("SELECT h.*, v.id_empresa FROM vyp_horario_viatico AS h JOIN vyp_viatico_empresa_horario AS v ON v.id_horario = h.id_horario_viatico AND v.id_mision = '$id_mision' UNION SELECT h.*, '' FROM vyp_horario_viatico AS h WHERE h.id_horario_viatico NOT IN (SELECT v.id_horario FROM vyp_viatico_empresa_horario AS v WHERE v.id_mision = '$id_mision')");

        $n = $horario_viaticos->num_rows();

        $retorno = "";

        if($horario_viaticos->num_rows() > 0){
            foreach ($horario_viaticos->result() as $fila) {
                $n--;
                if($n == 0){
                    $retorno .= "['".$fila->id_horario_viatico."', '".substr($fila->hora_inicio,0,5)."', '".substr($fila->hora_fin,0,5)."', '".$fila->descripcion."', '".$fila->monto."', '".$fila->id_empresa."',]";
                }else{
                    $retorno .= "['".$fila->id_horario_viatico."', '".substr($fila->hora_inicio,0,5)."', '".substr($fila->hora_fin,0,5)."', '".$fila->descripcion."', '".$fila->monto."', '".$fila->id_empresa."',]";
                }
            }
        }
        echo $retorno;
	}

	public function verficar_oficina_destino(){
		$data = array(
			'id_mision' => $this->input->post('id_mision'),
			'departamento' => '00006',//$this->input->post('nr'),
			'municipio' => '00097',//$this->input->post('nombre_empleado'),
			'nombre_empresa' => 'Oficina central (San Salvador)',
			'direccion_empresa' => 'San Salvador',
			'distancia' => '0.00',
			'tipo' => 'destino_oficina'
			);

		if($this->solicitud_model->verficar_cumpla_kilometros($data)){
			echo $this->solicitud_model->verficar_oficina_destino($data);
		}else{
			echo "viaticos";
		}
		
	}

	public function gestionar_mision(){
		if($this->input->post('band') == "save"){
			$data = array(
			'nr' => $this->input->post('nr'),
			'nombre_completo' => $this->input->post('nombre_empleado'),
			'fecha_mision' => date("Y-m-d",strtotime($this->input->post('fecha_mision'))),
			'actividad_realizada' => saltos_sql($this->input->post('actividad'))
			);
			echo $this->solicitud_model->insertar_mision($data);			
		}else if($this->input->post('band') == "edit"){
			$data = array(
			'id_mision' => $this->input->post('id_mision'), 
			'nr' => $this->input->post('nr'),
			'nombre_completo' => $this->input->post('nombre_empleado'),
			'fecha_mision' => date("Y-m-d",strtotime($this->input->post('fecha_mision'))),			
			'actividad_realizada' => saltos_sql($this->input->post('actividad'))
			);
			echo $this->solicitud_model->editar_mision($data);
		}else if($this->input->post('band') == "delete"){
			$data = array(
			'id_mision' => $this->input->post('id_mision')
			);

			$sql = "DELETE FROM vyp_empresas_visitadas WHERE id_mision_oficial = '".$this->input->post('id_mision')."'";
			
			if($this->solicitud_model->eliminar_empresas_visitadas($sql) == "exito" && $this->solicitud_model->eliminar_registros_viaticos($this->input->post('id_mision')) == true){
				echo $this->solicitud_model->eliminar_mision($data);
			}else{
				echo "fracaso";
			}
		}
	}


	public function gestionar_destinos(){
        if($this->input->post('band') == "save"){
			$data = array(
				"id_mision" => $this->input->post('id_mision'),
	            "departamento" => $this->input->post('departamento'),
	            "municipio" => $this->input->post('municipio'),
	            "nombre_empresa" => $this->input->post('nombre_empresa'),
	            "direccion_empresa" => $this->input->post('direccion_empresa'),
	            "distancia" => $this->input->post('distancia'),
	            "tipo" =>  $this->input->post('tipo'),
	            "band" => $this->input->post('band')
	        );
			echo $this->solicitud_model->insertar_destino($data);			
		}else if($this->input->post('band') == "edit"){
			$data = array(
	            "id_mision" => $this->input->post('id_mision'),
	            "departamento" => $this->input->post('departamento'),
	            "municipio" => $this->input->post('municipio'),
	            "nombre_empresa" => $this->input->post('nombre_empresa'),
	            "direccion_empresa" => $this->input->post('direccion_empresa'),
	            "distancia" => $this->input->post('distancia'),
	            "tipo" =>  $this->input->post('tipo'),
	            "band" => $this->input->post('band')
	        );
			echo $this->solicitud_model->editar_destino($data);
		}else if($this->input->post('band') == "delete"){
			$data = array(
	            "id_mision" => $this->input->post('id_mision'),
	            "departamento" => $this->input->post('departamento'),
	            "municipio" => $this->input->post('municipio'),
	            "nombre_empresa" => $this->input->post('nombre_empresa'),
	            "direccion_empresa" => $this->input->post('direccion_empresa'),
	            "distancia" => $this->input->post('distancia'),
	            "tipo" =>  $this->input->post('tipo'),
	            "band" => $this->input->post('band')
	        );
			echo $this->solicitud_model->eliminar_destino($data);
		}
		
	}
}
?>