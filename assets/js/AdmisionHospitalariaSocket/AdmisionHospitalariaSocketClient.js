xconsole.log("socket client");
var showTooltipActive = false
const socket = io(":3001", {
  cors: {
    "force new connection": true,
    "reconnectionAttempts": "Infinity",
    "timeout": 10000,
    "transports": ["websocket"]
  }
});
/*console.log(io.data);
socket.emit("setDataRequest",{
    table       : "o_camas",
    data_name   : ["cama_id","cama_nombre","cama_estado"]}
)*/
socket.on("getDataRequest", function (data) {
  refreshGraphics(data);
  //activateTooltip()
});

var dropdownToggleForbidden = ["Limpieza e Higiene"]
var AreasSemaforo = ["Limpieza e Higiene", "Enfermería Hospitalización"]

socket.on("getDataTooltip", function (data) {
  if (data["dataTooltip"].length > 0) {
    showTooltip(data);
  }
});

socket.on("getDataFechaSuciaTooltip", function (data) {
  if (data["dataTooltip"].length > 0) {
    showFechaSuciaTooltip(data);
  }
});

socket.on("getDataNotesTooltip", function (data) {
  if (data["dataTooltip"].length > 0) {
    showDataNotesTooltip(data);
  }
});

socket.on("setDataNotesEstado", function (data) {
  if ("Limpieza e Higiene" == $('input[name=area]').val() || $('input[name=area]').val() == 'Dirección Enfermería ' || $('input[name=area]').val() == "Enfermería Hospitalización") {
    msj_success_noti("Se han leído las notas de la cama " + data['cama_nombre'])
  }
});

socket.on("getDataCamasNotas", function (data) {
  //if("Limpieza e Higiene" == $('input[name=area]').val()){
  //console.log("getDataCamasNotas")
  //console.log(data)
  var id = "nota_" + data["cama_id"]
  var n = data["note_len"].length
  updateNotesNotification(id, n)
  //}
});

var aresCriticas = ["UCI", "UTR", "UTMO"]

socket.on("getDataPacientesAreasCriticas", function (data) {
  if (data.area == $('input[name=area]').val()) {
    showPacientesAreasCriticas(data.dataPacientes, data.camas);
  }
});

function loadTablaPacienteAreaCritica() {
  if (aresCriticas.find(element => element.trim() === $('input[name=area]').val())) {
    getDataPacientesAreasCriticas($('input[name=area]').val())
  }
}

socket.on("getDataBed", async function (data) {
  refreshGraphics(data);
  //await delay(5000);
  //activateTooltip()
});
const colorCamaEstado = {
  'Disponible': 'green',
  'Sucia': 'grey-900',
  'Limpia': 'cyan-400',
  'Descompuesta': 'yellow-600',
  'Reparada': 'lime',
  'HOMBRE': 'blue-800',
  'MUJER': 'pink-A100',
  'Reservada': 'purple-300',
  'Contaminada': 'red'
}

const procesoData = {
  null: { "text": '.', "color": 'white' },
  0: { "text": '.', "color": 'white' },
  1: { "text": 'PA', "color": 'orange' },
  2: { "text": 'A', "color": 'black' },
  3: { "text": 'CC', "color": 'red' }
}

function findBed(className) {
  var floors = document.getElementsByClassName("container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12");
  var n_camas = 0
  var c = ["UCI", "UTMO", "UTR"]
  for (const floor of floors) {
    var bedCharts_space = floor.getElementsByClassName("bedCharts-space text-left")[0];
    if (bedCharts_space != undefined) {
      var flooraux = bedCharts_space.getElementsByTagName("span")[0];
      if (!(c.find(element => element === flooraux.textContent))) {
        var beds = floor.getElementsByClassName("container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12 rowCamas");
        n_camas += beds[0].getElementsByClassName(className).length;
      }
    }
  }
  return n_camas;
}

function findBedEnf(className) {
  var floor = document.getElementsByClassName("container-camas")[0];
  var beds = floor.getElementsByClassName(className);
  return beds.length;
}

