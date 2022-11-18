<?= modules::run('Sections/Menu/index'); ?>
<div class="box-row">
  <div class="box-cell">
    <div class="box-inner col-md-12" style="margin-top: 10px">
      <div class="panel panel-default ">
        <div class="panel-body b-b b-light">
          <div class="col-md-6">
            <div class="col-md-12">
              <h6>Paciente</h6>
              <div class="col-md-1"></div>
              <div class="col-md-10"><h3><?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?></h3></div>
            </div>
          </div>
          <div class="col-md-4">
            
          </div>
          <div class="col-md-2">
            
          </div>
        </div>
    </div>
  </div>
  </div>
</div>

  
<?= modules::run('Sections/Menu/footer'); ?>