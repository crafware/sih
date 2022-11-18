$('body').on('click','.VerificarPre',function(e){
  
  var idp = $(this).attr('data-value');
 
    bootbox.confirm({
    message: '<h5>¿Quieres validar esta Preinscripcion?</h5>',
    buttons: {
      cancel:{
        label: 'Cancelar',
        className: 'btn-imss-cancel'
      },
      confirm: {
        label: 'Acepar',
        className: 'back-imss'
      }
    },callback: function(response){
       if(response){
        $.ajax({
          url: base_url+"Farmacovigilancia/PrescripcionesRevisadas",
          type: 'POST',
          dataType:'json',
          data: {
           'idp': idp,
           'csrf_token':csrf_token
          },success: function (data, textStatus, jqXHR) {
              msj_success_noti(data.mensaje);
              window.location.reload();
          },error: function (e) {
              msj_error_serve(e)
              bootbox.hideAll();
          }
        });
      }
    }      
  });
});


$('body').on('click','.Verificar-fv',function(e){
 
   var id_medicamento = $(this).attr('data-value');
   bootbox.confirm({
    message: '<h5>¿Quieres Verificar El Medicamento?</h5>',
    buttons: {
      cancel:{
        label: 'Cancelar',
        className: 'btn-imss-cancel'
      },
      confirm: {
        label: 'Acepar',
        className: 'back-imss'
      }
    },callback: function(response){
       if(response){
         
        $.ajax({
          url: base_url+"Farmacovigilancia/VerificarMedicamento",
          type: 'POST',
          dataType:'json',
          data: {
           'id_medicamento': id_medicamento,
           'csrf_token':csrf_token
          },
          beforeSend: function (xhr) {
            //$('.wait').html('<td><div class="loading"><img src="../assets/img/loadingimss.gif"/><br/>Un momento, por favor...</div></td>');
            msj_loading();
         },
         success: function(data) {
           //$('#fila').html('<div class="loading" style="display:none"><img src="../assets/img/loadingimss.gif"/><br/>Un momento, por favor...</div>');
          //  console.log(data);
          //  console.log(data.medSinRevisar);
           bootbox.hideAll();
           $('#fila' + id_medicamento).remove();
           msj_success_noti(data.mensaje);
           //actualizarTablero();
           $('#nuevos').html(data.medSinRevisar);
           $('#revisados').html(data.medRevisados);
         },error: function (e) {
          msj_error_serve(e)
          bootbox.hideAll();
      }
        });
       
      }
    }      
  });

});
