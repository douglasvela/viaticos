<?php
$nr_usuario = $_GET["nr_usuario"];

if(!empty($nr_usuario)){

    $info_empleado = $this->db->query("SELECT ie.*, ecb.id_empleado_banco FROM vyp_informacion_empleado ie JOIN vyp_empleado_cuenta_banco ecb ON ecb.nr = ie.nr WHERE ecb.estado = 1 AND ie.nr = '".$nr_usuario."'");
    if($info_empleado->num_rows() > 0){ 
        foreach ($info_empleado->result() as $filas) {}

        $empleado_informacion = $this->db->query("SELECT eil.id_empleado_informacion_laboral, e.id_empleado, e.nr, UPPER(CONCAT_WS(' ', e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre_completo, telefono_contacto, e.correo, eil.id_empleado_informacion_laboral, cf.funcional, cn.cargo_nominal, eil.salario FROM sir_empleado e JOIN sir_empleado_informacion_laboral eil ON eil.id_empleado = e.id_empleado JOIN tcm_empleado_informacion_laboral veil ON veil.id_empleado = eil.id_empleado JOIN sir_cargo_funcional cf ON cf.id_cargo_funcional = eil.id_cargo_funcional JOIN sir_cargo_nominal cn ON cn.id_cargo_nominal = eil.id_cargo_nominal AND veil.fecha_inicio = eil.fecha_inicio AND e.nr = '".$nr_usuario."'");

    	$jefaturas = $this->db->query("SELECT e.nr, UPPER(CONCAT_WS(' ', e.primer_nombre, e.segundo_nombre, e.tercer_nombre, e.primer_apellido, e.segundo_apellido, e.apellido_casada)) AS nombre_completo FROM sir_empleado e WHERE e.nr = '".$filas->nr_jefe_inmediato."' OR e.nr = '".$filas->nr_jefe_departamento."'");

	    if($empleado_informacion->num_rows() > 0){ 
	        foreach ($empleado_informacion->result() as $filainfoe) {}
	    }

        $oficina_origen = $this->db->query("SELECT * FROM vyp_oficinas WHERE id_oficina = '".$filas->id_oficina_departamental."'");
    	$filaofi = "";
	    if($oficina_origen->num_rows() > 0){ 
	        foreach ($oficina_origen->result() as $filaofi) {}
	    }

		$exists = "";
		if(@file_get_contents( base_url()."assets/firmas/".$nr_usuario.".png" )){
			$exists = "existe";
		}else{
			$exists = "noesta";
		}

	    if($oficina_origen->num_rows() > 0 && $filas->nr_jefe_departamento != "" && $exists == "existe"){
	    	$nr_jefe_inmediato = $filas->nr_jefe_inmediato;
		    $nr_jefe_regional = $filas->nr_jefe_departamento;
		    $latitud_oficina = $filaofi->latitud_oficina;
		    $longitud_oficina = $filaofi->longitud_oficina;
		    $nombre_oficina = $filaofi->nombre_oficina;
		    $id_oficina_origen = $filaofi->id_oficina;
		    $jefe_inmediato = "";
		    $jefe_regional = "";
		    if($jefaturas->num_rows() > 0){ 
		        foreach ($jefaturas->result() as $filajefes) {
		        	if($nr_jefe_inmediato == $filajefes->nr){
		        		$jefe_inmediato = $filajefes->nombre_completo;
		        	}
		        	if($nr_jefe_regional == $filajefes->nr){
		        		$jefe_regional = $filajefes->nombre_completo;
		        	}
		        }
		    }

		    echo '<div class="alert alert-info">';
	    	echo '<h3 class="text-info"><i class="fa fa-check"></i> Datos para la solicitud</h3>';
	    	echo "<table width='100%'>
	    			<tbody>
	    				<tr>
	    					<td width='70%'><b>Persona solicitante:</b> $filainfoe->nombre_completo</td>
	    					<td width='30%'><b>NR:</b> $nr_usuario</td>
	    				</tr>
	    				<tr>
	    					<td width='70%'><b>Oficina:</b> $nombre_oficina</td>
	    					<td width='30%'><b>Salario:</b> $ ".number_format($filainfoe->salario,2)."</td>
	    				</tr>
	    				<tr>
	    					<td colspan='2'><b>Cargo nominal:</b> $filainfoe->cargo_nominal</td>
	    				</tr>
	    				<tr>
	    					<td colspan='2'><b>Cargo funcional:</b> $filainfoe->funcional</td>
	    				</tr>
	    				<tr>
	    					<td colspan='2'><b>Jefatura inmediata:</b> $jefe_inmediato</td>
	    				</tr>
	    				<tr>
	    					<td colspan='2'><b>Dirección o jefatura regional:</b> $jefe_regional</td>
	    				</tr>
	    			</tbody>
	    		</table>";
	    	echo '</div>';

	    }else{
	    	$nr_jefe_inmediato = "";
		    $nr_jefe_regional = "";
		    $latitud_oficina = "";
		    $longitud_oficina = "";
		    $nombre_oficina = "";
		    $id_oficina_origen = "";
		    echo '<div class="alert alert-danger">';
	    	echo '<h3 class="text-danger"><i class="fa fa-times-circle"></i> Faltan datos</h3>';
	    	echo "Parece que tus datos están incompletos. Solicita a fondo circulante que registren a que oficina perteneces, quien es tu jefatura inmediata, dirección de área o jefatura regional y firma escaneada si no estuviese registrada";
	    	echo '</div>';
	    }

	    echo '<input type="hidden" id="nr_jefe_inmediato" name="nr_jefe_inmediato" value="'.$nr_jefe_inmediato.'" required>';
		echo '<input type="hidden" id="nr_jefe_regional" name="nr_jefe_regional" value="'.$nr_jefe_regional.'" required>';
		echo '<input type="hidden" id="latitud_oficina" name="latitud_oficina" value="'.$latitud_oficina.'">';
		echo '<input type="hidden" id="longitud_oficina" name="longitud_oficina" value="'.$longitud_oficina.'">';
		echo '<input type="hidden" id="nombre_oficina" name="nombre_oficina" value="'.$nombre_oficina.'">';
		echo '<input type="hidden" id="id_oficina_origen" name="id_oficina_origen" value="'.$id_oficina_origen.'">';
		echo '<input type="hidden" id="id_empleado_informacion_laboral" name="id_empleado_informacion_laboral" value="'.$filainfoe->id_empleado_informacion_laboral.'">';

    }else{
    	echo '<div class="alert alert-danger">';
    	echo '<h3 class="text-danger"><i class="fa fa-times-circle"></i> Faltan datos</h3>';
    	echo "Parece que tus datos están incompletos. Solicita a fondo circulante que registren a que oficina perteneces, quien es tu jefatura inmediata, dirección de área o jefatura regional y firma escaneada si no estuviese registrada";
    	echo '</div>';
    	echo '<input type="text" style="display: none;" id="nr_jefe_inmediato" name="nr_jefe_inmediato" value="" required>';
		echo '<input type="text" style="display: none;" id="nr_jefe_regional" name="nr_jefe_regional" value="" required>';
    }
}

?>