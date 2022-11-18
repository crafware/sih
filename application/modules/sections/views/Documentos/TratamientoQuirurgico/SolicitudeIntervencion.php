<?= modules::run('Sections/Menu/index'); ?> 
<link rel="stylesheet" href="<?=base_url()?>assets/styles/typeahead.css" rel="stylesheet" type="text/css"/>

<div class="app-title">
  <div>
    <h1><i class="fa fa-file-text-o"></i> Intervenciones y Procedimientos Quirurgicos</h1>
    <p>Solicitudes</p>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item"><a href="#">Catálogo</a></li>
  </ul>
</div>

<div class="tile mb-4">
   <div class="page-header">
    <div class="row">
      <div class="col-lg-12">
        <h2 class="mb-3 ">Solicitud</h2>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-centered" style="margin-top: -10px">
    <div class="box-inner">
      <div class="panel panel-default ">
        <div class="panel-body b-b b-light">
          <div class="card-body" style="padding: 20px 0px;">
            <form class="solicitud-intervencion">
              <div class="row">              
                <div class="form-group col-md-4">
                  <label class="bold">Número Seguro Social</label>
                  <div class="input-group">
                    <input type="text" name="nss"  required="required" class="form-control">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-success btnVerificarNSS" ><i class="fa fa-search"></i></button>
                    </span>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label class="bold">Agregado Médico</label>
                  <input  name="agregadoMedico" value="<?=$observacion[0]['observacion_cama_nombre']?>" class="form-control" required="required">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-4">
                  <label class="bold">Nombre(s)</label>
                  <input name="nombre" class="form-control" value="" required="required">
                </div>
                <div class="form-group col-md-4">
                  <label class="bold">Apellido Paterno</label>
                  <input name="nombrePaterno" class="form-control" value="" required="required">
                </div>
                <div class="form-group col-md-4">
                  <label class="bold">Apellido Materno</label>
                  <input name="nombreMaterno" class="form-control" value="" required="required">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-5">
                  <label class="control-label bold" for="">Cirugía</label>
                  <div class="col-md-12">
                    <label class="radio-inline"><input type="radio" name="cirugia" id="electiva" value="e" required="required"> Electiva </label>
                    <label class="radio-inline"><input type="radio" name="cirugia" id="urgencia" value="u"> Urgencia </label>
                    <label class="radio-inline"><input type="radio" name="cirugia" id="reintervencion" value="r"> Reintervención </label>
                  </div>
                </div>
                <div class="form-group col-md-4">
                  <label class="bold">Fecha Solicitada</label>
                  <input name="fechaSolicitada" value="<?=$si[0]['ci_fecha_solicitada']?>" class="form-control dd-mm-yyyy" required="required">
                </div>
                <div class="form-group col-md-3">
                  <label class="bold">Hora solicitada</label>
                  <input name="horaSolicitada" value="<?=$si[0]['ci_hora_deseada']?>" class="form-control clockpicker" required="required">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label class="bold">Diagnóstico Preoperatorio</label>
                  <div class="dxPreop" id="prefetch">
                    <input name="ci_diagnostico" id="search_box" class="form-control typeahead" value="<?=$si[0]['ci_diagnostico']?>" required="required">
                    <input type="hidden" name="cie10_id" id="cie10_id" value="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label class="bold">Operación Proyectada</label>
                  <div class="cxProyectada" id="prefetch">
                    <input type="text" name="procedimiento" class="form-control typeahead" required="required">
                    <input type="hidden" name="cie9_id" id="cie9_id" value="">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-5">
                  <label class="control-label bold" for="">Hemoderivados el dia de la cirugía</label>
                  <p>
                    <label class="radio-inline"><input type="radio" name="reqSangre" id="reqSangre1" value="si" required="required"> Si </label>
                    <label class="radio-inline"><input type="radio" name="reqSangre" id="reqSangre2" value="no"> No </label>
                  </p>
                </div>
              </div>
              <div class="row reqSangre hidden">
                <div class="form-group col-md-3">
                  <label class="bold">Grupo Sanguineo</label>
                  <input name="" value="<?=$st[0]['solicitudtransfucion_gs_abo']?>" class="form-control">
                </div>
                <div class="form-group col-md-3">
                  <label class="bold">Rh (D)</label>
                  <input name="" value="<?=$st[0]['solicitudtransfucion_gs_rhd']?>" class="form-control">
                </div>
                <div class="form-group col-md-3">
                  <label class="bold">En quirófano (ml.)</label>
                  <input name="" value="<?=$st[0]['solicitudtransfucion_disponible']?>" class="form-control">  
                </div>
                <div class="form-group col-md-3">
                  <label class="bold">En reserva (ml.)</label>
                  <input name="" value="<?=$st[0]['solicitudtransfucion_reserva']?>" class="form-control">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-4">
                  <label class="control-label bold" for="">Tipo de Anestesia</label>
                  <div class="col-md-12">
                    <label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="1"> Local </label>
                    <label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="2"> Regional </label>
                    <label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="3"> General </label>
                  </div>
                </div>
                <div class="form-group col-md-4">
                  <label class="control-label bold" for="">Valoración Preoperatoria Permisible</label>
                  <div class="col-md-12">
                    <label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="l"> Si </label>
                    <label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="2"> No </label>
                    <label class="radio-inline"><input type="radio" name="anestesia" id="anestesia" value="0"> No requiere </label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-4">
                  <label class="control-label bold" for="">Prueba para COVID-19</label>
                  <div class="col-md-12">
                    <label class="radio-inline"><input type="radio" name="pruebaCovid" id="pruebaCovid" value="l"> Si </label>
                    <label class="radio-inline"><input type="radio" name="pruebaCovid" id="pruebaCovid" value="2"> No </label>
                  </div>
                </div>
                  <div class="form-group col-md-4">
                    <label class="control-label bold" for="">Tele de Torax Preoperatoria</label>
                    <div class="col-md-12">
                      <label class="radio-inline"><input type="radio" name="telePreoperatoria" id="telePreoperatoria" value="l"> Si </label>
                      <label class="radio-inline"><input type="radio" name="telePreoperatoria" id="telePreoperatoria" value="2"> No </label>
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <label class="control-label bold" for="">Tiempo Quirurgico Aproximado</label>
                    <input name="tiempoQx" value="<?=$st[0]['solicitudtransfucion_reserva']?>" class="form-control">
                  </div>
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <label class="bold">Requerimientos, Insumos y Equipo Necesarios</label>
                  <textarea name="material" class="form-control" id="material" rows="3"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-10">
                  <label class="bold" for="">Nombre del Médico Tratante</label>   
                    <select class="select2 width100" name="medicoBase" id="medicoBase" data-value="<?=$Nota['notas_medicotratante']?>" required>
                      <option value="" disabled selected>Seleccione</option>
                      <?php foreach ($MedicosBase as $value) { ?>
                      <option value="<?=$value['empleado_matricula'] ?>"><?=$value['empleado_nombre'] ?> <?=$value['empleado_apellidos'] ?></option>
                      <?php } ?>
                    </select>
                </div>
          
                <div class="form-group col-md-2 ">
                  <label class="bold" for="">Agregar médico</label>
                  <button type="button" class="btn btn-info form-control">Add</button>
                 </div>
              </div>
                  
                  
                  <!-- <div class="col-md-3">
                      <div class="form-group">
                          <label class=""><b style="text-transform: uppercase">Nombre Jefa de Servicio</b></label>
                          <input name="ci_njs" value="<?=$si[0]['ci_njs']?>" class="form-control">
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="form-group">
                          <label class=""><b style="text-transform: uppercase">Nombre Médico Cirujano</b></label>
                          <input name="ci_nmc" value="<?=$si[0]['ci_nmc']?>" class="form-control">
                      </div>
                  </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class=""><b style="text-transform: uppercase">Matricula</b></label>
                            <input name="ci_mmc" value="<?=$si[0]['ci_mmc']?>" class="form-control">
                        </div>
                        <input type="hidden" name="triage_id" value="<?=$_GET['folio']?>">
                        <input type="" name="tratamiento_id" value="<?=$this->uri->segment(4)?>">
                        <input type="hidden" name="csrf_token">
                        <button class="btn btn-primary btn-block">Guardar</button>
                    </div> -->
             <div class="row">
              <div class="col-md-offset-8 col-md-2 mt-5">
                <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
              </div>
              <div class="col-md-2 mb-4 mt-5" >
                <input type="hidden" name="csrf_token" >
                <input type="" name="area" value="<?=$this->UMAE_USER;?>">
                <input type="hidden" name="asistentesmedicas_id" value="<?=$solicitud[0]['asistentesmedicas_id']?>">   
                <button class="btn back-imss btn-block " type="submit" >Guardar</button>
              </div>
              <br><br><br><br>  
             </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/TratamientoQuirurgico.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Nss.js?'). md5(microtime())?>" type="text/javascript"></script>
