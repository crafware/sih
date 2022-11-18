<?= modules::run('Sections/menu_v2/index'); ?> 
<link href="<?=  base_url()?>assets/fonts/custom/fontello/fontello.css" rel="stylesheet" type="text/css" />
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding" style="margin-top: -15px">
        <section class="content-header">
            <h4>Entrega de Guardia</h4>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>
        <section class="content"> 
            <!-- info boxes -->
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-bed"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Censables</span>
                            <span class="info-box-number">90<small>%</small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-bed"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">No Censables</span>
                            <span class="info-box-number">41,410</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fas fa-hospital-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ingresos</span>
                            <span class="info-box-number">760</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fas fa-hospital-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Egresos</span>
                            <span class="info-box-number">2,000</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-id-card-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Prealtas</span>
                            <span class="info-box-number">200</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-id-card-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ingresos por AC</span>
                            <span class="info-box-number">2</span>
                        </div>
                        <!-- /.info-box-content --> 
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="box-data">
                        <div class="box-data-title bg-blue">
                            Hospitalizados
                        </div>
                        <div class="icon_indicador"><i class="font-inpatient">&#xe800;</i></div>
                        <div class="indicador">209</div>
                        <hr class="hr-box">
                        <div class="icon-bedpatient"><i class="font-bedpatient" style="color:blue;">&#xe802;</i></div>
                        <div class="table-content">
                            <table class="table-indicadores" style="width:100%">
                                <tbody>
                                    <tr>
                                        <td class="bg-blue">Disponibles</td>
                                        <td class="bg-gray">30%</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue">Ocupadas</td>
                                        <td class="bg-gray">105</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-blue">Estancia Promedio</td>
                                        <td class="bg-gray">4 dias</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- <span class="subIndicador label label-primary">Camas Ocupadas</span>
                        <span class="subIndicador label label-primary">Camas disponibles</span>
                        <span class="subIndicador label label-primary">Estancia Promedio</span> -->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box-data">
                        <div class="box-data-title bg-orange">
                            UCI
                        </div>
                        <div class="icon_indicador"><i class="font-critical">&#xe801;</i></div>
                        <div class="indicador">15</div>
                        <hr class="hr-box">
                        <div class="icon-bedpatient"><i class="font-bedpatient" style="color:orange;">&#xe802;</i></div>
                        <div class="table-content">
                            <table class="table-indicadores" style="width:100%">
                                <tbody>
                                    <tr>
                                        <td class="bg-orange">Disponibles</td>
                                        <td class="bg-gray">30%</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-orange">Ocupadas</td>
                                        <td class="bg-gray">105</td>
                                    </tr>
                                    <tr>
                                        <td class="bg-orange">Estancia Promedio</td>
                                        <td class="bg-gray">4 dias</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box-data">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box-data">

                    </div>
                </div>                
            </div>
            <!-- Grafica de indicadores -->
            <div class="row">
                <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Monthly Recap Report</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <div class="btn-group">
                          <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-wrench"></i></button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                          </ul>
                        </div>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-8">
                          <p class="text-center">
                            <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                          </p>

                          <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="salesChart" style="height: 180px;"></canvas>
                          </div>
                          <!-- /.chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                          <p class="text-center">
                            <strong>Goal Completion</strong>
                          </p>

                          <div class="progress-group">
                            <span class="progress-text">Add Products to Cart</span>
                            <span class="progress-number"><b>160</b>/200</span>

                            <div class="progress sm">
                              <div class="progress-bar progress-bar-aqua" style="width: 80%"></div>
                            </div>
                          </div>
                          <!-- /.progress-group -->
                          <div class="progress-group">
                            <span class="progress-text">Complete Purchase</span>
                            <span class="progress-number"><b>310</b>/400</span>

                            <div class="progress sm">
                              <div class="progress-bar progress-bar-red" style="width: 80%"></div>
                            </div>
                          </div>
                          <!-- /.progress-group -->
                          <div class="progress-group">
                            <span class="progress-text">Visit Premium Page</span>
                            <span class="progress-number"><b>480</b>/800</span>

                            <div class="progress sm">
                              <div class="progress-bar progress-bar-green" style="width: 80%"></div>
                            </div>
                          </div>
                          <!-- /.progress-group -->
                          <div class="progress-group">
                            <span class="progress-text">Send Inquiries</span>
                            <span class="progress-number"><b>250</b>/500</span>

                            <div class="progress sm">
                              <div class="progress-bar progress-bar-yellow" style="width: 80%"></div>
                            </div>
                          </div>
                          <!-- /.progress-group -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- ./box-body -->
                    <div class="box-footer">
                      <div class="row">
                        <div class="col-sm-3 col-xs-6">
                          <div class="description-block border-right">
                            <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                            <h5 class="description-header">$35,210.43</h5>
                            <span class="description-text">TOTAL REVENUE</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                          <div class="description-block border-right">
                            <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                            <h5 class="description-header">$10,390.90</h5>
                            <span class="description-text">TOTAL COST</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                          <div class="description-block border-right">
                            <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                            <h5 class="description-header">$24,813.53</h5>
                            <span class="description-text">TOTAL PROFIT</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                          <div class="description-block">
                            <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                            <h5 class="description-header">1200</h5>
                            <span class="description-text">GOAL COMPLETIONS</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- /.box-footer -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>


            <div class = "container" > 
                <h4> Codeigniter 3 - búsqueda automática de jquery ajax usando ejemplo typeahead- ItSolutionStuff.com </h4>
                <div class="col-md-12">
                    <div class="form-group " id="prefetch">
                        <input type = "text" name="cie10_nombre" class="form-control input-lg typeahead tt-input" placeholder="Search Here" autocomplete="off" spellcheck="false">
                
                    </div>  
                </div>
            </div>
        

           
        </section>
         <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>
        </div>
    </div>

</div>
 
<?= modules::run('Sections/Menu/footer'); ?>


