<?= modules::run('Sections/Menu/HeaderCamas'); ?>
<?php
function getServerIp(){
    if($_SERVER['SERVER_ADDR'] === "::1"){
        return "localhost";
    }
    else{
        return $_SERVER['SERVER_ADDR'];
    }
}
?>
<style type="text/css">
.widget {
  border-radius: 3px;
  -webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box;
  padding: 12px 17px;
  color: #f8f8f8;
  background: rgb(100 87 87 / 63%);
  margin-bottom: 30px;
  position: relative;
}

.title-fragilidad {
    position:absolute;
    width:60px;
    height:15px;
    text-align:left;
    padding-left:15px;
    line-height:15px;
    top:60px;
    left:-1px;
    font-size:10px;
}

.title-funcionalidad {
    position:absolute;
    width:60px;
    height:15px;
    text-align:left;
    padding-left:1px;
    line-height:15px;
    top:60px;
    left:80px;
    font-size:10px;
}
.value-fragilidad {
    position:absolute;
    width:60px;
    height:15px;
    text-align:left;
    padding-left:1px;
    line-height:15px;
    top:75px;
    left:0px;
    font-size:12px;
}

.value-funcionalidad {
    position:absolute;
    width:60px;
    height:15px;
    text-align:left;
    padding-left:1px;
    line-height:15px;
    top:75px;
    left:80px;
    font-size:12px;
}

.escalas{
	float: left;
	padding: 0px 0px 10px 15px;
}
.signosv{
	display: flex;
	padding: 7px 0px 0px 15px;
}
.divnamesv:not(:last-of-type) {
	border-right: 1px solid #ddd;
	margin-right: 8px;
  padding-right: 13px;
}
.div-sv{
	padding-right: 13px;

}
.sv-title.svname {
	color: #888;
    font-size: 10px;
    font-weight: 400;
}
.sv-title {
    color: #777;
    font-size: 10px;
    letter-spacing: .5px;
    line-height: 1em;
    margin: 0px 0 3px;
    /* text-transform: uppercase;*/
}

.value-sv.valuesv {
    font-size: 14px;
}
.value-sv{
    color: #333;
    font-size: 9px;
    font-weight: 800;
    margin-bottom: 0;
}

/*Tooltip  */

.contenedor {
	position: relative;
}

figure {
	width: 100%;
	position: relative;
}

figure .mapa {
	width: 100%;
	vertical-align: top;
	box-shadow: 5px 5px 60px rgba(0,0,0,.20);
	border-radius: 10px;
}

.tooltipF1::after {
	content: "";
	display: inline-block;
	border-left: 15px solid transparent;
	border-right: 15px solid transparent;
	border-top: 15px solid #fff;
	position: absolute;
	bottom:-15px;
	left: calc(90% + 5px);
}


.tooltipF2::after {
	content: "";
	display: inline-block;
	border-left: 15px solid transparent;
	border-right: 15px solid transparent;
	border-top: 15px solid #fff;
	position: absolute;
	bottom:-15px;
	left: calc(0);
}


.tooltip.activo {
	opacity: 1;
	transform: translateY(0px);
}

/* ------------------------- */
/* Mediaqueries */
/* ------------------------- */

@media screen and (max-width: 768px) {
	figcaption .tooltip {
		font-size: 9px;
	}

	.tooltip .info button {
		width: 100%;
	}
}

@media screen and (max-width: 576px) {
	figure .mapa {
		margin-bottom: 40px;
	}

	figcaption .icono {
		top: 32px;
		/* display: none; */
	}

	.tooltip {
		position: static;
		opacity: 1;
		width: 100%;
		transform: translate(0);*/
	}

	.tooltip::after {
		content: "";
		display: none;
	}
	.modal-footer {
		margin-top: 40px !important;
	}
}

.ttip + .tooltip  {
	/*left: 132px;*/
  width: 13.25em !important;
}
.ttip + .tooltip > .tooltip-inner {
  background-color: #73AD21; 
  color: #FFFFFF; 
  border: 1px solid green; 
  padding: 5px;
  font-size: 14px;

}

