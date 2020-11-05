console.log("arrancando->Codeasusap.js");
actualizarTabla_gconsumo();
busacarAsocBtn();
generarConsumoSinMedidor();

InsertarSuministro();

//cuando ingresen código para buscar al asiciado
function busacarAsocBtn(){
	let el = document.getElementById("btnBuscarAsoc");
	if(el){

		el.addEventListener('click',function(){
			
			let usuario = $("#txtBuscarAsoc").val();
			
			if(usuario != ""){
				if(!isNaN(usuario)){
					if(usuario.length == 8 || usuario.length == 11 || usuario.length == 6){
						
						let datos = new FormData();
						datos.append("codAsoc",usuario);
						datos.append("btnaccion","buscarAsociado");
						
						$.ajax({
							url:"../ajax/buscarAjax.php",
							method:"POST",
							data: datos,
							cache: false,
							contentType: false,
							processData: false,
							success:function(respuesta){
								if(respuesta){
									
									let datos = JSON.parse(respuesta);
									let datostabla = datos.tabla;
									let datosmodal = datos.modal;

									let cant_sumi = datostabla["cant_suministro"];
									cant_sumi++;

									let htmlAsoc = `
																	
										<tr>		
											<td>1</td>											
											<td>${datostabla["dni"]}</td>
											<td>${datostabla["nombre"]}</td>
											<td>${datostabla["apellido"]}</td>
											<td>${datostabla["telefono"]}</td>
											
											<td>${cant_sumi}</td>
											<td>
												<a href="#cantSumin" data-toggle="modal" dni="485666" class="cantSumin btn btn-success btn-raised btn-xs" >
													<i class="zmdi zmdi-refresh"></i>
												</a>
											</td>
											<td>
												<form action="../asocUpdate/" method="post">
													<input type="hidden" name="dniAsoc" id="" value="${datostabla["dni"]}">												
													<button type="submit" class="btn btn-success btn-raised btn-xs" id="btnUpdateAsoc">
														<i class="zmdi zmdi-refresh"></i>
													</button>												
												</form>																						
											</td>
											</tr>   				
										
									`; 
											//<td><a href="#!" class="btn btn-danger btn-raised btn-xs"><i class="zmdi zmdi-delete"></i></a></td>
									let htmlSumi = ``;
									for (let index = 0; index < datosmodal.length; index++) { //El index tiene que comenzar desde cero. Porque cada uno de los suministros tiene como indice un numeral, y este comienza con el cero.
										
										htmlSumi += `
											<tr>
												<td>${index+1}</td>
												<td>${datosmodal[index]["codigo"]}</td>
												<td>${datosmodal[index]["direccion"]}</td>
												<td>${datosmodal[index]["categoria"]}</td>
												<td>${datosmodal[index]["medidor"]}</td>
												<td>${datosmodal[index]["corte"]}</td>
											</tr>	
										`;
										//console.log(htmlSumi);					
									}
									
									//Escribe datos en el modal del suministro. 
									$(".txtDniAsocModal").val(datostabla["dni"]);
									$(".txtNombreAsocModal").val(datostabla["nombre"]);
									
									//IMPRIME DATOS PARA LOS ASOCIADOS Y SUMINISTROS		
									$(".responseAsoc").html(htmlAsoc);//Escribe datos en la tabla
									$(".responseSumi").html(htmlSumi);//Escribe datos en el modal
									
									//Limpia el msj de no se encontró nada.
									$(".infoAsoc").html("");
									
									//CONTROL DEL BTN PARA AGREGAR SUMINISTRO
									$('#btnAddSumiModal').attr("disabled", false)
									$('#btnAddSumiModal').attr("data-toggle", "modal")							
									
								}else{
									//Limpia la tabla de asociado.
									$(".responseAsoc").html("");
									//Imprime msj de error cuando no coincide el dato con los registro de la db
									$(".infoAsoc").html("<div class='text-danger'>No se encontró asociado...</div>");
									
									//CONTROL DEL BTN PARA AGREGAR SUMINISTRO
									$('#btnAddSumiModal').attr("disabled", true)
									$('#btnAddSumiModal').attr("data-toggle", "#")
									
								}
								
							}
						});
					}else{
						alert("DNI O RUC DE USUARIO NO VALIDO!!");
					}
				}else{
					alert("EL DNI O RUC ES UN NUMERO")
				}
			}else{
				alert("INGRESE DNI O RUC")
			}

			
		});
	}

}

function InsertarSuministro(){

 	let el =  document.getElementById("btnisum")
	if(el){
		//console.log("funcion insertarSuministro");
		el.addEventListener('click',(e)=>{
			e.preventDefault();

			let dni = $("#txtDniAsocModal").val();			
			let dt = new FormData(formularioSumi);
			dt.append('dni',dni);
			/*
				console.log(dt.get('dni'));
				console.log(dt.get('categoriaSumi'));
				console.log(dt.get('direccionSumi'));		
				console.log(dt.get('direccionPsjSumi'));		
				console.log(dt.get('direccionNroSumi'));		
				console.log(dt.get('medidorSumi'));		
				console.log(dt.get('corteSumi'));	
			*/
			let txtVacios=false;
			let msj = "¿Crear suministro?";
			//validar que no se dejen valores vacios en el formulario
			if(dt.get('direccionPsjSumi')=="" || dt.get('direccionNroSumi')==""){			
				//colocar cursor donde falta rrellenar información					
				if(dt.get('direccionPsjSumi')==""){
					document.getElementById("direccionPsjSumi").focus();
				}else{
					document.getElementById("direccionNroSumi").focus();
				}
				//mensaje de error cuando no se rellenan todos los campos
				txtVacios = true;
				msj = "¡Estás dejando campos vacios!";
			}
			swal({
				text: `${msj}`,
				type: "warning",										  		
				confirmButtonColor: '#03A9F4',		  		
				confirmButtonText: '<i class="zmdi zmdi-run"></i> Adelante',		
				showCancelButton: true,
				cancelButtonColor: '#F44336',
				cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> Corregir'			
			}).then(()=>{
				//le en ADELANTE

				fetch('../ajax/gestionAS.php',{
					method: 'POST',
					body: dt
				})
				.then(res => res.json())
				.then(data=>{					
					//response
					swal({
						title: "¡OK!",
						text: "El suministro ha sido creado correctamente!",
						type: "success",				
						confirmButtonColor: '#03A9F4',		  		
						confirmButtonText: '<i class="zmdi zmdi-run"></i> Aceptar',				
					})	
					//Limpia la tabla de asociado.
					$(".responseAsoc").html("");
					//Imprime msj de error cuando no coincide el dato con los registro de la db
					$(".infoAsoc").html("");					
					//CONTROL DEL BTN PARA AGREGAR SUMINISTRO
					$('#btnAddSumiModal').attr("disabled", true)
					$('#btnAddSumiModal').attr("data-toggle", "#")
					//desaparece Modal - simulando click :V 
					$('#btncancelarIS').click();
				})

			},
			
			()=>{
				//le dio en CORREGIR
				swal({
					title: "¡OK!",
					text: "CORRIJA LOS CAMPOS VACIOS!",
					type: "info",				
					confirmButtonColor: '#03A9F4',		  		
					confirmButtonText: '<i class="zmdi zmdi-run"></i> Aceptar',				
				})	
											
			});
			
			return false;

		});
				
	}
}