<!-- <script src="<?= base_url('assets/libs/bootstrap3-typeahead/bootstrap3-typeahead.min.js')?>"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script>
<script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
      
    var cie10_data = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: '<?php echo base_url(); ?>Sections/Documentos/BuscarDxPreop',
      remote:{
          url: '<?php echo base_url(); ?>Sections/Documentos/BuscarDxPreop?query=%QUERY',
          wildcard:'%QUERY'
      }
    });
  
    $('.dxPreop .typeahead').typeahead(
      {minLength: 3,
       hint: true,
       highlight: true
      }, 
      {
         name: 'cie10_data',
         display: 'nombre',
         source: cie10_data.ttAdapter(),
         limit: 1500,
         templates:
         {
          empty: [
                  '<div class="empty-message">',
                  'Imposible encontrar petición con ese criterio de búsqueda',
                  '</div>'
                  ].join('\n'),
          suggestion:Handlebars.compile('<div class="row"><div class="col-md-12" style="padding-right:5px; padding-left:5px;">{{nombre}} - <strong>{{clave}}</strong></div></div>')
         }
      }
    );
    
    $('.dxPreop .typeahead').bind('typeahead:select', function(ev, suggestion) {
        $('#cie10_id').val(suggestion.cie10_id);
    });

    var cie9_data = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      prefetch: '<?php echo base_url(); ?>Sections/Documentos/BuscarProcedimiento',
      remote:{
          url: '<?php echo base_url(); ?>Sections/Documentos/BuscarProcedimiento?query=%QUERY',
          wildcard:'%QUERY'
      }
    });

    $('.cxProyectada .typeahead').typeahead(
      {minLength: 3,
       hint: true,
       highlight: true
      }, 
      {
         name: 'cie9_data',
         display: 'nombre',
         source: cie9_data.ttAdapter(),
         limit: 1500,
         templates:
         {
          empty: [
                  '<div class="empty-message">',
                  'Imposible encontrar petición con ese criterio de búsqueda',
                  '</div>'
                  ].join('\n'),
          suggestion:Handlebars.compile('<div class="row"><div class="col-md-12" style="padding-right:5px; padding-left:5px;">{{nombre}} - <strong>{{clave}}</strong></div></div>')
         }
      }
    );
    $('.cxProyectada .typeahead').bind('typeahead:select', function(ev, suggestion) {
        $('#cie9_id').val(suggestion.id_cx);
    });

    $('input[name=reqSangre]').click(function(e) {
      if($(this).val() == 'si') {
        $('.reqSangre').removeClass('hidden');
      }else $('.reqSangre').addClass('hidden');
    });

  });
</script>