function findPA() {
  var n_camas = 0
  var floor = document.getElementsByClassName("container-camas")[0];
  var beds = floor.getElementsByClassName("fila");
  for (const bed of beds) {
    if (bed.getElementsByTagName("center")[0].textContent == "PA") {
      n_camas += 1
    }
  }
  return n_camas;
}
var dropdownToggle = ["Admisión Hospitalaria", "UCI", "División de Calidad"]
function refreshGraphics(data) {
  var floors = document.getElementsByClassName("container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12");
  for (const floor of floors) {
    var bedCharts_space = floor.getElementsByClassName("bedCharts-space text-left")[0];
    if (bedCharts_space != undefined) {
      var flooraux = bedCharts_space.getElementsByTagName("span")[0];
      if (flooraux.textContent == data["floor"][0]["piso_nombre_corto"]) {
        var beds = floor.getElementsByClassName("container-fluid col-lg-12 col-md-12 col-sm-12 col-xs-12 rowCamas");
        beds = beds[0].getElementsByClassName("fila");
        for (const bed of beds) {
          var bedaux = bed.getElementsByClassName("cama-no cama-celda")[0];
          if (bedaux.getAttribute("data-cama") == data["bed"][0]["after"]["cama_id"]) {
            if (data["bed"][0]["before"]["cama_estado"] != data["bed"][0]["after"]["cama_estado"]) {
              let infoPisoDisponibles = floor.getElementsByClassName("infoPisoDisponibles")[0].innerText;
              let infoPisoOcupadas = floor.getElementsByClassName("infoPisoOcupadas")[0].innerText;
              var DisponiblesString = "Disponibles: ";
              var OcupadasString = "Ocupadas: ";
              var DisponiblesInt = parseInt(infoPisoDisponibles.substring(DisponiblesString.length, infoPisoDisponibles.length));
              var OcupadasInt = parseInt(infoPisoOcupadas.substring(OcupadasString.length, infoPisoOcupadas.length));
              if (data["bed"][0]["before"]["cama_estado"] == "Disponible" && data["bed"][0]["after"]["cama_estado"] != "Disponible") {
                DisponiblesInt -= 1;
                OcupadasInt += 1;
              } else if (data["bed"][0]["before"]["cama_estado"] != "Disponible" && data["bed"][0]["after"]["cama_estado"] == "Disponible") {
                DisponiblesInt += 1;
                OcupadasInt -= 1;
              }
              floor.getElementsByClassName("infoPisoDisponibles")[0].innerText = DisponiblesString + DisponiblesInt;
              floor.getElementsByClassName("infoPisoOcupadas")[0].innerText = OcupadasString + OcupadasInt;
              //document.getElementsByClassName("camas-disponibles")[0].innerText = camas_disponibles + DisponiblesT;
            }
            //Modifica Cama Disponible color 
            if (data["bed"][0]["before"]["cama_estado"] != data["bed"][0]["after"]["cama_estado"] || data["bed"][0]["before"]["cama_genero"] != data["bed"][0]["after"]["cama_genero"]) {
              var cama_no = bed.getElementsByClassName("cama-no")[0];
              cama_no.classList.remove(colorCamaEstado[data["bed"][0]["after"]["cama_estado"]]);
              cama_no.classList.remove(colorCamaEstado[data["bed"][0]["before"]["cama_estado"]]);
              cama_no.classList.remove(colorCamaEstado[data["bed"][0]["after"]["cama_genero"]]);
              cama_no.classList.remove(colorCamaEstado[data["bed"][0]["before"]["cama_genero"]]);
              /*console.log(data["bed"][0]["after"]["cama_estado"])
              console.log(data["bed"][0]["after"]["cama_genero"])
              console.log(colorCamaEstado[data["bed"][0]["after"]["cama_genero"]])*/
              if (data["bed"][0]["after"]["cama_estado"] == "Ocupado") {
                cama_no.classList.add(colorCamaEstado[data["bed"][0]["after"]["cama_genero"]]);
              } else {
                cama_no.classList.add(colorCamaEstado[data["bed"][0]["after"]["cama_estado"]]);
              }
              cama_no.setAttribute("data-estado", data["bed"][0]["after"]["cama_estado"])
              cama_no.setAttribute("data-accion", data["bed"][0]["after"]["cama_estado"])
              cama_no.setAttribute("data-folio", data["bed"][0]["after"]["triage_id"])
            }
            //Modifica Cama Proceso
            var proceso = bed.getElementsByTagName("div")[0];
            proceso.style.color = procesoData[data["bed"][0]["after"]["proceso"]]["color"];
            proceso.getElementsByTagName("center")[0].innerText = procesoData[data["bed"][0]["after"]["proceso"]]["text"];
            //Modifica Cama Informacion general
            var OcupadasT = ' Ocupadas';
            var DisponiblesT = ' Disponibles';
            var ReservadasT = ' Reservadas';
            var LimpiasT = ' Limpias';
            var SuciasT = ' Sucias';
            var ContaminadasT = ' Contaminadas';
            var DescompuestasT = ' Descompuestas';
            var ReparadasT = ' Reparadas';
            var camas_totales = findBed("fila")
            var camas_Sucias = findBed(colorCamaEstado['Sucia'])
            var camas_Limpias = findBed(colorCamaEstado['Limpia'])
            var camas_Disponibles = findBed(colorCamaEstado['Disponible'])
            var camas_Descompuestas = findBed(colorCamaEstado['Descompuesta'])
            var camas_Reparadas = findBed(colorCamaEstado['Reparada'])
            var camas_Ocupadas = findBed(colorCamaEstado['HOMBRE']) + findBed(colorCamaEstado['MUJER'])
            var camas_Reservadas = findBed(colorCamaEstado['Reservada'])
            var camas_Contaminadas = findBed(colorCamaEstado['Contaminada'])
            var porcentaje_o = (1 - (camas_Disponibles / camas_totales)) * 100;
            var aux = ""
            //Limpieza hugiene
            aux = document.getElementsByClassName("ocupadas")[0];
            if (aux) { aux.innerText = camas_Ocupadas + OcupadasT; }
            aux = document.getElementsByClassName("disponibles")[0];
            if (aux) { aux.innerText = camas_Disponibles + DisponiblesT; }
            aux = document.getElementsByClassName("reservadas")[0];
            if (aux) { aux.innerText = camas_Reservadas + ReservadasT; }
            aux = document.getElementsByClassName("camas-limpias")[0];
            if (aux) { aux.innerText = camas_Limpias + LimpiasT; }
            aux = document.getElementsByClassName("camas-sucias")[0];
            if (aux) { aux.innerText = camas_Sucias + SuciasT; }
            aux = document.getElementsByClassName("camas-contaminadas")[0];
            if (aux) { aux.innerText = camas_Contaminadas + ContaminadasT; }
            aux = document.getElementsByClassName("camas-descompuestas")[0];
            if (aux) { aux.innerText = camas_Descompuestas + DescompuestasT; }
            aux = document.getElementsByClassName("camas-reparadas")[0];
            if (aux) { aux.innerText = camas_Reparadas + ReparadasT; }
            //Admision hospitalaria
            aux = document.getElementsByClassName("porcentaje-ocupacion")[0];
            if (aux) { aux.innerText = porcentaje_o.toFixed(2) + " %"; }
            aux = document.getElementsByClassName("camas-disponibles")[0];
            if (aux) { aux.innerText = camas_Disponibles + DisponiblesT; }
            aux = document.getElementsByClassName("camas-ocupadas")[0];
            if (aux) { aux.innerText = camas_Ocupadas + OcupadasT; }
            aux = document.getElementsByClassName("camas-limpias")[0];
            if (aux) { aux.innerText = camas_Limpias + LimpiasT; }
            //aux = document.getElementsByClassName("camas-reparadas")[0];
            //if (aux){aux.innerText = camas_Reparadas + ContaminadasT;}
            aux = document.getElementsByClassName("camas-descompuestas")[0];
            if (aux) { aux.innerText = camas_Descompuestas + DescompuestasT; }
            aux = document.getElementsByClassName("camas-sucias")[0];
            if (aux) { aux.innerText = camas_Sucias + SuciasT; }
            aux = document.getElementsByClassName("camas-contaminadas")[0];
            if (aux) { aux.innerText = camas_Contaminadas + ContaminadasT; }
            aux = document.getElementsByClassName("camas-reparadas")[0];
            if (aux) { aux.innerText = camas_Reparadas + ReparadasT; }
            if (0 != document.getElementsByClassName("dropdown-toggle").length) {
              if (dropdownToggle.find(element => element.trim() === document.getElementsByClassName("dropdown-toggle")[0].textContent.trim())) {
                if (data["triage"].length == 0) {
                  delecteOctions(cama_no);
                } else {
                  createOctions(cama_no, data);
                }
                return 0;
              }
            }
            if (dropdownToggle.find(element => element.trim() === $('input[name=area]').val())) {
              if (data["triage"].length == 0) {
                delecteOctions(cama_no);
              } else if ($('input[name=area]').val() == "División de Calidad") {
                createOctionsDivisionDeCalidad(cama_no, data);
              } else {
                createOctionsUCI(cama_no, data);
              }
              return 0;
            }
            if (AreasSemaforo.find(element => element.trim() === $('input[name=area]').val()) || $('input[name=area]').val() == 'Dirección Enfermería ') {
              var cama_no = bed.getElementsByClassName("cama-no")[0];
              if (AreasSemaforo.find(element => element.trim() === $('input[name=area]').val())) {
                delecteOctions(cama_no);
                createOctionsLimpiezaEHigiene(cama_no, data);
              }
              if (data["bed"][0]["before"]["cama_display"] != data["bed"][0]["after"]["cama_display"]) {
                var id_semaforo_0 = data["bed"][0]["after"]["cama_id"] + '_semaforo_0';
                var id_semaforo_1 = data["bed"][0]["after"]["cama_id"] + '_semaforo_1';
                var id_semaforo_2 = data["bed"][0]["after"]["cama_id"] + '_semaforo_2';
                document.getElementById(id_semaforo_0).classList.add("yellow");
                document.getElementById(id_semaforo_1).classList.add("yellow");
                document.getElementById(id_semaforo_2).classList.add("yellow");
                if (data["bed"][0]["after"]["cama_display"] == "0") {
                  document.getElementById(id_semaforo_0).classList.remove("yellow");
                  document.getElementById(id_semaforo_1).classList.remove("yellow");
                  document.getElementById(id_semaforo_2).classList.remove("yellow");
                } else if (data["bed"][0]["after"]["cama_display"] == "1") {
                  document.getElementById(id_semaforo_1).classList.remove("yellow");
                  document.getElementById(id_semaforo_2).classList.remove("yellow");
                } else if (data["bed"][0]["after"]["cama_display"] == "2") {
                  document.getElementById(id_semaforo_2).classList.remove("yellow");
                }
              }
            }
          }
        }
      }
    } else {
      refreshGraphicsEnf(data)
    }
  }
}