/**
 * Se actualizará la tabla de estado_gconsumo para dar inicio a la generación de consumo
 * para el mes que corresponde.
 */
function actualizarTabla_gconsumo(){
	let el = document.querySelector("#btn_updGC");
	if(el){		
		//let el = $("#btn_updGC");
		console.log("UPDATE estado GCONSUMO");
		$("#btn_updGC").click(function(e){
			e.preventDefault();
			//console.log("click update tabla gconsuo");

			let datos = new FormData();
			datos.append("UPDfgc",true);
			
			fetch('../ajax/gestionAS.php',{
				method: 'POST',
				body: datos
			}).then(res => res.json())
			.then(data=>{
				console.log(data)
				location.reload();
				//response
			})
		});   
	}
}
/**
 * A traves de un btn se generará los consumos
 * desaparecerá cuando se hayá generado los consumos para el mes que corresponde
 */
function generarConsumoSinMedidor(){
	let el = document.querySelector("#btnGenerarCXD");
	if(el){
		el.addEventListener('click',()=>{
			let optionData = new FormData();
			optionData.append("OPTION","GCSnMedi");

			//ocultando bton
			el.style.display="none";
			document.getElementById("loadBtnGCXD").innerHTML = `
					<i class="zmdi zmdi-spinner zmdi-hc-spin zmdi-hc-4x"></i> 
					</br>Porfavor Espere... </br>Esta operación podría tardar un momento... 
			`;

			fetch('../ajax/gestionRcbAjax.php',{
				method:'POST',
				body:optionData
			}).then(res => res.json())
			.then(data=>{
				console.log(data);
				if(data){
					document.getElementById("loadBtnGCXD").innerHTML = "LISTO!!! :)";
					location.reload();
				}else{
					console.log("NOT reload -> kev")
				}
				
			});

			console.log("click en btn consumo x defecto");
			
		});
	}
}

