/* Calcular Funcionalidad Barthel */
function   calcular_barthel() {
  var tot = $('#puntos_barthel');
  tot.val(0);
  $('.suma_barthel').each(function() {
    if($(this).hasClass('suma_barthel')) {
      tot.val(($(this).is(':checked') ? parseInt($(this).attr('value')) : 0) + parseInt(tot.val()) );
    }
    else {

     tot.val(parseInt(suma.val()) + (isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val())));
    }

  });

  //var totalParts = parseInt(tot.val()).toFixed(2).split('.');
  //tot.val('$' + totalParts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' +  (totalParts.length > 1 ? totalParts[1] : '0'));
    if(tot.val() >= 0 && tot.val() <= 20)  {
        $("#puntos_barthel").val(tot.val() + ' ptos: ' + 'Dependiente Total');
    } else if(tot.val() >= 21 && tot.val() <= 40) {
        $("#puntos_barthel").val(tot.val() + ' ptos: ' + 'Dependiente Grave');
    } else if(tot.val() >= 41 && tot.val() <= 59) {
        $("#puntos_barthel").val(tot.val() + ' ptos: ' + 'Dependiente Moderado');
    } else if(tot.val() >= 60 && tot.val() <= 99) {
        $("#puntos_barthel").val(tot.val() + ' ptos: ' + 'Dependiente Leve');
    } else if (tot.val() == 100){
        $("#puntos_barthel").val(tot.val() + ' ptos: ' + 'Independiente')
    }
};

function   calcular_escalaFragilidad() {
  var tot = $('#puntos_eFragilidad');
  tot.val(0);
  $('.suma_ef').each(function() {
    if($(this).hasClass('suma_ef')) {
      tot.val(($(this).is(':checked') ? parseInt($(this).attr('value')) : 0) + parseInt(tot.val()) );
    }
    else {

     tot.val(parseInt(suma.val()) + (isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val())));
    }

  });

    if(tot.val() == 0)  {
        $("#puntos_eFragilidad").val(tot.val() + ' ptos: ' + 'Paciente robusto');
    } else if(tot.val() >= 1 && tot.val() <= 2) {
        $("#puntos_eFragilidad").val(tot.val() + ' ptos: ' + 'Paciente prefrágil');
    } else if(tot.val() >= 3) {
        $("#puntos_eFragilidad").val(tot.val() + ' ptos: ' + 'Paciente Frágil');
    } 
}

$(document).on('click keyup','.suma_barthel',function() {
    calcular_barthel();
});

$(document).on('click keyup','.suma_ef',function() {
    calcular_escalaFragilidad();
});