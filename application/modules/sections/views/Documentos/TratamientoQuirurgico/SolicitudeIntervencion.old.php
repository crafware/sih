
<?= modules::run('Sections/Menu/index'); ?> 
<link rel="stylesheet" href="https://twitter.github.io/typeahead.js/css/examples.css" />
<!-- <link rel="stylesheet" href="<?= base_url() ?>assets/styles/typeahead.css" rel="stylesheet" type="text/css" /> -->
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-12 col-centered" style="margin-top: -20px">
        <div class="box-inner padding">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss text-center" style="">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">
                        <b>Solicitud de Intervención Quirúrgica</b>
                    </span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="card-body" style="padding: 20px 0px;">
                        <form class="solicitud-intervencion">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: -15px">
                                    <div class="form-group">
                                        <label><b style="text-transform: uppercase">Servicio</b></label>
                                        <input name="ci_servicio" value="<?=$especialidad[0]['especialidad_nombre']?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class=""><b style="text-transform: uppercase">N° Cama</b></label>
                                        <input  value="<?=$observacion[0]['observacion_cama_nombre']?>" class="form-control" readonly="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class=""><b style="text-transform: uppercase">Fecha Solicitud</b></label>
                                        <input name="ci_fecha_solicitud" value="<?=$si[0]['ci_fecha_solicitud']?>" class="form-control dd-mm-yyyy" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class=""><b style="text-transform: uppercase">Fecha Solicitada</b></label>
                                        <input name="ci_fecha_solicitada" value="<?=$si[0]['ci_fecha_solicitada']?>" class="form-control dd-mm-yyyy">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class=""><b style="text-transform: uppercase">Hora deseado</b></label>
                                        <input name="ci_hora_deseada" value="<?=$si[0]['ci_hora_deseada']?>" class="form-control clockpicker">
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><b style="text-transform: uppercase">Elegir Prioridad</b></label>
                                        <select name="ci_prioridad" data-value="<?=$si[0]['ci_prioridad']?>" class="form-control">
                                            <option value="">Seleccionar</option>
                                            <option value="Prioridad Alta">Prioridad Alta</option>
                                            <option value="Prioridad Media">Prioridad Media</option>
                                            <option value="Prioridad Baja">Prioridad Baja</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><b style="text-transform: uppercase">Anestesia Proyectada</b></label>
                                        <select name="ci_ap" data-value="<?=$si[0]['ci_ap']?>" class="form-control">
                                            <option value="">Seleccionar</option>
                                            <option value="Local">Local</option>
                                            <option value="Regional">Regional</option>
                                            <option value="General">General</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><b style="text-transform: uppercase">Operación planeada</b></label>
                                        <select name="ci_operacion_eu" data-value="<?=$si[0]['ci_tipo_procedimiento']?>" class="form-control">
                                            <option value="">Seleccionar</option>
                                            <option value="Electiva">Electiva</option>
                                            <option value="Urgencia">Urgencia</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class=""><b style="text-transform: uppercase">Diagnostico preoperatorio</b></label>
                                        <div class="scrollable-dropdown-menu " id="prefetch">
                                            <input name="ci_diagnostico"  value="<?=$si[0]['ci_nombre_diagnostico']?>" class="form-control typeahead" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class=""><b style="text-transform: uppercase">Procedimiento Quirúrgico</b></label>
                                        <div class="scrollable-dropdown-menu" id="prefetch2">
                                            <input name="ci_proc_quiru" id="proc_quiru" value="<?=$si[0]['ci_nombre_porcedimiento']?>" class="form-control typeahead">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    
                                    <div class="form-group">
                                        <label class=""><b style="text-transform: uppercase">Grupo Sanguineo</b></label>
                                        <input name="" value="<?=$st[0]['solicitudtransfucion_gs_abo']?>" readonly="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class=""><b style="text-transform: uppercase">RH</b></label>
                                        <input name="" value="<?=$st[0]['solicitudtransfucion_gs_rhd']?>" readonly="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class=""><b style="text-transform: uppercase">En quirófano</b></label>
                                        <input name="" value="<?=$st[0]['solicitudtransfucion_disponible']?>" readonly="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class=""><b style="text-transform: uppercase">En reserva</b></label>
                                        <input name="" value="<?=$st[0]['solicitudtransfucion_reserva']?>" readonly="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class=""><b style="text-transform: uppercase">Tiempo estimada de cirugia</b></label>
                                        <input name="ci_tec" value="<?=$si[0]['ci_tec']?>" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                    <input type="hidden" name="tratamiento_id" value="<?=$this->uri->segment(4)?>">
                                    <input type="hidden" name="csrf_token">


                                    <button class="btn btn-primary btn-block">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer');?>
<script src="<?= base_url('assets/js/sections/TratamientoQuirurgico.js?'). md5(microtime())?>" type="text/javascript"></script>
<!-- <script src="<?= base_url('assets/libs/bootstrap3-typeahead/bootstrap3-typeahead.min.js')?>"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script>
<script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        var sample_data = new Bloodhound({
         datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
         queryTokenizer: Bloodhound.tokenizers.whitespace,
         prefetch: '<?php echo base_url(); ?>Sections/Documentos/BuscarDxPreoperatorio',
         remote:{
            url: '<?php echo base_url(); ?>Sections/Documentos/BuscarDxPreoperatorio?query=%QUERY',
            wildcard:'%QUERY'
            }
        });
        $('#prefetch .typeahead').typeahead({minLength: 3}, {
            name: 'sample_data',
            display: 'nombre',
            source:sample_data.ttAdapter(),
            limit:300,
            templates:
             {
              suggestion:Handlebars.compile('<div class="row"><div class="col-md-8" style="padding-right:5px; padding-left:5px;">{{nombre}}</div></div>')
             }
        });
        let cirugias = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            // prefetch: '<?php echo base_url(); ?>Sections/Documentos/BuscarProceQuirurgico',
            remote:{
                     url: '<?php echo base_url(); ?>Sections/Documentos/BuscarProceQuirurgico?search=%QUERY',
                     wildcard:'%QUERY'
                   }
          });
            $('#prefetch2 .typeahead').typeahead({minLength: 3}, {
                name: 'cirugias',
                display: 'cirugia',
                source:cirugias.ttAdapter(),
                limit:300,
                templates:
                {
                suggestion:Handlebars.compile('<div class="row"><div class="col-md-8" style="padding-right:5px; padding-left:5px;">{{cirugia}}</div></div>')
                }
            });
    });
</script>
    
  

        
    
    
    