function generarConsumoConMedidor(value){
	let el = document.querySelector('#buscarSumCnM');
	if(el){
		//TARIFA PLANA...
		let optTarifaP = document.getElementById("optTP");
		//Limpia los resultados para iniciar la busqueda
		optTarifaP.addEventListener("click",function(){
			document.querySelector("#rspSumi").innerHTML = '';
			if(this.checked){
				document.querySelector("#titRspSumi").innerHTML = `
				<tr>
					<th scope="col">#</th>
					<th scope="col">Suministro</th>
					<th scope="col">MONTO TP</th>
					<th scope="col">Consumo Anterior</th>
					<th scope="col">Cant. Deudas</th>
					<th scope="col">Asociado</th>
					<th scope="col">Categoria</th>
					<th scope="col">Direccion</th>				
				</tr>
				`;
			}else{
				document.querySelector("#titRspSumi").innerHTML = `
				<tr>
					<th scope="col">#</th>
					<th scope="col">Suministro</th>
					<th scope="col">CONSUMO</th>
					<th scope="col">Consumo Anterior</th>
					<th scope="col">Cant. Deudas</th>
					<th scope="col">Asociado</th>
					<th scope="col">Categoria</th>
					<th scope="col">Direccion</th>				
				</tr>
				`;
			}
		})
		
		console.log("Fn->generarConsumoConMedidor",value,optTarifaP);
		
		let optionData = new FormData();
		optionData.append('OPTION',"GCCnMedi");
		optionData.append("codigo_sum",value);
		optionData.append("optTP",optTarifaP.checked);
		
		fetch("../ajax/gestionRcbAjax.php",{
			method:"POST",
			body:optionData
		}).then(res=>res.json())
		.then(data=>{
			console.log(data,".....-.-.-.")

			if(data=="LISTO"){
				//crear boton de reinicio. reload
				console.log("MSJ DE LISTO - TERMINADO!!")
				document.querySelector("#alertOfCompl").innerHTML = `<span class="text-success blockquote"> LISTO!!</span>`;
				document.querySelector("#rspSumi").innerHTML = '';
				return null;
			}

			let htmlSumi = ``;
			let nmracion = 0;		
			data.forEach(element => {	
			
				if(element.resTarifP){
					//CUANDO SEAN TARIFA PLANA
					htmlSumi +=`
						<tr>
							<th scope="row">${++nmracion}</th>
							<td>${element.codigo_sum}</td>
							<td contenteditable="true" onBlur="cogerMontoTP(this,'${element.codigo_sum}','${element.categoria}')" style="background: #00aa9a;color: red;" placeholder="0.0" autofocus>
								0.0
							</td>
							<td>${element.consm_ant}</td>
							<td>${element.contador_deuda}</td>
							<td>${element.nombre} ${element.apellido} ${element.nombre_sum}</td>      
							<td>${element.categoria}</td>
							<td>${element.direccion}</td>
	
						</tr>
					`;
				}else{
					//CUANDO NO SEAN TARIFA PLANA
					htmlSumi +=`
						<tr>
							<th scope="row">${++nmracion}</th>
							<td>${element.codigo_sum}</td>
							<td contenteditable="true" onBlur="cogerConsumo(this,${element.consm_ant},'${element.codigo_sum}','${element.categoria}')" style="background: #00aa9a;color: red;" placeholder="0.0" autofocus>
								0.0
							</td>
							<td>${element.consm_ant}</td>
							<td>${element.contador_deuda}</td>
							<td>${element.nombre} ${element.apellido} ${element.nombre_sum}</td>      
							<td>${element.categoria}</td>
							<td>${element.direccion}</td>
	
						</tr>
					`;
				}	
			});

			document.querySelector("#rspSumi").innerHTML = htmlSumi;		
			
		});

	}

}
generarConsumoConMedidor("");
function cogerMontoTP(value, cod_sum, categoria){
	//realizar el repintado por si habia cometido un error.
	value.style.background = "#00aa9a";
	value.style.color = "red";
	//------------------------------------------

	let montoTP = value.innerHTML;
	montoTP = montoTP.replace(",",".");	
	montoTP = Number(montoTP).toFixed(2);

	//si distinto de false, el monto es valido
	if(montoTP > 0 && !Number.isNaN(montoTP)){

		//MENSAJE DE ALERTA PARA INSERTAR CONSUMO O NO :d
			swal({
				title: "¿Ejecutar esta acción?",
				text: "USUARIO: " + cod_sum + "<br>MONTO: " + montoTP,
				type: "info",				
				confirmButtonColor: '#03A9F4',		  		
				confirmButtonText: '<i class="zmdi zmdi-run"></i> Aceptar',		
				showCancelButton: true,
				cancelButtonColor: '#F44336',
				cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> Cancel'		
			}).then(()=>{
				//Cuando le de la opción de ok
				console.log("le dio aceptar",0,cod_sum);

				//limpiando por si no cargan los datos...
				document.querySelector("#rspSumi").innerHTML = '';				
				/*
				*/
				dataS = new FormData();
				dataS.append("consumo",0);
				dataS.append("cod_sum",cod_sum);
				dataS.append("monto",montoTP);
				dataS.append("OPTION","insertGCCnM");
				
				fetch('../ajax/gestionRcbAjax.php',{
					method:'POST',
					body:dataS
				})
				.then(res => res.json())
				.then(data=>{
					console.log("->",data);					
					//actualizar tabla 
					let inputCode = document.querySelector("#buscarSumCnM").value;
					generarConsumoConMedidor(inputCode);
				});
			
			},function(){
				//si no le da a la opcion de aceptar
				console.log("No le dió aceptar")
			});
	
		}else{
			//color de ERROR para cuando ingrese un consumo invalido
			value.style.background = "red";
			value.style.color = "white";
		}

}
function cogerConsumo(value, cons_ant, cod_sum, categoria){

	//realizar el repintado por si habia cometido un error.
	value.style.background = "#00aa9a";
	value.style.color = "red";


	let consumo = value.innerHTML;
	consumo = consumo.replace(",",".");
	consumo_df = eval(consumo - cons_ant);//diferencia de consumo ingresado y el consumo del mes anterior
	consumo_df = Number(consumo_df.toFixed(2));// determinanod la cantidad de decimales.	
	let monto = generarMonto(consumo_df,categoria);

	//si distinto de false, el monto es valido
	if(monto['res']!=false){

	//MENSAJE DE ALERTA PARA INSERTAR CONSUMO O NO :d
		swal({
			title: "¿Ejecutar esta acción?",
			text: "CONSUMO: "+ consumo +"<br>USUARIO: " + cod_sum + "<br>MONTO: " + monto.valor,
			type: "info",				
			confirmButtonColor: '#03A9F4',		  		
			confirmButtonText: '<i class="zmdi zmdi-run"></i> Aceptar',		
			showCancelButton: true,
			cancelButtonColor: '#F44336',
			cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> Cancel'		
		}).then(()=>{
			//Cuando le de la opción de ok
			console.log("le dio aceptar",consumo,cod_sum);
			//document.querySelector("#rspSumi").innerHTML = "--->>"+cod_sum;	
			//limpiando por si no cargan los datos...
			document.querySelector("#rspSumi").innerHTML = '';				
			/*
			*/
			dataS = new FormData();
			dataS.append("consumo",consumo);
			dataS.append("cod_sum",cod_sum);
			dataS.append("monto",monto.valor);
			dataS.append("OPTION","insertGCCnM");
			
			fetch('../ajax/gestionRcbAjax.php',{
				method:'POST',
				body:dataS
			})
			.then(res => res.json())
			.then(data=>{
				console.log("->",data);
				
				//actualizar tabla 
				let inputCode = document.querySelector("#buscarSumCnM").value;
				generarConsumoConMedidor(inputCode);
			});
		
		},function(){
			//si no le da a la opcion de aceptar
			console.log("No le dió aceptar")
			//value.innerHTML = 0;
			//location.reload();
		});

	}else{
		//color de ERROR para cuando ingrese un consumo invalido
		if(monto.option == 'negativo'){
			value.style.background = "orange";
			value.style.color = "white";		
		}else if(monto.option == 'invalido'){
			value.style.background = "red";
			value.style.color = "white";
		}else{
			value.style.background = "red";
			value.style.color = "white";			
		}
		console.log("no p",value);
	}
}

