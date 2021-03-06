<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Oficinas extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('oficina_model');
	}

	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view('configuraciones/oficinas');
		$this->load->view('templates/footer');
	}
	public function mostrarComboMunicipi($id)
	{
		$objeto = explode("x", $id);
		$nuevo['id_departamento']=$objeto[0];
		$nuevo['id_municipio']=$objeto[1];

		$this->load->view('configuraciones/oficinas_ajax/comboMunicipio',$nuevo);
	}
	public function mostrarComboMunicipi2($id)
	{
		$objeto = explode("x", $id);
		$nuevo['id_departamento']=$objeto[0];
		$nuevo['id_municipio']=$objeto[1];

		$this->load->view('configuraciones/oficinas_ajax/comboMunicipio2',$nuevo);
	}

	public function mostrarDepartamento(){
		$data = array(
			'id_municipio' => $this->input->post('id_municipio')
		);
		echo $this->oficina_model->obtenerDepartamento($data);
	}

	public function mostrarCorreoJefe(){
		$data = array(
			'jefe_oficina' => $this->input->post('jefe_oficina')
		);
		echo $this->oficina_model->obtenerCorreoJefe($data);
	}

	public function tabla_oficinas(){
		$this->load->view('configuraciones/oficinas_ajax/tabla_oficinas');
	}

	public function tabla_oficina_autorizador(){
		$this->load->view('configuraciones/oficinas_ajax/tabla_oficina_autorizador');
	}

	public function tabla_telefonos($id){
		$objeto =  new stdClass();
		$objeto->id = $id;
		$this->load->view('configuraciones/oficinas_ajax/tabla_oficinas_phone',$objeto);
	}

	public function gestionar_oficinas(){
	
		if($this->input->post('band') == "save"){
			$data = array(
			'nombre_oficina' => $this->input->post('nombre_oficina'), 
			'direccion_oficina' => $this->input->post('direccion_oficina'),
			'jefe_oficina' => $this->input->post('jefe_oficina'),
			'email_oficina' => $this->input->post('email_oficina'),
			'latitud_oficina' => $this->input->post('latitud_oficina'),
			'longitud_oficina' => $this->input->post('longitud_oficina'),
			'id_departamento' => $this->input->post('id_departamento'),
			'id_municipio' => $this->input->post('id_municipio'),
			'id_zona' => $this->input->post('id_zona')
			);
			
                echo $this->oficina_model->insertar_oficina($data);
            
		}else if($this->input->post('band') == "edit"){
			
			$data = array(
			'id_oficina' => $this->input->post('id_oficina'), 
			'nombre_oficina' => $this->input->post('nombre_oficina'), 
			'direccion_oficina' => $this->input->post('direccion_oficina'),
			'jefe_oficina' => $this->input->post('jefe_oficina'),
			'email_oficina' => $this->input->post('email_oficina'),
			'latitud_oficina' => $this->input->post('latitud_oficina'),
			'longitud_oficina' => $this->input->post('longitud_oficina'),
			'id_departamento' => $this->input->post('id_departamento'),
			'id_municipio' => $this->input->post('id_municipio'),
			'id_zona' => $this->input->post('id_zona')
			);
			
				echo $this->oficina_model->editar_oficina($data);
			

		}else if($this->input->post('band') == "delete"){

			$data = array(
			'id_oficina' => $this->input->post('id_oficina')
			);
			echo $this->oficina_model->eliminar_oficina($data);

		}
	}
	public function gestionar_oficinas_telefonos(){
		if($this->input->post('band_phone') == "save"){
			$data = array(
			'telefono_vyp_oficnas_telefono' => $this->input->post('telefono_vyp_oficnas_telefono'), 
			'id_oficina_vyp_oficnas_telefono' => $this->input->post('id_oficina_vyp_oficnas_telefono')
			);
            echo $this->oficina_model->insertar_oficina_phone($data);
		}else if($this->input->post('band_phone')=="edit"){
			$data = array(
				'id_vyp_oficinas_telefono' => $this->input->post('id_vyp_oficinas_telefono'),
				'telefono_vyp_oficnas_telefono' => $this->input->post('telefono_vyp_oficnas_telefono')
			);
			echo $this->oficina_model->editar_oficina_phone($data);
		}else if($this->input->post('band_phone') == "delete"){
			$data = array(
			'id_vyp_oficinas_telefono' => $this->input->post('id_vyp_oficinas_telefono')
			);
			echo $this->oficina_model->eliminar_oficina_phone($data);
		}
	}

	public function gestionar_autorizador(){
		if($this->input->post('band') == "save"){
			$data = array(
				'id_oficina' => $this->input->post('id_oficina'),
				'nr_autorizador' => $this->input->post('nr_autorizador'),
				'id_sistema' => $this->input->post('id_sistema')
			);
            echo $this->oficina_model->insertar_oficina_autorizador($data);
		}else if($this->input->post('band')=="edit"){
			$data = array(
				'id_oficina_autorizador' => $this->input->post('id_oficina_autorizador'),
				'id_oficina' => $this->input->post('id_oficina'),
				'nr_autorizador' => $this->input->post('nr_autorizador'),
				'id_sistema' => $this->input->post('id_sistema')
			);
			echo $this->oficina_model->editar_oficina_autorizador($data);
		}else if($this->input->post('band') == "delete"){
			$data = array(
				'id_oficina_autorizador' => $this->input->post('id_oficina_autorizador')
			);
			echo $this->oficina_model->eliminar_oficina_autorizador($data);
		}
	}

	function verificar_dependencias(){
		$data = array(
			'id_oficina' => $this->input->post('id_oficina')
		);

		$valido_eliminar = $this->oficina_model->verificar_informacion_empleado($data); //verifica si la categoria tiene tarifa
		if($valido_eliminar != false){
			$informacion_empleado = '<ul>';
			foreach ($valido_eliminar->result() as $fila) {
				$informacion_empleado .= '<li>'.$fila->nombre_completo.'</li>';
			}
			$informacion_empleado .= '</ul>';
		}else{
			$informacion_empleado = "eliminar";
		}
		echo $informacion_empleado;
	}

}
?>