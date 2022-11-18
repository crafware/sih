<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-10 col-centered" style="margin-top: 10px">
            <div class="panel no-border">
                <div class="panel-heading back-imss">
                    <span class="">
                        <div class="row">
                            <div class="col-md-4">
                                <b>INDICADOR DE TICKETS GENERADOS</b>
                            </div>
                            <div class="col-md-8 total_tickets text-right"></div>
                        </div>
                    </span> 
                </div>
                <div class="panel-body  show-hide-grafica-panel" >
                    <div class="">
                        <div class="row" style="margin-top: 10px">
                            <div class="col-md-4" style='padding-right: 0px'>
                                <select class="width100 select_filter" >
                                    <option value="by_fecha">BUSQUEDA POR FECHA</option>
                                </select>
                            </div>
                            <form class="by_fecha">
                                <div class="col-md-4">
                                    <input type="text" name="inputFecha" placeholder="Seleccionar Fecha " required="" class="form-control dp-yyyy-mm-dd">
                                </div>
                                <div class="col-md-4">
                                    <input name="csrf_token" type="hidden">
                                    <button class="btn back-imss btn-block">Buscar</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                    <table style="margin-top: 20px" class="table footable m-b-none table-filtros table-bordered table-hover table-no-padding" data-limit-navigation="5" data-filter="#filter" data-page-size="10">
                        <thead>
                            <tr>
                                <th >N° DE FOLIO</th>
                                <th >FECHA</th>
                                <th >HORA</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Horacero.js?').md5(microtime())?>" type="text/javascript"></script>