</style>
<link href="<?=  base_url()?>assets/styles/tooltip.css" rel="stylesheet" type="text/css" />
<div class="box-row">
	<div class="box-cell">
		<div class="box-inner col-md-12" style="padding: 10px">
			<!-- Panel de indicadores -->
			<div class="" role="main"> 
				<div class="title text-center"><h4>Visor de Camas Hospitalización UMAE Hospital de Especialiades del CMN siglo XXI</h4></div> 
				         
                <div class="row tile_count">
					        <div class="container col-lg-3 col-md-6 col-sm-6 col-xs-6 tile_stats_count">
					        	<div class="row"> 
	                		 		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	                		 			<span class="count_top"><i class="fa fa-bed"></i>&nbsp;Camas censables</span>
														<strong>308</strong>
	                		 		</div>
						     	</div>   
					        	<div class="row">
					        		<div class="container">
					        			<table>
						        			<tr>
	    										<td><div class="bed-status blue-700 color-white"><i class="fa fa-bed"></i></div></td>
													<td><span class="camas-ocupadas-hombres"></span></td>
	    										<td><div class="bed-status pink-A100 color-white"><i class="fa fa-bed"></div></td>
													<td><span class="camas-ocupadas-mujeres"></span></td>
	    										<!-- <td><span><i class="fa fa-male"></i></span></td> -->
	    										<td style="padding-left: 15px"><span class="camas-ocupadas"></span></td>
	  										</tr>
  										</table>
						        	</div>
					        	</div>
					        	<div class="row">
					        		
					        	</div>
					        	<div class="row">
					        		<div class="container">
  										<span class="count_bottom"><i class="green porcentaje-ocupacion"></i> Ocupacion</div>
					        	</div>
					        </div>
  							<div class="container col-lg-3 col-md-6 col-sm-6 col-xs-6 tile_stats_count">
					        	<div class="row"> 
	                		 		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	                		 		<span class="count_top"><i class="fa fa-bed"></i>&nbsp;Censables Disponibles</span> </div>
						     	</div>   
					        	<div class="row">
					        		<div class="container">
					        			<table>
						        			<tr>
	    										<td><div class="bed-status green-500 color-white"><i class="fa fa-bed"></div></td>
	    										<td><span class="camas-disponibles"></span></td>
	  										</tr>
  										</table>
						        	</div>
					        	</div>
					        	<div class="row">
					        		<div class="container">
					        			<table>
						        			<tr>
	    										<td><div class="bed-status cyan-400 color-white"><i class="fa fa-bed"></i></div></td>
	    										<!-- <td><span>Limpias</span></h2></td> -->
	    										<td><span class="camas-limpias"></span></td>
	  										</tr>
  										</table>
						        	</div>
					        	</div>
					        	<div class="row">
					        		<div class="container">
					        			<table>
						        			<tr>
	    										<td><div class="bed-status lime color-white"><i class="fa fa-bed"></i></div></td>
	    										<td><span class="camas-reparadas"></span></td>
	  										</tr>
  										</table>
						        	</div>
					        	</div>

					        	<div class="row">
					        		<div class="container">
  										<span class="count_bottom"><i>&nbsp; </i>
  									</div>
					        	</div>
					        	
					        </div>

  							<div class="container col-lg-3 col-md-6 col-sm-6 col-xs-6 tile_stats_count">
					        	<div class="row"> 
	                		 		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	                		 		<span class="count_top"><i class="fa fa-bed"></i>&nbsp;Censables Inhabilitadas</span> </div>
						     	</div>   
					        	<div class="row">
					        		<div class="container">
					        			<table>
						        			<tr>
	    										<td><div class="bed-status yellow-600 color-white"><i class="fa fa-bed"></i></div></td>
	    										<!-- <td><span>Descompuestas</span></h2></td> -->
	    										<td><span class="camas-descompuestas"></span></td>
	  										</tr>
  										</table>
						        	</div>
					        	</div>
					        	<div class="row">
					        		<div class="container">
					        			<table>
						        			<tr>
	    										<td><div class="bed-status grey-900 color-white"><i class="fa fa-bed"></i></div></td>    							
	    										<td><span class="camas-sucias"></span></td>
	  										</tr>
  										</table>
						        	</div>
					        	</div>

					        	<div class="row">
					        		<div class="container">
					        			<table>
						        			<tr>
	    										<td><div class="bed-status red color-white"><i class="fa fa-bed"></i></div></td>
	    										<td><span class="camas-contaminadas"></span></td>
	  										</tr>
  										</table>
						        	</div>
					        	</div>
					        </div>

  							<div class="container col-lg-3 col-md-6 col-sm-6 col-xs-6 tile_stats_count">
					        	<div class="row"> 
	                		 		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	                		 		<span class="count_top"><i class="fa fa-bed"></i>&nbsp;Censables Reservadas</span> </div>
						     	</div>   
					        	
					        	<div class="row">
					        		<div class="container">
					        			<table>
						        			<tr>
	    										<td><div class="bed-status deep-purple-400 color-white"><i class="fa fa-bed"></i></div></td>
	    										<td><span class="reservadas"></span></h2></td>
	  										</tr>
  										</table>
						        	</div>
					        	</div>
					        	<div class="row">
					        		<div class="container">
  										<span class="count_bottom"><i >&nbsp; </i> </div>
					        	</div>

					        </div>
     		</div>
     		<!-- Panle de indicadores -->
     		<!-- Tablero de Camas -->		
     		<div class="row">
     			<div class="col-md-12 col-sm-12 col-xs-12">
     				<div class="dashboard_graph">
     					<div class="row" style="margin-top: 1px"> 
                    		<div class="visor-camas"></div>
                		</div>
     				</div>
     			</div>
     		</div> <!-- fin de tablero de camas -->
		</div>
	</div>
	<input type="hidden" name="area" value="<?= $this->UMAE_AREA?>">
