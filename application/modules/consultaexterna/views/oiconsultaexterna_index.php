<?= modules::run('Sections/Menu/index'); ?>
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-12 col-centered">
            <div class="panel panel-default " style="">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center!important">
                        <strong>INGRESO HOSPITALARIO POR MEDICO</strong><br>
                    </span>
                    <!--  BOTON DE AGREGAR EL PACIENTE -->
                    <a  md-ink-ripple="" class="agregar-orden-internamiento md-btn md-fab m-b tip green waves-effect pull-right" data-original-title="Generar Registro">
                        <i class="mdi-social-person-add i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row" style="margin-top: 0px">
                        <div class="col-sm-12">
                          <div class="row">
                              <form class="formSearch">
                                  <div class="col-md-4" >
                                      <div class="form-group">
                                          <div class="form-group">
                                              <select class="form-control" name="inputSelect">
                                                  <option value="POR_NUMERO">N° DE PACIENTE</option>
                                                  <option value="POR_NOMBRE">NOMBRE DEL PACIENTE</option>
                                                  <option value="POR_NSS">N.S.S (SIN AGREGADO)</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-5" style="padding-right: 2px">
                                      <div class="input-group m-b ">
                                          <span class="input-group-addon back-imss "  style="border:1px solid #256659">
                                              <i class="fa fa-search"></i>
                                          </span>
                                          <input type="text" name="inputSearch" class="form-control" autocomplete="off" placeholder="Ingresar N° de Paciente">
                                      </div>
                                  </div>
                                  <div class="col-md-3" style="padding-left: 0px">
                                      <div class="form-group">
                                          <input type="hidden" name="csrf_token">
                                          <button class="btn btn-block back-imss" name="btnSearch">BUSCAR</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                  <h6 class="inputSelectNombre hide" style="color: red;margin-top: -10px"><i class="fa fa-warning"></i> ESTA CONSULTA ESTA LIMITADA A: 100 REGISTROS</h6>
                                  <table class="footable table table-bordered" id="tableResultSearch" data-filter="#search" data-page-size="20" data-limit-navigation="7">
                                      <thead>
                                          <tr>
                                              <th data-sort-ignore="true">N° DE PACIENTE</th>
                                              <th data-sort-ignore="true">FECHA INGRESO</th>
                                              <th data-sort-ignore="true">NOMBRE</th>
                                              <th data-sort-ignore="true">ACCIONES</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td colspan="4" class="text-center">
                                                  <h5>NO SE HA REALIZADO UNA BÚSQUEDA</h5>
                                              </td>
                                          </tr>
                                      </tbody>
                                      <tfoot>
                                          <tr>
                                              <td colspan="4" class="text-center">
                                                  <ul class="pagination"></ul>
                                              </td>
                                          </tr>
                                      </tfoot>
                                  </table>
                              </div>
                          </div>
                      </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/ConsultaExterna.js?').md5(microtime())?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/sections/Pacientes.js?'). md5(microtime())?>" type="text/javascript"></script>