//escribir algoritmo para generar el monto con respecto al consumo ingresado
function generarMonto($consumo, categoria){
	if(!isNaN(parseFloat($consumo)) && isFinite($consumo)){
		let $val1,$val2,$val3,$resIGV;
		$val1=0; $val2 =0; $val3=0; $resIGV=0, $montTotal=0;
		if($consumo >= 0){		
			switch (categoria) {
				case 'Domestico':
					if($consumo<=20){
						$val1 = 3.56;
					}else{
						$val1 = 3.56;
						$consumo-=20;
						if($consumo<=20){
							$val2 = $consumo * 0.60;                        
						}else{
							$val2 = 20 * 0.60;
							$consumo-=20;
							$val3 = $consumo * 0.95;
						}
					}
					$val1 = Number($val1.toFixed(1));									
					$val2 = Number($val2.toFixed(1));									
					$val3 = Number($val3.toFixed(1));
					$sum = $val1+$val2+$val3;									

					$resIGV = $sum*0.18; 
					$resIGV = Number($resIGV.toFixed(1));

					$montTotal = $sum + $resIGV;								
					break;
				case 'Comercial':
					if($consumo<=20){
						$val1=20*0.50;
					}else {
						$val1=10;                    
						$consumo-=20;
						$val2 = $consumo*0.95;
					}
					$val1 = Number($val1.toFixed(1));									
					$val2 = Number($val2.toFixed(1));	
					$sum = $val1+$val2;									

					$resIGV = $sum*0.18; 
					$resIGV = Number($resIGV.toFixed(1));

					$montTotal = $sum + $resIGV;					
					break;

				case 'Estatal':
					if($consumo<=20){
						$val1=20*0.60;
					}else {
						$val1=12; //10 
						$consumo-=20;
						$val2 = $consumo*0.95;
					}
					$val1 = Number($val1.toFixed(1));									
					$val2 = Number($val2.toFixed(1));	
					$sum = $val1+$val2;									

					$resIGV = $sum*0.18; 
					$resIGV = Number($resIGV.toFixed(1));

					$montTotal = $sum + $resIGV;					
					break
				case 'Industrial':
					$val1 = $consumo * 2.00;
			
					$val1 = Number($val1.toFixed(1));
					$sum=$val1;		

					$resIGV = $sum*0.18; 
					$resIGV = Number($resIGV.toFixed(1));

					$montTotal = $sum + $resIGV;	
					break;	
				case 'Mantenimiento':
					$val1 = 2.11;
			
					$val1 = Number($val1.toFixed(1));
					$sum=$val1;		

					$resIGV = $sum*0.18; 
					$resIGV = Number($resIGV.toFixed(1));

					$montTotal = $sum + $resIGV;	
					break;				
		
				default:
					break;
			}
			return {res:true, valor:Number($montTotal.toFixed(1))};
		}else{
			return {res:false, option:'negativo'};
		}
	}
	return {res:false, option:'invalido'};
}

//---------------------btn Buscar suministro con CORTE
function buscarSumiConCorte(){	
	let el = document.querySelector("#btnBuscarSumCorte");
	if(el){
		console.log("coem");			
		actualizarTablaConCorte("");
		el.addEventListener('keyup',function(){	
			console.log(this.value);			
			actualizarTablaConCorte(this.value);
		});
	}
}
function actualizarTablaConCorte($bsc_cod){
	//traer toda la tabla completa con limit 10
	let restbl = document.querySelector("#tblSumCorte");
	let data = new FormData();
	data.append('OPTION','bscSumCnCorte')
	data.append('infoDBsqd',$bsc_cod)
	fetch("../ajax/gestionRcbAjax.php",{
		method:'post',
		body:data
	}).then(res => res.json())
	.then(data=>{
		//console.log(data);
		let htmlRS = ``;
		let num = 0;
		data.forEach(element => {
			htmlRS += `
					<tr>
						<th scope="row">${++num}</th>
						<td>${element.cod_suministro}</td>
						<td>${element.nombre} ${element.apellido}</td>
						<td>${element.direccion}</td>
						<td>${element.telefono}</td>
						<td>${element.categoria_suministro}</td>
						<td class="text-center text-info">${element.contador_deuda}</td>
						<td class="text-center text-danger">                            							
							<b>EN CORTE</b>                  
						</td>
					</tr>	
			`;
		});
		restbl.innerHTML = htmlRS;
	});

}

buscarSumiConCorte()
//---------------------FIN - btn Buscar suministro con CORTE

/***************** EVENTOS GENERAR RECIBOS **************************** */
function generarmeses($selectmese, $selectanio){
	let elfech = document.querySelector($selectmese);
	if(elfech){
		console.log(elfech);
		let anio = document.querySelector($selectanio);
		let anioActual = anio.value; //la primera vez que corre es el año actual. :D
		mesesAct = elfech.innerHTML; //la primera vez que corre es los meses transcurridos hasta hoy :D
		anio.addEventListener('click',()=>{
			console.log(anio.value);
			console.log(anioActual);
			if(anio.value == anioActual){
				console.log("pintar hasta este mes")
				elfech.innerHTML = mesesAct;
			}else{
				console.log("pintar todos los mese")
				mesCom = `
					<option value="1">Enero</option><option value="2">Febrero</option><option value="3">Marzo</option><option value="4">Abril</option><option value="5">Mayo</option><option value="6">Junio</option><option value="7">Julio</option><option value="8">Agosto</option><option value="10">Octubre</option><option value="11">Noviembre</option><option value="12">Diciembre</option>
				`;
				elfech.innerHTML = mesCom;
			}
		})
	}
}
//generarmeses(".fechas-meses","#fecha_anio");
generarmeses("#fecha_mesXsumi","#fecha_anioXsumi");

