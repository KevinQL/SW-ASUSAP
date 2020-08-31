<?php
    if (isset($_POST['dniAsoc'])) {
        # code...        
        $dniUsuer = $_POST['dniAsoc'];

        require_once "controllers/adminController.php";
        $objUser = new adminController();        
        $dataReg = $objUser->dataAsociadoYsuministorUPD($dniUsuer); 
        $dataUser = $dataReg['dataAsoc'];
        $dataSumi = $dataReg['dataSumi'];

        $arrDirec = $objUser->obtenerDireccionCalleController("");
        //var_dump($$arrDirec );

    }else{
        //en caso de que no exista el POST  
        echo "
        <script>            
            location.assign('../dashboard/'); 
        </script>
        ";        
    }
?>

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-money-box zmdi-hc-fw"></i> Actualizar Usuario <small>Ingrese cambios</small></h1>
	</div>
	<p class="lead">
    </p>    
</div>

<!--AGREGAR ASOCIADO FORMULARIO-->
<div class="container-fluid">
	<div class="row">
        <!-- SECCIÓN 1 ASOCIADO-->
		<div class="col-xs-12">
            
            <!--SECCIÓN ACTUALIZAR ASOCIADO-->
			<ul class="nav nav-tabs" style="margin-bottom: 15px;">
			  	<li class=""><a href="#new" data-toggle="tab">ASOCIADO</a></li>
			</ul>

			<div id="myTabContent" class="tab-content">
				<div class="formNewAss" id="new">
					<div class="container-fluid">
                        <!---formulario nuevo asociado -->
						<div class="row">

                            <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
							    <form action="" method="post" enctype="multipart/form-data" autocomplete="off" onsubmit="return false" id="UPDformUser">
                                
                                    <div class="col-xs-12 col-sm-12">                                        
                                        <div id="nombreAsocVal" class="col-xs-6 col-md-6 form-group label-floating ">
                                          <label class="control-label">NOMBRE</label>
                                          <input class="form-control" type="search" name="nombreAsoc" id="nombreAsoc" value="<?php echo $dataUser['nombre'];?>" required>
                                        </div>
                                        <div id="apellidoAsocVal" class="col-xs-6 col-md-6 form-group label-floating ">
                                          <label class="control-label">APELLIDO</label>
                                          <input class="form-control" type="text" name="apellidoAsoc" id="apellidoAsoc" value="<?php echo $dataUser['apellido'];?>">
                                        </div>

                                    </div>

                                    <div class="col-xs-12 col-sm-12">

                                        <div id="dniAsocVal" class="col-xs-12 col-md-6 form-group label-floating">
                                          <label class="control-label">DNI</label>
                                          <input class="form-control" type="number" name="dniAsoc" id="dniAsoc" min="10000000" max="99999999999" value="<?php echo $dataUser['dni'];?>" required disabled>
                                        </div>

                                        <div id="telefonoAsocVal" class="col-xs-12 col-md-6 form-group label-floating">
                                          <label class="control-label">TELEFONO</label>
                                          <input class="form-control" type="number" name="telefonoAsoc" id="telefonoAsoc" min="111111111" max="999999999" value="<?php echo $dataUser['telefono'];?>">
                                        </div>

                                    </div>

								    <p class="text-center">
								    	<button type="submit" class="btn btn-success btn-raised btn-lg" name="updateAsoc" id="updateAsoc" onclick="actualizarUsuario()"><i class="zmdi zmdi-floppy"></i> ACTUALIZAR </button>
								    </p>
							    </form>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
        
        <!-- SECCIÓN 2 SUMINISTROS-->
        <div class="col-xs-12">
            <?php
            $con_deudas = "<span class='text-info bg-info'>SIN DEUDAS</span>";
            foreach ($dataSumi as $suministro) {
                # code...                                                                                                         
                if ($suministro['contador_deuda']>=1)
                    $con_deudas = "<span class='text-danger bg-info'>CON DEUDAS</span>";                                    
            }
            ?>
            <!--SECCIÓ ACTUALZAR LOS SUMINISTROS DE USUARIOS-->
            <ul class="nav nav-tabs" style="margin-bottom: 15px;">
			  	<li class="">
                  <a href="#new1" data-toggle="tab">SUMINISTROS</a>
                </li>
                <li class="">                  
                  <a href="#newsas" data-toggle="tab"><?=$con_deudas?></a>
                </li>
                  
			</ul>

            <!-- TABLA DE SUMINISTROS-->
            <div class="col-md-12">                            
                            
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">COD-SUMINSTRO</th>
                                <th class="text-center">DIRECCIÓN</th>                                
                                <th class="text-center">Nro CASA</th>
                                <th class="text-center">ESTADO</th>                                
                                <th class="text-center">MEDIDOR</th>
                                <th class="text-center">CATEGORÍA</th>
                                <th class="text-center">ACTUALIZAR</th>                                
                            </tr>
                        </thead>
                        <!--Respuesta servidor tabla de asociado-->                            
                        <tbody class="">
                            <?php
                            $cont = 0;
                            $con_deudas=false;
                            foreach ($dataSumi as $suministro) {
                                # code...                                   
                                $con_deudas = $suministro['contador_deuda']>=1?true:false;    
                                $styleDeuda = "background:rgba(100,240,190,.1)";                 
                                if ($con_deudas) $styleDeuda = "background:rgba(100,0,0,.1)";                                    
                            ?>
                            <!--SUMINISTROS -->
                            <tr id="SUMI<?=$suministro['cod_suministro']?>">
                                <td><?php echo ++$cont; ?></td>
                                <td style=<?=$styleDeuda?>> 
                                    <?php echo $suministro['cod_suministro']; ?>
                                </td>
                                <td>
                                    <select name="direccion<?=$cont?>" id="direccion<?=$cont?>">
                                        <option><?php echo $suministro['direccion']; ?></option>
                                        <?php 
                                        foreach ($arrDirec as $direccion) {
                                            # code...
                                            echo "<option>{$direccion['nombre']}</option>";
                                        }
                                        ?>
                                    </select>                                    
                                </td>                              
                                
                                <td contenteditable="true" name="nr_casa<?=$cont?>" id="nr_casa<?=$cont?>"><?php echo $suministro['casa_nro']; ?></td>
                                <td>
                                    <?php
                                        $indexEstado = $suministro['estado_corte'];                                         
                                        $arrEstado = [1=>"EN CORTE",0=>'ACTIVO',2=>'INACTIVO'];                                        
                                    ?>
                                    <select class="" name="estado<?=$cont?>" id="estado<?=$cont?>">
                                        <?php                                            
                                            foreach ($arrEstado as $key => $value) {
                                                # code...                                                
                                                if($key == $indexEstado){
                                                    echo "<option value='{$key}' selected>{$value}</option>";
                                                    continue;
                                                }
                                                echo "<option value='{$key}'>{$value}</option>";
                                            }
                                        ?>                                        
                                        
                                    </select>
                                </td>
                                <td>
                                    <?php 
                                        $medidor = $suministro['tiene_medidor'] == 0 ?"SIN MEDIDOR":"CON MEDIDOR";
                                        $arrMedidor = [0=>"SIN MEDIDOR",1=>"CON MEDIDOR"];
                                    ?>
                                    <select class="" name="medidor<?=$cont?>" id="medidor<?=$cont?>">
                                        <?php
                                            foreach ($arrMedidor as $key => $value) {
                                                # code...
                                                if($value == $medidor){
                                                    echo "<option value='{$key}' selected>{$value}</option>";
                                                    continue;                                                    
                                                }
                                                echo "<option value='{$key}'>{$value}</option>";
                                            }
                                        ?>                     
                                    </select>
                                </td>
                                <td>
                                    <?php
                                        $categoria = $suministro['categoria_suministro'];
                                        $arrCategoria = ["Industrial","Domestico","Comercial","Estatal","Tarifa Plana",'Mantenimiento'];
                                    ?>
                                    <select class="" name="categoria<?=$cont?>" id="categoria<?=$cont?>">
                                        <?php 
                                            foreach ($arrCategoria as $value) {
                                                # code...
                                                if($value == $categoria){
                                                    echo "<option selected>{$value}</option>";
                                                    continue;
                                                }
                                                echo "<option>{$value}</option>";
                                            }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                <input type="hidden" name="pasaje<?=$cont?>" id="pasaje<?=$cont?>" value="<?php echo $suministro['pasaje']; ?>">
                                    <a href="#!" class="btn btn-success btn-raised btn-xs" onclick="btnUPDsum('<?=$suministro['cod_suministro']?>',<?=$cont?>,'<?=$con_deudas?>')" >
                                        <i class="zmdi zmdi-refresh"></i>
                                    </a>
                                </td>                                
                            </tr>	
                            <?php
                            }
                            ?>
                            <!--
                            -->
                        </tbody>
                    </table>
                </div>                    
            </div>                    
            <!---->

        </div>
    </div>
</div>
<!-- FIN - AGREGAR ASOCIADO FORMULARIO-->