</div>
 <?= modules::run('Sections/Menu/footer'); ?>
 <script>
  const Especialidades = <?= json_encode($Especialidades) ?>;
	const inputOptions = [{ text: '', value: ''}];
		for(let i = 0;i < Especialidades.length; i++){
			let aux = {
				text: 	Especialidades[i]["especialidad_nombre"],
				value:	Especialidades[i]["especialidad_id"]
			}
			inputOptions.push(aux)
		}
</script>
<script src="<?=  base_url()?>assets/libs/bootstrap-popper/popper.min.js"></script>
<script src="<?= base_url('assets/js/AdmisionHospitalaria.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= "http://".getServerIp().':3001/socket.io/socket.io.js'?>" type="text/javascript"></script>
<!--<script type="module" src="<?= base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?'). md5(microtime())?>" type="text/javascript"></script>
-->

<script>

    $('a.pre_registro').on('click',function(){
		var url = $(this).attr('href');  
		var url = "AdmisionHospitalaria/Registro";
        $('#iframe-modal').attr("src",url);
		$('#modal-preregistro').modal({backdrop: 'static',	keyboard: false, show: true});
    });

    $('a.paciente').on('click',function(){
		var url = $(this).attr('href');  
			var url = "Admisionhospitalaria/BuscarPaciente";
			$('#iframe-paciente').attr("src",url);
		$('#modal-paciente').modal({backdrop: 'static',	keyboard: false, show: true});
    });
    
    $('a.ingresos').on('click',function(){
		var url = $(this).attr('href');  
		var url = "AdmisionHospitalaria/Ingresos";
        $('#iframe-ingresos').attr("src",url);
		$('#modal-ingresos').modal({backdrop: 'static',	keyboard: false, show: true});
    });

    $('a.altas').on('click',function(){
		var url = $(this).attr('href');  
		var url = "AdmisionHospitalaria/ReporteAltas";
        $('#iframe-altas').attr("src",url);
		$('#modal-altas').modal({backdrop: 'static',	keyboard: false, show: true});
    });

</script>


  