function GRbuscarXdireccion(){
	let el = document.querySelector("#nombreDirec");
	if(el){
		console.log("function->GRbuscarXdireccion()")

		$option_anio = document.querySelector('#fecha_anio');
		$option_mes = document.querySelector('#fecha_mes');
		
		//Linpiando tabla y buscador
		/*
		{
			$option_anio.addEventListener('click',()=>{
				el.value = '';
				document.querySelector("#resTablaRD").innerHTML = ``;
			})
			$option_mes.addEventListener('click',()=>{
				el.value = '';
				document.querySelector("#resTablaRD").innerHTML = '';
			})
		}
		*/
		
		actualizarTblGRDireccion("",$option_anio.value,$option_mes.value);
		console.log(el);		
		el.addEventListener("keyup",function(){

			let nombreDireccion = this.value;

			actualizarTblGRDireccion(nombreDireccion,$option_anio.value,$option_mes.value);

		});
	}
}
function actualizarTblGRDireccion(direccion,anio,mes){
	let data = new FormData();
	data.append('OPTION','buscarRD');
	data.append('nombreDirec',direccion);
	data.append('anio',anio);
	data.append('mes',mes);

	fetch('../ajax/gestionRcbAjax.php',{
		method:'POST',
		body:data
	}).then(res => res.json())
	.then(rdata=>{
		console.log(rdata);
		//imprimir tabla

		$htmlRecib=``;
		let cont = 0;
		rdata.forEach(element=>{
			$htmlRecib += `
				<tr>
					<td>${++cont}</td>
					<td>${element.direccion}</td>          
					<td><a href="../reportes/rxd.php?direccion=${element.direccion}&anio=${$option_anio.value}&mes=${$option_mes.value}" class="btn btn-info btn-raised btn-xs" target="_blank">G. Recibo</a></td>
				</tr>
			`;					
		});

		document.querySelector("#resTablaRD").innerHTML = $htmlRecib;

	})
}

GRbuscarXdireccion();

// onkeyup(this) Función en el HTML erecibo-view.php
function GRbuscarSumXCod($this){
	console.log("Function -> GRbuscarSumXcod(value)")

	{
		document.querySelector("#fecha_anioXsumi").addEventListener('click',()=>{
			document.querySelector("#tblRspxSum_GR").innerHTML=``;			
		})
		document.querySelector("#fecha_mesXsumi").addEventListener('click',()=>{
			document.querySelector("#tblRspxSum_GR").innerHTML=``;			
		})
	}

	let txtCodSum = $this.value;
	let anioxsum = document.querySelector("#fecha_anioXsumi").value;
	let mesxsum = document.querySelector("#fecha_mesXsumi").value;
	console.log(txtCodSum);
	console.log(anioxsum, mesxsum);

	let data = new FormData();
	data.append("OPTION",'bscGRxSum');
	data.append("cod_sum",txtCodSum);
	data.append("anio",anioxsum);
	data.append("mes",mesxsum);

	fetch('../ajax/gestionRcbAjax.php',{
		method:"post",
		body:data
	}).then(res => res.json())
	.then(data => {
		console.log(data);
		let cont = 0;
		let html =``;	
		data.forEach(element=>{
			html +=`
			<tr>
				<td>${++cont}</td>
				<td>${element.suministro_cod_suministro}</td>
				<td>${element.nombre} ${element.apellido} ${element.nombre_sum}</td>
				<td>${element.direccion}</td>
				<td>${element.esta_cancelado=='1'?"<span class='text-info'>Si</span>":"<span class='text-danger'>No</span>"}</td>
				<td>${element.tiene_medidor=='1'?'Si':'No'}</td>
				<td>${element.estado_corte=='1'?"<span class='text-danger'>Si</span>":"<span class='text-info'>No</span>"}</td>
				<td><a href="../reportes/rxp.php?codigoSum=${element.suministro_cod_suministro}&anio=${element.anio}&mes=${element.mes}" target="_blank" class="btn btn-info btn-raised btn-xs">G. Recibo</a></td>				
			</tr>			
			`;
		})	
		document.querySelector("#tblRspxSum_GR").innerHTML=html;
	})

}


//fUNCIONES PARA CRECIBO
function buscarSuministrosParaCobrar(){
	let el = document.getElementById('txtBscSumCobro');
	if(el){
		buscarSuministrosParaCobrarTBL('');
		el.addEventListener('keyup',()=>{	
			console.log(el.value);
			buscarSuministrosParaCobrarTBL(el.value);
		})
	}
}
function buscarSuministrosParaCobrarTBL(txtInput){
	
	let data = new FormData();
	data.append('OPTION','CobrarRecibo');
	data.append('cod_sum',txtInput);
	
	fetch('../ajax/gestionRcbAjax.php',{
		method:'POST',
		body:data
	}).then(res => res.json())
	.then(data=>{
		console.log(data)
		let ahtml = ``;
		let cont = 0;
		data.forEach(element=>{
			let xmes = NombreMes(element.mes);		
			ahtml += `
				<tr>
					<td>${++cont}</td>
					<td>${element.suministro_cod_suministro}</td>
					<td>${element.nombre} ${element.apellido} ${element.nombre_sum}</td>
					<td>${element.direccion}</td>
					<td>${element.categoria_suministro}</td>
					<td>${element.anio}</td>
					<td>${xmes}</td>
					<td>s/ ${element.monto_pagar}</td>
					<td><a href="#!" class="btn btn-success btn-raised btn-xs" onclick="cobrarAgua(this,'${element.suministro_cod_suministro}',${element.anio},${element.mes},${element.monto_pagar},'${txtInput}')">Cobrar</a></td>
				</tr>				
			`;
		});
		document.querySelector('#rspTblCrecibo').innerHTML = ahtml;
	})
}
function cobrarAgua(e,cod_sum,anio,mes,monto,txtinput){
	//DESCONTAR CONTADOR DEUDA
	//ESTADO CORTE, RESTAURAR. 
	let lmes = NombreMes(mes);

	console.log(e,cod_sum,lmes);
	swal({
		title: "¿Realizar cobro?",
		text: "<p>Para el mes de <b>"+lmes+"</b></p>SUMINISTRO: <b>" + cod_sum + "</b><br>COBRAR:    <b>S/ " + monto +" Soles</b>",
		type: "info",				
		confirmButtonColor: '#03A9F4',		  		
		confirmButtonText: '<i class="zmdi zmdi-run"></i> Aceptar',		
		showCancelButton: true,
		cancelButtonColor: '#F44336',
		cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> Cancel'		
	}).then(()=>{
		//Cuando le de la opción de ok
		document.querySelector('#rspTblCrecibo').innerHTML = "";//limpiar bien la lista de cobros
		let data = new FormData();
		data.append('OPTION','PagoRecibo');
		data.append('cod_sum',cod_sum);
		data.append('anio',anio);
		data.append('mes',mes);
	
		fetch('../ajax/gestionRcbAjax.php',{
			method:'post',
			body:data
		}).then(res => res.json())
		.then(data =>{
			console.log("data -> ",data);
			console.log("txtinput -> ",txtinput)
			txtinput = (txtinput==null || txtinput==undefined)?'':txtinput;
			buscarSuministrosParaCobrarTBL(txtinput);
		})
	},function(){
		//si no le da a la opcion de aceptar
		console.log("No le dió aceptar",cod_sum)
	});


	
}

