<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12 col-centered">
            <div class="panel panel-default " style="margin-top: 10px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">GESTIÓN DE CAMAS</span>
                    <a href="#" onclick="AbrirDocumentoMultiple(base_url+'Inicio/Documentos/HL_CL','Camas En Limpieza',200)" md-ink-ripple=""class="md-btn btn-add-sala md-fab m-b red waves-effect pull-right" style="position: absolute;right: 10px">
                        <i class="fa fa-file-pdf-o i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row ">
                        <div class="col-md-6">
                            <div class="input-group m-b ">
                                <span class="input-group-addon back-imss border-back-imss" >
                                    <i class="fa fa-user-plus"></i>
                                </span>
                                <input type="text" class="form-control" name="triage_id" placeholder="Ingresar N° de Folio">
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <div class="input-group m-b ">
                                <span class="input-group-addon back-imss border-back-imss" >
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="filter" placeholder="Filtro General">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover footable table-no-padding" data-filter="#filter" data-limit-navigation="7"data-page-size="10">
                                <thead>
                                    <tr>
                                        <th>N° DE CAMA</th>
                                        <th style="width: 20%;">UBICACION</th>
                                        <th style="width: 22%">TIEMPO TRANSCURRIDO</th>
                                        <th style="width: 24%">NOMBRE QUIEN REPORTA</th>
                                        <th>FALLA</th>
                                        <th style="width: 15%">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr id="<?=$value['triage_id']?>" >
                                        <td><?=$value['triage_id']?></td>         
                                        <td style="font-size: 12px"> </td>         
                                  
                                        <td ></td> <!-- tiempo trascurrido -->
                                        <td ><?=$value['ce_asignado_consultorio']?></td> 
                                        <td>                                             <!-- Estado -->
                                            
                                        </td>
                                        <td >           
                                            
                                        </td>
                                    </tr>
                                    
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
            </div>
            </div>
            
    </div>
</div>
    <input name="LoadCamasLimpieza" value="Si">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/HigieneLimpieza.js?').md5(microtime())?>" type="text/javascript"></script>