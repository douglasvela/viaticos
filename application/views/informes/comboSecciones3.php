
<?php
echo '<select id="" name="" class="form-control" onchange="" style="width: 100%"" required>';
echo '<option value="">[Elija el empleado]</option>';

$datos = $this->db->query("SELECT * FROM org_seccion where depende='$id_seccion'");

if($datos->num_rows() > 0){
    foreach ($datos->result() as $filadatos) {


echo '<option class="m-l-50"   value="'.$filadatos->id_seccion.'">'.$filadatos->id_seccion.$filadatos->nombre_seccion.'</option>';

    }
}

?>
  </select>
