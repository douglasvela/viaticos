<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poliza_presupuesto extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('poliza_presupuesto_model');
		$this->load->library('mpdf');
	}

	public function index(){
		$this->load->view('templates/header');
		$this->load->view('poliza/poliza_presupuesto');
		$this->load->view('templates/footer');
	}

	public function tabla_generar_poliza(){
		$this->load->view('poliza/ajax_poliza_presupuesto/tabla_generar_poliza');
	}

	public function tabla_poliza(){
		$this->load->view('poliza/ajax_poliza_presupuesto/tabla_poliza');
	}

	public function imprimir_poliza(){
		$this->load->view('poliza/ajax_poliza_presupuesto/imprimir_poliza');
	}

	function editar_poliza(){
		$data = array(
			'sql' => $this->input->post('sql'), 
			'no_poliza' => $this->input->post('no_poliza'),
			'anio' => $this->input->post('anio')
		);

		echo $this->poliza_presupuesto_model->editar_poliza($data);
	}

	function eliminar_poliza(){
		echo $this->poliza_presupuesto_model->eliminar_poliza($this->input->post('no_poliza'));
	}

	/*public function calcular_viaticos(){
		$data = array(
			'hora_inicio' => $this->input->post('hora_inicio'), 
			'hora_fin' => $this->input->post('hora_fin')
		);
		$res = $this->solicitud_model->calcular_viaticos($data);
		$suma = 0;
		if($res->num_rows() > 0){
			foreach ($res->result() as $fila) {
				$suma += $fila->monto; 
			}
		}

		echo number_format($suma, 2, '.', '');
	}

	/*public function gestionar_bancos(){		

		if($this->input->post('band') == "save"){

			$data = array(
			'nombre' => $this->input->post('nombre'), 
			'caracteristicas' => $this->input->post('caracteristicas')
			);
			echo $this->bancos_model->insertar_banco($data);
			
		}else if($this->input->post('band') == "edit"){
			$data = array(
			'idb' => $this->input->post('idb'), 
			'nombre' => $this->input->post('nombre'), 
			'caracteristicas' => $this->input->post('caracteristicas')

			);
			echo $this->bancos_model->editar_banco($data);

		}else if($this->input->post('band') == "delete"){

			$data = array(
			'idb' => $this->input->post('idb')
			);
			echo $this->bancos_model->eliminar_banco($data);

		}
	}*/
}
?>