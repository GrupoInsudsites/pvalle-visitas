<?php echo form_open_multipart(base_url().'admin/informes/index/'); ?>
<h1>
	<?php if (isset($sede)) {
		echo $sede;
	} ?>
	

</h1>
 <label for='fecha_desde'>Fecha desde </label>
 <input id="desde" name="desde" size="15" value="<?php echo $desde; ?>" />
 <label for='fecha_hasta'>Fecha hasta </label>
 <input id="hasta" name="hasta" size="15" value="<?php echo $hasta; ?>"  />
 <label for='tipovisita'>Tipo de visita </label>
 <select name="tipovisita" id="tipovisita">
 	<option value="todos">Todos</option>
 	<option value="empleado">Empleados</option>
 	<option value="contratista">Contratistas</option>
 	<option value="visita">Visitas</option>
	<option value="pasajero">Pasajeros</option>
 </select>
 <?php if($admin == 1 || $admin == 4) { ?>
<label for='sedes'>Sede</label>
<select name="sedes" id="tipovisita">
	<option value=""></option>
 	<?php foreach ($sedes as $sedeName) {?>
		<option value="<?php echo $sedeName->id ?>"
			<?php 
				if($select == $sedeName->id){
					echo 'selected="selected"';
				}
			 ?>

			><?php echo $sedeName->nombre ?></option>
 	<?php } ?>
 </select>
 <?php } ?>
 <input type="submit" name="submit" value="Aplicar Criterios" /> 
<?php echo form_close(); ?>
<div id="grafico" style="width:1200px; height:550px;"></div>
<div  style="width:1000px; height:50px; padding:5px; ">
	<?php
		if($select != 4 && $select != 5){
			foreach($por as $k=>$v){
				if($k == 'ganaderia' || $k == 'yacare'){
					if($k == 'ganaderia'){
						$nombre = 'Ganadería';
					}else{
						$nombre = 'Yacaré Porá'; 
					}
				}else{
					$nombre = ucfirst($k);
				}
				echo '<span style="font-size:17px;"><b>'. $nombre . '</b>('.$v.'%) | </span> ';
			}
			echo '<br><b>Total de visitas para el período seleccionado: </b>' .$total. ' visitas' ;
		} else{
			
			foreach($por as $k=>$v){
				$nombre = "";
				$val = true;
				if($k == 'ganaderia' || $k == 'yacare'){
					if($k == 'ganaderia'){
						$nombre = 'Fresa';
					}
					elseif($k == 'yacare'){
						$nombre = ucfirst('Olivari');
					}else{
						$val = false;
					}
				}else{
					if($k == 'hotel' ){
						$nombre = "Impregnadora";
					}
					if($k == 'vivero'){
						$nombre = "San alonso";
					}if($k == 'forestal'||$k == 'otros'){
						$nombre = ucfirst($k);
					}
					$nombre = ucfirst($nombre);
				}
				
				if($val){
					echo '<span style="font-size:17px;"><b>'. $nombre . '</b>('.$v.'%) | </span> ';
				}
			}
			echo '<br><b>Total de visitas para el período seleccionado: </b>' .$total. ' visitas' ;
		}
	 ?>

</div>

<div class="container" style="border-top: 1px solid #333;">
	<div class="row row-centered">
		<div class="col-md-12" style="padding:10px;border-top: 1px solid #333;">
						<h3  class="titulos">Visitas</h3>
							<table id='example1' class='display datatable'>
								<thead>
									<tr>
										<th>Ingreso</th>
										<th>Nombre</th>
										<th>Dominio</th>
										<th>DNI</th>
										<th>Empresas visitadas</th>
										<th>Tipo</th>
										<th>Sede</th>
										<th>Salida</th>
										<?php if($this->session->userdata['id']==20 ||$this->session->userdata['id']==14 || $this->session->userdata['id']==1){ ?>
											<th>Acciones</th>
										<?php } ?>

									</tr>
								</thead>
								<tbody>
									<?php 
									if(isset($entradassalidas)){ 
									foreach ($entradassalidas as $es) { ?>
										<tr>
											<td><?php 
													$ingreso = date_create($es->ingreso);
													echo date_format($ingreso, 'd-m-Y H:i:s');

											?></td>
											<td><?php echo $es->nombre; ?></td>
											<td><?php echo $es->dominio; ?></td>
											<td><?php echo $es->dni; ?></td>
											<td><?php 
												$empresas = '';
											    if($select != 4 && $select != 5){
										            if($es->vivero == 1){
										                $empresas .= 'Vivero, ';
										            }
										            if($es->forestal == 1){
										                $empresas .= 'Forestal, ';
										            }
										            if($es->ganaderia == 1){
										                $empresas .= 'Ganaderia, ';
										            }
										            if($es->hotel == 1){
										                $empresas .= 'Hotel, ';
										            }
										            if($es->yacare == 1){
										                $empresas .= 'Yacaré Porá, ';
										            }
										            if($es->otros == 1){
										                $empresas .= 'Otro, ';
										            }
											    }else{
											    	if($es->vivero == 1){
										                $empresas .= 'San Alonso, ';
										            }
										            if($es->forestal == 1){
										                $empresas .= 'Forestal, ';
										            }
										            if($es->hotel == 1){
										                $empresas .= 'Impregnadora, ';
										            }
										            if($es->ganaderia == 1){
										                $empresas .= 'Fresa, ';
										            }
										            if($es->otros == 1){
										                $empresas .= 'Otro, ';
										            }
										            if($select == 5){
										            	if($es->yacare){
										            		$empresas .= 'Olivari';
										            	}
										            }
											    }   


										       
										       echo  rtrim($empresas, ', ');

										        


											?></td>
											<td><?php echo $es->tipovisita; ?></td>
											<td><?php
												if($es->sede == 1){
													echo "Garruchos";
												}elseif($es->sede == 2){
													echo "Gafosa";
												}elseif($es->sede == 3){
													echo "Puerto valle";
												}elseif ($es->sede == 4) {
													echo "Villa olivari";
												}elseif($es->sede == 5){
													echo "Impregnadora";
												}
												?>
												
											</td>
											<td>
											<?php 
											if($es->salida == null){
												echo "sin salida registrado";
											}else{
												$salida = date_create($es->salida);
												echo date_format($salida, 'd-m-Y H:i:s');
											}
											?>

											</td>
											<?php if($this->session->userdata['id']==20 ||$this->session->userdata['id']==14 || $this->session->userdata['id']==1){ ?>
												<td><a href="<?php echo base_url();?>admin/informes/borra_linea/<?php echo $es->id; ?>">Borrar</a></td>
											<?php } ?>
										</tr>
									<?php } 
									}?>
								</tbody>
							</table>
			</div>
	</div>
	
</div>
