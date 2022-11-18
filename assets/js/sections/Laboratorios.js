


  //---------------mhma----------///

  function dimePropiedades(){ 
 
    $("#menu option:not(:selected)").each(function( index ) {
      $("#area-" + $( this ).val()).addClass('hidden');
    });

    var valor = $("#menu option:selected").val();
    $("#area-" + valor).removeClass('hidden');

  }
  
 

  $(document).ready(function(){
 
  // Delete row on delete button click
  $(document).on("click", ".delete_row_catalogo_lab", function(){

    var value = $(this).attr('value').split('&');
    var id = "check_catalogo_"+value[0];

    $("#"+id).prop("checked", false);

    $(this).parents("tr").remove();

    var ids_catalogo = JSON.parse($("#arreglo_id_catalogo_estudio").val());

    delete ids_catalogo[$(this).attr('value')];
    $("#arreglo_id_catalogo_estudio").val(JSON.stringify(ids_catalogo));


  });

    $(document).on('click keyup','#check_estudios_lab',function() {

      if($(this).is(':checked')) {

        $("#panel_estudios").removeClass('hidden');

      }else{

        $("#panel_estudios").addClass('hidden');

        $(".delete_row_catalogo_lab").each(function(){
          $( this ).parents("tr").remove();
        });

        $(".catalogo_estudio").each(function(){
          $( this ).prop("checked", false);
        });

        $("#arreglo_id_catalogo_estudio").val("{}");

      }
        
    });

    $(document).on('click keyup','.catalogo_estudio',function() {

      var value = $(this).attr('value').split('&');
      var id = "catalogo_lab_"+value[0];

      if($(this).is(':checked')) {

        var row = '<tr id="'+id +'"  value="'+$(this).attr('value') +'">' +
                // '<th scope="row">'+value[0]+'</th>' +
                // '<td >'+value[1]+'</td>' +
                // '<td>'+value[2]+'</td>' +
                '<td>'+value[3]+'</td>' +
                  '<td>'+ '<a class="delete_row_catalogo_lab" title="Delete" data-toggle="tooltip" value="'+$(this).attr('value')+'"><i class="glyphicon glyphicon-trash"></i></a>'+
                  '</td>' +
              '</tr>';
        $(".tabla-catalogo-laboratorio").append(row);   
      }
      else {

        $("#"+id).remove();
      }

    });

    ///////////////////

    $(document).on('click keyup','.catalogo_estudio',function() {
      var value = $(this).attr('value').split('&');
      var id = "catalogo_lab_"+value[0];
      var ids_catalogo = JSON.parse($("#arreglo_id_catalogo_estudio").val());
      if($(this).is(':checked')){
        ids_catalogo[$(this).attr('value')] = value[0];
      }else{
        delete ids_catalogo[$(this).attr('value')];
      }                                                                                                                                                    
        $("#arreglo_id_catalogo_estudio").val(JSON.stringify(ids_catalogo));
    });

    ////////////////////////////////

  });

 //---------------mhma----------///