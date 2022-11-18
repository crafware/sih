<!--Panel de procedimientos medicos -->
<div class="panel panel-default panel-x">
  <div class="panel-heading"><h4>PROCEDIMIENTO(S) MÉDICO(S)</h4></div>
  <div class="panel-body ">
    <div class="form-group">
        <h5><span>Seleccione si se Procedimientos Realizados al Paciente</span>
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
          <label class="md-check">
            <input type="checkbox" name="check_procedimientos" <?=$checkEstado ?> value="<?= $valor_check ?>"><i class="green"></i>
          </label>
        </h5>
      
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