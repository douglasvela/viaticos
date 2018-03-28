<script type="text/javascript">

    function editar_generalidad(){
        $("#band").val("edit");
        $("#submit").click();
    }

    function eliminar_generalidad(){
        $("#band").val("delete");
        swal({   
            title: "¿Está seguro?",   
            text: "¡Desea eliminar el registro!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#fc4b6c",   
            confirmButtonText: "Sí, deseo eliminar!",   
            closeOnConfirm: false 
        }, function(){   
            $("#submit").click(); 
        });
    }

    function iniciar(){
        
    }


</script>

<!-- ============================================================== -->
<!-- Inicio de DIV de inicio (ENVOLTURA) -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- TITULO de la página de sección -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="align-self-center" align="center">
                <h3 class="text-themecolor m-b-0 m-t-0">Gestión de generalidades</h3>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Fin TITULO de la página de sección -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Inicio del CUERPO DE LA SECCIÓN -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- Inicio del FORMULARIO de gestión -->
            <!-- ============================================================== -->
            <div class="col-lg-1"></div>
            <div class="col-lg-10" id="cnt_form">
                <div class="card">
                    <div class="card-header bg-info" id="ttl_form">
                        <h4 class="card-title m-b-0 text-white">Fomulario de generalidades</h4>
                    </div>
                    <div class="card-body b-t">
                        
                        <?php echo form_open('', array('id' => 'formajax', 'style' => 'margin-top: 0px;', 'class' => 'm-t-40')); ?>
                        <?php
                        	$generalidades = $this->db->query("SELECT * FROM vyp_generalidades");

                        	$id_generalidad = ""; $pasaje = "0.00"; $alojamiento = "0.00"; $num_cuenta = ""; $id_banco = ""; $banco = ""; $num_cuenta = ""; $cod_presupuestario = "";
			                if($generalidades->num_rows() > 0){
			                    foreach ($generalidades->result() as $filag) {
			                    	$id_generalidad = $filag->id_generalidad;
			                    	$pasaje = $filag->pasaje;
			                    	$alojamiento = $filag->alojamiento;
                                    $id_banco = $filag->id_banco;
                                    $banco = $filag->banco;
                                    $num_cuenta = $filag->num_cuenta;
                                    $limite_poliza = $filag->limite_poliza;
                                    $cod_presupuestario = $filag->codigo_presupuestario;
			                    }
			                }
                        ?>
                            <input type="hidden" id="band" name="band" value="save">
                            <input type="hidden" id="id_generalidad" name="id_generalidad" value="<?php echo $id_generalidad; ?>">

                            <span>Sección de viáticos</span>
                            <blockquote>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <h5>Máximo pasaje: <span class="text-danger">*</span></h5>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                                            <input type="number" id="pasaje" name="pasaje" class="form-control" required="" placeholder="0.00" value="<?php echo number_format($pasaje,2); ?>">
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <h5>Máximo alojamiento: <span class="text-danger">*</span></h5>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                                            <input type="number" id="alojamiento" name="alojamiento" class="form-control" required="" placeholder="0.00" value="<?php echo number_format($alojamiento,2); ?>">
                                        </div>
                                    </div>
                                </div>
                            </blockquote>

                            <span>Sección de poliza</span>
                            <blockquote>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <h5>Banco: <span class="text-danger">*</span></h5>
                                        <select id="id_banco" name="id_banco" class="select2" style="width: 100%" required="">
                                            <option value="">[Elija el banco]</option>
                                            <?php 
                                                $banco = $this->db->query("SELECT * FROM vyp_bancos");
                                                if($banco->num_rows() > 0){
                                                    foreach ($banco->result() as $fila) {              
                                                        if($id_banco == $fila->id_banco){
                                                            echo '<option class="m-l-50" value="'.$fila->id_banco.'" selected>'.$fila->nombre.'</option>';
                                                        }else{
                                                            echo '<option class="m-l-50" value="'.$fila->id_banco.'">'.$fila->nombre.'</option>';
                                                        }
                                                       
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <h5>Cuenta bancaria: <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" id="cuenta" name="cuenta" value="<?php echo $num_cuenta; ?>" class="form-control" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group col-lg-6">
                                        <h5>Monto límite de poliza: <span class="text-danger">*</span></h5>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                                            <input type="number" id="limite_poliza" name="limite_poliza" class="form-control" required="" placeholder="0.00" value="<?php echo number_format($limite_poliza,2); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <h5>Código presupuestario: <span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" id="codigo_presupuestario" name="codigo_presupuestario" value="<?php echo $cod_presupuestario; ?>" class="form-control" required="">
                                        </div>
                                    </div>

                                </div>
                            </blockquote>
                            
                            <button id="submit" type="submit" style="display: none;"></button>
                            <div align="right" id="btnadd">
                                <button type="reset" class="btn waves-effect waves-light btn-success"><i class="mdi mdi-recycle"></i> Limpiar</button>

                                <?php if($id_generalidad == ""){ ?>
                                <button type="submit" class="btn waves-effect waves-light btn-success2"><i class="mdi mdi-plus"></i> Guardar</button>
                                <?php }else{ ?>
                                <button type="button" onclick="editar_generalidad()" class="btn waves-effect waves-light btn-info"><i class="mdi mdi-pencil"></i> Editar</button>
                                <?php } ?>
                            </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-1"></div>
            <!-- ============================================================== -->
            <!-- Fin del FORMULARIO de gestión -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- Fin CUERPO DE LA SECCIÓN -->
        <!-- ============================================================== -->
    </div> 
</div>
<!-- ============================================================== -->
<!-- Fin de DIV de inicio (ENVOLTURA) -->
<!-- ============================================================== -->

<script>

$(function(){     
    $("#formajax").on("submit", function(e){
        e.preventDefault();
        var f = $(this);
        var formData = new FormData(document.getElementById("formajax"));
        formData.append("banco", $("#id_banco option:selected").text().trim());
        
        $.ajax({
            url: "<?php echo site_url(); ?>/configuraciones/generalidades/gestionar_generalidades",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function(res){
            if(res == "exito"){
                if($("#band").val() == "save"){
                    swal({ title: "¡Registro exitoso!", type: "success", showConfirmButton: true });
                }else if($("#band").val() == "edit"){
                    swal({ title: "¡Modificación exitosa!", type: "success", showConfirmButton: true });
                }else{
                    swal({ title: "¡Borrado exitoso!", type: "success", showConfirmButton: true });
                }
                location.reload();
            }else{
                swal({ title: "¡Ups! Error", text: "Intentalo nuevamente.", type: "error", showConfirmButton: true });
            }
        });
            
    });
});

</script>