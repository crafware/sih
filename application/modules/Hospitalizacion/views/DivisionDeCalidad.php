<?php
function getServerIp()
{
	if ($_SERVER['SERVER_ADDR'] === "::1") {
		return "localhost";
	} else {
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
				<div class="title text-center">
					<h4>Visor de Camas Hospitalización UMAE Hospital de Especialiades del CMN siglo XXI</h4>
				</div>
			</div>
			<!-- Buscaar paciente -->

			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<p><input type="checkbox" id="ocultarBusquedaRadioButoon" checked="True"><strong> &nbsp Buscar paciente</strong></p>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" id="ocultarBusqueda">
					<div class="col-md-12 estados-conservacion-limpieza dashboard_graph">
						<div class="" style="margin-top: 1px">
							<div class="">
								<div class="col-md-4">
									<div class="form-group">
										<div class="form-group">
											<select onclick="FechaSelectSearch();" class="form-control" name="inputSelect" id="inputSelect">
												<option value="POR_NUMERO">N° DE PACIENTE</option>
												<option value="POR_NOMBRE">NOMBRE DEL PACIENTE</option>
												<option value="POR_NSS">N.S.S (SIN AGREGADO)</option>
												<option value="POR_FECHA">FECHA</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-2" style="padding-right: 2px" id="inputSearchDiv">
									<div class="input-group m-b ">
										<span class="input-group-addon back-imss " style="border:1px solid #256659">
											<i class="fa fa-search"></i>
										</span>
										<input type="text" id="inputSearch" name="inputSearch" class="form-control" autocomplete="off" placeholder="Ingresar N° de Paciente">
									</div>
								</div>

								<div class="col-md-2" style="padding-right: 2px; display: none;" id="inputSelectIngresosEgresos">
									<div class="input-group m-b ">
										<span class="input-group-addon back-imss " style="border:1px solid #256659">
											<i class="fa fa-search"></i>
										</span>
										<select onclick="FechaSearchIngresosEgresos();" class="form-control" name="inputSelectIngresosEgresos" id="inputSelectIngresosEgresosGet">
											<option value="fecha_ingreso">INGRESO</option>
											<option value="fecha_egreso">EGRESO</option>
										</select>
									</div>
								</div>

								<div class="col-md-2" style="padding-right: 2px; display: none;" id="selectFecha">
									<div class="input-group m-b ">
										<span class="input-group-addon back-imss" style="border:1px solid #256659">
											<i class="fa fa-calendar"></i>
										</span>
										<input type="text" class="form-control dp-yyyy-mm-dd" name="empleado_fecha_nac" value="" id="selectFechaGet">
									</div>
								</div>


								<div class="col-md-2" style="padding-left: 0px">
									<div class="form-group">
										<input type="hidden" name="csrf_token">
										<button class="btn btn-block back-imss buscarPacienteDDC" name="btnSearch">BUSCAR</button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h6 class="inputSelectNombre hide" style="color: red;margin-top: -10px"><i class="fa fa-warning"></i> ESTA CONSULTA ESTA LIMITADA A: 100 REGISTROS</h6>
									<table class="footable table table-bordered" id="tableResultSearch" data-filter="#search" data-page-size="20" data-limit-navigation="7" style="display:none">
										<thead>
											<tr>
												<th data-sort-ignore="true">NOMBRE</th>
												<th data-sort-ignore="true">NSS</th>
												<th data-sort-ignore="true">FOLIO</th>
												<th data-sort-ignore="true">FECHA INGRESO</th>
												<th data-sort-ignore="true">CAMA</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="4" class="text-center">
													<h5>NO SE HA REALIZADO UNA BÚSQUEDA</h5>
												</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="5" class="text-center">
													<ul class="pagination"></ul>
												</td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--- Camas -->
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="col-md-12 estados-conservacion-limpieza">
						<table>
							<tr>
								<td>
									<div class="bed-status blue-700 color-white"><i class="fa fa-bed"></i></div>
								</td>
								<td>
									<div class="bed-status pink-A100 color-white"><i class="fa fa-bed"></i></div>
								</td>
								<td><strong class="ocupadas" style="padding-right: 20px">Ocupadas</strong></td>
								<td>
									<div class="bed-status green color-white"><i class="fa fa-bed"></i></div>
								</td>
								<td><strong class="disponibles" style="padding-right: 20px">Disponibles</strong></td>
								<td>
									<div class="bed-status purple-300 color-white"><i class="fa fa-bed"></i></div>
								</td>
								<td><strong class="reservadas" style="padding-right: 20px">Reservadas</strong></td>
								<td>
									<div class="bed-status cyan-400 color-white"><i class="fa fa-bed"></i></div>
								</td>
								<td><strong class="camas-limpias" style="padding-right: 20px"></strong></td>
								<td>
									<div class="bed-status grey-900 color-white"><i class="fa fa-bed"></i></div>
								</td>
								<td><strong class="camas-sucias" style="padding-right: 20px"></strong></td>
								<td>
									<div class="bed-status red color-white"><i class="fa fa-bed"></i></div>
								</td>
								<td><strong class="camas-contaminadas" style="padding-right: 20px"></strong></td>
								<td>
									<div class="bed-status yellow-600 color-white"><i class="fa fa-bed"></i></div>
								</td>
								<td><strong class="camas-descompuestas" style="padding-right: 20px"></strong></td>
								<td>
									<div class="bed-status lime color-white"><i class="fa fa-bed"></i></div>
								</td>
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
</div>
<input type="hidden" name="area" value="<?= $this->UMAE_AREA ?>">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/DivisionDeCalidad.js?') . md5(microtime()) ?>" type="text/javascript"></script>
<script src="<?= "http://" . getServerIp() . ':3001/socket.io/socket.io.js' ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?') . md5(microtime()) ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/AreasCriticas.js?') . md5(microtime()) ?>" type="text/javascript"></script>
<link href="<?=  base_url()?>assets/styles/tooltip.css" rel="stylesheet" type="text/css" />
<script>
	function FechaSelectSearch() {
		console.log(document.getElementById("inputSelect").value)
		if (document.getElementById("inputSelect").value == "POR_FECHA") {
			$('#inputSearchDiv').css("display", 'none');
			$('#inputSelectIngresosEgresos').css("display", '');
			$('#selectFecha').css("display", '');
			document.getElementById("inputSearch").value = "";
		} else {
			$('#inputSearchDiv').css("display", '');
			$('#inputSelectIngresosEgresos').css("display", 'none');
			$('#selectFecha').css("display", 'none');
			document.getElementById("selectFechaGet").value = "";
		}
	}
	$('select[name=inputSelect]').change(function() {
		if ($(this).val() == 'POR_NUMERO') {
			$('input[name=inputSearch]').attr('placeholder', 'Ingresar Folio de paciente');
			$('input[name=inputSearch]').unmask();
		}
		if ($(this).val() == 'POR_NOMBRE') {
			$('input[name=inputSearch]').attr('placeholder', 'Apellidos y nombre');
			$('input[name=inputSearch]').unmask();
		}
		if ($(this).val() == 'POR_NSS') {
			$('input[name=inputSearch]').attr('placeholder', 'Ingresar NSS (Sin Agregado)');
			$('input[name=inputSearch]').mask('9999-99-9999-9');
		}
	});
</script>