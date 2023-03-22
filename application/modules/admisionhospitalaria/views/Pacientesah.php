<?= modules::run('Sections/Menu/Header_modal'); ?>   
<link href="<?= base_url()?>assets/libs/datatables/datatables.css" rel="stylesheet">
<div class="panel panel-default ">       
    <div class="panel-body b-b b-light">
        <div class="row">
            <div class="col-md-3">
                <label for=""><b>Buscar folio</b></label>
                <div class="input-group m-b">
                    <input type="text" name="buscarPaciente" class="form-control" id="buscarPaciente" placeholder="Ingresar N° de Folio">
                    <span class="input-group-addon back-imss border-back-imss pointer" id="buacarPacienteButton">
                        <i class="fa fa-search"></i>
                    </span>
                </div>
            </div>
            <div class="col-md-3">
                <label for=""><b>Fecha de ingreso</b></label>
                <div class="input-group m-b">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" name="fecha" class="form-control" id="fecha" value="<?php echo date("d-m-Y");?>" placeholder="Seleccionar fecha">
                </div>
            </div>
            <div class="col-md-3">
                <input type="hidden" name="tipoconsulta" id="tipoconsulta" value="preregistro">
            </div>
            <div class="col-md-2">
                <div class="input-group m-b">
                    <button class="btn btn-info" style="margin-top: 24px" onclick="window.location.href='RegistrarPaciente'">Agregar Pacientes</button>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">    
                    <!-- <table id="tableRegistros" class="table table-bordered footable"  data-filter="#search" data-page-size="20" data-limit-navigation="8"> -->
                        <table class="table table-striped table-bordered" id="tableRegistros">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Servicio / Médico</th>                    
                                <th>Cama</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?= modules::run('Sections/Menu/Footer_modal'); ?>
<script src="<?= base_url('assets/libs/datatables/datatables.js')?>" type="text/javascript"></script>


<script>
$(document).ready(function($) {
    const tipoconsulta = $('#tipoconsulta').val();
    let fecha = $('#fecha').val();    
    passDate(fecha);
    $('#fecha').datepicker({
        startDate: 0,
        language: 'es',
        format: "dd-mm-yyyy",
        autoclose: true,
        setDate: new Date(),
        todayBtn: 'linked'
    }).on('changeDate', function(e){
        let fecha=$('#fecha').val();
        passDate(fecha);
    });

    
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
    /*
    $('#asignarCama button').click(function (e) {
        $('#iframe-modal').modal('hide');
        $('.fade').remove();

        $('body').removeClass('modal-open');
    });
*/
    $("#buacarPacienteButton").click(function(e){
        const Folio = $("#buscarPaciente").val();
        passDateFolio(Folio);
    });

    $('body').on('click','.generar43051',function (e) {
        e.preventDefault();
        AbrirDocumentoMultiple(base_url+'Inicio/Documentos/DOC43051/'+$(this).attr('data-triage'),'DOC43051');
        $('.modal').modal('hide')   
    });

    $('body').on('click', '#asignarCama', function() {
        let aux = document.createElement("input");
        let folio = $(this).attr('data-folio');
        aux.setAttribute('value', folio);
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);
        console.log(folio)
        $('#modal-preregistro').modal('hide');
        
    });



    function passDate(fecha) {
        $('#tableRegistros').DataTable({
            ajax:{
                    url:base_url+"AdmisionHospitalaria/AjaxPacientes",
                    type:"POST",
                    data: { fecha:fecha,
                            tipoconsulta:tipoconsulta,
                            csrf_token:csrf_token
                          },
                    dataSrc: 'data'
                    },
            columns: [
                       
                        {"data": "nombre","className": "text-left"},
                        {"data": "servicio","className": "text-left"},
                        {"data": "cama","className": "text-left"},
                        {"data": "accion","className": "text-left"}
                    ],
            columnDefs: [
                         
                            {
                            "targets": [0], 
                            "data": "nombre", 
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;'><b><i class='fa fa-user'></i>  &nbsp;"+data+"</b></span><br>"+
                                       "<span style='color:#006699;'><i class='fa fa-address-card'></i> &nbsp;"+row.afiliacion+"</span><br>"+
                                       "<span style='color:#555;'><i class='fa fa-file-text'></i>  &nbsp;"+row.triage_id+"</span><br>";
                                           
                                }
                            },
                            
                            {
                            "targets": [1], 
                            "data": "servicio", 
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;text-transform: uppercase'><i class='fa fa-h-square'></i> &nbsp;"+data+"</span><br>"+
                                "<span style='color:#008F39;'><i class='fa fa-user-md'></i> &nbsp;"+row.medico+"</span><br>"+
                                "<span style='color:#FF8000;'><i class='fa fa-clock-o'></i> &nbsp;Ingreso "+row.tipo_ingreso+", hora "+row.hora_ingreso+" hrs.</span>";
                                             
                                }
                            },

                            {
                            "targets": [2], 
                            "data": "cama", 
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;text-transform: uppercase'><i class='fa fa-bed'></i> &nbsp;"+data+"</span><br>";
                                
                                }
                            }

                        ],
            dom: 'Bfrtip',
            buttons: [
                        {
                            extend: 'pdfHtml5',
                            title: 'Prealtas'
                        }
            ]
                
        });
    }

    function passDateFolio(Folio) {
        $('#tableRegistros').DataTable({
            ajax:{
                    url:base_url+"AdmisionHospitalaria/AjaxPacientesFolio",
                    type:"POST",
                    data: { Folio:Folio,
                            tipoconsulta:tipoconsulta,
                            csrf_token:csrf_token
                          },
                    dataSrc: 'data'
                    },
            columns: [
                       
                        {"data": "nombre","className": "text-left"},
                        {"data": "servicio","className": "text-left"},
                        {"data": "cama","className": "text-left"},
                        {"data": "accion","className": "text-left"}
                    ],
             columnDefs: [
                         
                            {
                            "targets": [0], 
                            "data": "nombre", 
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;'><b><i class='fa fa-user'></i>  &nbsp;"+data+"</b></span><br>"+
                                       "<span style='color:#006699;'><i class='fa fa-address-card'></i> &nbsp;"+row.afiliacion+"</span><br>"+
                                       "<span style='color:#555;'><i class='fa fa-file-text'></i>  &nbsp;"+row.triage_id+"</span><br>";
                                           
                                }
                            },
                            
                            {
                            "targets": [1], 
                            "data": "servicio", 
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;text-transform: uppercase'><i class='fa fa-h-square'></i> &nbsp;"+data+"</span><br>"+
                                "<span style='color:#008F39;'><i class='fa fa-user-md'></i> &nbsp;"+row.medico+"</span><br>"+
                                "<span style='color:#FF8000;'><i class='fa fa-clock-o'></i> &nbsp;"+row.tipo_ingreso+" "+row.hora_ingreso+"</span>";
                                             
                                }
                            },

                            {
                            "targets": [2], 
                            "data": "cama", 
                            "render": function(data, type, row) {
                                return "<span style='color:#006699;text-transform: uppercase'><i class='fa fa-bed'></i> &nbsp;"+data+"</span><br>";
                                
                                }
                            }

                        ]
                
        });
    }

}); 

</script>

    
    