function refreshGeneralData() {
  //Modifica Cama Informacion general
  var OcupadasT = ' Ocupadas';
  var DisponiblesT = ' Disponibles';
  var ReservadasT = ' Reservadas';
  var LimpiasT = ' Limpias';
  var SuciasT = ' Sucias';
  var ContaminadasT = ' Contaminadas';
  var DescompuestasT = ' Descompuestas';
  var ReparadasT = ' Reparadas';
  var camas_totales = findBed("fila")
  var camas_Sucias = findBed(colorCamaEstado['Sucia'])
  var camas_Limpias = findBed(colorCamaEstado['Limpia'])
  var camas_Disponibles = findBed(colorCamaEstado['Disponible'])
  var camas_Descompuestas = findBed(colorCamaEstado['Descompuesta'])
  var camas_Reparadas = findBed(colorCamaEstado['Reparada'])
  var camas_Ocupadas = findBed(colorCamaEstado['HOMBRE']) + findBed(colorCamaEstado['MUJER'])
  var camas_Reservadas = findBed(colorCamaEstado['Reservada'])
  var camas_Contaminadas = findBed(colorCamaEstado['Contaminada'])
  var porcentaje_o = (1 - (camas_Disponibles / camas_totales)) * 100;
  var aux = ""
  //Limpieza hugiene
  aux = document.getElementsByClassName("ocupadas")[0];
  if (aux) { aux.innerText = camas_Ocupadas + OcupadasT; }
  aux = document.getElementsByClassName("disponibles")[0];
  if (aux) { aux.innerText = camas_Disponibles + DisponiblesT; }
  aux = document.getElementsByClassName("reservadas")[0];
  if (aux) { aux.innerText = camas_Reservadas + ReservadasT; }
  aux = document.getElementsByClassName("camas-limpias")[0];
  if (aux) { aux.innerText = camas_Limpias + LimpiasT; }
  aux = document.getElementsByClassName("camas-sucias")[0];
  if (aux) { aux.innerText = camas_Sucias + SuciasT; }
  aux = document.getElementsByClassName("camas-contaminadas")[0];
  if (aux) { aux.innerText = camas_Contaminadas + ContaminadasT; }
  aux = document.getElementsByClassName("camas-descompuestas")[0];
  if (aux) { aux.innerText = camas_Descompuestas + DescompuestasT; }
  aux = document.getElementsByClassName("camas-reparadas")[0];
  if (aux) { aux.innerText = camas_Reparadas + ReparadasT; }
  //Admision hospitalaria
  aux = document.getElementsByClassName("porcentaje-ocupacion")[0];
  if (aux) { aux.innerText = porcentaje_o.toFixed(2) + " %"; }
  aux = document.getElementsByClassName("camas-disponibles")[0];
  if (aux) { aux.innerText = camas_Disponibles + DisponiblesT; }
  aux = document.getElementsByClassName("camas-ocupadas")[0];
  if (aux) { aux.innerText = camas_Ocupadas + OcupadasT; }
  aux = document.getElementsByClassName("camas-limpias")[0];
  if (aux) { aux.innerText = camas_Limpias + LimpiasT; }
  //aux = document.getElementsByClassName("camas-reparadas")[0];
  //if (aux){aux.innerText = camas_Reparadas + ContaminadasT;}
  aux = document.getElementsByClassName("camas-descompuestas")[0];
  if (aux) { aux.innerText = camas_Descompuestas + DescompuestasT; }
  aux = document.getElementsByClassName("camas-sucias")[0];
  if (aux) { aux.innerText = camas_Sucias + SuciasT; }
  aux = document.getElementsByClassName("camas-contaminadas")[0];
  if (aux) { aux.innerText = camas_Contaminadas + ContaminadasT; }
  aux = document.getElementsByClassName("camas-reparadas")[0];
  if (aux) { aux.innerText = camas_Reparadas + ReparadasT; }
}


