<?php 
                    $id_mision = $_GET["id_mision"];                   
                    $correlativo = 0;
                    $query = $this->db->query("SELECT * FROM vyp_observaciones_pasajes WHERE id_mision_pasajes = '".$id_mision."' AND corregido = 0");
                    if($query->num_rows() > 0){
                ?>
                <div class="card">
                    <div class="card-header bg-danger">
                        <h4 class="card-title m-b-0 text-white">Observaciones</h4>
                    </div>
                    <div class="card-body b-t" style="padding-top: 5px; padding-bottom: 5px;">


                        <ul class="list-task list-group m-b-0" data-role="tasklist" id="tasklist">

                        <?php 
                            if($query->num_rows() > 0){ 
                                foreach ($query->result() as $fila) {
                                    $correlativo++;
                        ?>
                            <li class="list-group-item" data-role="task" style="border: 0; padding: 0px;">
                                <div class="checkbox checkbox-info">
                                    <input type="checkbox" value="<?php echo  $fila->id_observacion_pasaje; ?>" id="<?php echo  $fila->id_observacion_pasaje; ?>id_ob" name="id,<?php echo $fila->id_observacion_pasaje; ?>">
                                    <label for="<?php echo $fila->id_observacion_pasaje; ?>id_ob" class="" onclick=""> <span><?php echo $fila->observacion; ?></span></label>
                                </div>
                            </li>
                        <?php 
                                }
                           }
                        ?>
                        
                        </ul>
                    </div>
                </div>
                <?php } ?>