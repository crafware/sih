
<?= modules::run('Sections/Menu/Header'); ?>
<div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <select class="select2" name="procedimientos[]" id="procedimientos" data-value="<?=$Nota['nota_procedimientos']?>" style="width: 100%" multiple="multiple">
              <?php foreach ($Procedimientos as $value) {?>
                 <option value="<?=$value['procedimiento_id']?>"><?=$value['nombre']?></option>
              <?php }?>
        </select>
      </div>
    </div> 
</div>
<div class="container">
  <div class="row"><?=print_r($rol)?></div>
  <div class="row"><?=var_dump($rol) ?></div>
</div>
<?= modules::run('Sections/Menu/Footer'); ?>
<script>
	$('#procedimientos').val($('#procedimientos').attr('data-value').split(',')).select2({
		placeholder: 'Seleccione una opciones',	
		allowClear: true
	});
</script>