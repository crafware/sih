    <form class="Form-Notas-COC" oninput="x.value=parseInt(nota_eva.value)">
      <!-- Tipo de Nota -->
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:1px">
          <?php
            $tipo_nota = 'Nota de Evolución';
            if($_GET['via'] == 'Interconsulta'){
              $tipo_nota = 'Nota de Interconsulta';
            }else if($_GET['via'] == 'Valoración'){
              $tipo_nota = 'Nota de Seguimiento de Interconsulta';
            }else if($_GET['TipoNota']=='Nota de Egreso') {
              $tipo_nota = 'Nota de Egreso';
            }
          ?>
          <span class="input-group-addon back-imss border-back-imss">
            <input type="text" class="tipo_nota width100" name="notas_tipo" value="<?=$tipo_nota?> " readonly>
          </span>
        </div>
      </div>

      <!-- Actualización de Signos Vitales -->
      <div class="panel panel-default panel-y" >
        <div class="panel-heading"><h4>Actualización de Signos Vitales</h4></div>
        <div class="panel-body" >
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-4 col-sm-3 col-md-2">
              <div class="form-group">
                <label><b>T.A (mmHg)</b></label>
                <input class="form-control"  name="sv_ta" value="<?=$signosVitalesNota['sv_ta']?>">
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2">
              <div class="form-group">
                <label><b>Temp (°C)</b></label>
                  <input class="form-control" name="sv_temp"  value="<?=$signosVitalesNota['sv_temp']?>">
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2">
              <div class="form-group">
                <label><b>F. Cardiaca (lpm)</b></label>
                  <input class="form-control" name="sv_fc"  value="<?=$signosVitalesNota['sv_fc']?>">
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2">
              <div class="form-group">
                <label><b>F. Resp (rpm)</b></label>
                <input class="form-control" name="sv_fr"  value="<?=$signosVitalesNota['sv_fr']?>">
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2">
              <div class="form-group">
                <label><b>SP02 (%)</b></label>
                <input class="form-control" name="sv_oximetria"  value="<?=$signosVitalesNota['sv_oximetria']?>">
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2">
              <div class="control-group">
                <label><b>Glucosa (mg/dl)</b></label>
                <input class="form-control" name="sv_dextrostix"  value="<?=$signosVitalesNota['sv_dextrostix']?>">
              </div>
            </div>
          </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="control-group">
                  <label><b>Peso (kg)</b></label>
                  <input class="form-control" name="sv_peso"  value="<?=$signosVitalesNota['sv_peso']?>">
                </div>
              </div>
              <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="control-group">
                  <label><b>Talla (cm)</b></label>
                  <input class="form-control" name="sv_talla"  value="<?=$signosVitalesNota['sv_talla']?>">
                </div>
              </div>
            </div>
          
        </div>
      </div>
      
      <!-- Evolución y Actualización del Cuadro Clinico -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Evolución y Actualización del Cuadro Clínico</h4></div>
        <div class="panel-body">
          <?php
            $sololectura = "";
            if($Nota['notas_tipo']=='NOTA DE INTERCONSULTA' || isset($_GET['via']) && $_GET['via'] == 'Interconsulta' || isset($_GET['via']) && $_GET['via'] == 'Valoración'){
              $titulo = "Motivo de Interconsulta";
              $visibleInterconsulta = "";
              $MotivoInterconsulta = $this->config_mdl->_query("SELECT motivo_interconsulta FROM doc_430200 WHERE triage_id = ". $_GET['folio']." AND doc_servicio_solicitado = (SELECT empleado_servicio
              FROM os_empleados WHERE empleado_id = $this->UMAE_USER)");
              // En caso que se realice nota interconsulta el problema sera el diagnostico de ingreso y el motivo de interconsulta
              $problema ="".$Diagnosticos[0]['cie10_nombre']."\n".    "Motivo interconsulta: ".$MotivoInterconsulta[0]['motivo_interconsulta'];
              $sololectura = "readonly";
            }else{
              $titulo = "Sintomas del Paciente";
              $problema = $Nota['nota_problema'];
            }
          ?>
          <div class="col-xs-12 col-sm-12 col-md-12">  
            <div class="form-group evolucion-psoap" id="area_editor_div1">
              <label><b><?=$titulo?></b></label>
              <textarea onchange="deleteTypeLetter('area_editor_div1');" class="form-control editor" name="nota_problema" rows="3" id="area_editor1" placeholder="Problema o Diagnósticos" <?=$sololectura ?> ><?=$problema?></textarea>
            </div>
            <div class="form-group" id="area_editor_div2">
              <label><b id="psoap_subjetivo" >Interrogatorio <span style="font-size: 9px"> (Subjetivo)</span></b></label>
              <textarea onchange="deleteTypeLetter('area_editor_div2');" class="form-control editor" name="nota_interrogatorio" rows="5" id="area_editor2" placeholder="Interrogatorio directo o indirecto"><?=$Nota['nota_interrogatorio']?></textarea>
            </div>
            <div class="form-group" id="area_editor_div3">
              <label><b id="psoap_objetivo" >Exploración Física <span style="font-size: 9px"> (Objetivo)</span></b></label>
              <textarea onchange="deleteTypeLetter('area_editor_div3');" class="form-control editor" name="nota_exploracionf" rows="5" id="area_editor3" placeholder="Anote sus observaciones"><?=$Nota['nota_exploracionf']?></textarea>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Actualización de Escalas de Valoración -->
      <div class="panel panel-default">
        <div class="panel-heading"><h4>Actualización de Escalas de Valoración</h4></div>
        <div class="panel-body">
          <div class="col-md-3">
            <label><b>ESCALA DE GLASGOW</b></label>
            <div class="input-group">
              <input type="text" autocomplete="off" class="form-control" data-toggle="modal" data-target='#myModal1' placeholder="Clic para colocar valor" name="hf_escala_glasgow" value="<?=$Nota['nota_escala_glasgow']?>">
              <span class="input-group-addon">Puntos</span>
            </div>
          </div>
          <!-- Modal Escala de glasgow -->
          <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" id="modalTamanioG">
              <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="myModalLabel">Puntuación de la Escala de Glasgow</h4>
               </div>
               <div class="modal-body">
                  <fieldset class="scheduler-border">
                   <legend class="scheduler-border label_glasgow_ocular"><b>APERTURA OCULAR</b></legend>
                           <div class="form-group">
                               <label class="md-check">
                               <input type="radio" class='sum_glasgow' name="apertura_ocular" value="4" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Espontánea</label>&nbsp;&nbsp;
                               <label class="md-check">
                               <input type="radio" class='sum_glasgow' name="apertura_ocular" value="3" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Hablar</label>&nbsp;&nbsp;
                               <label class="md-check">
                               <input type="radio" class='sum_glasgow' name="apertura_ocular" value="2" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Dolor</label>&nbsp;&nbsp;
                               <label class="md-check">
                               <input type="radio" class='sum_glasgow' name="apertura_ocular" value="1" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausente</label>
                           </div>
                   </fieldset>
                   <fieldset class="scheduler-border">
                       <legend class="scheduler-border label_glasgow_motora"><b>RESPUESTA MOTORA</b></legend>
                           <div class="form-group">
                               <label class="md-check">
                                   <input type="radio" class='sum_glasgow' name="respuesta_motora" value="6" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 6 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Obedece</label>&nbsp;&nbsp;
                                   <label class="md-check">
                                   <input type="radio" class='sum_glasgow' name="respuesta_motora" value="5" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 5 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Localiza</label>&nbsp;&nbsp;
                                   <label class="md-check">
                                   <input type="radio" class='sum_glasgow' name="respuesta_motora" value="4" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Retira</label>
                                   <label class="md-check">
                                   <input type="radio" class='sum_glasgow' name="respuesta_motora" value="3" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Flexión normal</label>&nbsp;&nbsp;
                                   <label class="md-check">
                                   <input type="radio" class='sum_glasgow' name="respuesta_motora" value="2" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Extensión anormal</label>&nbsp;&nbsp;
                                   <label class="md-check">
                                   <input type="radio" class='sum_glasgow' name="respuesta_motora" value="1" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausencia de repuesta</label>
                           </div>
                   </fieldset>
                   <fieldset class="scheduler-border">
                       <legend class="scheduler-border label_glasgow_verbal"><b>RESPUESTA VERBAL</b></legend>
                           <div class="form-group">
                               <label class="md-check">
                               <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="5" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 5 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Orientado&nbsp;&nbsp;</label>
                               <label class="md-check">
                               <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="4" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Confuso&nbsp;&nbsp;</label>
                               <label class="md-check">
                               <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="3" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Incoherente&nbsp;&nbsp;</label>
                               <label class="md-check">
                               <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="2" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Sonidos Incomprensibles&nbsp;&nbsp;</label>
                               <label class="md-check">
                               <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="1" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausencia de respuesta</label>
                           </div>

                               <div class="form-group">PUNTUACIÓN TOTAL: &nbsp;<input type="text" name="hf_escala_glasgow" size="3" value="<?=$hojafrontal[0]['hf_escala_glasgow']?>" disable></div>
                   </fieldset>
               </div> <!-- div del cuerpo del modal -->
               <div class="modal-footer">
                   <button type="button" class="btn btn-primary btn_modal_glasgow" data-dismiss="">Aceptar</button>
               </div>
             </div>
            </div>
          </div>
          <div class="col-md-3">
            <label><b>RIESGO DE CAÍDA</b></label>
            <div class="form-group">
               <label class="md-check">
               <input type="radio" name="hf_riesgo_caida" data-value="<?=$Nota['hf_riesgo_caida']?>" value="Alta" class="has-value"><i class="red"></i>Alta
               </label>&nbsp;&nbsp;&nbsp;
               <label class="md-check">
               <input type="radio" name="hf_riesgo_caida" data-value="<?=$Nota['hf_riesgo_caida']?>" value="Media" class="has-value"><i class="red"></i>Media
               </label>&nbsp;&nbsp;
               <label class="md-check">
                <input type="radio" name="hf_riesgo_caida" data-value="<?=$Nota['hf_riesgo_caida']?>" value="Baja" class="has-value"><i class="red"></i>Baja
               </label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label><b>ESCALA DE DOLOR (EVA)</b></label><br>
              <div class="row">
                <div class="col-sm-6">
                     <?php if($Nota['nota_eva'] == ''){
                      $nota_eva = 0;
                      }else{
                        $nota_eva = $Nota['nota_eva'];
                      }?>
                    <input type="range" name="nota_eva" value="<?=$nota_eva?>" min="0" max="10" value="0">
                </div>
                <div class="col-sm-6" style="width:10px;height:30px;border:1px solid blue;">
                   <output name="x" for="nota_eva"><?=$nota_eva?></output>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <label><b>RIESGO DE TROMBOSIS</b></label>
              <div class="input-group">
                  <input type="text" class="form-control" autocomplete="off" data-toggle="modal" data-target='#myModal2' placeholder="Clic para colocar valor" name="nota_riesgotrombosis" id="puntos_rt" value='<?=$Nota['nota_riesgotrombosis']?>'>
              </div>
          </div>
          <!-- Modal Riesgo de Trombosis -->
          <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" id="modalTamanioT">
              <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title" id="myModalLabel">Escala Para Evaluar El Riesgo de Trombosis</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-4">
                        <label><b>SELECCIONAR SEXO</b></label>
                            <div class="radio">
                            <label><input type="radio" name="rt_sexo" value="m">Masculino</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="rt_sexo" value="f">Femenino</label>
                            </div>
                    </div>
                    <div class="col-md-4">
                        <label><b>EDAD</b></label>
                        <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="0">Entre 1-40 años. <b>(0 ptos).</b></label></div>
                        <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="1">Entre 40-60 años. <b>(1 pto).</b></label></div>
                        <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="2">Entre 61-74 años. <b>(2 ptos).</b></label></div>
                        <div class="radio"><label><input type="radio" class="suma_rt" name="rt_edad" value="3">75 años o más. <b>(3 ptos).</b></label></div>
                    </div>
                    <div class="col-md-4 col-mujer hidden">
                        <div class="checkbox">
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt4" value="1">Uso de terapia de remplazo hormonal. <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt5" value="1">Embarazo o parto en el último mes. <b>(1 pto)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt6" value="1">Historia de muerte inexplicable de recién nacidos, abortos expontáneos (más de 3), hijos prematuros o con restricción del crecimento. <b>(1 pto)</b></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label><b>CIRUGÍAS</b></label>
                        <div class="checkbox">
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt7" value="1">Cirugía menor prevista (≤ 45 minutos). <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt8"  value="1">Antecedentes de cirugía mayor (≥ 45 minutos) en el último mes. <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt9" value="2">Cirugía mayor a 45 minutos (incluyendo laparoscopía o artroscopia). <b>(2 ptos)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt10" value="5">Cirugía de remplazo de cadera o rodilla. <b>(5 ptos)</b></label></div>
                    </div>
                    <div class="col-md-4">
                        <label><b>HISTORIA DE...</b></label>
                        <div class="checkbox">
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt11" value="3">Historia de trombosis, trombosis venosa profunda (TVP) o tromboembolia pulmonar (TEP). <b>(3 ptos)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt12" value="3">Historia familiar de trombosis. <b>(3 ptos)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt13" value="3">Historia familiar o personal de pruebas de sangre positivas que indican incremento en el riesgo de trombosis. <b>(3 ptos)</b></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label><b>ANTECEDENTES CON MENOS DE 1 MES</b></label>
                        <div class="checkbox">
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt14" value="1">Infarto de miocardio ( ≤ 1 mes). <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:left"><input type="checkbox" class="suma_rt" name="rt15" value="1">Insuficiencia cardiaca congestiva ( ≤ 1 mes). <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt16" value="1">Infección grave (neumonía) ( ≤ 1 mes). <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt17" value="1">Enfermedad pulmonar (Enfisema o EPOC). ( ≤ 1 mes) <b>(1 pto)</b></label>
                        <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt18" value="1">Transfusión  sanguínea ( ≤ 1 mes). <b>(1 pto)</b></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label><b>COMORBILIDADES</b></label>
                        <div class="checkbox">
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt19" value="1">Historia de enfermedad inflamatoria intestinal (CUCI o Crohn). <b>(1 pto)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt20" value="2">Antecedente de cáncer (excluyendo cáncer de piel, no melanoma). <b>(2 ptos)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt21" value="1">Obesidad (índice de masa corporal ≥ de 30 y ≤ de 40). <b>(1 pto)</b></label>
                            <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt22" value="2">Obesidad mórbida (índice de masa corporal mayor a 40). <b>(2 ptos)</b></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <label><b>ORTOPEDIA Y TRAUMATISMOS</b></label>
                      <div class="checkbox">
                          <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt23" value="5">Fractura de cadera pelvis o pierna. <b>(5 ptos)</b></label>
                          <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt24" value="5">Traumatismo grave (accidente automovilístico, fracturas múltiples). <b>(5 ptos)</b></label>
                          <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt25" value="5">Lesión de la médula espinal con parálisis. <b>(5 ptos)</b></label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label><b>EXPLORACIÓN</b></label>
                      <div class="checkbox">
                          <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt26" value="1">Venas varicosas visibles. <b>(1 pto)</b></label>
                          <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt27" value="1">Edema de piernas. <b>(1 pto)</b></label>
                          <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt28" value="2">Inmovilizador o yeso en miembros inferiores que no permite movilización en el último mes. <b>(2 ptos)</b></label>
                          <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt29" value="2">Catéter en vasos sanguíneos del cuello o tórax que lleva sangre o medicamentos al corazón en el último mes. <b>(2 ptos)</b></label>
                          <label style="TEXT-ALIGN:justify"><input type="checkbox" class="suma_rt" name="rt30" value="2">Confinado en cama por  72 horas o más. <b>(2 ptos)</b></label>
                      </div>
                    </div>
                </div>
                  </div> 
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--Resultados de serrvicio Auxiliares de Diagnóstico -->
      <div class="panel panel-default panel-y">
        <div class="panel-heading"><h4>Estudios de Laboratorio y Gabinete</h4></div>
        <div class="panel-body">
          <div class="col-xs-12 col-sm-12 col-md-12" >
            <div class="form-group" id = "area_editor_div4">
              <label><b>Resultados de Laboratorio y Gabinete</b></label>
              <textarea onchange="deleteTypeLetter('area_editor_div4');" class="form-control editor" name="nota_auxiliaresd" rows="5" id="area_editor4" placeholder="Resultados de Laboratorio y Gabinete"><?=$Nota['nota_auxiliaresd']?>
              </textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- Procedimientos -->
      <div class="panel panel-default ">
        <div class="panel-heading"><h4>Procedimientos</h4></div>
        <div class="panel-body">
           <?php
            // Declara el estado original checkbox de procedimientos
            // Al editar, modifica el estado del checkbox
              if(empty($Nota['nota_procedimientos'])){
                $checkEstado = "";
                $estadoDiv = "style='display:none'";
                $valor_check = "0";
              }else {
                $checkEstado = "checked";
                $estadoDiv = "";
                $valor_check = "1";
              }
            ?>
          <div class="form-group">
            <h4><label class="md-check"><input type="checkbox" name="check_procedimientos" <?=$checkEstado ?> value="<?= $valor_check ?>"><i class="indigo"></i> <b>Procedimientos Realizados</b></label> 
            </h4>
            <div class="input-group m-b div_procedimientos" <?= $estadoDiv ?> >
              <span class="input-group-addon back-imss border-back-imss"><i class="fa fa-user-plus"></i></span>
              <select class="select2" multiple="" name="procedimientos[]" id="procedimientos" data-value="<?=$Nota['nota_procedimientos']?>" style="width: 100%" >
                <?php foreach ($Procedimientos as $value) {?>
                   <option value="<?=$value['procedimiento_id']?>"><?=$value['nombre']?></option>
                <?php }?>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Analisis del Caso -->
      <div class="panel panel-default ">
        <div class="panel-heading"><h4>Análisis del Caso (Comentarios y Concluciones)</h4></div>
        <div class="panel-body">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group evolucion-psoap " id ='area_editor_div5'>
              <textarea onchange="deleteTypeLetter('area_editor_div5');" class="form-control editor" name="nota_analisis" rows="5" id="area_editor5" placeholder="Anote sus comentarios y conclusiones del caso"><?=$Nota['nota_analisis']?>
              </textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- Actualizaciones del Diagnostico -->
      <div class="panel panel-default ">
        <div class="panel-heading"><h4>Actualización de Diagnóstico(s)</h4></div>
        <div class="panel-body">
          <div class="form-group">
            <label style="margin-top: 10px;padding-bottom: 10px"><b>Diagnóstico(s) Encontrado(s)</b></label>   
            <div class="row row-diagnostico-principal"></div>
            <div class="col-md-3" style="left:-12px;top:-8px">
              <button type="button" class="fa fa-plus btn btn-success btn_add-dx"  data-original="Agregar o cambiar Diagnóstico" value="add"> Agregar Dx Secundario</button>
            </div>
            <div class="col-md-12 input-group m-b hidden" id="add_dxsecundario" style="margin-top: 10px">
              <span class="input-group-addon"><i class="fa fa-stethoscope" style="font-size: 16px"></i></span>
              <input type="text" class="form-control" name="cie10_nombre" placeholder="Tecleé el diagnóstico a buscar y seleccione (minimo 5 caracteres)" >
              <span class="input-group-addon back-imss border-back-imss add-cie10"><i class="fas fa fa-search pointer"></i></span>
            </div>
          </div>
        </div>
      </div> 
            
      <!-- Seccion plan y ordenes médicas -->
      <div class="panel panel-default ">
        <div class="panel-heading"><h4>Plan y Ordenes Médicas</h4></div>
        <div class="panel-body">
          <!-- Indicaciones de Nutrición -->
          <div class="col-sm-2 col-md-4" >
            <label><b>a) Instrucciones de nutricion:</b></label>
            <div class="form-group radio">
              <label class="md-check">
                <input type="radio" class="has-value" value="0" id='play_ordenes_nuevo' name="play_ordenes"><i class="red"></i>Nuevo&nbsp;&nbsp;
              </label>
              <label class="md-check">
                <input type="radio" class="has-value" value="1" id='play_ordenes_continuar' name="play_ordenes"><i class="red"></i>Continuar con la anterior
              </label>
            </div>
          </div>
          <label class="lbl_mensaje"></label>
          <!-- Ordenes de Nutrición -->
          <div class="col-sm-12" id="divNutricion" >
            <div class="seccion-plan-ordenes">
              <div class="col-sm-3" style="padding:0" id="divRadioNutricion">
                
                <?php
                // Declara estado original del radio cuando se realiza nueva nota
                $checkAyuno = '';
                $checkDieta = '';
                $divSelectDietas = 'hidden';
                $select_dietas = '0';
                $otraDieta = '';
                $divOtraDieta = 'hidden';
                if($_GET['a'] == 'edit'){
                  if($Nota['nota_nutricion'] == '0'){
                    $checkAyuno = 'checked';
                  }else if($Nota['nota_nutricion'] == '1' || $Nota['nota_nutricion'] == '2'
                  || $Nota['nota_nutricion'] == '3'|| $Nota['nota_nutricion'] == '4'|| $Nota['nota_nutricion'] == '5'
                  || $Nota['nota_nutricion'] == '6'|| $Nota['nota_nutricion'] == '7'|| $Nota['nota_nutricion'] == '8'
                  || $Nota['nota_nutricion'] == '9'|| $Nota['nota_nutricion'] == '10'|| $Nota['nota_nutricion'] == '11'
                  || $Nota['nota_nutricion'] == '12'){
                    $checkDieta = 'checked';
                    $divSelectDietas = '';
                    $select_dietas = $Nota['nota_nutricion'];
                  }else{
                    $divSelectDietas = '';
                    $checkDieta = 'checked';
                    $divOtraDieta = '';
                    $select_dietas = '13';
                    $otraDieta = $Nota['nota_nutricion'];
                  }
                }
                ?>
                <div class="form-group radio">
                  <label class="md-check">
                    <input type="radio" class="has-value" value="0" id='radioAyuno' name="dieta" <?= $checkAyuno ?> ><i class="red"></i>Ayuno
                  </label>
                  <label class="md-check">
                    <input type="radio" class="has-value" value="" id='radioDieta' name="dieta" <?= $checkDieta ?> ><i class="red"></i>Dieta
                  </label>
                </div>
              </div>
              <div  id="divSelectDietas" class="col-sm-3"  <?= $divSelectDietas ?>>
                <div class="form-group">
                  <label>Tipos de dieta:</label>
                  <!-- El valor es numerico para distinguir si la opcion pertenece a los
                       radios, selects o input -->
                  <select name="tipoDieta" id="selectDietas" class="form-control" data-value="<?= $select_dietas ?>">
                    <option value="0">Seleccionar Dieta</option>
                    <option value="1">IB - Normal</option>
                    <option value="2">IIA - Blanda</option>
                    <option value="3">IIB - Astringente</option>
                    <option value="4">III - Diabetica</option>
                    <option value="5">IV - Hiposodica</option>
                    <option value="6">V - Hipograsa</option>
                    <option value="7">VI - Liquida clara</option>
                    <option value="8">VIA - Liquida general</option>
                    <option value="9">VIB - Licuada por sonda</option>
                    <option value="10">VIB - Licuada por sonda artesanal</option>
                    <option value="11">VII - Papilla</option>
                    <option value="12">VIII - Epecial</option>
                    <option value="13">Otros</option>
                  </select>
                </div>
              </div>
              <div  id='divOtraDieta' class="col-sm-6" style="padding:0" <?= $divOtraDieta ?> >
                <div class="form-group">
                  <label>Otra dieta:</label>
                  <input type="text" class="form-control" name="otraDieta" value="<?= $otraDieta ?>" id="inputOtraDieta" placeholder="Otra dieta">
                </div>
              </div>
            </div>
          </div>
          <!-- Signos Vitales  -->
          <div class="col-sm-12" id="divSignos" >
            <?php
              // Declara estado original del select cuando se realiza nueva nota
              $select_signos = 0;
              $otras_indicaciones = 'hidden';
              // El estado de las variables cambia al realizar un cambio, esto para determinar si el valor corresponde al select o textarea
              if($_GET['a'] == 'edit'){
                if($Nota['nota_svycuidados'] == '0' || $Nota['nota_svycuidados'] == '1' || $Nota['nota_svycuidados'] == '2' ){
                  $select_signos = $Nota['nota_svycuidados'];
                }else{
                  $select_signos = "3";
                  $otras_indicaciones = '';
                }
              }
            ?>

            <div class="col-sm-4 form-group" style="padding:0" id="divTomaSignos">
              <label><b>b) Toma de signos vitales: </b></label>
              <select  id="selectTomaSignos" class="form-control" data-value="<?= $select_signos ?>" name="tomaSignos">
                <option value="0" unselected>Seleccionar</option>
                <option value="1">Por turno</option>
                <option value="2">Cada 4 horas</option>
                <option value="3">Otros</option>
              </select>
            </div>

            <div id="divOtrasInidcacionesSignos"  <?= $otras_indicaciones ?>>
              <div class="col-sm-8 form-group" style="padding-right: 0">
              <label>Otras inidcaciones:</label>
              <input type="text" id="otras-indicaciones-signos" name="otrasIndicacionesSignos" class="form-control" placeholder="Otras indicaciones" value="<?=$Nota['nota_svycuidados']?>">
              </div>
            </div>
          </div>
          <!-- Cuidados Generales de Enfermería -->
          <div class="col-sm-12" >
            <div class="col-sm-12" style="padding:0" id="divCuidadosGenerales">
              <div class="form-group ">
                <label><b>c) Cuidados Generales de Enfermería:</b>
                    <?php
                    // Declara el estado original checkbox de cuidados generales de enfermeria
                    $labelCheck = 'SI';
                    $hiddenCheck = 'hidden';
                    // Al editar, modifica el estado del checkbox
                    if($Nota['nota_cgenfermeria'] == 1){
                      $check_generales = 'checked';
                      $labelCheck = '';
                      $hiddenCheck = '';
                    }
                    ?>
                  <input type="checkbox" id="checkCuidadosGenerales" name="nota_cgenfermeria" value="1" <?= $check_generales ?> > -
                  <label id="labelCheckCuidadosGenerales"><?= $labelCheck ?></label>
                </label>
                <ul id="listCuidadosGenerales" <?= $hiddenCheck ?> >
                  <li>a. Estado neurológico</li>
                  <li>b. Cama con barandales</li>
                  <li>c. Calificación del dolor</li>
                  <li>d. Calificación de riesgo de caida</li>
                  <li>e. Control de liquidos por turno</li>
                  <li>f. Vigilar riesgo de úlceras por presión</li>
                  <li>g. Aseo bucal</li>
                  <li>h. Lavado de manos</li>
                </ul>
              </div>
            </div>
          </div>
          <!-- Cuidados Especiales de Enfermería -->
          <div class="col-sm-12"  >
            <div class="col-sm-12" style="padding:0">
              <div class="form-group" id ='area_editor_div6'>
                <label><b>d) Cuidados Especiales de Enfermería</b></label>
                <textarea onchange="deleteTypeLetter('area_editor_div6');" class="form-control nota_cuidadosenfermeria editor" name="nota_cuidadosenfermeria" rows="5" id="area_editor6" placeholder="Cuidados especiales de enfermeria"><?=$Nota['nota_cuidadosenfermeria']?></textarea>
              </div>
            </div>
          </div>
           <!-- Cuidados Generales de Enfermería -->
          <div class="col-sm-12" id="divCuidadosGenerales" >
            <div class="col-sm-12" style="padding:0">
              <div class="form-group" id = 'area_editor_div7' >
                <label><b>e) Soluciones parenterales</b></label>
                <textarea onchange="deleteTypeLetter('area_editor_div7');" class="form-control nota_solucionesp editor" name="nota_solucionesp" rows="5" id="area_editor7" placeholder="Soluciones Parenterales"><?=$Nota['nota_solucionesp']?></textarea>
              </div>
            </div>
          </div>
          <!-- Estudios de Laboratorio -->
          <div class="col-sm-12" id="EstudiosLaboratorio" >
            <div class="form-group">
              <label><b>f)</b></label>
              <?php
                if( $um_estudios_obj[0]['solicitud_id'] && $um_estudios_obj[0]['estudios']!="{}"){
                    $hidden = "";?>    
                    <label class="md-check" >&nbsp;<input type="checkbox" id="check_estudios_lab" checked >
                        <i class="indigo"></i>
                    </label>
                    <input type="hidden" name="solicitud_laboratorio_id" value="<?=$um_estudios_obj[0]['solicitud_id']?>">
                    <input type="hidden" id ="arreglo_id_catalogo_estudio" name="arreglo_id_catalogo_estudio"  class="" type="text" size="15" maxlength="30" value='<?=$um_estudios_obj[0]['estudios']?>' name="nombre">
                    <?php
                }else{
                     $hidden = "hidden";?>
           
                    <label class="md-check" >&nbsp;<input type="checkbox" id="check_estudios_lab"  >
                    <i class="indigo"></i>
                    </label>
                    <input type="hidden" name="solicitud_laboratorio_id" value="<?=$um_estudios_obj[0]['solicitud_id']?>">
                    <input type="hidden" id ="arreglo_id_catalogo_estudio" name="arreglo_id_catalogo_estudio"  class="" type="text" size="15" maxlength="30" value='{}' name="nombre">
                    <?php 
                }?>
              <label><b>Solicitud de Estudios de Laboratorio</b></label>


                <div class="col-sm-12 <?=$hidden?>" id="panel_estudios">
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-info add-new pull-right" data-toggle="modal" data-target='#myModaL_1'><i class="fa fa-plus"></i> Agregar Nuevo</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4" >
                        <table class="table table-striped tabla-catalogo-laboratorio">
                            <thead>
                                <tr>
                                    <th scope="col">ESTUDIO</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $objeto_ = json_decode($um_estudios_obj[0]['estudios']);
                                foreach($objeto_ as $nombre => $valor){
                                $estudios = explode("&", $nombre);
                            ?>                                   
                            <tr id="catalogo_lab_<?=$estudios[0]?>" value = "<?=$nombre?>"  >
                                <td><?=$estudios[3]?></td>
                                <td><a class="delete_row_catalogo_lab" title="Delete" data-toggle="tooltip" value = "<?=$nombre?>" ><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>                
          <!-- Modal Estudios de Laboratorio -->
          <div class="modal fade" id="myModaL_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" id="modalTamanioT">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Estudios de Laboratorio</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <select  class="form-control" id="menu" onchange="dimePropiedades();">
                    <?php
                    foreach($um_catalogo_laboratorio_area as $area){ ?>
                      <option value="<?= $area['area']?>"> <label><b><?= $area['area'] ?></b></label></option>
                    <?php }?>
                    </select>
                    <?php
                    $ahidden = "";
                    foreach($um_catalogo_laboratorio_area as $area){
                    ?>
                      <div class="col-md-12 <?= $ahidden ?>" id ="area-<?= $area['area'] ?>">   
                        <div class="row">
                          <label><b>---------<?= $area['area'] ?>---------</b></label> 
                        </div>
                        <?php
                          foreach ($um_catalogo_laboratorio_tipos[$area['area'] ] as $tipo) {
                        ?>
                            <div class="col-md-2">                                     
                              <div class="checkbox">
                                <div class="row">
                                  <label><?= $tipo['tipo'] ?></label>
                                </div>
                                <?php
                                  foreach($um_catalogo_laboratorio as $estudios){
                                    if($estudios['tipo']==$tipo['tipo'] && $estudios['area']==$area['area']){
                                        $value_estudios = $estudios['catalogo_id'].'&'.$estudios['area'].'&'.$estudios['tipo'].'&'.$estudios['estudio'];
                                    if(property_exists($objeto_, $value_estudios)){
                                     ?>
                                      <div class="row">
                                        <label style="TEXT-ALIGN:justify"><input type="checkbox" checked class="catalogo_estudio" name="<?= $estudios['catalogo_id']?>" id="<?= 'check_catalogo_'.$estudios['catalogo_id']?>" value="<?= $value_estudios?>"><?= $estudios['estudio'] ?></label>
                                      </div>
                                      <?php 
                                      }else{ ?>
                                            <div class="row">
                                              <label style="TEXT-ALIGN:justify"><input type="checkbox"  class="catalogo_estudio" name="<?= $estudios['catalogo_id']?>" id="<?= 'check_catalogo_'.$estudios['catalogo_id']?>" value="<?= $value_estudios?>"><?= $estudios['estudio'] ?></label>
                                            </div>
                                      <?php
                                            }
                                        }
                                    }?>                                          
                              </div>
                            </div>
                              <?php
                            }?>
                      </div>
                      <?php
                      $ahidden = "hidden";
                    }?>
                  </div>
                </div> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
              </div>
            </div>
          </div>
          <!-- Prescripciones -->
          <div class="col-sm-12">
            <label><b>g) Prescripción: </b> &nbsp;</label>
            <label class="md-check">
              <input type="checkbox" id="check_form_prescripcion"><i class="indigo"></i><label id="label_check_prescripcion">- SI</label>
            </label>
            <!-- Panel con el historial de prescripciones -->
            <nav class=" back-imss">
              <ul class="nav navbar-nav" >
                <li>
                    <a class="collapse show" id="acordeon_prescripciones_activas">
                      Prescripciones activas:
                      <label id="label_total_activas"><?= $Prescripciones_activas[0]['activas'] ?></label>
                    </a>
                </li>
                <!--
                <li>
                  <a id="acordeon_prescripciones_pendientes">
                      Pendientes por conciliacion:
                      <label id="label_total_pendientes"><?= $Prescripciones_pendientes[0]['pendientes'] ?></label>
                  </a>
                </li>
                -->
                <li>
                  <a id="acordeon_prescripciones_canceladas">
                      Canceladas o actualizadas:
                      <label id="label_total_canceladas"><?= count($Prescripciones_canceladas) ?></label>
                  </a>
                </li>
                <li>
                  <a id="acordeon_reacciones">
                      Reacciones adversas:
                      <label id="label_total_reacciones"><?= count($ReaccionesAdversas) ?></label>
                  </a>
                </li>
                <li>
                  <a id="acordeon_notificaciones">
                      Notificaciones:
                      <label id="label_total_notificaciones"><?= count($Notificaciones) ?></label>
                  </a>
                </li>
                <!-- Alegia a medicamentos
                <li>
                  <a id="acordeon_alergia_medicamentos">
                      Alergia a medicamentos:
                      <label id="label_total_reacciones"><?= count($AlergiaMedicamentos) ?></label>
                  </a>
                </li>
                -->
                <!--
                <li>
                  <a id="acordeon_notificaciones">
                      Notificaciones Farmacovigilancia:
                      <label id="label_total_notificaciones">0</label>
                  </a>
                </li>
                 -->
              </ul>
                  <label id="estado_panel" hidden>0</label>
            </nav>
            <div>
              <table id="historial_medicamentos_activos" style="width:100%;" hidden>
                <thead id="historial_prescripcion" >
                  <tr>
                    <th>Medicamento</th>
                    <th>Fecha prescripción</th>
                    <th>Dosis</th>
                    <th>Vía</th>
                    <th>Frecuencia</th>
                    <th>Aplicación</th>
                    <th>Fecha Inicio</th>
                    <th colspan="2">Tiempo</th>
                    <th>Fecha Fin</th>
                    <th id="col_dias">Días Transcurridos</th>
                    <th id="col_fechaFin" >Acciones</th>
                    <!-- <th id="col_acciones" >Acciones</th>
                    <th id="col_movimiento" >Movimiento</th>
                    <th id="col_fecha_movimiento" >Fecha Movimiento</th> -->
                  </tr>
                </thead>
                <tbody id="table_prescripcion_historial">
                </tbody>
              </table>
            </div>
            <div>
              <div class="panel-group" id='historial_movimientos' hidden>
              </div>
            </div>
            <div id='historial_reacciones' hidden>
              <table style="width:100%;">
                <thead>
                  <th>Medicamento</th>
                  <th>Observacion</th>
                </thead>
                <tbody id="table_historial_reacciones">
                </tbody>
              </table>
            </div>
            <div id="historial_alergia_medicamentos" hidden>
              <table style="width:100%;" >
                <thead>
                  <th>Medicamentos que presentan alergias</th>
                </thead>
                <tbody >
                  <tr>
                    <td id="table_historial_alergia_medicamentos">
                    <?php for($x=0 ;$x < count($AlergiaMedicamentos); $x++){ ?>
                      <?=($x + 1).") ".$AlergiaMedicamentos[$x]['medicamento']."&nbsp;&nbsp;&nbsp;"?>
                    <?php } ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div>
              <div class="panel-group" id='historial_notificaciones' hidden>
              </div>
            </div>
            <!-- Fin panel prescripcion -->
            <!-- Inicio formulario prescripcion -->
            <div class="formulario_prescripcion" style="padding-top: 10px;" hidden>
              <br>
              <div class="row" >
                <div class="col-md-12" style="margin-top: -15px">
                  <div class="form-group">
                    <div class="input-group m-b">
                        <span class="input-group-addon back-imss border-back-imss" >
                          RECETA MÉDICA
                        </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-sm-12" style="padding:0">
                <div class="col-md-12 col-sm-12" style="padding: 0;">
                  <div class="form-group">
                    <label><b>Medicamento / Forma farmacéutica</b></label>
                    <div class="input-group">
                      <div class id="borderMedicamento" >
                        <select id="select_medicamento" onchange="indicarInteraccion()" class="form control select2 selectpicker" style="width: 100%" hidden>
                            <option value="0">-Seleccionar-</option>
                            <?php foreach ($Medicamentos as $value) {?>
                            <option value="<?=$value['medicamento_id']?>" ><?=$value['medicamento']?></option>
                            <?php } ?>
                        </select>

                      </div>
                      <div id="border_otro_medicamento" hidden>
                          <input type="text" class="form-control" id="input_otro_medicamento" placeholder="Indicar otro medicamento">
                      </div>
                      <span class="input-group-btn otro_boton_span">
                        <button class="btn btn-default btn_otro_medicamento" type="button" value="0" title="Indicar otro medicamento que no esta en catalogo">Otro medicamento</button>
                      </span>
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
                </div>
                <!-- identificador de los medicamentos con interaccion interaccion_amarilla,
                     el select se llena al seleccionar un medicamento -->
                <div  class="col-sm-2" hidden>
                  <label><b>interaccion_amarilla</b></label>
                  <div id="borderMedicamento">
                    <select id="interaccion_amarilla" class="" style="width: 100%" >
                        <option value="0">-Seleccionar-</option>
                        <?php foreach ($Medicamentos as $value) {?>
                        <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_amarilla']?></option>
                        <?php } ?>
                    </select>
                  </div>
                </div>
                <div  class="col-sm-2" style="padding: 1;" hidden>
                  <label><b>interaccion_roja</b></label>
                  <div id="borderMedicamento">
                    <select id="interaccion_roja" class="" style="width: 100%" >
                        <option value="0">-Seleccionar-</option>
                        <?php foreach ($Medicamentos as $value) {?>
                        <option value="<?=$value['medicamento_id']?>" ><?=$value['interaccion_roja']?></option>
                        <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-sm-12" style="padding:0">
                <div class="col-sm-5" style="padding-left: 0px;">
                  <label><b>Via de administración</b></label>
                  <div class="input-group" id="borderVia">
                    <div id="opcion_vias_administracion">
                      <select name=""class="form control select2 width100" id="via">
                        <option value="0">-Seleccionar-</option>
                      </select>
                    </div>
                    <span class="input-group-btn">
                      <button class="btn btn-default btn_otra_via" type="button" value="0" title="Indicar otra via de administración">Otra</button>
                    </span>
                  </div>
                </div>
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
              <div class="col-sm-12" style="padding:0">
                <div class="col-sm-2" style="padding-left: 0;">
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
              <div class="col-sm-8" style="padding: 0;" >
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
              <div class="col-sm-2" style="padding-right: 0">
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
                    <th hidden >ID</th>
                    <th>Medicamento</th>
                    <!-- <th>Cat F.</th> -->
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
            <!-- Fin formulario prescripcion-->
          </div>
        </div>
      </div>

      <!-- Condiciones de Estado de Salud -->
      <div class="panel panel-default ">
        <div class="panel-heading"><h4>Condiciones de Estado de Salud</h4></div>
        <div class="panel-body">
          <div class="col-md-12">
            <h5><span>Estado de Salud</span></h5>
            <div class="form-group">
                <label class="md-check">
                    <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Delicado"><i class="red"></i>Delicado
                </label>&nbsp;&nbsp;&nbsp;
                <label class="md-check">
                    <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Muy Delicado"><i class="red"></i>Muy Delicado
                </label>&nbsp;&nbsp;&nbsp;
                <label class="md-check">
                    <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Grave"><i class="red"></i>Grave
                </label>&nbsp;&nbsp;&nbsp;
                <label class="md-check">
                    <input type="radio" name="nota_estadosalud" data-value="<?=$Nota['nota_estadosalud']?>" class="has-value" value="Muy Grave"><i class="red"></i>Muy Grave
                </label>&nbsp;&nbsp;&nbsp;
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group" id= 'area_editor_div_nota_pronosticos'>
                <h5><span>Pronóstico</span></h5>
                <textarea onchange="deleteTypeLetter('area_editor_div_nota_pronosticos');" class="form-control" name="nota_pronosticos" rows="2" placeholder="Anote diagnóstico y problemas clinicos"><?=$Nota['nota_pronosticos']?></textarea>
            </div>
          </div>                
        </div>
      </div>

      <!-- Acciones y Decisiones Médicas -->
      <div class="panel panel-default ">
        <div class="panel-heading"><h4>Acciones y Decisiones Médicas</h4></div>
        <div class="panel-body">
          <div class="col-md-12">
            <div class="form-group">
              <h5><?php
                  if(count($Interconsultas) > 0){
                      $check = 'checked';
                      $style = "";
                      $value_check = "1";
                  }else{
                    $style = "style='display:none'";
                    $value_check = "0";
                  }?>
                <label class="md-check">
                  <input type="checkbox" name="check_solicitud_interconsulta" value="<?=$value_check?>" <?=$check?> >
                  <i class="green"></i> 
                </label>
                <span><b>Solicitud de Interconsultas</b></span>
              </h5>           
              <div class="col-md-5">
                <a data-toggle="collapse" data-target="#listaInterconsultas">
                  <span class="glyphicon glyphicon-collapse-down"></span> Interconsultas solicitadas
                </a>            
                <div class="collapse" id="listaInterconsultas">
                    <table style="margin-bottom: 15px ">
                        <thead>
                          <tr>
                            <th>Servicio</th>
                            <th>Estado</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($Interconsultas as $value) {
                          if ($value['doc_estatus'] == 'Evaluado'){
                            $etiquetaColor='green';
                          }else $etiquetaColor='amber';?>
                          <tr>
                            <?php $especialidad = Modules::run('Config/ObtenerNombreServicio',array('servicio_id' => $value['doc_servicio_solicitado']));?>
                            <td align="left"><?=$especialidad?></td>
                            <td align="right"><span class="label <?=$etiquetaColor?>"><?=$value['doc_estatus']?></span></td>
                          </tr><?php 
                        }?>
                        </tbody>
                    </table>
                </div>
              </div>
              <?php
                  $interconsulta_solicitada = "";
                  for ($x=0; $x < count($Interconsultas); $x++) {
                      if($x == 0){
                      $interconsulta_solicitada = $Interconsultas[$x]['doc_servicio_solicitado'];
                  }else{
                    $interconsulta_solicitada = $interconsulta_solicitada.",".$Interconsultas[$x]['doc_servicio_solicitado'];
                      }
                  }
              ?>
              <div class="col-md-12 input-group m-b nota_interconsulta" <?=$style?>>
                <span class="input-group-addon  back-imss border-back-imss"><i class="fa fa-user-plus"></i></span>
                    <select class="select2" multiple="" name="nota_interconsulta[]" id="nota_interconsulta" data-value="<?=$interconsulta_solicitada?>" style="width: 100%">
                      <?php foreach ($Especialidades as $value) {?>
                      <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                      <?php } ?>
                    </select>
              </div>
              <div class="form-group nota_interconsulta" <?=$style?>>
                <label for=""><b>MOTIVO</b></label>
                <textarea class="form-control" name="motivo_interconsulta" rows="2"><?=$Interconsultas[0]['motivo_interconsulta'] ?></textarea>
              </div>
            </div> 
          </div>
        </div>
      </div>
      <!-- Medico tratante(s) -->
      <div class="panel panel-default ">
        <div class="panel-heading"><h4>Médico Tratante</h4></div>
        <div class="panel-body">
          <div class="col-md-12">
              <?php 
                  foreach ($Usuario as $value) {
                    $medicoRol = $value['empleado_roles'];
                  } 
                  if($medicoRol == 2) {?>                                  
                      <div class="col-md-12" style="background: white; padding: 25px 15px 15px 15px">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                  <label><b>NOMBRE</b></label>
                                  <input type="text" name="medicoTratante" value="<?=$value['empleado_nombre'].' '.$value['empleado_apellidos']?>" readonly="" class="form-control">
                                </div>doc_notas
                                <div class="col-md-3">
                                    <label><b>MATRICULA</b></label>
                                    <input type="text" name="MedicoTratante" value="<?=$value['empleado_matricula']?>" readonly="" class="form-control">
                                </div>
                                <div class="col-md-3">
                                  <label><b>CEDULA PROFESIONAL</b></label>
                                  <input type="text" name="cedulaMedico" value="<?=$value['empleado_cedula']?>" readonly="" class="form-control">
                              </div>
                            </div>
                        </div>
                      </div>                      
              <?php }else {?>   

                      <div class="col-sm-12 col-md-12" style="padding-bottom: 10px">
                          <div style="background: white; border-bottom: 2px solid #E6E9ED">
                              <h4>MÉDICO TRATANTE <small>NOMBRE DE MEDICOS RESIDENTES</small></h4>
                          </div>
                          <div class="form-group">
                              <div class="col-sm-8 col-ms-8">
                                <label>Nombre de supervisor Médico de Base:</label>
                                <?php $medicoTratante = $Nota['notas_medicotratante'] =='' ? '': $medicoTratante['empleado_apellidos'].' '.$medicoTratante['empleado_nombre']; ?>
                                <input class="form-control" name="medicosBase" id="medicosBase" placeholder="Tecleé apellidos del médico y seleccione" value="<?=$medicoTratante?>" autocomplete="off" required>     
                                <input type="hidden" name="medicoTratante" id="id_medico_tratante" value="<?=$Nota['notas_medicotratante']?>"> 
                              </div>
                              <div class="col-sm-3 col-md-3">
                                <label>Matricula </label>           
                                  <input class="form-control" id="medicoMatricula" type="text" name="medicoMatricula" value="<?=$medicoTratante['empleado_matricula']?>"  readonly>  
                              </div>
                          </div>
                      </div>
                      <div class="col-sm-12 col-md-12 disabled" style="padding-bottom: 12px">        
                          <div class="form-group">
                             
                            <div class="col-sm-4 col-md-3"> 
                              <label>Nombre(s) de médico(s) residente(s):</label>  
                              <input type="text" required class="form-control" id="" name="nombre_residente[]" placeholder="Nombre(s)" value="<?=$Residentes[0]['nombre_residente']?>" >
                            </div>
                            <div class="col-sm-3">
                              <label>Apellido paterno y materno </label>
                                 <input type="text" class="form-control" id="medico<?=$i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?=$Residentes[0]['apellido_residente']?>" required>
                               </div>                             
                            <div class="col-sm-3 col-md-3">
                              <label>Cédula Profesional</label>
                              <input class="form-control" id="residenteCedula" type="text" name="cedula_residente[]" placeholder="Cédula Profesional" value="<?=$Residentes[0]['cedulap_residente']?>" required>
                            </div>
                            <div class="col-sm-2 col-md-2">
                              <label>Grado</label>
                              <input class="form-control" id="grado" type="text" name="grado[]" placeholder="Grado (ej. R3MI)" value="<?=$Residentes[0]['grado']?>" required>
                            </div>
                            <div class="col-sm-1 col-md-1">
                              <label>Agregar +</label>
                              <a href='#' class="btn btn-success btn-xs " style="width:100%;height:100%;padding:7px;" id="add_otro_residente" data-original-title="Agregar Médico Residente"><span class="glyphicon glyphicon-plus "></span></a>
                            </div>
                        
                          </div>
                      </div>
                      <div id="medicoResidente" style="padding-top: 10px">
                          <?php for($i = 1; $i < count($Residentes); $i++){?>
                              <div class="col-sm-12 form-group">
                                 <div class="col-sm-4 col-md-3">
                                  <!-- <label style="color: white;">Nombres</label> -->
                                   <input type="text" class="form-control" id="medico<?=$i ?>" name="nombre_residente[]" placeholder="Nombre(s)" value="<?=$Residentes[$i]['nombre_residente']?>"  >
                                 </div>
                                 <div class="col-sm-4 col-md-3">
                                  <!-- <label style="color: white;">Apellidos</label> -->
                                   <input type="text" class="form-control" id="medico<?=$i ?>" name="apellido_residente[]" placeholder="Apellidos" value="<?=$Residentes[$i]['apellido_residente']?>"  >
                                 </div>
                                 <div class="col-sm-3 col-md-3">
                                  <!-- <label style="color: white;">Cedula</label> -->
                                   <input type="text" class="form-control" id="medico<?=$i ?>" name="cedula_residente[]" placeholder="Cédula Profesional" value="<?=$Residentes[$i]['cedulap_residente']?>"  >
                                 </div>
                                 <div class="col-sm-2 col-md-2">
                                  <input class="form-control" id="grado" type="text" name="grado[]" placeholder="Grado (ej. R3MI)" value="<?=$Residentes[$i]['grado']?>" required>
                                  </div>
                              </div>
                          <?php }?>
                      </div>
              <?php }?>               
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" style="padding-bottom: 25px; padding-top: 25px">
          <div class="col-md-offset-8 col-md-2">
            <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.top.close()">Cancelar</button>
          </div>
          <div class="col-md-2">
              <input name="csrf_token" type="hidden">
              <input name="triage_id" value="<?=$_GET['folio']?>" type="hidden">
              <input name="accion" value="<?=$_GET['a']?>" type="hidden">
              <input name="notas_id" value="<?=$this->uri->segment(4)?>" type="hidden">
              <input name="via" value="<?=$_GET['via']?>" type="hidden">
              <input name="inputVia" value="<?=$_GET['inputVia']?>" type="hidden">
              <input name="doc_id" value="<?=$_GET['doc_id']?>" type="hidden">
              <input name="umae_area" value="<?=$this->UMAE_AREA?>" type="hidden">
              <input name="tipo_nota" value="<?=$_GET['TipoNota']?>" type="hidden">                      
              <button class="btn back-imss pull-right btn-block" type="submit" style="margin-bottom: -10px">Guardar</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url()?>assets/libs/bootstrap3-typeahead/bootstrap3-typeahead.min.js" type="text/javascript"></script>
<script src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/CIE10.js?md5='). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Diagnosticos.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Documentos.js?'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Laboratorios.js?md5'). md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/libs/jodit-3.2.43/build/jodit.min.js')?>"></script>
<!-- <script src="<?= base_url('assets/libs/jodit-3.2.43/assets/prism.js')?>"></script> -->
<script src="<?= base_url('assets/js/Doc_imagenes_estilo_letra.js?md5=') . md5(microtime()) ?>" type="text/javascript"></script>

