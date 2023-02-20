<?= modules::run('Sections/Menu/Header_modal'); ?>
<style type = "text/css">
  input{
    text-transform:uppercase;
  }
  input[data-readonly] {
    pointer-events: none;
  }
</style> 
<!-- vista de registro de paceintes en Admision Hospitalaria -->
<div class="col-md-12 col-centered">
  <div class="box-inner padding">      
	  <!-- formulario -->  
    <form class="registro43051">
      <!-- Datos de afiliación -->
      <div class="tile mb-4">
        <div class="title-header">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <h1 class="mb-3 line-head" id="piso">Datos de Afiliación del Paciente</h1>
            </div>
          </div>
        </div>
        <div class="row" >
          <div class="col-md-4">
            <label style="text-transform: uppercase;font-weight: bold;">N.S.S</label>
            <div class="input-group">
              <input class="form-control" name="pum_nss" value="<?=$PINFO['pum_nss']?>" data-inputmask="'mask': '9999-99-9999-9'" required>
              <span class="input-group-btn">
                <button type="button" class="btn btn-success" id="btnVerificarNSS" >Verificar</button>
              </span>
            </div>
          </div>
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
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">N.S.S Agregado</label>
              <input class="form-control" required name="pum_nss_agregado" placeholder="" value="<?=$PINFO['pum_nss_agregado']?>">
            </div>
          </div>
          <div class="col-md-4" >
            <?php if($PINFO['pia_vigencia'] == 'SI'){
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
              <input class="form-control" required name="pum_delegacion" placeholder="" value="<?=$PINFO['pum_delegacion']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" >
              <label style="font-weight: bold">U.M.F de Adscripción</label>
              <input class="form-control" required name="pum_umf" placeholder="" value="<?=$PINFO['pum_umf']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" >
              <label style="font-weight: bold">C.U.R.P</label>
              <input class="form-control" required name="triage_paciente_curp" placeholder="" value="<?=$info[0]['triage_paciente_curp']?>">
            </div>
          </div>
        </div>
        <div class="row">                    
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Apellido Paterno </label>
              <input class="form-control" name="triage_nombre_ap" value="<?=$info[0]['triage_nombre_ap']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Apellido Materno </label>
              <input class="form-control" name="triage_nombre_am" value="<?=$info[0]['triage_nombre_am']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Nombre(s)</label>
              <input class="form-control" name="triage_nombre" placeholder="" value="<?=$info[0]['triage_nombre']?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Fecha de Nacimiento</label>
              <input class="form-control dd-mm-yyyy" name="triage_fecha_nac" placeholder="01/01/2016" value="<?=$info[0]['triage_fecha_nac']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Sexo</label>
                <select class="form-control" name="triage_paciente_sexo" data-value="<?=$info[0]['triage_paciente_sexo']?>" required>
                    <option value="">Seleccionar</option>
                    <option value="HOMBRE">HOMBRE</option>
                    <option value="MUJER">MUJER</option>
                </select>
            </div>
          </div>
        </div>
      </div>
      <!-- Domicilio -->
      <div class="tile mb-4">
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
                  <input class="form-control" required name="directorio_cp" placeholder="" value="<?=$DirPaciente['directorio_cp']?>">
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-secondary" id="buscarCP" ><i class="glyphicon glyphicon-search"></i></button>
                  </span>
                </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                  <label style="font-weight: bold">Calle y Número</label>
                  <input class="form-control" required name="directorio_cn" placeholder="" value="<?=$DirPaciente['directorio_cn']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                  <label style="font-weight: bold">Colonia</label>
                  <input class="form-control" required name="directorio_colonia" placeholder="" value="<?=$DirPaciente['directorio_colonia']?>">
            </div>
          </div>                 
        </div>
        <div class="row">  
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Municipio/Delegación</label>
              <input class="form-control" required name="directorio_municipio" placeholder="" value="<?=$DirPaciente['directorio_municipio']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label style="font-weight: bold">Estado / Ciudad</label>
                <input class="form-control" required name="directorio_estado" placeholder="" value="<?=$DirPaciente['directorio_estado']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Teléfono de Contacto</label>
              <input class="form-control" type="number" required name="directorio_telefono" placeholder="" value="<?=$DirPaciente['directorio_telefono']?>">
            </div>
          </div>
        </div>
      </div>
      <!-- Datos empresa -->
      <div class="tile mb-4">
        <div class="title-header">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <h1 class="mb-3 line-head" id="piso">Datos de la empresa</h1>
            </div>
          </div>
        </div>
        <div class="row">  
          <div class="col-md-8">
            <div class="form-group">
              <label style="font-weight: bold">Nombre de la empresa</label>
              <input class="form-control" name="empresa_nombre" placeholder="" value="<?=$Empresa['empresa_nombre']?>">
            </div>
          </div>
        </div>
        <div class="row">                
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Código Postal (opcional)</label>
                <div class="input-group">
                  <input class="form-control" name="empresa_cp" placeholder="" value="<?=$DirEmpresa['directorio_cp']?>">
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-secondary" id="buscarCP" ><i class="glyphicon glyphicon-search"></i></button>
                  </span>
                </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                  <label style="font-weight: bold">Calle y Número</label>
                  <input class="form-control" name="empresa_cn" placeholder="" value="<?=$DirEmpresa['directorio_cn']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                  <label style="font-weight: bold">Colonia</label>
                  <input class="form-control" name="empresa_colonia" placeholder="" value="<?=$DirEmpresa['directorio_colonia']?>">
            </div>
          </div>                 
        </div>
        <div class="row">  
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Municipio/Delegación</label>
              <input class="form-control" name="empresa_municipio" placeholder="" value="<?=$DirEmpresa['directorio_municipio']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label style="font-weight: bold">Estado / Ciudad</label>
                <input class="form-control" name="empresa_estado" placeholder="" value="<?=$DirEmpresa['directorio_estado']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Teléfono de trabajo</label>
              <input class="form-control" type="number" name="empresa_telefono" placeholder="" value="<?=$DirEmpresa['directorio_telefono']?>">
            </div>
          </div>
        </div>
      </div>
      <!-- Familiar Responsable -->
      <div class="tile mb-4">
        <div class="title-header">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <h1 class="mb-3 line-head" id="piso">Datos del Familiar Responsable</h1>
            </div>
          </div>
        </div>
        <div  class="row">
          <div class="col-md-4">
              <div class="form-group">
                <label style="font-weight: bold">En Caso necesario llamar a:</label>
                <input class="form-control" name="pic_responsable_nombre" placeholder="" value="<?=$PINFO['pic_responsable_nombre']?>">
              </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Parentesco:</label>
              <input class="form-control" name="pic_responsable_parentesco" placeholder="" value="<?=$PINFO['pic_responsable_parentesco']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" >
              <label style="font-weight: bold">Teléfono Responsable:</label>
                <div class="input-group">
                    <input class="form-control" type="number" name="pic_responsable_telefono" placeholder="" value="<?=$PINFO['pic_responsable_telefono']?>">
                    <span class="input-group-btn">
                    <button target="_blank"  data-original-title="Dar click cuando el responsable tenga el mismo número que el paciente" type="button" class="btn btn-secondary tip" id="btnTelefonoPaciente" ><i class="glyphicon glyphicon-earphone"></i></button>
                    </span>
                </div>
            </div>
          </div>
        </div>
        <div class="title-header">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <h1 class="mb-3 line-head" id="piso">Direccion</h1>
              <input type="checkbox" id = 'dcp_id' name="direccion_checkbox_parentesco" value="0">
              <label style="font-weight: bold"> Desactive si la persona responsable tiene la misma dirección del paciente.</label><br>
            </div>
          </div>
        </div>
        <div class="row" id = "DR1">                
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Código Postal</label>
                <div class="input-group">
                  <input class="form-control" name="responsable_cp" placeholder="" value="<?=$DirPaciente["responsable"]['directorio_cp']?>">
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-secondary" id="buscarCP" ><i class="glyphicon glyphicon-search"></i></button>
                  </span>
                </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                  <label style="font-weight: bold">Calle y Número</label>
                  <input class="form-control" name="responsable_cn" placeholder="" value="<?=$DirPaciente["responsable"]['directorio_cn']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                  <label style="font-weight: bold">Colonia</label>
                  <input class="form-control" name="responsable_colonia" placeholder="" value="<?=$DirPaciente["responsable"]['directorio_colonia']?>">
            </div>
          </div>
        </div>
        <div class="row" id = "DR2">
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Municipio/Delegación</label>
              <input class="form-control" name="responsable_municipio" placeholder="" value="<?=$DirPaciente["responsable"]['directorio_municipio']?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label style="font-weight: bold">Estado / Ciudad</label>
                <input class="form-control" name="responsable_estado" placeholder="" value="<?=$DirPaciente["responsable"]['directorio_estado']?>">
            </div>
          </div>
        </div>
      </div>
      <!-- Datos de Internamiento -->
      <div class="tile mb-4">
        <div class="title-header">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <h1 class="mb-3 line-head" id="piso">Datos de Internamiento</h1>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Especialidad</label>
                <select name="ingreso_servicio" class="especialidad form-control" data-value="<?=$Doc43051['ingreso_servicio']?>" required>
                  <option value='' disabled selected>Seleccionar</option>
                  <?php foreach ($Especialidades as $value) {?>
                  <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                  <?php }?>
                </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label style="font-weight: bold">Médico Tratante</label>
              <select name="ingreso_medico" id="divMedicos" class="form-control" data-value="<?=$Doc43051['ingreso_medico']?>" required>
                  <!-- Se llena las opciones de manera dinamica desde ajax y controlador -->
                <option value='' disabled selected>Seleccionar</option>
                <option value="<?=$Doc43051['ingreso_medico']?>"><?=$medicoTratante['empleado_apellidos']?> <?=$medicoTratante['empleado_nombre']?> </option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" >
              <label style="font-weight: bold">Asistente Médica que Registra</label>
              <input class="form-control" required name="pic_am" required="" placeholder="" value="<?=$PINFO['pic_am']=='' ? $empleado[0]['empleado_nombre'].' '.$empleado[0]['empleado_apellidos'] : $PINFO['pic_am']?>" disabled>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group" >
              <label style="font-weight: bold">Diagnóstico de Ingreso</label>
                <input type="text" class="form-control" name="diagnostico" value="<?=$Doc43051['diagnostico_presuntivo']?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group" >
              <label style="font-weight: bold">Motivo de Internamiento:</label>
                <select name="motivo_internamiento" data-value="<?=$Doc43051['motivo_internamiento']?>" class="form-control" required>
                  <option value="" ></option>
                  <option value="Cirugía">Cirugía</option>
                  <option value="Tratamiento" >Tratamiento</option>
                </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" >
              <label style="font-weight: bold">Tipo de Ingreso:</label>
              <select name="tipo_ingreso" data-value="<?=$Doc43051['tipo_ingreso']?>" class="form-control" required>
                  <option value="" ></option>
                  <option value="Programado">Programado</option>
                  <option value="Urgente" >Urgente</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label style="font-weight: bold">Documento de Ingreso o Comentario</label>
                <input type="text" name="pia_documento" class="form-control" value="<?=$PINFO['pia_documento']?>" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for=""><b><span><i class="fa fa-calendar"></i></span> Fecha de Ingreso</b></label>
                <input type="text" name="fecha_ingreso" class="form-control dd-mm-yyyy dateIngreso has-value" placeholder="Escoger Fecha" autocomplete="off" value="<?=$Doc43051['fecha_ingreso']=='' ? '' : date("d/m/Y",strtotime($Doc43051['fecha_ingreso']))?>" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for=""><b><span><i class="fa fa-clock"></i></span>Hora de Ingreso</b></label>
                <input class="form-control clockpicker readonly" name="hr_ingreso" placeholder="hr:min" value="<?=$Doc43051['hora_ingreso']?>"data-inputmask="'mask': '99:99'" required>
                <p id = "error_hora"></p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label style="font-weight: bold">Paciente con Riesgo de Contagio</label>
                <select name="riesgo_infeccion" data-value="<?=$Doc43051['riesgo_infeccion']?>" class="form-control" required>
                    <option value="" disabled selected>Seleccionar</option>
                    <option value="No" >No</option>
                    <option value="Si" >Si</option>
                    <option value="Indefinido" >Indefinido</option>
                </select>
            </div>
          </div>
        </div>
      </div>
      <div class="title mb-4">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-offset-8 col-md-2">
              <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.history.back();">Cancelar</button>
            </div>
            <div class="col-md-2">
              <input type="hidden" name="url_tipo" value="Am">
              <input type="hidden" name="csrf_token" >
              <input type="hidden" name="triage_id" value="<?=$this->uri->segment(3)?>">
              <input type="hidden" name="via_registro" value="Hora Cero Hosp">
              <input type="hidden" name="area" value="<?= $this->UMAE_AREA?>">
              <button class="md-btn md-raised m-b btn-fw back-imss  btn-block waves-effect no-text-transform pull-right" type="submit" style="margin-bottom: -10px">Guardar</button>
            </div>
          </div>
        </div>
      </div> 
    </form>
  </div>
</div>

<?= modules::run('Sections/Menu/Footer_modal'); ?>
<script src="<?= base_url('assets/js/sections/Nss.js?'). md5(microtime())?>" type="text/javascript"></script>
<!-- <script src="<?= base_url('assets/js/Asistentemedica.js?'). md5(microtime())?>" type="text/javascript"></script>  -->
<script src="<?= base_url('assets/js/Asistentemedica_hosp.js?'). md5(microtime())?>" type="text/javascript"></script>

<script>
  
  function checkIfInputHasVal(){
      if($("#formAfterRederict").val==""){
            //alert("formAfterRederict should have a value");
            return false;
      }
    }
  function checkResponsable(){
    console.log("<?=$DirPaciente["responsable"]['triage_id']?>");
    DR1 = document.getElementById("DR1");
    DR2 = document.getElementById("DR2");
    check = document.getElementById("dcp_id");
    if("<?=$DirPaciente["responsable"]['triage_id']?>" == "<?=$this->uri->segment(3)?>"){
      document.getElementById("dcp_id").checked = true;
      DR1.style.display='block';
      DR2.style.display='block';
    }else{
      DR1.style.display='none';
      DR2.style.display='none';
    }
  }
  $('#dcp_id').click(function(){
        DR1 = document.getElementById("DR1");
        DR2 = document.getElementById("DR2");
        check = document.getElementById("dcp_id");
        if (check.checked) {
          DR1.style.display='block';
          DR2.style.display='block';
        }
        else {
          DR1.style.display='none';
          DR2.style.display='none';
        }
  });

  $('.dateIngreso').datepicker({
        startDate: 0,
        language: 'es',
        format: "dd/mm/yyyy",
        autoclose: true,
        setDate: new Date(),
        todayBtn: 'linked'
    });

   $(".dateIngreso").datepicker({
        language: "es",
        autoclose: true
  });
  $(".hr_ingreso").clockpicker({
      placement: "top",
      autoclose: true
  });
  $(".readonly").on('keydown paste focus mousedown', function(e){
      if(e.keyCode != 9) // ignore tab
          e.preventDefault();
  });
  $('.especialidad').change(function(){
      var especialidad_id = $("select[name=ingreso_servicio]").val();
      $.ajax({
        url : base_url+'AdmisionHospitalaria/GetMedicoEspecialista',
        type : 'POST',
        data : {
                especialidad_id: especialidad_id,
                csrf_token:csrf_token,
            },
        dataType : 'json',
        success : function(data, textStatus, jqXHR) {
            //alert(data);
          $("#divMedicos").html(data);
        },
            error : function(e) {
                alert('Error en el proceso de consulta');
            }
        });
    });
  //$('#aisgnarCama').click()

   $('.registro43051').submit(function (e){
      //var hr_ingreso = document.getElementsByClassName("hr_ingreso")[0].val();
      /*if(hr_ingreso.include("_")){
        //document.getElementById("error_hora").innerTe = 'Hora de ingreso incompleta';
        return 0
      }*/
        e.preventDefault();
        $.ajax({
            url: base_url+"AdmisionHospitalaria/Ajaxregistro43051",
            type: 'POST',
            dataType: 'json',
            data:$(this).serialize(),
            beforeSend: function (xhr) {
                msj_loading();
            },success: function (data, textStatus, jqXHR) {
              bootbox.hideAll();
              console.log(data.accion);
              if(data.accion=='1' ){
                 //window.location.href='Registro';
                window.history.back();
                //AbrirDocumentoMultiple(base_url+'inicio/documentos/DOC43051/'+$('input[name=triage_id]').val());
              }
            },error: function (e) {
                bootbox.hideAll();
                MsjError();
                console.log(e);
              }
        }); // fin ajax
    });// fin 
    checkResponsable();
</script>



