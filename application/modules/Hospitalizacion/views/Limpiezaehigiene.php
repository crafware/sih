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

<?= modules::run('Sections/Menu/HeaderCamas'); ?>
<div class="box-row">
	<div class="box-cell">
		<div class="box-inner col-md-12" style="padding: 10px">
			<!-- Panel de indicadores -->
			<div class="" role="main"> 
				<div class="title text-center"><h4>Visor de Camas Hospitalización UMAE Hospital de Especialiades del CMN siglo XXI</h4></div>
			</div>				
			<div class="row">
     			<div class="col-md-12 col-sm-12 col-xs-12">
     				<div class="col-md-12 estados-conservacion-limpieza">
						<table>
	        				<tr>
								<td><div class="bed-status blue-700 color-white"><i class="fa fa-bed"></i></div></td>
								<td><div class="bed-status pink-A100 color-white"><i class="fa fa-bed"></div></td>
								<td><strong class="ocupadas" style="padding-right: 20px">Ocupadas</strong></td>
								<td><div class="bed-status green color-white"><i class="fa fa-bed"></div></td>
    							<td><strong class="disponibles" style="padding-right: 20px">Disponibles</strong></td>
    							<td><div class="bed-status purple-300 color-white"><i class="fa fa-bed"></i></div></td>
    							<td><strong class="reservadas" style="padding-right: 20px">Reservadas</strong></td>
    							<td><div class="bed-status cyan-400 color-white"><i class="fa fa-bed"></i></div></td>
    							<td><strong class="camas-limpias" style="padding-right: 20px"></strong></td>
    							<td><div class="bed-status grey-900 color-white"><i class="fa fa-bed"></i></div></td>
    							<td><strong class="camas-sucias" style="padding-right: 20px"></strong></td>
    							<td><div class="bed-status red color-white"><i class="fa fa-bed"></i></div></td>
    							<td><strong class="camas-contaminadas" style="padding-right: 20px"></strong></td>
    							<td><div class="bed-status yellow-600 color-white"><i class="fa fa-bed"></i></div></td>
    							<td><strong class="camas-descompuestas" style="padding-right: 20px"></strong></td>
    							<td><div class="bed-status lime color-white"><i class="fa fa-bed"></i></div></td>
    							<td><strong class="camas-reparadas" style="padding-right: 20px"></strong></td>
							</tr>
						</table>
					</div>
						<div class="dashboard_graph">
							<div class="row" style="margin-top: 1px"> 
    						<div class="visor-camas"></div>
           				</div>
 					</div>
 				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="infoEmpleado" value="<?= $this->UMAE_USER?>">
	<input type="hidden" name="area" value="<?= $this->UMAE_AREA?>">
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= "http://".getServerIp().':3001/socket.io/socket.io.js'?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/Conservacionlimpieza.js?'). md5(microtime())?>" type="text/javascript"></script>
<link href="<?=  base_url()?>assets/styles/tooltip.css" rel="stylesheet" type="text/css" />