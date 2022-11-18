<?php echo modules::run('Sections/Menu/index'); ?>
<div class="row">
	<div class="col-md-4">
		<div class="tile mb-4" style="background-color:#4ebcda">
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<h3 class="mb-3 line-head" style="color:#FFFFFF">Pacientes Registrados</h3>
				</div>
			</div>
			<div class="row">
				<div class="panel-body">
					<div class="col-md-5">
						<i class="fa fa-users fa-5x" style="color:#FFFFFF"></i>
					</div>
					<div class="col-md-7">
						<h5 class="text-center" style="color:#FFFFFF"><b>Total Registrados</b></h5>
						<h1 class="totalPacientes text-center" style="color:#FFFFFF"></h1>
					</div> 
				</div>

			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="tile mb-4" style="background-color:#f76c51">
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<h3 class="mb-3 line-head" style="color:#FFFFFF">Expedientes En Prestamo</h3>
				</div>
			</div>
			<div class="row">
				<div class="panel-body">
					<div class="col-md-5">
						<i class="fa fa-newspaper-o fa-5x" style="color:#FFFFFF"></i>
					</div>
					<div class="col-md-7">
						<h5 class="text-center" style="color:#FFFFFF">Total</h5>
						<h1 class="totalExpedientesPrestados text-center" style="color:#FFFFFF"></h1>
					</div> 
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">	
		<div class="tile mb-4" style="background-color:#000000">
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<h3 class="mb-3 line-head" style="color:#FFFFFF">Información día actual</h3>
				</div>
			</div>
			<div class="row">
				<div class="panel-body" style="padding-bottom: 48px;">
					<div class="col-md-5">
						<i class="fa fa-info-circle fa-5x" style="color:#FFFFFF"></i>
					</div>
					<div class="col-md-7">
						<table style="width: 100%;border: 0px; " >
						  <tr >
						    <td style="color:#FFFFFF" >Registros nuevos</td>
						    <td style="color:#FFFFFF" id="registrosDia"></td>
						  </tr>
						  <tr>
						    <td style="color:#FFFFFF">Prestados</td>
						    <td style="color:#FFFFFF" id="prestadosDia"></td>
						  </tr>
						  <tr>
						    <td style="color:#FFFFFF">Cancelados</td>
						    <td style="color:#FFFFFF">0</td>
						  </tr>

						</table>
						
					</div> 
				</div>
			</div>
		</div>
		</div>
		
	</div>
</div>

<?= modules::run('Sections/Menu/Footer'); ?>
<script type="text/javascript">
	$.ajax({
    url: base_url+"Arimac/Reportes/infoDashboardArimac",
    dataType: 'json',
    type: 'GET',
    beforeSend: function (xhr) {
                
    },
    success: function (data, textStatus, jqXHR) { 
      $('.totalPacientes').html(data.total);
      $('.totalExpedientesPrestados').html(data.total_prestados);
      $('#registrosDia').html(data.registrados_dia);
      $('#prestadosDia').html(data.prestados_dia);

    },
    error: function (e) {
            console.log(e);
            MsjError();
           }
   });
</script>