function refreshGraphicsEnf(data) {
  var floor = document.getElementsByClassName("container-camas")[0];
  if (floor == undefined || floor.length == 0) {
    return 0
  }
  var beds = floor.getElementsByClassName("fila");
  for (const bed of beds) {
    var bedaux = bed.getElementsByClassName("cama-no cama-celda")[0];
    if (bedaux.getAttribute("data-cama") == data["bed"][0]["after"]["cama_id"]) {
      if (data["bed"][0]["before"]["cama_estado"] != data["bed"][0]["after"]["cama_estado"] || data["bed"][0]["before"]["cama_genero"] != data["bed"][0]["after"]["cama_genero"]) {
        var cama_no = bed.getElementsByClassName("cama-no")[0];
        cama_no.classList.remove(colorCamaEstado[data["bed"][0]["after"]["cama_estado"]]);
        cama_no.classList.remove(colorCamaEstado[data["bed"][0]["before"]["cama_genero"]]);
        cama_no.classList.remove(colorCamaEstado[data["bed"][0]["after"]["cama_genero"]]);
        cama_no.classList.remove(colorCamaEstado[data["bed"][0]["before"]["cama_estado"]]);
        if (data["bed"][0]["after"]["cama_estado"] == "Ocupado") {
          cama_no.classList.add(colorCamaEstado[data["bed"][0]["after"]["cama_genero"]]);
        } else {
          cama_no.classList.add(colorCamaEstado[data["bed"][0]["after"]["cama_estado"]]);
        }
        cama_no.setAttribute("data-estado", data["bed"][0]["after"]["cama_estado"])
        cama_no.setAttribute("data-accion", data["bed"][0]["after"]["cama_estado"])
        cama_no.setAttribute("data-folio", data["bed"][0]["after"]["triage_id"])
      }
      //Modifica Cama Proceso
      if (data["bed"][0]["before"]["proceso"] != data["bed"][0]["after"]["proceso"]) {
        var proceso = bed.getElementsByTagName("div")[0];
        proceso.style.color = procesoData[data["bed"][0]["after"]["proceso"]]["color"];
        proceso.getElementsByTagName("center")[0].innerText = procesoData[data["bed"][0]["after"]["proceso"]]["text"];
      }
      if (data["bed"][0]["before"]["cama_display"] != data["bed"][0]["after"]["cama_display"]) {
        var id_semaforo_0 = data["bed"][0]["after"]["cama_id"] + '_semaforo_0';
        var id_semaforo_1 = data["bed"][0]["after"]["cama_id"] + '_semaforo_1';
        var id_semaforo_2 = data["bed"][0]["after"]["cama_id"] + '_semaforo_2';
        document.getElementById(id_semaforo_0).classList.add("yellow");
        document.getElementById(id_semaforo_1).classList.add("yellow");
        document.getElementById(id_semaforo_2).classList.add("yellow");
        if (data["bed"][0]["after"]["cama_display"] == "0") {
          document.getElementById(id_semaforo_0).classList.remove("yellow");
          document.getElementById(id_semaforo_1).classList.remove("yellow");
          document.getElementById(id_semaforo_2).classList.remove("yellow");
        } else if (data["bed"][0]["after"]["cama_display"] == "1") {
          document.getElementById(id_semaforo_1).classList.remove("yellow");
          document.getElementById(id_semaforo_2).classList.remove("yellow");
        } else if (data["bed"][0]["after"]["cama_display"] == "2") {
          document.getElementById(id_semaforo_2).classList.remove("yellow");
        }
      }
      //Modifica Cama Informacion general
      var camas_totales = findBedEnf("fila")
      var camas_Sucias = findBedEnf(colorCamaEstado['Sucia'])
      var camas_Disponibles = findBedEnf(colorCamaEstado['Disponible'])
      var camas_Descompuestas = findBedEnf(colorCamaEstado['Descompuesta'])
      var camas_Ocupadas = findBedEnf(colorCamaEstado['HOMBRE']) + findBedEnf(colorCamaEstado['MUJER'])
      var aux = ""
      //Limpieza hugiene
      aux = document.getElementById("camasTotal");
      if (aux) { aux.innerText = camas_totales; }
      aux = document.getElementById("camasDisponibles");
      if (aux) { aux.innerText = camas_Disponibles; }
      aux = document.getElementById("camasOcupadas");
      if (aux) { aux.innerText = camas_Ocupadas; }
      aux = document.getElementById("camasSucias");
      if (aux) { aux.innerText = camas_Sucias; }
      aux = document.getElementById("camasDescompuestas");
      if (aux) { aux.innerText = camas_Descompuestas; }
      aux = document.getElementById("camasPrealta");
      if (aux) { aux.innerText = findPA(); }
      return 0;
    }
  }
}

function createOctionsDireccionEnfermeria(cama_no, data) {
  var cama_estado1 = data["bed"][0]["before"]["cama_estado"]
  var cama_estado2 = data["bed"][0]["after"]["cama_estado"]
  if ((cama_estado1 != 'Limpia') && (cama_estado2 == 'Limpia')) {
    var sqlPaciente = data["triage"]
    var valor = data["bed"][0]["after"];
    var nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' + valor['cama_nombre'] + '</h5></li>';
    var CambiarCama = '<li><a href="#" class="cambiar-cama-paciente" data-id="' + sqlPaciente[0]['triage_id'] + '" data-area="' + valor['area_id'] + '" data-cama="' + valor['cama_nombre'] + '" data-cama-id="' + valor['cama_id'] + '" data-sexo="' + valor['cama_genero'] + '"><i class="fa fa-bed icono-accion"></i> Cambiar Cama</a></li>';
    var Imprimir43051 = '<li><a href="#" class="generar43051" data-triage="' + sqlPaciente[0]['triage_id'] + '" data-cama="' + valor['cama_id'] + '"><i class="fa fa-print icono-accion"></i> Generar 43051</a></li>';
    //var CancelarIngreso   = '<li><a href="#" class="cancelar43051" data_triage="'       + sqlPaciente[0]['triage_id'] + '" data-cama="'+valor['cama_id']+'"><i class="fa fa-ban icono-accion"></i> Cancelar Ingreso</a></li>';
    //var LiberarCama       = '<li><a href="#" class="liberar43051" data-triage="'        + sqlPaciente[0]['triage_id'] + '" data-cama="'+valor['cama_id']+'"><i class="fa fa-share-square-o icono-accion"></i> Liberar Cama</a></li>'; 
    var AltaPaciente = '<li><a class="alta-paciente" data-area="' + valor['area_id'] + '" data-cama="' + valor['cama_id'] + '" data-triage="' + sqlPaciente[0]['triage_id'] + '"><i class="fa fa-id-badge icono-accion"></i> Alta Paciente</a></li>';
    var str = '<ul class="list-inline list-menu">' +
      '<li class="dropdown">' +
      '<a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">' +
      '<i class="fa fa-bed"></i>' +
      '</a>' +
      '<ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' + nombreCama + ' ' + CambiarCama + ' ' + Imprimir43051 + ' ' + AltaPaciente + '</ul>' +
      '</li>' +
      '</ul>';
  } else if (cama_estado == 'Reservada') {
    var sqlPaciente = data["triage"]
    var valor = data["bed"][0]["after"];
    var nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' + valor['cama_nombre'] + '</h5></li>';
    var Imprimir43051 = '<li><a href="#" class="generar43051" data-triage="' + sqlPaciente[0]['triage_id'] + '" data-cama="' + valor['cama_id'] + '"><i class="fa fa-print icono-accion"></i> Generar 43051</a></li>';
    var LiberarCama = '<li><a href="#" class="liberar43051" data-triage="' + sqlPaciente[0]['triage_id'] + '" data-cama="' + valor['cama_id'] + '"><i class="fa fa-share-square-o icono-accion"></i> Liberar Cama</a></li>';
    var str = '<ul class="list-inline list-menu">' +
      '<li class="dropdown">' +
      '<a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">' +
      '<i class="fa fa-bed"></i>' +
      '</a>' +
      '<ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' + nombreCama + ' ' + Imprimir43051 + '  ' + LiberarCama + '</ul>' +
      '</li>' +
      '</ul>';
  } else {
    return 0;
  }
  var h6 = cama_no.getElementsByTagName("h6")[0].outerHTML
  var div = cama_no.getElementsByClassName("tooltip")[0].outerHTML

  cama_no.innerHTML = str + h6 + div
}