<script>
    var editors = [].slice.call(document.querySelectorAll('.editor'));
    editors.forEach(function (textarea) {
        //textarea.addEventListener('click', function (e) {
            if (!Jodit.instances[textarea.id]) {
                // Object.keys(Jodit.instances).forEach(function (id) {
                //     Jodit.instances[id].destruct();
                // });

                var editor = new Jodit(textarea, {
                      language: 'es',
                      textIcons: false,
                      iframe: false,
                      iframeStyle: '*,.jodit_wysiwyg {color:red;}',
                      defaultMode: Jodit.MODE_WYSIWYG,
                      enter: 'br',
                      // uploader: {
                      // url: 'https://xdsoft.net/jodit/connector/index.php?action=fileUpload'
                      // },
                      // filebrowser: {
                      //   ajax: {
                      //     url: 'https://xdsoft.net/jodit/connector/index.php'
                      //   }
                      // },
                      buttons: [
                                  'font', 
                                  'fontsize', '|',
                                  'bold',
                                  'italic', '|',
                                  'ul',
                                  'ol', '|',
                                  'outdent', 'indent',  '|',
                                  'brush',
                                  'paragraph', '|',
                                  //'image',
                                  'table', '|',    
                                  'align', 'undo', 'redo', '|',
                                  'hr',
                                  'eraser', '|',              
                                  'symbol',
                                  'fullsize', 
                                  //'source'
                              ],
                      buttonsMD: [
                                  'font', 
                                  'fontsize', '|',
                                  'bold',
                                  'italic', '|',
                                  'ul',
                                  'ol', '|',
                                  'outdent', 'indent',  '|',
                                  'brush',
                                  'paragraph', '|',
                                  //'image',
                                  'table', '|',    
                                  'align', 'undo', 'redo', '|',
                                  'hr',
                                  'eraser', '|',              
                                  'symbol',
                                  'fullsize', 
                                  //'source'
                              ],
                      buttonsSM:  ',about',
                      buttonsXS: 'source'
  
                });

                //editor.selection.insertCursorAtPoint(e.clientX, e.clientY);
            }
        //});
    });
</script>
