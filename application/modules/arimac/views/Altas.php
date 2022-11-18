<?= modules::run('Sections/Menu/index'); ?>
<style>
  
    .lista {
    display: inline-block;
    font-size: 105%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    padding: 0.25em 0.4em;
    border-radius: 0.25rem;
    background-color: white !important;
    color: black;
}
  
</style> 
<div class="app-title">
  <div>
      <p>Apertura y Consulta de Expedientes</p>
      <h1><i class="fa fa-address-book-o"></i> Expediente Clínico </h1>
  </div>
  <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Arimac</li>
        <li class="breadcrumb-item"><a href="#"></a></li>
  </ul>
</div>
<div class="panel panel-default ">  
  <!-- Bisqueda de Paciente en UMAE -->     
  <div class="panel-body b-b b-light">
    <div class="row">
      <div class="col-md-3">
        <label for=""><b>Buscar NSS</b></label>
        <div class="input-group m-b">
          <input type="text" name="nss" class="form-control" data-inputmask="'mask': '99999999999'" placeholder="Ingresar número afiliación">
          <span class="input-group-addon back-imss border-back-imss">
            <i class="fa fa-search"></i>
          </span>
        </div>
      </div>  
    </div>
    <form class="registroPacienteUmae">
      <!-- Datos de afiliación -->
      <div class="tile mb-4 dataPaciente hidden">
        <div class="title-header">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <h1 class="mb-3 line-head" id="piso">Datos de Afiliación del Paciente - Número <span class="noexp"></span></h1>
            </div>
          </div>
        </div>
        <div class="row" >
          <div class="col-md-4">
            <label style="text-transform: uppercase;font-weight: bold;">N.S.S</label>
            <div class="input-group">
              <input class="form-control" name="nss_umae" value="" data-inputmask="'mask': '99999999999'" required>
              <span class="input-group-btn">
                <button type="button" class="btn btn-success" id="btnVerificarNSS" >Verificar</button>
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">N.S.S Agregado</label>
              <input class="form-control" name="nss_agregado" placeholder="" value="" required >
            </div>
          </div>
          <div class="col-md-4" ><?php 
            if($PINFO['pia_vigencia'] == 'SI'){
              $colorVigencia = 'background-color: rgb(144, 255, 149);';
            }else if($PINFO['pia_vigencia'] == 'NO'){
              $colorVigencia = 'background-color: rgb(252, 155, 155);';
            }?>
            <div class="form-group" >
              <label style="font-weight: bold">Vigencia de Derechos</label>
              <input class="form-control" style="<?=$colorVigencia ?>" name="pia_vigencia" value="<?=$PINFO['pia_vigencia']?>" required >
            </div>
          </div>
        </div>
        <div class='row'> 
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Delegación IMSS</label>
              <input class="form-control" name="delegacion" placeholder="" value="<?=$PINFO['pum_delegacion']?>" required >
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" >
              <label style="font-weight: bold">U.M.F de Adscripción</label>
              <input class="form-control"  name="umf" placeholder="" value="<?=$PINFO['pum_umf']?>" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" >
              <label style="font-weight: bold">C.U.R.P</label>
              <input class="form-control"  name="curp" placeholder="" value="<?=$info[0]['triage_paciente_curp']?>" required>
            </div>
          </div>
        </div>
        <div class="row">                    
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Apellido Paterno </label>
              <input class="form-control" name="nombre_ap" value="" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Apellido Materno </label>
              <input class="form-control" name="nombre_am" value="" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Nombre(s)</label>
              <input class="form-control" name="nombre" placeholder="" value="" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Fecha de Nacimiento</label>
              <input class="form-control dd-mm-yyyy" name="fechaNac" placeholder="01/01/2016" value="" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Sexo</label>
                <select class="form-control" name="sexo" data-value="<?=$info[0]['triage_paciente_sexo']?>">
                    <option value="">Seleccionar</option>
                    <option value="HOMBRE">HOMBRE</option>
                    <option value="MUJER">MUJER</option>
                </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Telefóno de contacto</label>
              <input class="form-control" name="telefono" data-inputmask="'mask': '99 9999 9999'"value="<?=$info[0]['triage_fecha_nac']?>" required>
            </div>
          </div>
        </div>
      </div>
      <!-- Domicilio -->
      <!--
      <div class="tile mb-4 domicilio hidden">
        <div class="title-header">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <h1 class="mb-3 line-head" id="piso">Domicilio del Paciente</h1>
            </div>
          </div>
        </div>
        <div class="row">                
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Código Postal</label>
                <div class="input-group">
                  <input class="form-control" name="cp" placeholder="" value="<?=$DirPaciente['directorio_cp']?>">
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-secondary" id="buscarCP" ><i class="glyphicon glyphicon-search"></i></button>
                  </span>
                </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                  <label style="font-weight: bold">Calle y Número</label>
                  <input class="form-control" name="calle_numero" placeholder="" value="<?=$DirPaciente['directorio_cn']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                  <label style="font-weight: bold">Colonia</label>
                  <input class="form-control" name="colonia" placeholder="" value="<?=$DirPaciente['directorio_colonia']?>">
            </div>
          </div>                 
        </div>
        <div class="row">  
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Municipio/Delegación</label>
              <input class="form-control" name="municipio" placeholder="" value="<?=$DirPaciente['directorio_municipio']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label style="font-weight: bold">Estado</label>
                <input class="form-control" name="estado" placeholder="" value="<?=$DirPaciente['directorio_estado']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Teléfono de Contacto</label>
              <input class="form-control" type="number" name="telefono" placeholder="" value="<?=$DirPaciente['directorio_telefono']?>">
            </div>
          </div>
        </div>
      </div> -->
      <!-- Especilidad atencion -->
      <div class="tile mb-4 dataPaciente hidden">
        <div class="title-header">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <h2 class="mb-3 line-head" id="piso">Especialidad Tratante</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label style="font-weight: bold">Especialidad</label>
                <select name="ingreso_servicio" class="ingreso_servicio form-control" data-value="<?=$Doc43051['ingreso_servicio']?>">
                  <option value='' disabled selected>Seleccionar</option>
                  <?php foreach ($Especialidades as $value) {?>
                  <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                  <?php }?>
                </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label style="font-weight: bold">Médico Tratante</label>
              <select name="ingreso_medico" id="divMedicos" class="form-control" data-value="<?=$Doc43051['ingreso_medico']?>" required>
                  <!-- Se llena las opciones de manera dinamica desde ajax y controlador -->
                <option value='' disabled selected>Seleccionar</option>
                <option value="<?=$Doc43051['ingreso_medico']?>"><?=$medicoTratante['empleado_apellidos']?> <?=$medicoTratante['empleado_nombre']?> </option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label style="font-weight: bold">Tipo de Ingreso</label>
              <select class="form-control" name="tipo_ingreso" data-value="<?=$Doc43051['ingreso_medico']?>" required>
                  <!-- Se llena las opciones de manera dinamica desde ajax y controlador -->
                <option value='' disabled selected>Seleccionar</option>
                <option value="4.30.08">4.30.08</option>
                <option value="Urgente">Urgente</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group" >
              <label style="font-weight: bold">Persona quién registra</label>
              <input class="form-control" name="usuarioRegistra" required="" value="<?=$pinfo['usuario_registra']=='' ? $empleado[0]['empleado_nombre'].' '.$empleado[0]['empleado_apellidos'] : $pinfo['usuario_registra']?>" disabled>
            </div>
          </div>
        </div>
      </div>
      <!-- Datos del paciente encontrado -->
      <div class="tile mb-4 infoPaciente hidden">
        <div class="title-header">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <h2 class="mb-3 line-head" id="piso">Datos del Paciente</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="row">
                  <div class="col col-xs-6">
                    <h3 class="panel-title" itemprop="name">Información encontrada</h3>
                  </div>
                  <div class="col col-xs-6 text-right">
                    <div class="actions">
                      <a href="javascript:;" class="btn editar">
                        <i class="glyphicon glyphicon-pencil"></i>
                        Editar 
                      </a>
                      <a href="javascript:;" class="btn imprime">
                        <i class="glyphicon glyphicon-print"></i>
                        Imprimir Etiqueta
                      </a>
                      <a href="javascript:;" class="btn btn-circle cerrar">
                        <i class="glyphicon glyphicon-remove-circle"></i>
                        Cerrar
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="panel-body" itemprop="reviewBody">
                <div class="media">
                  <div class="media-left avatar"></div>
                  <div class="media-body">
                    <h4 class="media-heading nomPaciente"></h4>
                    <h1 class="media-heading noExpediente"></h1>
                    <div class="card-body" style="width:700px; margin: -20px 0px 0px -22px" >
                      <ul class="list-group list-group-flush ml-0 mb-2">
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                              NSS
                              <span class="badge lista nss-agregado"></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center ">
                              UMF
                              <span class="badge lista umf"></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center ">
                              DELEGACIÓN
                              <span class="badge lista deleg"></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center ">
                              CURP
                              <span class="badge lista curp"></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center ">
                              TELEFONO DE CONTACTO
                              <span class="badge lista tel"></span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center [hide_empty:update_date]">
                              REGISTRADO
                              <span class="badge lista fecha_registro_usuario"></span>
                          </li>
                      </ul>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- Procesa datos del pacceinte cuando se hace apertura de expedeinte  o actualiza datos -->
      <div class="title mb-4 dataPaciente hidden">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-offset-8 col-md-2">
              <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.location.href=base_url+'Arimac/Altapaciente'">Cancelar</button>
            </div>
            <div class="col-md-2">
              <input type="hidden" name="csrf_token" >
              <input type="hidden" name="noExpediente" value="<?=$info['idPaciente']?>">
              <input type="hidden" name="area" value="<?= $this->UMAE_AREA?>">
              <button class="md-btn md-raised m-b btn-fw back-imss btn-block waves-effect no-text-transform pull-right" type="submit" style="margin-bottom: -10px">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </form> 
  </div>
</div>

<?= modules::run('Sections/Menu/Footer'); ?>
<script src="<?=  base_url()?>assets/libs/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="<?= base_url('assets/js/Mensajes.js')?>" type="text/javascript"></script>
<!-- <script src="<?= base_url('assets/js/sections/Nss.js?'). md5(microtime())?>" type="text/javascript"></script> -->
<script src="<?= base_url('assets/js/Arimac.js?'). md5(microtime())?>" type="text/javascript"></script> 