buscarSuministrosParaCobrar()

//Función Nombre de fechas mes
function NombreMes($n_mes){
	$n_mes = Number($n_mes);
	switch ($n_mes) {
		case 1:
			$r_mes = "Enero";
			break;
		case 2:
			$r_mes = "Febrero";
			break;
		case 3:
			$r_mes = "Marzo";
			break;
		case 4:
			$r_mes = "Abril";
			break;				
		case 5:
			$r_mes = "Mayo";
			break;
		case 6:
			$r_mes = "Junio";
			break;
		case 7:
			$r_mes = "Julio";
			break;
		case 8:
			$r_mes = "Agosto";
			break;
		case 9:
			$r_mes = "Septiembre";
			break;
		case 10:
			$r_mes = "Octubre";
			break;
		case 11:
			$r_mes = "Noviembre";
			break;
		case 12:
			$r_mes = "Diciembre";
			break;												
		default:
			$r_mes = $n_mes;
			break;
	}	
	return $r_mes;
}

//validar Usuario
function instantformUser(){
	el = document.querySelector("#formUser");
	if(el){		
		/********************** */
		let pasaje, nro, categoria, medidor, nombre, apellido, dni, telefono;	
		pasaje = document.querySelector("#direccionPsjAsoc");
		pasaje_error= document.querySelector("#direccionPsjAsocVal");
		nro = document.querySelector("#direccionNroAsoc");
		nro_error=document.querySelector("#direccionNroAsocVal");
	
		categoria = document.querySelector("#categoriaAsoc");
		medidor = document.querySelector("#medidorAsoc");
	
		nombre = document.querySelector("#nombreAsoc");
		nombre_error=document.querySelector("#nombreAsocVal");
		apellido = document.querySelector("#apellidoAsoc");
		apellido_error=document.querySelector("#apellidoAsocVal");
	
		dni = document.querySelector("#dniAsoc");
		dni_error=document.querySelector("#dniAsocVal");
		telefono = document.querySelector("#telefonoAsoc"); 
		telefono_error=document.querySelector("#telefonoAsocVal");

		/********************** */

		nombre.style.textTransform="uppercase";
		apellido.style.textTransform="uppercase";
		pasaje.style.textTransform="uppercase";


		nombre.addEventListener("keyup",function(){
			let patt = new RegExp("[0-9]");
			let res = patt.test(nombre.value);	
			console.log(categoria.value);
			if(categoria.value != "Estatal"){
				if(res){
					//console.log("es numero")
					nombre_error.classList.add("has-error");
					alert("LOS NOMBRES NO DEBEN LLEVAR NÚMEROS")
					nombre.value = "";
				}
			}		
			
		})

		categoria.addEventListener("click",function(){
			if(this.value == "Estatal" && apellido.value != ""){
				alert("NO HAY APELLIDO PARA CATEGORIA ESTATAL");
				apellido.value = "";
			}
		})
		apellido.addEventListener("keyup",function(){
			let patt = new RegExp("[0-9]");
			let res = patt.test(apellido.value);
			if(categoria.value != "Estatal" && apellido.value != ""){
				if(res){
					//console.log("es numero")
					apellido_error.classList.add("has-error");
					alert("LOS APELLIDOS NO DEBEN LLEVAR NÚMEROS")
					apellido.value = "";
				}
			}else{
				if(categoria.value == "Estatal" && apellido.value != ""){
					alert("NO HAY APELLIDO PARA CATEGORIA ESTATAL")
					apellido.value = "";
				}
			}		
		})

		dni.addEventListener("blur",function(){
			//console.log(this.value,this.value.length)
			if(this.value != ""){
				if(!(this.value.length == 6 || this.value.length == 8 || this.value.length == 11)){
					alert("ERROR DE DNI, RUC O CODIGO");
					dni_error.classList.add("has-error");
				}				
			}
		})

		telefono.addEventListener("blur",function(){
			if(this.value != ""){
				if(this.value.length != 9){
					alert("NUMERO TELEFÓNICO NO VALIDO");
					this.value = "";
				}
			}
		})
		
	}
}
instantformUser();

