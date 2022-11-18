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

.tooltip-inner {
    max-width: none;
    white-space: nowrap;
    background:white;
    border:1px solid lightgray;
  -webkit-box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  -moz-box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  color:gray;
  margin:0;
  padding:0;
  
}
.tooltip.in{
	opacity: 1.9 !important;
}

.tooltip.bottom .tooltip-arrow {
  top: 50;
  left: 50%;
  margin-left: -10px;
  border-bottom-color: red; 
  border-width: 0 5px 5px;
}

/*div {cursor:pointer;}.tooltip-inner {
    max-width: none;
    white-space: nowrap;
    background:white;
    border:1px solid lightgray;
  -webkit-box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  -moz-box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  color:gray;
  margin:0;
  padding:0;
}*/

.tooltip-head {
    max-width:306px;position:relative;overflow:auto;
}

.tooltip-title {
    width:306px;background:#F2F2F2;line-height:30px;float:left;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;text-align:left;padding-left:15px;
}

.tooltip-paciente {
    width:150px;float:left; height:30px;line-height:30px;text-align:right;padding-left:15px;
}
.tooltip-paciente {
    width:150px;float:left; height:30px;line-height:30px;text-align:right;padding-left:15px;
}
.tooltip-folio {
    width:120px;float:right; height:30px;text-align:left;padding-left:30px;
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

.tooltip-medico-nombre {
    width:299px;float:left;height:27px;text-align:left;padding-left:15px;padding-top:13x;line-height:40px;
}

.tooltip-sv-title {
    width:150px;float:left; height:30px;text-align:left;padding-left:15px;line-height:30px;font-size:10px;
}
.tooltip-medico2 {
    width:150px;float:left; height:30px;text-align:left;padding-left:15px;line-height:14px;font-size:10px;
}
.escalas{
	
	float: left;
	padding: 0px 0px 10px 15px;
}
.signosv{
	display: flex;
	float: left;
	padding: 0px 0px 10px 15px;
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
    font-size: 9px;
}
.value-sv{
    color: #333;
    font-size: 9px;
    font-weight: 500;
    margin-bottom: 0;
}
.tooltip-footer {
    width:306px;background:#F2F2F2;line-height:30px;float:left;
}

.modal-footer {
	margin-top: 40px !important;
}
</style>
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
	                 			<span class="count_top"><i class="fa fa-bed"></i>&nbsp;General</span>
	                 		</div>
					   	</div>   
			        	<div class="row">
			        		<div class="container">
			        			<table>
				        			<tr>
										<td><div class="bed-status blue-700 color-white"><i class="fa fa-bed"></i></div></td>
										<td><div class="bed-status pink-A100 color-white"><i class="fa fa-bed"></div></td>
										<td><span class="camas-ocupadas"></span></td>
									</tr>
								</table>
				        	</div>
			        	</div>					
			        	<div class="row">
			        		<div class="container">
									<span class="count_bottom"><i class="green porcentaje-ocupacion"></i> Ocupacion</span>
			        		</div>
			        	</div>
			        </div>
					<div class="container col-lg-3 col-md-6 col-sm-6 col-xs-6 tile_stats_count">
			        	<div class="row"> 
            		 		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            		 		<span class="count_top"><i class="fa fa-bed"></i>&nbsp;Disponibles</span> </div>
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
            		 		<span class="count_top"><i class="fa fa-bed"></i>&nbsp;Inhabilitadas</span> </div>
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
            		 		<span class="count_top"><i class="fa fa-bed"></i>&nbsp;Reservadas</span> </div>
				     	</div>   
			        	
			        	<div class="row">
			        		<div class="container">
			        			<table>
				        			<tr>
										<td><div class="bed-status deep-purple-400 color-white"><i class="fa fa-bed"></i></div></td>
										<td><span class="reservadas"></span></td>
										</tr>
									</table>
				        	</div>
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
<script src="<?=  base_url()?>assets/libs/bootstrap-popper/popper.min.js"></script>
<script src="<?= base_url('assets/js/AdmisionHospitalaria.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= "http://".getServerIp().':3001/socket.io/socket.io.js'?>" type="text/javascript"></script>
<script type="module" src="<?= base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?'). md5(microtime())?>" type="text/javascript"></script>


<script>


    $(function () {
  		//$('[data-toggle="tooltip"]').tooltip();
  		//$('.cama').tooltip();
  		 
	})


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


  
