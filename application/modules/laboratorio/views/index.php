<?= modules::run('Sections/Menu/index'); ?>
<div class="app-title">
  <div class="div">
      <h1><i class="fa fa-bed"></i> Ingresos</h1>
      <p>Pacientes de Ingreso en Admisión Continua</p>
      <input type="hidden" name="area" value="<?=$_GET['area']?>">
  </div>
  <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Laboratorio</li>
        <li class="breadcrumb-item"><a href="#"></a></li>
  </ul>
</div>
<div class="tile mb-4">
    <div class="page-head">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                <h2 class="mb-3 line-head title"></h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-8">
                            <div class="form-group" >
                                <input type="text" class="form-control" id="filter" placeholder="Filtro General">
                            </div>
                        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table footable table-bordered table-responsive table-striped table-pacientes" data-filter="#filter" data-page-size="20">
                <thead class="thead-dark">
                    <tr>
                        <th>Folio</th>
                        <th>Hora de Ingreso</th>
                        <th>Género</th>
                        <th>Paciente</th>
                        <th>NSS</th>
                        <th>Fecha Nacimiento</th>
                        <th>Médico</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot class="hide-if-no-paging">
                    <tr>
                        <td colspan="7" class="text-center">
                            <ul class="pagination"></ul>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script type="text/javascript" src="<?=base_url('assets/js/laboratorio.js?'). md5(microtime())?>"></script>