function createOctions(cama_no, data) {
  var cama_estado = data["bed"][0]["after"]["cama_estado"]
  if (cama_estado == 'Ocupado') {
    var sqlPaciente = data["triage"]
    var valor = data["bed"][0]["after"];
    var nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' + valor['cama_nombre'] + '</h5></li>';
    var CambiarCama = '<li><a href="#" class="cambiar-cama-paciente" data-id="' + sqlPaciente[0]['triage_id'] + '" data-area="' + valor['area_id'] + '" data-cama="' + valor['cama_nombre'] + '" data-cama-id="' + valor['cama_id'] + '" data-sexo="' + valor['cama_genero'] + '"><i class="fa fa-bed icono-accion"></i> Cambiar Cama</a></li>';
    var Imprimir43051 = '<li><a href="#" class="generar43051" data-triage="' + sqlPaciente[0]['triage_id'] + '" data-cama="' + valor['cama_id'] + '"><i class="fa fa-print icono-accion"></i> Generar 43051</a></li>';
    //var CancelarIngreso   = '<li><a href="#" class="cancelar43051" data_triage="'       + sqlPaciente[0]['triage_id'] + '" data-cama="'+valor['cama_id']+'"><i class="fa fa-ban icono-accion"></i> Cancelar Ingreso</a></li>';
    //var LiberarCama       = '<li><a href="#" class="liberar43051" data-triage="'        + sqlPaciente[0]['triage_id'] + '" data-cama="'+valor['cama_id']+'"><i class="fa fa-share-square-o icono-accion"></i> Liberar Cama</a></li>'; 
    var AltaPaciente = '<li><a class="alta-paciente" data-area="' + valor['area_id'] + '" data-cama="' + valor['cama_id'] + '" data-triage="' + sqlPaciente[0]['triage_id'] + '"><i class="fa fa-id-badge icono-accion"></i> Alta Paciente</a></li>';
    var str = '<ul class="list-inline list-menu">' +
      '<li class="dropdown">' +
      '<a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">' +
      '<i class="fa fa-bed"></i>' +
      '</a>' +
      '<ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' + nombreCama + ' ' + CambiarCama + ' ' + Imprimir43051 + ' ' + AltaPaciente + '</ul>' +
      '</li>' +
      '</ul>';
  } else if (cama_estado == 'Reservada') {
    var sqlPaciente = data["triage"]
    var valor = data["bed"][0]["after"];
    var nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' + valor['cama_nombre'] + '</h5></li>';
    var Imprimir43051 = '<li><a href="#" class="generar43051" data-triage="' + sqlPaciente[0]['triage_id'] + '" data-cama="' + valor['cama_id'] + '"><i class="fa fa-print icono-accion"></i> Generar 43051</a></li>';
    var LiberarCama = '<li><a href="#" class="liberar43051" data-triage="' + sqlPaciente[0]['triage_id'] + '" data-cama="' + valor['cama_id'] + '"><i class="fa fa-share-square-o icono-accion"></i> Liberar Cama</a></li>';
    var str = '<ul class="list-inline list-menu">' +
      '<li class="dropdown">' +
      '<a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">' +
      '<i class="fa fa-bed"></i>' +
      '</a>' +
      '<ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' + nombreCama + ' ' + Imprimir43051 + '  ' + LiberarCama + '</ul>' +
      '</li>' +
      '</ul>';
  } else {
    return 0;
  }
  var h6 = cama_no.getElementsByTagName("h6")[0].outerHTML
  var div = cama_no.getElementsByClassName("tooltip")[0].outerHTML

  cama_no.innerHTML = str + h6 + div
}

function createOctionsUCI(cama_no, data) {
  var cama_estado = data["bed"][0]["after"]["cama_estado"]
  if (cama_estado == 'Ocupado' || cama_estado == 'Ocupado') {
    var valor = data["bed"][0]["after"];
    var nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' + valor['cama_nombre'] + '</h5></li>';
    var Expediente = '<li><a class = "abrirExpediente" data = ' + valor['triage_id'] + '  href=""  data1 = "http://' + window.location.host + '/sih/Sections/Documentos/Expediente/' + valor['triage_id'] + '/?tipo=Hospitalizacion"  target="_blank"><i class="fa fa-share-square-o icono-accion"></i>Ver expediente</a></li>';

    var str = '<ul class="list-inline list-menu">' +
      '<li class="dropdown">' +
      '<a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">' +
      '<i class="fa fa-bed"></i>' +
      '</a>' +
      '<ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' + nombreCama + ' ' + AltaPaciente + ' ' + Expediente + '</ul>' +
      '</li>' +
      '</ul>';
  } else {
    return 0;
  }
  var h6 = cama_no.getElementsByTagName("h6")[0].outerHTML
  var div = cama_no.getElementsByClassName("tooltip")[0].outerHTML

  cama_no.innerHTML = str + h6 + div
}

function createOctionsDivisionDeCalidad(cama_no, data) {
  var cama_estado = data["bed"][0]["after"]["cama_estado"]
  if (cama_estado == 'Ocupado' || cama_estado == 'Reservada') {
    var valor = data["bed"][0]["after"];
    var nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' + valor['cama_nombre'] + '</h5></li>';
    var Expediente = '<li><a class = "abrirExpediente" data = ' + valor['triage_id'] + '  href="http://' + window.location.host + '/sih/Sections/Documentos/Expediente/' + valor['triage_id'] + '/?tipo=Hospitalizacion"  target="_blank"><i class="fa fa-share-square-o icono-accion"></i>Ver expediente</a></li>';
    var str = '<ul class="list-inline list-menu">' +
      '<li class="dropdown">' +
      '<a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">' +
      '<i class="fa fa-bed"></i>' +
      '</a>' +
      '<ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' + nombreCama + ' '/*+CambiarCama+' '+Imprimir43051+' '*/ + Expediente + '</ul>' +
      '</li>' +
      '</ul>';
  } else {
    return 0;
  }
  var h6 = cama_no.getElementsByTagName("h6")[0].outerHTML
  var div = cama_no.getElementsByClassName("tooltip")[0].outerHTML

  cama_no.innerHTML = str + h6 + div
}

