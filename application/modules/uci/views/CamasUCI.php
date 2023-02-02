<?= modules::run('Sections/Menu/HeaderCamas'); ?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="<?=  base_url()?>assets/styles/tooltip.css" rel="stylesheet" type="text/css" />
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
<style type="text/css">
	.tooltip-inner {
		/*width: 100px;*/
		padding: 3px 8px;
		color: #fff;
		text-align: center;
		background-color: #000;
		border-radius: 4px
	}

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
		position: absolute;
		width: 60px;
		height: 15px;
		text-align: left;
		padding-left: 15px;
		line-height: 15px;
		top: 60px;
		left: -1px;
		font-size: 10px;
	}

	.title-funcionalidad {
		position: absolute;
		width: 60px;
		height: 15px;
		text-align: left;
		padding-left: 1px;
		line-height: 15px;
		top: 60px;
		left: 80px;
		font-size: 10px;
	}

	.value-fragilidad {
		position: absolute;
		width: 60px;
		height: 15px;
		text-align: left;
		padding-left: 1px;
		line-height: 15px;
		top: 75px;
		left: 0px;
		font-size: 12px;
	}

	.value-funcionalidad {
		position: absolute;
		width: 60px;
		height: 15px;
		text-align: left;
		padding-left: 1px;
		line-height: 15px;
		top: 75px;
		left: 80px;
		font-size: 12px;
	}

	.escalas {
		float: left;
		padding: 0px 0px 10px 15px;
	}

	.signosv {
		display: flex;
		padding: 7px 0px 0px 15px;
	}

	.divnamesv:not(:last-of-type) {
		border-right: 1px solid #ddd;
		margin-right: 8px;
		padding-right: 13px;
	}

	.div-sv {
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

	.value-sv {
		color: #333;
		font-size: 9px;
		font-weight: 800;
		margin-bottom: 0;
	}

	/*Tooltip  */

	.contenedor {
		position: relative;
	}

	.tooltip {
		/*display: flex;*/
		position: absolute;
		top: 0;
		left: 0;
		background: #fff;
		border-radius: 10px;
		box-shadow: 5px 5px 50px rgba(0, 0, 0, .20);
		width: 31.25em;
		z-index: 1000;
		opacity: 0;

		transform: translate(-333px, -235px);
		font-size: auto;
	}

	.tooltip.fade {
		/*display: flex;*/
		width: 130px;
	}
	.tooltipF1::after {
		content: "";
		display: inline-block;
		border-left: 15px solid transparent;
		border-right: 15px solid transparent;
		border-top: 15px solid #fff;
		position: absolute;
		bottom: -15px;
		left: calc(90% + 5px);
	}


	.tooltipF2::after {
		content: "";
		display: inline-block;
		border-left: 15px solid transparent;
		border-right: 15px solid transparent;
		border-top: 15px solid #fff;
		position: absolute;
		bottom: -15px;
		left: calc(0);
	}

	/* ------------------------- */
	/* Mediaqueries */
	/* ------------------------- */

</style>
<div class="box-row">
	<div class="box-cell">
		<div class="box-inner col-md-12" style="padding: 30px">
			<!-- Panel de indicadores -->
			<div class="" role="main">
				<div class="col-md-12">
					<div class="panel panel-default" style="margin-top: 10px">
						<div class="panel-heading p teal-900 back-imss">
							<span style="font-size: 15px;font-weight: 500;text-transform: uppercase">PACIENTES EN ÁREA DE <?= $this->UMAE_AREA ?></span>			
							<span style="font-size: 15px;font-weight: 500;">Menú inicial</span>
						</div>
						<div class="panel-body b-b b-light">
							<p><input type="checkbox" id="ocultartablaPaciente" checked="True"> Mostrar pacientes ingresados</p>
							<!-- Tabla pacientes  -->
							<div class="col-md-12 col-sm-12 col-xs-12" id="tablaPaciente"></div>
							<!-- Buscaar paciente -->
							<div class=" mb-2">
								<p><input type="checkbox" id="ocultarBusquedaRadioButoon" checked="True">Buscar paciente</p>
								<div class="col-md-12 col-sm-12 col-xs-12" id="ocultarBusqueda">
									<div class="dashboard_graph">
										<div class="" style="margin-top: 1px">
											<div class="">
												<div class="col-md-4">
													<div class="form-group">
														<div class="form-group">
															<select class="form-control" name="inputSelect" id="inputSelect">
																<option value="POR_NUMERO">N° DE PACIENTE</option>
																<option value="POR_NOMBRE">NOMBRE DEL PACIENTE</option>
																<option value="POR_NSS">N.S.S (SIN AGREGADO)</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-md-6" style="padding-right: 2px">
													<div class="input-group m-b ">
														<span class="input-group-addon back-imss " style="border:1px solid #256659">
															<i class="fa fa-search"></i>
														</span>
														<input type="text" id="inputSearch" name="inputSearch" class="form-control" autocomplete="off" placeholder="Ingresar N° de Paciente">
													</div>
												</div>
												<div class="col-md-2" style="padding-left: 0px">
													<div class="form-group">
														<input type="hidden" name="csrf_token">
														<button class="btn btn-block back-imss buscarPaciente" name="btnSearch" id=buscarPaciente>BUSCAR</button>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<h6 class="inputSelectNombre hide" style="color: red;margin-top: -10px"><i class="fa fa-warning"></i> ESTA CONSULTA ESTA LIMITADA A: 100 REGISTROS</h6>
													<table class="footable table table-bordered" id="tableResultSearch" data-filter="#search" data-page-size="20" data-limit-navigation="7" style="display:none">
														<thead>
															<tr>
																<th data-sort-ignore="true">N° DE PACIENTE</th>
																<th data-sort-ignore="true">FECHA INGRESO</th>
																<th data-sort-ignore="true">NOMBRE</th>
																<th data-sort-ignore="true">NSS</th>
																<th data-sort-ignore="true">ACCIONES</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td colspan="5" class="text-center">
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
							<!-- Camas informacion colore -->
							<div class=" mb-2">
								<p><input type="checkbox" id="ocultarCamasRadioButoon" checked> Mostrar camas</p>
								<div class="col-md-12 col-sm-12 col-xs-12 ocultarCamas">
									<div class="dashboard_graph">
										<div class="" style="margin-top: 1px">
											<table>
												<tbody>
													<tr>
														<td>
															<div class="bed-status blue-700 color-white"><i class="fa fa-bed"></i></div>
														</td>
														<td>
															<div class="bed-status pink-A100 color-white"><i class="fa fa-bed"></i></div>
														</td>
														<td><strong class="" style="padding-right: 20px">Ocupadas</strong></td>
														<td>
															<div class="bed-status green color-white"><i class="fa fa-bed"></i></div>
														</td>
														<td><strong class="" style="padding-right: 20px">Disponibles</strong></td>
														<td>
															<div class="bed-status purple-300 color-white"><i class="fa fa-bed"></i></div>
														</td>
														<td><strong class="" style="padding-right: 20px">Reservadas</strong></td>
														<td>
															<div class="bed-status cyan-400 color-white"><i class="fa fa-bed"></i></div>
														</td>
														<td><strong class="" style="padding-right: 20px">Limpias</strong></td>
														<td>
															<div class="bed-status grey-900 color-white"><i class="fa fa-bed"></i></div>
														</td>
														<td><strong class="" style="padding-right: 20px">Sucias</strong></td>
														<td>
															<div class="bed-status red color-white"><i class="fa fa-bed"></i></div>
														</td>
														<td><strong class="" style="padding-right: 20px">Contaminadas</strong></td>
														<td>
															<div class="bed-status yellow-600 color-white"><i class="fa fa-bed"></i></div>
														</td>
														<td><strong class="" style="padding-right: 20px">Descompuestas</strong></td>
														<td>
															<div class="bed-status lime color-white"><i class="fa fa-bed"></i></div>
														</td>
														<td><strong class="" style="padding-right: 20px">Reparadas</strong></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- Camas -->
							<div class=" col-mb-2">
								<div class="col-md-12 col-sm-12 col-xs-12 ocultarCamas">
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
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="area" name="area" value="<?= $this->UMAE_AREA ?>">
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url() ?>assets/libs/bootstrap-popper/popper.min.js"></script>
<script src="<?= base_url('assets/js/sections/Pacientes.js?') . md5(microtime()) ?>" 	type="text/javascript"></script>
<script src="<?= "http://" . getServerIp() . ':3001/socket.io/socket.io.js' ?>" 			type="text/javascript"></script>
<script src="<?= base_url('assets/js/AreasCriticas.js?') . md5(microtime()) ?>" 			type="text/javascript"></script>
<script src="<?= base_url('assets/Sections/Pacientes.js?') . md5(microtime()) ?>" 		type="text/javascript"></script>


<!--tooltip-inner-->