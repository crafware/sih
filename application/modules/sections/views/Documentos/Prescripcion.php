<?= modules::run('Sections/Menu/index'); ?>

<div class="box-row">
  <div class="box-cell">
    <div class="box-inner col-md-12 col-centered">
      <div class="panel panel-default " style="margin-top: 10px">
        <div class="panel-heading p teal-900 back-imss" style="padding-bottom: 0px;">
          <div class="row" style="margin-top: -20px;">
            <div class="col-md-9" style="padding-left: 40px;">
              <div style="position: relative">
                <div style="top: 4px;position: absolute;height: 65px;width: 35px;left: -41px;" class="<?= Modules::run('Config/ColorClasificacion',array('color'=>$info['triage_color']))?>">
                </div>
              </div>
              <h5>
                <b>PACIENTE:</b> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?> | 
                <b>SEXO: </b><?=$info['triage_paciente_sexo']?> <?=$PINFO['pic_indicio_embarazo']=='Si' ? '| - Posible Embarazo' : ''?> | 
                <b>PROCEDENCIA:</b> <?=$PINFO['pia_procedencia_espontanea']=='Si' ? 'ESPONTANEA ' : ' '.$PINFO['pia_procedencia_hospital'].' '.$PINFO['pia_procedencia_hospital_num']?> | 
                <b>NSS:</b> <?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?> |
              </h5><?=$this->UMAE_SERVICIO?>
             <h5 style="margin-top: -5px;text-transform: uppercase">
                <?php 
                  if($info['triage_fecha_nac']!=''){
                      $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                      if($fecha->y<15){
                          echo 'PEDIATRICO';
                      }if($fecha->y>15 && $fecha->y<60){
                          echo 'ADULTO';
                      }if($fecha->y>60){
                          echo 'GERIATRICO';
                      }
                  }else{
                      echo 'S/E';
                  }
                ?> 
             </h5>
            </div>
            <div class="col-md-3 text-right">
              <h5><b>EDAD</b></h5>
              <h4 style="margin-top: -10px">
                <?php 
                  if($info['triage_fecha_nac']!=''){
                    $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac']));
                    echo $fecha->y.' <span>Años</span>';
                  }else{
                    echo 'S/E';
                  }
                ?>
              </h4>
            </div>
          </div>
        </div>
        <div class="panel-body b-b b-light">
          <form id="formPrescripcion">
            <div class="row">
              <div class="col-md-12">
                <h4>Agregar prescripción médica</h4>
              </div>
              <div class="col-md-8 col-sm-8">
                <div class="form-group">
                  <label><b>Medicamento / Forma farmacéutica (Cuadro Básico)</b></label>
                  <div class="input-group">
                    <div class id="borderMedicamento" >
                      <select id="select_medicamento" onchange="indicarInteraccion()" class="form control select2 selectpicker" style="width: 100%" hidden>
                         <option value="0">-Seleccionar-</option>
                         <?php foreach ($medicamentos as $value) {?>
                         <option value="<?=$value['medicamento_id']?>" ><?=$value['medicamento']?></option>
                         <?php } ?>
                      </select>
                    </div>
                    <div id="border_otro_medicamento" hidden>
                      <input type="text" class="form-control" id="input_otro_medicamento" placeholder="Indicar otro medicamento">
                    </div>
                    <span class="input-group-btn otro_boton_span">
                      <button class="btn btn-default btn_otro_medicamento" type="button" value="0" title="Indicar otro medicamento">Otro medicamento</button>
                    </span>
                  </div>
                </div>
              </div>
                <!-- Formulario para antibiotico NTP
                *El formulrio es desplegado en una ventana modal* -->
              <div class="form-group form-antibiotico-npt" hidden>
                 <input class="form-control" id="categoria_safe"/>
                 <input class="form-control aminoacido" />
                 <input class="form-control dextrosa" />
                 <input class="form-control lipidos-intravenosos" />
                 <input class="form-control agua-inyectable" />
                 <input class="form-control cloruro-sodio" />
                 <input class="form-control sulfato-magnesio" />
                 <input class="form-control cloruro-potasio" />
                 <input class="form-control fosfato-potasio" />
                 <input class="form-control gluconato-calcio" />
                 <input class="form-control albumina" />
                 <input class="form-control heparina" />
                 <input class="form-control insulina-humana" />
                 <input class="form-control zinc" />
                 <input class="form-control mvi-adulto" />
                 <input class="form-control oligoelementos" />
                 <input class="form-control vitamina" />
                 <input class="form-control total-npt" />
                 <!-- Campos antimicrobianos y oncologicos -->
                 <input class="form-control diluyente" />
                 <input class="form-control vol_diluyente" />
              </div>
              <!-- Fin formulario para antibiotico NTP -->

              <!-- identificador de los medicamentos con interaccion interaccion_amarilla,
                   el select se llena al seleccionar un medicamento -->
              <div class="col-sm-2" hidden>
                <label><b>interaccion_amarilla</b></label>
                <div id="borderMedicamento">
                  <select id="interaccion_amarilla" class="" style="width: 100%" >
                      <option value="0">-Seleccionar-</option>
                      <?php foreach ($medicamentos as $value) {?>
                      <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_amarilla']?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="col-sm-2" hidden>
                <label><b>interaccion_roja</b></label>
                <div id="borderMedicamento">
                  <select id="interaccion_roja" class="" style="width: 100%" >
                    <option value="0">-Seleccionar-</option>
                    <?php foreach ($medicamentos as $value) {?>
                    <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_roja']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <!-- Via de administracion -->
              <div class="col-sm-12">
                <div class="col-sm-5" style="padding-left: 0px;">
                  <label><b>Via de administración</b></label>
                  <div class="input-group" id="borderVia">
                    <div id="opcion_vias_administracion">
                      <select name="" class="form control select2 width100" id="via">
                        <option value="0">-Seleccionar-</option>
                     </select>
                    </div>
                    <span class="input-group-btn">
                      <button class="btn btn-default btn_otra_via" type="button" value="0" title="Indicar otra via de administración">Otra</button>
                    </span>
                  </div>
                </div>
                <!-- Dosis -->
                <div class="col-sm-1" style="padding-right: 0; padding-left: 0;">
                  <div class="form-group" >
                    <label ><b>Dosis</b></label>
                      <div id="borderDosis">
                        <input type="number" min='0' id="input_dosis" class="form-control">
                        <label id="dosis_max" hidden></label>
                        <label id="gramaje_dosis_max" hidden></label>
                      </div>
                  </div>
                </div>
                
                <div class="col-sm-1" style="padding-left: 0;">
                  <div class="form-group" >
                    <label ><b>Unidad</b></label>
                    <div id="borderUnidad">
                      <select name="" id="select_unidad" class="form-control">
                        <option value="0">-Unidad-</option>
                        <option value="g">g</option>
                        <option value="mg">mg</option>
                        <option value="mcg">mcg</option>
                        <option value="mL">mL</option>
                        <option value="UI">UI</option>
                      </select>
                   </div>
                  </div>
                </div>

                <div class="col-sm-2" style="padding-left: 0;">
                  <label><b>Frecuencia</b></label>
                  <div id="borderFrecuencia">
                    <select class="form-control" id="frecuencia" onchange="asignarHorarioAplicacion()" >
                      <option value="0">- Frecuencia -</option>
                      <option value="4 hrs">4 hrs</option>
                      <option value="6 hrs">6 hrs</option>
                      <option value="8 hrs">8 hrs</option>
                      <option value="12 hrs">12 hrs</option>
                      <option value="24 hrs">24 hrs</option>
                      <option value="48 hrs">48 hrs</option>
                      <option value="72 hrs">72 hrs</option>
                      <option value="Dosis unica">Dosis unica</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-3" style="padding-left: 0; padding-right: 0;">
                  <label><b>Horario de administración</b></label>
                  <div class="input-group" id="borderAplicacion">
                    <input type="text" class="form-control" id="aplicacion" disabled='disabled' >
                    <span class="input-group-btn">
                      <button class="btn btn-default edit-aplicacion" type="button" value="0" title="Cambiar el horario de aplicación">Cambiar</button>
                    </span>
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="col-sm-2">
                  <label><b>Fecha inicio</b></label>
                  <div class="input-group" id="borderFechaInicio">
                    <input id="fechaInicio" onchange="mostrarFechaFin()" class="form-control dd-mm-yyyy"  name="" placeholder="dd/mm/yyyy">
                    <span class="input-group-btn">
                       <button class="btn btn-default btn_fecha_actual" type="button" value="0" title="Fecha actual">Hoy</button>
                    </span>
                  </div>
                </div> 
                <!-- El div cambia dependiendo el medicamento que sea prescrito -->
                <div class="tiempo_tipo_medicamento">
                </div>
              </div>
              <div class="col-sm-8">
                <label><b>Observaciones para la prescripción</b></label>
                <div id="borderFechaFin">
                <input name="observacion_prescripcion" class="form-control" id="observacion"   name="" >
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group" style="padding-top:23px;" >
                  <div hidden id="div_btnActualizarPrescripcion">
                      <button type="button"  id="btnActualizarPrescripcion" class="btn back-imss btn-block" onclick="actualizarPrescripcion()"> MODIFICAR </button>
                  </div>
                  <div id="btn-form-npt" hidden>
                    <button type="button" class="btn back-imss btn-block edit-form-npt">MODIFICAR NPT </button>
                  </div>
                  <div id="btn-form-onco-anti" hidden>
                    <button type="button" class="btn back-imss btn-block edit-form-onco-anti">DILUYENTE</button>
                  </div>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group" style="padding-top:23px;">
                  <div class="btn_agregarPrescripcion">
                      <button type="button" class="btn back-imss btn-block"  onclick="agregarPrescripcion()"> AGREGAR </button>
                  </div>
                  <div class="btn_modificarPrescripcion" hidden>
                      <button type="button" class="btn back-imss btn-block" data-value="" id="btn_modificar_prescripcion"> MODIFICAR </button>
                  </div>
                </div>
              </div>
              <table style="width:100%;">
                <thead >
                  <tr>
                    <th colspan='11' class="back-imss">Medicamentos agregados</th>
                  </tr>
                  <tr>
                    <th hidden>ID</th>
                    <th>Medicamento</th>
                    <th>Dosis</th>
                    <th>Vía</th>
                    <th>Frecuencia</th>
                    <th>Aplicación</th>
                    <th>Inicio</th>
                    <th>Duración</th>
                    <th>Periodo</th>
                    <th>Fin</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody id="tablaPrescripcion">
                </tbody>
              </table>
            </div>   
            <div class="row" style="margin-top: 20px;">
              <div class="col-md-offset-8 col-md-2">
                <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
              </div>
              <div class="col-md-2">
                  <input type="hidden" name="csrf_token" >
                  <input type="hidden" name="triage_id" value="<?=$this->uri->segment(4)?>">                      
                  <button class="btn back-imss pull-right btn-block" type="submit" style="margin-bottom: -10px">Guardar</button>
              </div>
            </div>                   
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/sections/medicamentos.js?'). md5(microtime())?>" type="text/javascript"></script>