function createOctionsLimpiezaEHigiene(cama_no, data) {
  var cama_estado = data["bed"][0]["after"]["cama_estado"]
  if (cama_estado == 'Sucia' || cama_estado == 'Contaminada') {
    var valor = data["bed"][0]["after"];
    var nombreCama = '<li><h5 class="text-center link-acciones bold">Cama ' + valor['cama_nombre'] + '</h5></li>';
    var confirmarLimpieza = '<li><a href="#" class="confirmar-Limpieza" ' + '" data-cama="' + valor['cama_id'] + '" data-cama-id="' + valor['cama_id'] + '" data-estado="' + valor['cama_estado'] + '" data-cama_nombre="' + valor['cama_nombre'] + '" data-folio="' + valor['triage_id'] + '"><i class="fa fa-paint-brush icono-accion"></i> Confirmar limpieza</a></li>';
    var camaCeldaSemaforo = valor["cama_display"]
    var camaCeldaSemaforo_int = 4 - parseInt(valor["cama_display"]);
    var agregarNota = '<li><a href="#" class="nota-cama" ' + '" data-cama="' + valor['cama_id'] + '" data-cama-id="' + valor['cama_id'] + '" data-estado="' + valor['cama_estado'] + '" data-cama_nombre="' + valor['cama_nombre'] + '" data-folio="' + valor['triage_id'] + '"><i class="fa fa-file-text-o icono-accion"></i> Agregar nota</a></li>';
    if (camaCeldaSemaforo_int <= 3) {
      cambiarEstadoSemaforo = '<li><a href="#" class="cambiar-estado-semaforo" " data-cama="' + valor['cama_id'] + '" data-cama-id="' + valor['cama_id'] + '" data-estado="' + valor['cama_estado'] + '" data-cama_nombre="' + valor['cama_nombre'] + '" data-semaforo="' + camaCeldaSemaforo + '" data-folio="' + valor['triage_id'] + '"><i class="fa fa-paint-brush icono-accion"></i> Confirmar limpieza No.' + camaCeldaSemaforo_int + '</a></li>';
    } else {
      cambiarEstadoSemaforo = "";
    }
    var str = '<ul class="list-inline list-menu">' +
      '<li class="dropdown">' +
      '<a data-toggle="dropdown" class="" aria-haspopup="true" aria-expanded="false">' +
      '<i class="fa fa-bed"></i>' +
      '</a>' +
      '<ul class="dropdown-menu dropdown-menu-scale pull-left pull-up" style="margin-left: -5px">' + nombreCama + ' ' + confirmarLimpieza + ' ' + agregarNota + ' ' + cambiarEstadoSemaforo + ' ' + '</ul>' +
      '</li>' +
      '</ul>';
  } else {
    return 0;
  }
  var h6 = cama_no.getElementsByTagName("h6")[0].outerHTML
  var div = cama_no.getElementsByClassName("tooltip")[0].outerHTML

  cama_no.innerHTML = str + h6 + div
}

function delay(time) {
  return new Promise(resolve => setTimeout(resolve, time));
}

function delecteOctions(cama_no) {
  var i = document.createElement("i")
  i.classList.add('fa', 'fa-bed')
  var istr = i.outerHTML
  if (cama_no.getElementsByTagName("h6").length != 0) {
    cama_no.innerHTML = istr + cama_no.getElementsByTagName("h6")[0].outerHTML + cama_no.getElementsByClassName("tooltip")[0].outerHTML
  }
}

async function test() {
  var end = true
  var n = 0
  var cd1 = "", cd2 = "", cd1aux = "", cd2aux = "", aux = ""
  aux = document.getElementsByClassName("camas-disponibles")[0];
  if (aux) { cd1 = aux.innerText; cd1aux = aux.innerText; }
  aux = document.getElementsByClassName("disponibles")[0];
  if (aux) { cd1 = aux.innerText; cd2aux = aux.innerText; }
  //await delay(5000);
  while (end) {
    aux = document.getElementsByClassName("camas-disponibles")[0];
    if (aux) { cd1aux = aux.innerText; }
    aux = document.getElementsByClassName("disponibles")[0];
    if (aux) { cd2aux = aux.innerText; }
    await delay(100);
    if (cd1aux != cd1 || cd2aux != cd2 || n == 600) {
      end = false
    }
    n += 1
  }
  refreshGeneralData();
  //activateTooltip();
}

function activateTooltip() {
  var beds = document.getElementsByClassName("cama-celda");
  for (const bed of beds) {
    $("#" + bed.id).mouseenter(function () {
      if ((!($(this).attr("data-folio") == "" || $(this).attr("data-folio") == "0")) && (!(dropdownToggleForbidden.find(element => element.trim() === $('input[name=area]').val())))) {
        getDataTooltip(bed.id);
      } else if ($(this).attr("class").split(/\s+/).find(element => element.trim() === 'grey-900') && "Limpieza e Higiene" == $('input[name=area]').val()) {
        getDataTooltip(bed.id);
      } else if ($(this).attr("class").split(/\s+/).find(element => element.trim() === 'red') && "Limpieza e Higiene" == $('input[name=area]').val()) {
        getDataTooltip(bed.id);
      }
    });
    $("#" + bed.id).mouseleave(function () {
      hideTooltip("tooltip" + bed.id);
    });
  }
  if ("Limpieza e Higiene" == $('input[name=area]').val()) {
    $(".tooltip").css("transform", "translate(-100px,-35px)");
    $(".tooltip").css("width", "17em");
  }
  if ("Enfermería Hospitalización" == $('input[name=area]').val() || $('input[name=area]').val() == 'Dirección Enfermería ') {
    $('body').on('click', '.notificacion-nota', function () {
      if ((!($(this).attr("data-Notas-Len") != "0" && ($(this).attr("data-cama-status") == "Contaminada" || $(this).attr("data-cama-status") == "Sucia")))) {
        //console.log("data-cama-id")
        //console.log($(this).attr("data-cama-id"))
        getDataNotesTooltip($(this).attr("data-cama-id"), $(this).attr("data-cama-nombre"));
      }
    });
  }
}
var toolN = 0;
async function getDataTooltip(cama_id) {
  showTooltipActive = true
  var n = 1;
  var t = 200
  for (var i = 0; i < n * t; i++) {
    await delay(1);
    if (!showTooltipActive) {
      return 0;
    }
  }
  if (!(dropdownToggleForbidden.find(element => element.trim() === $('input[name=area]').val()))) {
    socket.emit("getDataTooltip", { "id": cama_id })
  } else if ("Limpieza e Higiene" == $('input[name=area]').val()) {
    socket.emit("getDataFechaSuciaTooltip", { "id": cama_id })
  }
}

