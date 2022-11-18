<?= modules::run('Sections/Menu/index'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/libs/light-bootstrap/all.min.css" />
<style type="text/css">
  .lista_diagnosticos{
  list-style: none;
  padding: 5px;
  margin: 0px;
  display: block;
  position: relative;
  
  border-left: 1px solid #000;
  border-right: 1px solid #000;
  border-bottom: 1px solid #00000038;
  color: black;
  background-color: #fff;
}
.lista_diagnosticos:hover{
  background-color: #256659;
  color: white;
}
.contenedor_consulta_diagnosticos{
  margin-top: 36px;
  max-width: 2000px;
  max-height: 200px;
  position:absolute;
  left:-40px;
  z-index: 1;
  overflow-y: auto;
  overflow-x: auto;
}
</style>
<div class="box-row">
  <div class="box-cell">
    <div class="col-md-11 col-centered">
      <div class="box-inner padding">
        <div class="panel panel-default " style="margin-top: -10px">
          <div class="panel-heading p teal-900 back-imss">
            <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">ORDEN DE INTERNAMIENTO HOSPITALARIO</span>
          </div>
          <div class="panel-body b-b b-light">
            <div class="card-body">
            <!-- formulario -->  
              <form class="orden-internamiento-medico">
                <div class="row" style="margin-top: -20px">
                  <div class="col-md-12" style="margin-top: 0px">
                    <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -5px;">
                      <div class="col-md-12 back-imss text-center">
                        <h5><b>DATOS DEL PACIENTE</b></h5>
                      </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="text-transform: uppercase;font-weight: bold;">N.S.S</label>
                                <div class="input-group">
                                    <input class="form-control" name="pum_nss" value="<?=$PINFO['pum_nss']?>" data-inputmask="'mask': '9999-99-9999-9'" required >                               
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-secondary" id="btnVerificarNSS" >Buscar</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label style="text-transform: uppercase;font-weight: bold">Agregado médico</label>
                            <input class="form-control" required name="pum_nss_agregado" placeholder="" value="<?=$PINFO['pum_nss_agregado']?>">
                          </div>
                        </div>
                        <div class="col-md-4" >
                            <div class="form-group">
                                <label style="text-transform: uppercase;font-weight: bold">Sexo</label>
                                <select class="form-control" name="triage_paciente_sexo" data-value="<?=$info['triage_paciente_sexo']?>">
                                <option value="">Seleccionar</option>
                                <option value="HOMBRE">HOMBRE</option>
                                <option value="MUJER">MUJER</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">                    
                      <div class="col-md-4">
                        <div class="form-group">
                          <label style="text-transform: uppercase;font-weight: bold">Apellido Paterno </label>
                          <input class="form-control" name="triage_nombre_ap" value="<?=$info['triage_nombre_ap']?>" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label style="text-transform: uppercase;font-weight: bold">Apellido Materno </label>
                          <input class="form-control" name="triage_nombre_am" value="<?=$info['triage_nombre_am']?>" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group" >
                          <label style="text-transform: uppercase;font-weight: bold">Nombre(s) </label>
                          <input class="form-control" name="triage_nombre" placeholder="" value="<?=$info['triage_nombre']?>"required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" >
                                <label style="text-transform: uppercase;font-weight: bold">Fecha de Nacimiento</label>
                                <input class="dd-mm-yyyy form-control" name="triage_fecha_nac" placeholder="dd/mm/aaaa" value="<?=$info['triage_fecha_nac']?>" required>
                            </div>
                        </div>
                    </div> 
                    <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -0px;">      
                        <div class="col-md-12 back-imss text-center">
                            <h5><b>DATOS DEL INTERNAMIENTO</b></h5>
                        </div> 
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label style="text-transform: uppercase;font-weight: bold">Diagnóstico de ingreso CIE-10:</label>
                            <div class="input-group">
                              <input type="text" class="form-control" id="text_diagnostico_0" autocomplete='off' onkeydown="BuscarDiagnostico(0)" value="<?= $Diagnostico[0]['cie10_nombre'] ?>" placeholder="Tecleé el nombre del diagnóstico y seleccionar" required>
                              <!-- lista que almacenan los diagnosticos consultados por el médico -->
                              <ul class="contenedor_consulta_diagnosticos" id="lista_resultado_diagnosticos_0"></ul>
                              <input type="hidden" name="cie10_id[]" id="text_id_diagnostico_0" value="">
                                <span class="input-group-btn" >
                                <button type="button" class="btn btn-secondary" id="btnborrardx" data-toggle="tooltip" data-placement="top" title="Borrar diagnóstico">
                                  <i class="fa fa-trash-o" style="font-size: 16px"></i>
                                </button>
                              </span>
                              <span class="input-group-btn" style="border-left: 3px solid white;">
                                <button type="button" class="btn btn-secondary" id="btncomplemento" data-toggle="tooltip" data-placement="top" title="Complemento de diagnóstico">
                                  <i class="fa fa-file-text" style="font-size: 16px"></i>
                                </button>
                              </span>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-12 complemento hidden">
                        <div class="form-group" >
                          <input type="text" class="form-control" name="complemento" value="<?=$diagnostico[0]["complemento"]?>" placeholder="Puede escribir un complemento del diagnóstico seleccionado">
                        </div>
                      </div>
                    </div>
                    <div class="row"> 
                      <div class="col-md-7">
                        <div class="form-group" >
                          <label style="text-transform: uppercase;font-weight: bold">Motivo de Internamiento:</label>
                          <input type="text" class="form-control" name="ordeni_motivo" value="<?=$info_ordeni['ordeni_motivo']?>"placeholder="Anote el motivo por el cual se interna el paciente" required=""> 
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="col-md-7">
                          <label style="text-transform: uppercase;font-weight: bold">Fecha ingreso</label>
                            <input class="form-control dd-mm-yyyy" name="ordeni_fecha" placeholder="dd/mm/aaaa" value="<?=$info_ordeni['ordeni_fecha']?>" required>
                        </div>
                        <div class="col-md-5">
                          <label style="text-transform: uppercase;font-weight: bold">Hora</label>
                          <input class="form-control clockpicker" name="ordeni_hr" placeholder="hr:min" value="<?=$info_ordeni['ordeni_hr']?>" required>
                        </div>
                      </div>
                    </div>            
                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-4 col-md-offset-8">
                          <input type="hidden" name="url_tipo" value="Am">
                          <input type="hidden" name="csrf_token" >
                          <input type="hidden" name="triage_id" value="<?=$this->uri->segment(3)?>">
                          <button class="md-btn md-raised m-b btn-fw back-imss  btn-block waves-effect no-text-transform pull-right" type="submit" style="margin-bottom: -10px">Guardar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>            
              </form>
               <!--   Modal para verificacion del la vigencia de afiliacion -->
                <div class="modal fade" id="ModalVigencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" id="modalTamanioG">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Validacion de Vigencia de Derechos</h4>
                      </div>
                      <div class="modal-body table-responsive" id="infoNSS"></div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                        </div>
                     </div>
                  </div>
                </div> <!-- Fin del Modal -->  
                  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<<!-- script type="text/javascript" src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js"></script> -->
<script src="<?= base_url()?>assets/libs/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="<?= base_url('assets/js/ConsultaExternaMedico.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/Asistentemedica.js?'). md5(microtime())?>" type="text/javascript"></script>



