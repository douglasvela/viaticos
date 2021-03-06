<div class="card">
    <div class="card-header">
        <div class="card-actions">
           
        </div>
        <h4 class="card-title m-b-0">Listado de oficinas</h4>
    </div>
    <div class="card-body b-t"  style="padding-top: 7px;">
        <div class="pull-right">
            <?php 
            if(tiene_permiso($segmentos=2,$permiso=2)){
            ?>
            <button type="button" onclick="cambiar_nuevo();" class="btn waves-effect waves-light btn-success2"><span class="mdi mdi-plus"></span> Nuevo registro</button>
            <?php } ?>
        </div>
        <div class="table-responsive">
            <table id="myTable" class="table table-bordered product-overview">
                <thead class="bg-info text-white">
                    <tr>
                        <th>Id</th>
                        <th>Nombre de la oficina</th>
                        <!-- <th>Dirección de la Oficina</th> -->
                        <th>Jefatura de la oficina</th>
                        <th>Depto.</th>
                        <th>Municipio</th>
                        <th>Tel.</th>
                        <th style="min-width: 85px;">(*)</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                	$oficinas = $this->db->get("vyp_oficinas");
                    if($oficinas->num_rows() > 0){
                        $puede_editar = tiene_permiso($segmentos=2,$permiso=4);
                        $puede_eliminar = tiene_permiso($segmentos=2,$permiso=3);
                        foreach ($oficinas->result() as $fila) {
                            echo "<tr>";
                            echo "<td>".$fila->id_oficina."</td>";
                            echo "<td>".$fila->nombre_oficina."</td>";
                            //echo "<td>".$fila->direccion_oficina."</td>";
                            $this->db->where("id_empleado",$fila->jefe_oficina);
                            $emple = $this->db->get("sir_empleado");
                            if($emple->num_rows()>0){
                                foreach ($emple->result() as $keyemple) {
                                echo "<td>".$keyemple->primer_nombre." ".$keyemple->segundo_nombre." ".$keyemple->primer_apellido." ".$keyemple->segundo_apellido."</td>";
                                }
                            }else{
                                echo "<td>-</td>";
                            }

                            //echo "<td>".$fila->jefe_oficina."</td>";
                            $this->db->where("id_departamento",$fila->id_departamento);
                            $depto = $this->db->get("org_departamento");
                            if($depto->num_rows()>0){
                                foreach ($depto->result() as $keydepto) {
                                  echo "<td>".$keydepto->departamento."</td>";
                                }
                            }else{
                                echo "<td>-</td>";   
                            }
                           
                           $this->db->where("id_municipio",$fila->id_municipio);
                            $munic = $this->db->get("org_municipio");
                            if($munic->num_rows()>0){
                                foreach ($munic->result() as $keymunic) {
                                  echo "<td>".$keymunic->municipio."</td>";
                                }
                            }else{
                                echo "<td>-</td>";      
                            }

                            /******* botón para la gestión de TELEFONOS **********/
                            echo "<td>";
                                if($puede_editar){
                                    $arrayTel = array($fila->id_oficina,$fila->nombre_oficina);
                                    echo generar_boton($arrayTel,"cambiar_phone","btn-info","mdi mdi-phone-plus","Teléfono(s)");
                                }
                            echo "</td>";

                            /******* botones para la edición de OFICINAS **********/
                            echo "<td>";
                              $array = array($fila->id_oficina, $fila->nombre_oficina, $fila->direccion_oficina, $fila->jefe_oficina, $fila->email_oficina, $fila->latitud_oficina,$fila->longitud_oficina,$fila->id_departamento,$fila->id_municipio,$fila->id_zona);
                               if($puede_editar){
                                    array_push($array, "edit");
                                    echo generar_boton($array,"cambiar_editar","btn-info","fa fa-wrench","Editar");
                                    unset($array[endKey($array)]); //eliminar el ultimo elemento de un array
                                }
                                if($puede_eliminar){
                                    array_push($array, "delete");
                                    echo generar_boton($array,"cambiar_editar","btn-danger","fa fa-close","Eliminar");
                                }
                            echo "</td>";

                           echo "</tr>";
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>