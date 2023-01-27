<?= modules::run('Sections/Menu/index'); ?>
<link href="<?=  base_url()?>assets/fonts/custom/fontello/fontello.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
  .blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}

.tile.infocamas{
  background-color: white !important;
}

.icon-bedpatient {
    width: 5%;
    display: inline-block;
    font-size: 70px;
    float: left;
    margin-top: -7px;
    padding: 3px;
}
.label {cursor: pointer;}
.title-bedstado{display:inline-block}
</style>
<link href="<?= base_url()?>assets/styles/beds.css" rel="stylesheet" type="text/css" />
<div class="app-title mb-2">
  <div>
      <h1><i class="fa fa-bed"></i> Camas</h1>
      <p>Administración de camas para pacientes hospitalizados</p>
  </div>
  <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Hospitalización</li>
        <li class="breadcrumb-item"><a href="#">Camas</a></li>
  </ul>
</div>
<div class="row mb-2">
  <div class="col-md-3">
    <div class="widget-small primary">
      <div class="info">
       	<div class="form-group">
          <label for="Ubicacion">Ubicación</label>
            <select class="form-control" id="selectPiso" name="selectPiso">
              <option value=" " disabled selected>Seleccionar Area</option>
              <?php foreach ($Piso as $value) {?>
              <option value="<?=$value['piso_id']?>"><?=$value['piso_nombre']?></option>
              <?php }?>
            </select>
        </div> 
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="widget-long">
      <div class="col-md-1 info-camas"> 
          <span class="count_top"><i class="fa fa-bed"></i> Total</span>
          <div class="count text-dark" id="camasTotal"></div>
      </div>
      <div class="col-md-2 info-camas">
        <div class="bed-status green color-white title-bedstado"><i class="fa fa-bed"></i></div>
        <div class="title-bedstado">Diponibles</div>
        <div class="count text-success" id="camasDisponibles"></div>
      </div>
      <div class="col-md-2 info-camas">
          <div class="bed-status blue-700 color-white title-bedstado"><i class="fa fa-bed"></i></div>
					<div class="bed-status pink-A100 color-white title-bedstado"><i class="fa fa-bed"></i></div>
          <div class="title-bedstado">Ocupadas</div>
          <div class="count text-primary" id="camasOcupadas"></div>
      </div>
      <div class="col-md-2 info-camas">
        <div class="bed-status grey-900 color-white title-bedstado"><i class="fa fa-bed"></i></div>
        <div class="title-bedstado">Sucias</div>
        <div class="count text-danger" id="camasSucias"></div>
      </div>
      <div class="col-md-2 info-camas">
        <div class="bed-status red color-white title-bedstado"><i class="fa fa-bed"></i></div>
        <div class="title-bedstado">Contaminadas</div>
        <div class="count text-danger" id="camasContaminadas"></div>
      </div> 
      <div class="col-md-2 info-camas">
        <div class="bed-status yellow-600 color-white title-bedstado"><i class="fa fa-bed"></i></div>
        <div class="title-bedstado">Descompuestas</div>
        <div class="count text-info" id="camasDescompuestas"></div>
      </div>
      <div class="col-md-1 info-camas">
          <span class="count_top"><i class="fa fa-bed"></i> Pre-Altas</span>
          <div class="count text-warning blink_me" id="camasPrealta"></div>
      </div>
    </div>
  </div> 
</div>
<!-- Camas -->
<div class="tile infocamas mb-2">
  <div class="title-header">
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <h1 class="mb-3 line-head" id="piso"></h1>
      </div>  
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="dashboard_graph">
        <div class="row" style="margin-top: 1px"> 
          <div class="visor-camas"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Informacion de paciente -->   
<div class="tile mb-2 info-tabs hide" style="background-color:white;">
  <div class="title-header">
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <h1 class="mb-3 line-head camaNo">Informacion de la cama <span id="nombreCama"></span></h1>
      </div>
      <div class="col-md-12 buttons-estados"> 
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="container-info-cama">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#dataPatient">Datos Paciente</a></li>
          <li><a data-toggle="tab" href="#menu1">Indicaciones Médicas</a></li>
          <li><a data-toggle="tab" href="#menu2">Médicamentos</a></li>
          <li><a data-toggle="tab" href="#menu3">Otros</a></li>
        </ul>
        <div class="tab-content">      
              <div id="dataPatient" class="tab-pane fade in active">
              </div>
              <div id="menu1" class="tab-pane fade">
                <h3>En construcción </h3>
                <p>Tenga paciencia.</p>
              </div>
              <div id="menu2" class="tab-pane fade">
                <h3>En construcción</h3>
                <p>.</p>
              </div>
              <div id="menu3" class="tab-pane fade">
                <h3>En construcción</h3>  
                <p>Tenga paciencia.</p>
              </div>
        </div>
      </div>
    </div>
    <div class="visor-camas" hidden></div>
  </div>
  <input type="hidden" name="infoEmpleado" value="<?= $this->UMAE_USER?>">
	<input type="hidden" name="area" value="<?= $this->UMAE_AREA?>">
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/EnfermeriaHosp.js?') . md5(microtime()) ?>" type="text/javascript"></script>
<link href="<?=  base_url()?>assets/styles/tooltip.css" rel="stylesheet" type="text/css" />
<script               src="<?= "http://".getServerIp().':3001/socket.io/socket.io.js'?>"> type="text/javascript"></script>
<script type="module" src="<?= base_url('assets/js/AdmisionHospitalariaSocket/AdmisionHospitalariaSocketClient.js?'). md5(microtime())?>" type="text/javascript"></script>