function validarUsuario(){
	console.log("On submit")
	let direccion, pasaje, nro, categoria, medidor, nombre, apellido, dni, telefono;
	direccion = document.querySelector("#direccionAsoc");
	pasaje = document.querySelector("#direccionPsjAsoc");
	pasaje_error= document.querySelector("#direccionPsjAsocVal");
	nro = document.querySelector("#direccionNroAsoc");
	nro_error=document.querySelector("#direccionNroAsocVal");

	categoria = document.querySelector("#categoriaAsoc");
	medidor = document.querySelector("#medidorAsoc");

	nombre = document.querySelector("#nombreAsoc");
	nombre_error=document.querySelector("#nombreAsocVal");
	apellido = document.querySelector("#apellidoAsoc");
	apellido_error=document.querySelector("#apellidoAsocVal");

	dni = document.querySelector("#dniAsoc");
	dni_error=document.querySelector("#dniAsocVal");
	telefono = document.querySelector("#telefonoAsoc"); 
	telefono_error=document.querySelector("#telefonoAsocVal");

	//$registrarAsoc = document.querySelector("#registrarAsoc");
	
	direccionv=direccion.value; 
	pasajev = pasaje.value.toUpperCase();
	nrov=nro.value;
	categoriav=categoria.value;
	medidorv=medidor.value;
	nombrev=nombre.value.toUpperCase();
	apellidov=apellido.value.toUpperCase();
	dniv=dni.value;
	telefonov = telefono.value;


	//console.log(direccion, pasaje, nro, categoria, medidor, nombre, apellido, dni, telefono);

	if(direccionv != "" || categoriav != "" || medidorv != "" || nombrev != ""|| dniv != ""){
			
		if(categoriav == "Estatal"){
			if(apellidov != ""){
				alert("NO HAY APELLIDO PARA CATEGORÍA ESTATAL");
				apellido.value = "";
				apellido_error.classList.add("has-error");
				return false;
			}
		}else{
			//categoriav != "Estatal"
			let patt = new RegExp("[0-9]");
			let res = patt.test(nombrev);
			if(res){
				alert("EL NOMBRE CONTIENE NÚMEROS!!")
				nombre.value = "";
				return false;
			}

			if(apellidov == ""){
				alert("APELLIDO ESTÁ VACIO!!")
				return false;
			}
		}

		if(!(dniv.length == 6 || dniv.length == 8 || dniv.length == 11)){
			alert("DNI O RUC INVALIDO!!");
			dni.value = "";
			return false;
		}

		console.log("Enviar formulario")

		let data = new FormData();
		data.append("OPTION","R_USER")
		data.append("registrarAsoc","TRUE")

		data.append('categoriaAsoc',categoriav);
		data.append('direccionAsoc',direccionv);
		data.append('direccionPsjAsoc',pasajev);
		data.append('direccionNroAsoc',nrov);
		data.append('nombreAsoc',nombrev);
		data.append('apellidoAsoc',apellidov);
		data.append('dniAsoc',dniv);
		data.append('telefonoAsoc',telefonov);
		data.append('medidorAsoc',medidorv);

		fetch("../ajax/gestionAS.php",{
			method:"post",
			body:data
		}).then(res => res.json())
		.then(data=>{
			console.log(data)
			if(data["res"] == "success"){
				//alert("USUARIO REGISTRADO");
				swal({
					title: "¡OK!",
					text: "¡Usuario ha sido creado correctamente!",
					type: "success",
					confirmButtonText: "Cerrar",
					closeOnConfirm: false
				},
				function(isConfirm){
						if (isConfirm) {	   
						} 
				});
				nombre.value = "";
				apellido.value = "";
				pasaje.value = "";
				nro.value="";
				dni.value = "";
				telefono.value = "";

			}else if(data["res"] == "dniExist"){
				//alert("EL USUARIO YA EXISTE")
				swal({
					title: "¡UPS!",
					text: "¡EL USUARIO YA EXISTE!",
					type: "info",
					cancelButtonColor: '#F44336',
					cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> Modificar',
					showCancelButton: true,
					confirmButtonColor: '#03A9F4',		  		
					confirmButtonText: '<i class="zmdi zmdi-run"></i> De acuerdo'
				}).then(()=>{
					//le dió acceptar 
					nombre.value = "";
					apellido.value = "";
					pasaje.value = "";
					nro.value="";
					dni.value = "";
					telefono.value = "";
				},()=>{
					//le dio cerrar

				})
			}else{
				//error
				//alert("NO SE PUDO REALIZAR EL RIGISTRO")
				swal({
					title: "¡Error!",
					text: "¡NO SE PUDO REALIZAR EL REGISTRO!",
					type: "error",
					confirmButtonText: "Cerrar",
					closeOnConfirm: false
				},
				function(isConfirm){
						if (isConfirm) {	   
						} 					
				});
			}
		})
		
		return false;	
		/*
		probar.borderWidth = "0px 0px 3px 0px";
		probar.borderColor = "#a94442";
		probar.borderStyle = "solid";
		*/
		
	}else{
		direccion_error.classList.add("has-error");
		categoria_error.classList.add("has-error");
		medidor_error.classList.add("has-error");
		nombre_error.classList.add("has-error");
		
		console.log("No enviar formulario")
	
		return false;
	}

}

function instantSuministro(){	
	let el = document.querySelector("#btnBuscarAsoc");
	if(el){

		let bscAso = document.querySelector("#txtBuscarAsoc"); 

		if(bscAso!=""){

		}

	}
}


//ACTUALIZAR SUMINISTROS
function btnUPDsum($id_cod, $contID,$deuda){
	
	console.log("CLICK BTN ACT", $id_cod);
	
	$select = "#SUMI"+$id_cod; //codiog de los registros. ID del tr
	$direccion = document.querySelector("#direccion"+$contID).value;	
	$pasaje = document.querySelector("#pasaje"+$contID).innerHTML;	
	$nr_casa = document.querySelector("#nr_casa"+$contID);	
	$estado = document.querySelector("#estado"+$contID).value;	
	$medidor = document.querySelector("#medidor"+$contID).value;	
	$categoria = document.querySelector("#categoria"+$contID).value;	
	$nr_casa_v = $nr_casa.innerHTML;
	
	$deuda = $deuda ? true:false;
	//console.log(typeof($deuda),$deuda)

	
	if($nr_casa_v < 0 && $nr_casa_v != ""){
		$nr_casa.style.background = "red"
		return false;
	}else{
		$nr_casa.style.background = ""
	}

	//preguntar si de verdad quiere realizar los cambios

	swal({
		title: "¿?",
		text: "¿REALIZAR ACTUALIZACIÓN?",
		type: "info",
		cancelButtonColor: '#F44336',
		cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> CANCELAR',
		showCancelButton: true,
		confirmButtonColor: '#03A9F4',		  		
		confirmButtonText: '<i class="zmdi zmdi-run"></i> ACTUALIZAR'
	}).then(()=>{
		//le dió acceptar 
		//fetch actualzar
		data = new FormData();
		data.append('OPTION', 'UPDsuministro');
		data.append('cod_sumi', $id_cod);
		data.append('direccion', $direccion);
		data.append('pasaje', $pasaje);
		data.append('nr_casa', $nr_casa_v);
		data.append('estado', $estado);
		data.append('medidor', $medidor);
		data.append('categoria', $categoria);
		
		fetch('../ajax/gestionAS.php',{
			method:"post",
			body:data		
		}).then(res => res.json())
		.then(data =>{
			console.log(data);
			//mensaje de ok 
			swal({
				title: "!OK¡",
				text: "¡¡ACTUALIZADO!!",
				type: "success",
				showCancelButton: true,
				showConfirmButton: false,
				cancelButtonColor: "#03a9f4",
				cancelButtonText:'cerrar'
			})
			//indicador de que el registro ya se actualizo una vez
			document.querySelector($select).style.background = "rgba(255, 255, 0,.2)";
		})

	},()=>{
		//le dio cerrar
		console.log("NO SE REALIZÓ LA ACTUALIZACIÓN")
	})


	return false;

}