async function getDataNotesTooltip(cama_id, cama_nombre) {
  showTooltipActive = true
  var n = 1;
  var t = 200
  for (var i = 0; i < n * t; i++) {
    await delay(1);
    if (!showTooltipActive) {
      return 0;
    }
  }
  socket.emit("getDataNotesTooltip", { "id": cama_id, "cama_nombre": cama_nombre })
}


function getDataPacientesAreasCriticas(area) {
  socket.emit("getDataPacientesAreasCriticas", {
    "area": area
  });
}

async function showTooltip(data) {
  var id = "tooltip" + data["id"]
  var tooltip = document.getElementById(id)
  var nombrePaciente = data["dataTooltip"][0]["triage_nombre_ap"] + " " + data["dataTooltip"][0]["triage_nombre_am"] + " " + data["dataTooltip"][0]["triage_nombre"];
  var servicio = data["dataTooltip"][0]["especialidad_nombre"];
  var medicoTratante = data["dataTooltip"][0]["empleado_apellidos"] + " " + data["dataTooltip"][0]["empleado_nombre"];
  var fechaIngreso = data["dataTooltip"][0]["fecha_ingreso"];
  var folio = data["dataTooltip"][0]["triage_id"];
  $('.tooltip').css("opacity", 0);
  $('.tooltip').css("display", 'none');
  var tooltipC = document.getElementById(data["id"]);
  let coords = tooltipC.getBoundingClientRect();
  var htmlCode = " " +
    "<div id = infoId" + id + ">" +
    "<div class='signosv'>" +
    "<div class='div-sv divnamesv'>" +
    "<h3 class='sv-title svname'>DETALLES DEL PACIENTE</h3>" +
    "</div>" +
    "</div>" +
    "<div class='signosv'>" +
    "<div class='div-sv divnamesv'>" +
    "<h3 class='sv-title svname'>Paciente Nombre</h3>" +
    "<p class='value-sv valuesv text-uppercase font-weight-bold'>" + nombrePaciente + "</p>" +
    "</div>" +
    "</div>" +
    "<div class='signosv'>" +
    "<div class='div-sv divnamesv'>" +
    "<h3 class='sv-title svname'>Fecha Ingreso:</h3>" +
    "<p class='value-sv valuesv text-uppercase font-weight-bold'>" + fechaIngreso + "</p>" +
    "</div>" +
    "</div>" +
    "<div class='signosv'>" +
    "<div class='div-sv divnamesv'>" +
    "<h3 class='sv-title svname'>Folio Ingreso:</h3>" +
    "<p class='value-sv valuesv text-uppercase font-weight-bold'>" + folio + "</p>" +
    "</div>" +
    "</div>" +
    "<div class='signosv'>" +
    "<div class='div-sv divnamesv'>" +
    "<h3 class='sv-title svname'>Servicio</h3>" +
    "<p class='value-sv valuesv text-uppercase font-weight-bold'>" + servicio + "</p>" +
    "</div>" +
    "</div>" +
    "<div class='signosv'>" +
    "<div class='div-sv divnamesv'>" +
    "<h3 class='sv-title svname'>Médico Tratante</h3>" +
    "<p class='value-sv valuesv text-uppercase font-weight-bold'>" + medicoTratante + "</p>" +
    "</div>" +
    "</div>" +
    "</div>"
  tooltip.innerHTML = htmlCode
  var cr = coords.left
  if (cr < 335) {
    tooltip.classList.remove("tooltipF1");
    tooltip.classList.add("tooltipF2");
    tooltip.style.left = `${335}px`;
  } else {
    tooltip.classList.remove("tooltipF2")
    tooltip.classList.add("tooltipF1")
    tooltip.style.left = `${0}px`;
  }
  tooltip.style.opacity = 1;
  tooltip.style.display = "";
}


function showFechaSuciaTooltip(data) {
  var id = "tooltip" + data["id"]
  var tooltip = document.getElementById(id)
  var fechaIngreso = data["dataTooltip"][0]["fecha"];
  $('.tooltip').css("opacity", 0);
  $('.tooltip').css("display", 'none');
  if (fechaIngreso != "") {
    var tooltipC = document.getElementById(data["id"]);
    let coords = tooltipC.getBoundingClientRect();
    var notas_fecha_hora = fechaIngreso.split(" ");
    var notas_fecha = notas_fecha_hora[0].split("-");
    var htmlCode = " " +
      "<div id = infoId" + id + ">" +
      "<div class='signosv'>" +
      "<div class='div-sv divnamesv'>" +
      "<h3 class='sv-title svname'>Fecha</h3>" +
      "<p class='value-sv valuesv text-dark'>" + notas_fecha[2] + "-" + notas_fecha[1] + "-" + notas_fecha[0] + " " + notas_fecha_hora[1] + "</p>" +
      "</div>" +
      "</div>" +
      "<div class='signosv'>" +
      "<div class='div-sv divnamesv'>" +
      "<h3 class='sv-title svname'>Tiempo transcurrido:</h3>" +
      "<p class='value-sv valuesv font-weight-bold tiempo-transcurrido' date-time='" + fechaIngreso + "' ></p>" +
      "</div>" +
      "</div>" +
      "</div>"
    tooltip.innerHTML = htmlCode
    var cr = coords.left
    if (cr < 150) {
      tooltip.classList.remove("tooltipF0");
      tooltip.classList.add("tooltipF2");
      tooltip.style.left = `${100}px`;
    } else {
      tooltip.classList.remove("tooltipF2")
      tooltip.classList.add("tooltipF0")
      tooltip.style.left = `${-60}px`;
    }
    tooltip.style.opacity = 1;
    tooltip.style.display = "";
  }
}

