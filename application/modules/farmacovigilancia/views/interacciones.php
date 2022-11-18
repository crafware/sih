<?= modules::run('Sections/Menu/index'); ?>
<link href="<?=  base_url()?>assets/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<style>
td.details-control {
    background: url('../resources/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('../resources/details_close.png') no-repeat center center;
}
</style>
<div class="app-title">
  <div>
    <h1><i class="fa fa-dashboard"></i> Farmaco Vigilancia</h1>
    <p>Identificación de Interacciones Farmacológicas</p>
  </div>
  <ul class="app-breadcrumb breadcrumb">
    <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
    <li class="breadcrumb-item"><a href="#">Catálogo</a></li>
  </ul>
</div>
<div class="tile mb-4">
  <div class="page-header">
    <div class="row">
      <div class="col-lg-12">
        <h2 class="mb-3	" id="buttons">Catálogo</h2>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table id="tablaMed" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th></th>
                <th>Médicamento</th>
                <th>Dosis Máx</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tfoot>
            
        </tfoot>
    </table>
    </div>
  </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/libs/datatables/datatables.js')?>" type="text/javascript"></script>
<script>
/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="4" cellspacing="0" border="0" style="padding-left:100px;">'+
                '<thead>'+
                    '<tr>'+
                        '<th style="width: 50%; background-color: yellow;text-align: right;">Interación Moderada</th>'+
                        '<th style="width: 50%; background-color: red; color: white; text-align: right;">Interación Grave</td>'+
                    '</tr>'+
                '</thead>'+
                '<tbody>'+
                    '<td>'+d.interaccion_a+'</td>'+
                    '<td>'+d.interaccion_r+'</td>'+
                '</tbody>'+
            '</table>';
}

$(document).ready(function($) {
 	$.extend(true, $.fn.dataTable.defaults, {
        info: true,
        paging: true,
        ordering: true,
        searching: true,
        processing: true,
        //retrieve: true,
        destroy: true,
        //serverSide: true,
       
        language: {
            url: base_url+"assets/libs/datatables/Spanish_Mexico.json"
        }
    });

 	var table = $('#tablaMed').DataTable({
 		ajax:{
                url:base_url+"Farmacovigilancia/AjaxCatalogoMedicamentos",
                type:"POST",
                data: { 
                        csrf_token:csrf_token
                      },
                dataSrc: 'data'
                },
        columns: [
                    {
                        "class":          'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {"data": "nombre"},
                    {"data": "dosis_max"},
                    {"data": "acciones"}
                   
                    
                ],

        columnDefs: [
                        
                        {
                         "targets": [0],
                         "data": null,
                         "render": function (data,tye,row) {
                                return "<span style='color:#006699;'><i class='fa fa-plus-square' style='font-size:18px'></i></span><br>";
                         }
                        },

                        
                        { 
                        "targets": [1],
                        "data": "nombre",
                        "render": function(data,type,row){
                                return "<span style='color:#1A2935;'><b>"+data+" "+row.forma+" "+row.gramaje+" VIA "+row.via+"</b></span><br>"+
                                	   "<span>"+row.categoria+"</span>";
                           
                                }
                        },
                        {
                        "targets": [2], 
                        "data": "nombre", 
                        "render": function(data, type, row) {
                            return "<span style='color:#006699;'><i class='fas fa-syringe' style='font-size:18px'></i> &nbsp;"+data+"</span><br>";          
                            }
                        }

                    ]

 	});

    $('#tablaMed tbody').on('click', 'td.details-control', function () {
        var tr = $(this).parents('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
});
</script>