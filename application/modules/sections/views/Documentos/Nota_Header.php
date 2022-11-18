<?= modules::run('Sections/Menu/HeaderNotas'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/libs/light-bootstrap/all.min.css" />
<link rel="stylesheet" href="<?= base_url()?>assets/libs/jodit-3.2.43/build/jodit.min.css"/>
<link rel="stylesheet" href="<?= base_url()?>assets/styles/notas.css"/>

<div class="col-xs-11 col-md-11 col-centered" style="margin-top: 10px">
  <div class="box-inner">
    <div class="row " style="margin-top: -30px;padding: 16px;">
      <div class="col-md-12 col-centered " style="padding: 0px;margin-bottom: -7px;">
        <h6 style="font-size: 12px;font-weight: 600;text-align: right">
          Fecha y Hora de Ingreso: <?=date("d / m/ Y", strtotime($info['triage_horacero_f']))?>  <?=$info['triage_horacero_h']?>
        </h6>
      </div>
    </div>
    <!-- Información del Paciente -->
    <!-- Cabecera de datos del paciente -->
    <div class="panel-heading p bg-white text-center" style="padding: 0px 16px!important"> 
      <div class="row" style="margin-top: 0px!important;">
        <div style="position: relative;">
          <div style="margin-left: -1px;position: absolute;">
            <img src="<?= base_url()?>assets/img/patients/patient_m.png" style="width: 90px;"/>
          </div>
        </div>
        <div class="col-xs-5 col-sm-5 text-left" style="padding-left: 85px">
          <div class="col-xs-12 col-sm-12 col-md-12" style="width:420px;height:89px">
            <h5 class="text-color-cyan" style="position:relative;top:-1px;left:1px">
              <b><?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?></b>
            </h5>
            <?php
              if($info['triage_fecha_nac']!=''){
                $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                $edad =  '<b>de'.' '. $fecha->y.' años</b>';
              }else $edad = "<b>desconocido</b>";       
            ?>
            <h5 class="text-color-black" style="position:relative;top:-7px;left:1px">
              <b><?=ucwords(strtolower($info['triage_paciente_sexo']));?> <?=$edad?> 
                <?=$PINFO['pic_indicio_embarazo']=='Si' ? '|   Posible Embarazo' : ''?>
              </b>
            </h5>
            <h5 class="text-color-blue" style="position:relative;top:-10px;lef: 1px">
              <b>NSS: <?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?></b>
            </h5>
            <div style="position:relative;top:-15px;left:1px">
                <h5 class="text-color-black">
                  <b>CAMA:</b> <?=$cama['cama_nombre']?>-<?=$piso[0]['piso_nombre_corto']?>
                </h5>
            </div> 
          </div>
        </div>
        <!-- Ultimos Signos vitales -->
        <div class="col-md-7">
          <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="padding: 5px 0px 10px 0px;">
            <?php if($UltimosSignosVitales[0]['fecha']!=''){
              $fecha = date("d-m-Y", strtotime($UltimosSignosVitales[0]['fecha']));
            } else { $fecha= 'Sin Registro';}?>
            <span class="text-color-black">Fecha de última toma de signos: <?=$fecha?></span>
          </div>
          <div class="col-xs-1 col-sm-1 col-md-1 text-center" style="width: 20%;">
            <h5 class="text-color-cyan"style="margin-top: -5px;"><b>T.A</b></h5>
            <h5 class="text-color-red" style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_ta']?> mm Hg</h5>
          </div>
          <div class="col-xs-1 col-sm-1 col-md-1 text-center" style="border-left: 1px solid black; width: 20%;">
            <h5 class="text-color-cyan"style="margin-top: -5px;"><b>Temp.</b></h5>
            <h5 class="text-color-red" style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_temp']?> °C</h5>
          </div>
          <div class="col-xs-1 col-sm-1 col-md-1 text-center" style="border-left: 1px solid black; width: 20%;">
            <h5 class="text-color-cyan"style="margin-top: -5px;"><b>F. Card.</b></h5>
            <h5 class="text-color-red" style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_fc']?> lpm</h5>
          </div>
          <div class="col-xs-1 col-sm-1 col-md-1 text-center" style="border-left: 1px solid black; width: 20%;">
            <h5 class="text-color-cyan"style="margin-top: -5px;"><b>F. Resp</b></h5>
            <h5 class="text-color-red" style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_fr']?> rpm</h5>
          </div>
          <div class="col-xs-1 col-sm-1 col-md-1 text-center" style="border-left: 1px solid black; width: 20%;">
            <h5 class="text-color-cyan"style="margin-top: -5px;"><b>SpO2</b></h5>
            <h5 class="text-color-red" style="margin-top: -6px;"> <?=$UltimosSignosVitales[0]['sv_oximetria']?> %</h5>
          </div>  
        </div>
      </div>
    </div>