function showDataNotesTooltip(data) {
  var notas = "";
  for (var i = 0; i < data["dataTooltip"].length; i++) {
    notas += '<h4>' + data["dataTooltip"][i]["nota"] + '</h4>'
  }
  bootbox.confirm({
    message: '<center><h4>Notas de la cama No.' + data["cama_nombre"] + '?</h4></center>' + notas,
    buttons: {
      confirm: {
        label: 'Marcar notas como leídas',
        className: 'btn-success'
      },
      cancel: {
        label: 'Cerrar',
        className: 'btn-danger'
      }
    },
    callback: function (result) {
      if (result) {
        socket.emit("setDataNotesEstado", { "id": data["id"], "cama_nombre": data["cama_nombre"], "estado": 1 })
      } else {
        //msj_error_noti("No se confirmo la limpieza" );
      }
    }
  });
}

function hideTooltip(id) {
  showTooltipActive = false;
  $('.tooltip').css("opacity", 0);
  $('.tooltip').css("display", 'none');
  $('.tooltip2').css("opacity", 0);
  $('.tooltip2').css("display", 'none');
  document.getElementById(id).innerHTML = "";
}

function updateNotesNotification(nota_id, n) {
  var nota = document.getElementById(nota_id);
  if (n == 0) {
    nota.style.opacity = 0;
    nota.innerHTML = "<p>0</p>";
    nota.setAttribute("data-Notas-Len", 0);
  } else {
    nota.style.opacity = 1;
    nota.innerHTML = "<p>" + n + "</p>";
    nota.setAttribute("data-Notas-Len", n);
  }
}

function showPacientesAreasCriticas(data, camas) {
  var tabla = '<div class="row">' +
    '<div class="col-md-12" style="margin-top: 0px">' +
    '<table id="tablaPacientes" class="table footable table-bordered table-hover table-no-padding" data-limit-navigation="10" data-filter="#filter" data-page-size="10">' +
    '<tr>' +
    '<th onclick="sortTable(0)" style="text-align:center;">No</th>' +
    '<th onclick="sortTable(1)" style="text-align:center;">Folio</th>' +
    '<th onclick="sortTable(2)" style="width: 30%" align="center">Paciente</th>' +
    '<th onclick="sortTable(3)" align="center">NSS </th>' +
    '<th onclick="sortTable(4)" align="center">Ingreso hospitalario</th>' +
    '<th onclick="sortTable(5)" align="center">Ingreso UCI</th>' +
    '<th onclick="sortTable(6)" style="width: 15%; text-align:center">Cama</th>' +
    '<th onclick="sortTable(7)" align="center">Tiempo instancia</th>' +
    '<th style="width: 15%">Acciones</th>' +
    '</tr>'
  for (var i = 0; i < data.length; i++) {
    var d = data[i]['fecha_ingreso'].split("-");
    if (d.length != 3) {
      d = data[i]['fecha_ingreso'].split("/");
      d = d[0] + "-" + d[1] + "-" + d[2]
    } else {
      d = d[2] + "-" + d[1] + "-" + d[0]
    }
    var dAC = new Date(data[i]['fecha_ingreso_uci']);
    var fechaInicio = dAC.getTime();
    var fechaFin = new Date().getTime();
    var tiempoInstancia = parseInt((fechaFin - fechaInicio) / (1000 * 60 * 60 * 24));
    tabla += '<tr>' +
      '<td>' + String(i + 1).padStart(2, 0) + '</td>' +
      '<td>' + data[i]['triage_id'] + '</td>' +
      '<td>' + data[i]['triage_nombre_ap'] + " " + data[i]['triage_nombre_am'] + " " + data[i]['triage_nombre'] + '</td>' +
      '<td style="text-align:center;">' + data[i]['pum_nss'] + ' ' + data[i]['pum_nss_agregado'] + '</td>' +
      '<td>' + d + '</td>' +
      '<td>' + String(dAC.getDate()).padStart(2, 0) + "-" + String(dAC.getMonth() + 1).padStart(2, 0) + "-" + String(dAC.getFullYear()).padStart(2, 0) + " " + String(dAC.getHours()).padStart(2, 0) + ":" + String(dAC.getMinutes()).padStart(2, 0) + '</td>' +
      "<td>"
    var cama = "";
    for (var j = 0; j < camas.length; j++) {
      if (parseInt(camas[j]["triage_id"]) == parseInt(data[i]['triage_id'])) {
        cama = camas[j]["cama_nombre"];
        break;
      }
    }
    if (cama == "") {
      tabla += "Por asignar";
    } else {
      tabla += cama;
    }
    tabla += '</td>' +
      '<td>' + tiempoInstancia + ' días</td>' +
      '<td>' +
      '<div>' +
      '<a href="http://' + window.location.host + '/sih/Sections/Documentos/Expediente/' + data[i]['triage_id'] + '/?tipo=Hospitalizacion"  target="_blank">' +
      '<i class="fa fa-share-square-o icono-accion tip" title="VER EXPEDIENTE" data-toggle="tooltip"></i>' +
      '</a>' +
      "&nbsp;" +
      "&nbsp;" +
      "&nbsp;" +
      '<a class="alta-paciente" data-triage="' + data[i]['triage_id'] + '">' +
      '<i class="fa fa-id-badge icono-accion tip" title="ALTA PACIENTE" data-toggle="tooltip"></i>' +
      '</a>' +
      '</div>' +
      '</td>' +
      '</tr>'
  }
  tabla += '</table>' +
    '</div>' +
    '</div>' +
    "<script>$(document).ready(function(){$('[data-toggle=" + '"tooltip"' + "]').tooltip();});</script>"
  $('#tablaPaciente').html(tabla);
}
//Ordenar tabla
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("tablaPacientes");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

///Periodo de tiempo de las camas sucias
if ("Limpieza e Higiene" == $('input[name=area]').val()) {
  // Update the count down every 1 second
  var x = setInterval(function () {
    var now = new Date().getTime();
    var NotasAllTime = document.getElementsByClassName("tiempo-transcurrido")
    for (var i = 0; i < NotasAllTime.length; i++) {
      var notas_fecha_hora_str = NotasAllTime[i].getAttribute("date-time");
      if (notas_fecha_hora_str != "") {
        var notas_fecha_hora = notas_fecha_hora_str.split(" ");
        var notas_fecha = notas_fecha_hora[0].split("-");
        var notas_hora = notas_fecha_hora[1].split(":");
        //console.log(notas_fecha);
        //console.log(notas_hora);
        var notas_hora_java = new Date(notas_fecha[0], notas_fecha[1] - 1, notas_fecha[2], notas_hora[0], notas_hora[1], 0, 0).getTime();
        var distance = now - notas_hora_java;
        //console.log(distance);
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        NotasAllTime[i].innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
      }
    }
  }, 1000);
}

activateTooltip();
test();
loadTablaPacienteAreaCritica();