function actualizarUsuario(){
	let el = document.querySelector("#UPDformUser");
	if(el){

		//acceder a los datos
		$dni= document.querySelector("#dniAsoc").value;
		$nombre = document.querySelector("#nombreAsoc").value;
		$apellido = document.querySelector("#apellidoAsoc").value;
		$telefono = document.querySelector("#telefonoAsoc").value;

		//validando información
		if($nombre == ""){
			alert("El nombre está vacio")
			return false;
		}

		if(!isNaN($nombre)){
			alert("EL NOMBRE O APELLIDO NO DEBEN TENER NÚMEROS")
			document.querySelector("#nombreAsocVal").classList.add("has-error");
			return false;
		}

		if($apellido != "" && !isNaN($apellido)){
			alert("EL NOMBRE O APELLIDO NO DEBEN TENER NÚMEROS")
			return false;
		}
		
		
		if($telefono.length != 9 && $telefono != ""){
			alert("EL NUMERO NO ES CORRECTO");
			return false;
		}


		console.log($dni,$nombre,$apellido,$telefono)

		//preguntar si quiere realizar la actualizacion
		swal({
			title: "¿ACTUALIZAR?",
			text: "",
			type: "info",
			cancelButtonColor: '#F44336',
			cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> CANCELAR',
			showCancelButton: true,
			confirmButtonColor: '#03A9F4',		  		
			confirmButtonText: '<i class="zmdi zmdi-run"></i> ACTUALIZAR'
		}).then(()=>{
			//le dió acceptar 
			//enviar un fetch
			data = new FormData();
			data.append('OPTION','UPDuser')
			data.append('dni',$dni)
			data.append('nombre',$nombre)
			data.append('apellido',$apellido)
			data.append('telefono',$telefono)
	
			fetch('../ajax/gestionAS.php',{
				method:"post",
				body:data		
			}).then(res => res.json())
			.then(data=>{
				console.log(data);
				if(data){
					//mensaje de ok 
					swal({
						title: "!OK¡",
						text: "¡¡ACTUALIZADO!!",
						type: "success",						
						showConfirmButton: true,
						confirmButtonColor: "#03a9f4",
						confirmButtonText:'cerrar'
					}).then(()=>{
						location.reload();
					})

				}
			})
		
		})


		
		console.log("actualizarUsuario");
	}
}

function instantUPDuser(){
	let el = document.querySelector("#UPDformUser");
	if(el){

		$initApellido = document.querySelector("#apellidoAsoc").value;
		$initNombre = document.querySelector("#nombreAsoc").value;

		//validar nombre
		document.querySelector("#nombreAsoc").addEventListener("keyup",function(){										
			if(!isNaN(this.value)){				
				document.querySelector("#nombreAsoc").style.background = "rgba(255,0,0,.03)";
			}else{
				document.querySelector("#nombreAsoc").style.background = "";

			}
		});
		document.querySelector("#nombreAsoc").addEventListener("blur", function(){		
			if(this.value == ""){
				this.value = $initNombre;				
				alert("NOMBRE NO DEBE ESTAR VACIO");
			}	
		})	

		//validar instant apellido
		document.querySelector("#apellidoAsoc").addEventListener("keyup",function(){	
			this.style.background = "";
			if( $initApellido == ""){
				alert("NO HAY UN APELLIDO");
				this.value = "";
			}			
		})	
		document.querySelector("#apellidoAsoc").addEventListener("blur",function(){	
			this.style.background = "";
			if( $initApellido != "" && this.value == ""){
				alert("EL APELLIDO NO DEBE ESTAR VACIO");
				this.value = $initApellido;
				this.style.background = "rgba(255,0,0,.03)";
				this.classList.add("has-error");
			}			
		})		

	}
}
instantUPDuser();

function obtenerListDirecciones(event){
	//console.log("key pressed ",  String.fromCharCode(event.keyCode));
	let codigo = event.which || event.keyCode;
	let pressCode = "";
	/*
    //console.log("Presionada: " + codigo);     
	if(codigo === 13){
      console.log("Tecla ENTER");
	}	
	*/
	if(codigo === 192){		
		pressCode = "Ñ";
	}
    if(codigo >= 65 && codigo <= 90){
	  //console.log(String.fromCharCode(codigo));
	  pressCode = String.fromCharCode(codigo);
	}	

	data = new FormData();
	data.append('OPTION','DIRECinst')
	data.append('keyup',pressCode)
	fetch("../ajax/gestionAS.php",{
		method:"post",
		body:data
	}).then(res=>res.json())
	.then(data=>{
		//console.log(data)
		let htmlSelectDirec = ``;
		data.forEach(element=>{
			htmlSelectDirec +=`<option>${element['nombre']}</option>`;
		})
		let selectDirecc = document.querySelector("#direccionAsoc");
		selectDirecc.innerHTML = htmlSelectDirec;	
	})

}

function mensajeParaRecibo(){
	console.log("mensje para recibo");
	let el = document.querySelector("#txtmsjRcb");

	if(el){

		console.log(el.value);

		let data = new FormData();
		data.append('OPTION','MSJrcb')
		data.append('msj',el.value)

		fetch('../ajax/gestionRcbAjax.php',{
			method:"post",
			body:data
		}).then(res => res.json())
		.then(data=>{			
			console.log(data)
			swal(
				'Listo!!',
				'Se actualizó el Mensaje',
				'success'
			)
		})
	}
}

function btnImprimeReporteCorte(){
	start_date = 2000;
	end_date = 2005;
	console.log("abriendo btn ");
	window.open(`../reportes/reporteCorte.php?inicioDate=${start_date}&finalDate=${end_date}`,'_blank')
}