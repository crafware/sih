console.log("Server start");
const express = require("express");
const path = require("path");
const app = express();
const mysql = require('mysql')
const createServer = require("http");

// Parsing middleware
// Parse application/x-www-form-urlencoded
// app.use(bodyParser.urlencoded({ extended: false })); // Remove 
app.use(express.urlencoded({ extended: true })); // New
// Parse application/json
// app.use(bodyParser.json()); // Remove
app.use(express.json()); // New
// MySQL Code goes here
const pool = mysql.createPool({
  multipleStatements: true,
  connectionLimit: 200,
  host: 'localhost',
  user: 'sih_um5293',
  password: 'sihUM-5293-#$',
  database: 'sih_umae'
})

//sectings
app.set('port', process.env.PORT || 3001);
//static files
app.use(express.static(path.join(__dirname, 'public')));
const server = app.listen(app.get('port'), () => {
  console.log('server on port', app.get("port"));

});
//get local ip
const { networkInterfaces } = require('os');
const nets = networkInterfaces();
var ip_local = "";
for (const name of Object.keys(nets)) {
  for (const net of nets[name]) {
    if (net.family === 'IPv4' && !net.internal) {
      ip_local = net.address;
    }
  }
}

console.log(ip_local);
//const socketIO  = require("socket.io");
const socketIO = require("socket.io");
const io = socketIO(server, {
  cors: {
    origin: ["http://localhost", "http://" + ip_local, "http://11.47.37.14:8080", "http://localhost:8080"],
    methods: ["GET", "POST"]
  }
});

// websocked
io.on("connection", (socket) => {
  socket.on("setDataRequest", (data => {
    io.sockets.emit("getDataRequest", "Hola cliente");
  }))
  //tooltip
  socket.on("getDataTooltip", (data => {
    getDataTooltip(data["id"], socket);
  }))
  socket.on("getDataFechaCamaSuciaTooltip", (data => {
    getDataFechaCamaSuciaTooltip(data["id"], socket);
  }))
  socket.on("getDataNotesTooltip", (data => {
    getDataNotesTooltip(data["id"], data["cama_nombre"], data["tipo_nota"], socket);
  }))
  socket.on("getDataPacientesAreasCriticas", (data => {
    console.log(data);
    getDataPacientesAreasCriticas(data["area"], socket);
  }))
  socket.on("getAsistentemedicaTablaRegistroPacientesAdmisionContinua",(data =>{
    getAsistentemedicaTablaRegistroPacientesAdmisionContinua(socket);
  }))
  //Update dates
  socket.on("setDataNotesEstado", (data => {
    console.log(data);
    setDataNotesEstado(data, socket);
  }))
  socket.on("usuarioJefeDashboard", (data => {
    console.log(data);
    usuarioJefeDashboard(data, socket);
  }))
  socket.on("refresh_um_consultas_dashboard", (data => {
    console.log("refresh_um_consultas_dashboard");
    pool.getConnection((err, connection) => {
      connection.query("TRUNCATE um_consultas_dashboard", (err,) => {
        connection.release()
        registroPacientesIngresados() 
      })
    })
  }))

})

function usuarioJefeDashboard(data, socket) {
  var id = data["id"];
  pool.getConnection((err, connection,) => {
    if (err) throw err;
    connection.query("SELECT * FROM os_empleados WHERE empleado_id = " + id, (err, row,) => {
      if (!err) {
        if (row[0] != undefined) {
          if (row[0]["empleado_jefe_servicio"] == 1) {
            var dt = new Date();
            var fecha1 = dt.toISOString().slice(0, 10)
            dt.setDate(dt.getDate() - 30);
            var fecha2 = dt.toISOString().slice(0, 10)
            var empleado_servicio = row[0]["empleado_servicio"];
            var sql = "SELECT * FROM um_consultas_dashboard WHERE I_D_Servicio = " + empleado_servicio + " and I_D_Fecha >= '" + fecha2 + "'";
            connection.query(sql, (err, row,) => {
              if (err) console.log(err);
              var oneYearData = row;
              connection.query("SELECT * FROM um_consultas_dashboard WHERE I_D_Servicio = " + empleado_servicio + " and I_D_Fecha = '" + fecha1 + "'", (err, row,) => {
                connection.release();
                /*console.log("oneYearData")
                console.log(oneYearData)
                console.log(sql)*/
                if (err) console.log(err);
                if (row[0] == undefined) {
                  row[0] = {
                    "I_D_Fecha": fecha1,
                    "I_D_Interconsultas_Atendidas": 0,
                    "I_D_Interconsultas_Solicitadas": 0,
                    "I_D_Pacientes_Ingresados_Pro": 0,
                    "I_D_Pacientes_Ingresados_Urg": 0,
                    "I_D_Prealtas": 0,
                    "I_D_Altas_Pacientes": 0,
                    "pic_indicio_embarazo": 0,
                    "I_D_Servicio": empleado_servicio
                  }
                }
                io.sockets.to(socket.id).emit("usuarioJefeDashboard", { "oneYearData": oneYearData, "oneDayData": row[0] })
              })
            })
          }
        }
      } else {
        console.log(err)
      }
    })
  })
}

function setDataNotesEstado(data) {
  console.log("data")
  console.log(data)
  var cama_id = data["id"]
  var cama_nombre = data["cama_nombre"]
  var tipo_nota = data["tipo_nota"]
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    console.log('connected as id ' + connection.threadId);
    connection.query('UPDATE os_camas_notas SET estado = 1 where cama_id = ' + cama_id + " and tipo_nota = " + tipo_nota, (err, rows,) => {
      connection.release(); // return the connection to pool
      if (!err) {
        try {
          io.sockets.emit("setDataNotesEstado", { "cama_id": cama_id, "cama_nombre": cama_nombre, "error": false });
        } catch (e) {
          // statements to handle any exceptions
          console.log(e); // pass exception object to error handler
          io.sockets.emit("setDataNotesEstado", { "cama_id": cama_id, "cama_nombre": cama_nombre, "error": true });
        }
      } else {
        console.log(err);
      }
    });
  });
}

// Get empleado by ID
function getData(bed) {
  var end = true
  var area_id = bed[0]["after"]["area_id"]
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    console.log('connected as id ' + connection.threadId);
    connection.query('SELECT * FROM os_pisos where area_id = ' + area_id, (err, rows,) => {
      connection.release(); // return the connection to pool
      if (!err) {
        /*console.log("rows-------------------------");
        console.log(bed);*/
        try {
          //io.sockets.emit("getDataRequest",event.affectedRows);
          if (bed[0]["after"]["cama_estado"] == "Ocupado" || bed[0]["after"]["cama_estado"] == "Reservada") {
            getDataTriage(bed, rows)
          } else {
            io.sockets.emit("getDataBed", { "bed": bed, "floor": rows, "triage": [] });
          }
        } catch (e) {
          // statements to handle any exceptions
          console.log(e); // pass exception object to error handler
        }
      } else {
        console.log(err);
      }
    });
  });
  return end;
}

function getDataTriage(bed, floor) {
  console.log("getDataTriage")
  var end = true
  var triage_id = bed[0]["after"]["triage_id"]
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    console.log('connected as id ' + connection.threadId);
    connection.query('SELECT * FROM os_triage where triage_id = ' + triage_id, (err, rows,) => {
      connection.release(); // return the connection to pool
      if (!err) {
        try {
          io.sockets.emit("getDataBed", { "bed": bed, "floor": floor, "triage": rows });
        } catch (e) {
          console.log(e); // pass exception object to error handler
        }
      } else {
        console.log(err);
      }
    });
  });
  return end;
}
areasCriticasDB = {
  "UCI": { 'db': "um_pacientes_uci", 'areaId': "6" },
  "UTR": { 'db': "um_pacientes_utr", 'areaId': "6" },
  "UTMO": { 'db': "um_pacientes_utmo", 'areaId': "6" }
}

function getDataPacientesAreasCriticas(area, socket) {
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    connection.query('SELECT * FROM ' + areasCriticasDB[area]["db"] + ", os_triage, doc_43051,paciente_info WHERE " +
      "os_triage.triage_id = " + areasCriticasDB[area]["db"] + ".triage_id AND " +
      "os_triage.triage_id = paciente_info.triage_id AND " +
      "os_triage.triage_id = doc_43051.triage_id AND " +
      areasCriticasDB[area]["db"] + ".fecha_egreso_uci IS NULL", (err, rows,) => {
        connection.release();
        if (!err) {
          getDataPacientesAreasCriticasCamas(area, socket, rows)
        } else {
          console.log(err);
        }
      })
  })
}

function getAsistentemedicaTablaRegistroPacientesAdmisionContinua(socket){
  pool.getConnection((err, connection,)=> {
    if (err) throw err;
    var dt = new Date();
    var hoy = dt.toISOString().slice(0, 10);
    var data = {}
    connection.query("SELECT os_triage.triage_id,os_triage.triage_nombre, os_triage.triage_nombre_ap, os_triage.triage_nombre_am, "+
                    "os_triage.triage_color,os_triage.triage_fecha_clasifica, os_triage.triage_hora_clasifica, os_triage.triage_via_registro, "+
                    "os_asistentesmedicas.asistentesmedicas_fecha, os_asistentesmedicas.asistentesmedicas_hora,paciente_info.pic_mt,paciente_info.pia_lugar_accidente "+
                    "FROM os_triage, os_accesos, os_asistentesmedicas, paciente_info WHERE os_accesos.acceso_tipo='Asistente Médica' "+
                    "AND os_accesos.triage_id = os_triage.triage_id AND os_accesos.areas_id = os_asistentesmedicas.asistentesmedicas_id AND "+
                    "os_asistentesmedicas.asistentesmedicas_fecha= '"+hoy+"' AND paciente_info.triage_id=os_triage.triage_id ORDER BY os_accesos.acceso_id LIMIT 150",(err,rows)=>{
      if(!err){
        /*$sqlST7=$this->config_mdl->sqlGetDataCondition('paciente_info',array(
          'triage_id'=>data[value]['triage_id']
      ),'pia_lugar_accidente')[0];*/
          data["table_data"] = rows
          connection.query("SELECT * FROM um_config",(err,rows) =>{
            connection.release();
            if(!err){
              data["um_config"] = rows
              io.sockets.to(socket.id).emit("getAsistentemedicaTablaRegistroPacientesAdmisionContinua",data);
            }
          })
      }else{
        console.log(err)
      }
    });
  })
}

function updateRegistroPacientesAtencionMedicaAdmisionContinua(data){
  pool.getConnection((err, connection,)=> {
    if (err) throw err;
    connection.query("SELECT os_triage.triage_id,os_triage.triage_nombre, os_triage.triage_nombre_ap, os_triage.triage_nombre_am, "+
                    "os_triage.triage_color,os_triage.triage_fecha_clasifica, os_triage.triage_hora_clasifica, os_triage.triage_via_registro, "+
                    "os_asistentesmedicas.asistentesmedicas_fecha, os_asistentesmedicas.asistentesmedicas_hora,paciente_info.pic_mt,paciente_info.pia_lugar_accidente "+
                    "FROM os_triage, os_accesos, os_asistentesmedicas, paciente_info WHERE os_accesos.acceso_tipo='Asistente Médica' "+
                    "AND os_accesos.triage_id = os_triage.triage_id AND os_accesos.areas_id = os_asistentesmedicas.asistentesmedicas_id "+
                    "AND paciente_info.triage_id=os_triage.triage_id AND paciente_info.triage_id = " + data["triage_id"] ,(err,rows)=>{
      connection.release();
      if(!err){
        console.log(rows[0])
        io.sockets.emit("updateRegistroPacientesAtencionMedicaAdmisionContinua", rows[0]);
      }else{
        console.log(err)
      }
    });
  })
}

function getDataPacientesAreasCriticasCamas(area, socket, rowsPacientes) {
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    connection.query('SELECT * FROM  os_camas WHERE os_camas.area_id = ' + areasCriticasDB[area]["areaId"], (err, rows,) => {
      connection.release();
      if (!err) {
        try {
          var data = { "dataPacientes": rowsPacientes, "area": area, "camas": rows }
          if (socket == "") {
            io.sockets.emit("getDataPacientesAreasCriticas", data)
          } else {
            io.sockets.to(socket.id).emit("getDataPacientesAreasCriticas", data);
          }
        } catch (e) {
          console.log(e);
        }
      } else {
        console.log(err);
      }
    })
  })
}

function getDataTooltip(cama_id_piso, socket) {
  var end = true
  cama_id = cama_id_piso.split("_")[0]
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    connection.query('SELECT triage_nombre, triage_nombre_ap, triage_nombre_am, especialidad_nombre, empleado_nombre, empleado_apellidos, fecha_ingreso, os_triage.triage_id FROM os_camas, os_triage, os_empleados, um_especialidades, doc_43051 WHERE doc_43051.ingreso_servicio = um_especialidades.especialidad_id AND um_especialidades.especialidad_id = doc_43051.ingreso_servicio AND doc_43051.ingreso_medico = os_empleados.empleado_id AND os_triage.triage_id = doc_43051.triage_id  AND os_triage.triage_id = os_camas.triage_id AND os_camas.cama_id = ' + cama_id, (err, rows,) => {
      connection.release(); // return the connection to pool
      if (!err) {
        try {
          io.sockets.to(socket.id).emit("getDataTooltip", { "dataTooltip": rows, "id": cama_id_piso });
        } catch (e) {
          console.log(e); // pass exception object to error handler
        }
      } else {
        console.log(err);
      }
    });
  });
  return end;
}


function getDataFechaCamaSuciaTooltip(cama_id_piso, socket) {
  var end = true
  cama_id = cama_id_piso.split("_")[0]
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    //connection.query('SELECT MAX(fecha_hora) as fecha FROM os_camas_estados WHERE cama_id = ' + cama_id, (err, rows,) => {
    connection.query('SELECT cama_fh_estatus as fecha FROM os_camas WHERE cama_id =' + cama_id, (err, rows,) => {
      connection.release(); // return the connection to pool
      if (!err) {
        try {
          io.sockets.to(socket.id).emit("getDataFechaCamaSuciaTooltip", { "dataTooltip": rows, "id": cama_id_piso });
        } catch (e) {
          console.log(e); // pass exception object to error handler
        }
      } else {
        console.log(err);
      }
    });
  });
  return end;
}

function getDataNotesTooltip(cama_id, cama_nombre, tipo_nota, socket) {
  var end = true;
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    //connection.query('SELECT MAX(fecha_hora) as fecha FROM os_camas_estados WHERE cama_id = ' + cama_id, (err, rows,) => {
    connection.query('SELECT * FROM os_camas_notas WHERE estado = 0 and cama_id =' + cama_id + " and tipo_nota = " + tipo_nota, (err, rows,) => {
      connection.release(); // return the connection to pool
      if (!err) {
        try {
          io.sockets.to(socket.id).emit("getDataNotesTooltip", { "dataTooltip": rows, "id": cama_id, "cama_nombre": cama_nombre });
        } catch (e) {
          console.log(e); // pass exception object to error handler
        }
      } else {
        console.log(err);
      }
    });
  });
  return end;
}

function getDataCamasNotas(data) {
  cama_id = data[0]["after"]["cama_id"]
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    connection.query('SELECT * FROM os_camas_notas WHERE estado = 0 and cama_id =' + cama_id, (err, rows,) => {
      connection.release(); // return the connection to pool
      if (!err) {
        try {
          io.sockets.emit("getDataCamasNotas", { "cama_id": cama_id, "note_len": rows });
        } catch (e) {
          console.log(e); // pass exception object to error handler
        }
      } else {
        console.log(err);
      }
    });
  });
}

/* ------------------------------------------- */
/* ------------------------------------------- */
/* Actualisa tabla um_consultas_dashboard */
/* ------------------------------------------- */
/* ------------------------------------------- */
/* Cama estados, Prealtas, Altas (I_D_Prealtas, I_D_Altas_Pacientes )*/

function getDataRegistroSolicitudesAtendidas(affectedRows) {
  var MySQLEvent = ""
  var inserts = "INSERT um_consultas_dashboard (I_D_Fecha, I_D_Interconsultas_Atendidas, I_D_Interconsultas_Solicitadas, I_D_Servicio) VALUES ";
  if (affectedRows[0]["before"] == undefined) {
    pool.getConnection((err, connection,) => {
      if (err) {
        console.log(err);
        throw err;
      }
      var fecha = affectedRows[0]["after"]["doc_fecha"];
      if (typeof (fecha) != "string")
        fecha = fecha.toISOString().slice(0, 10);
      else
        fecha = fecha.slice(0, 10)
      var servicio = affectedRows[0]["after"]["doc_servicio_solicitado"];
      connection.query("SELECT * FROM um_consultas_dashboard WHERE I_D_Fecha = '" + fecha + "' and I_D_Servicio = " + servicio, (err, row) => {
        if (!err) {
          if (row[0] != undefined) {
            if (affectedRows[0]["after"]["doc_estatus"] == "Evaluado") {
              MySQLEvent = "UPDATE um_consultas_dashboard SET I_D_Interconsultas_Atendidas = " + (row[0]["I_D_Interconsultas_Atendidas"] + 1) + ", I_D_Interconsultas_Solicitadas = " + (row[0]["I_D_Interconsultas_Solicitadas"] + 1) + " WHERE I_D_Fecha = '" + fecha + "' and I_D_Servicio = " + servicio
            } else if (affectedRows[0]["after"]["doc_estatus"] == "En Espera") {
              MySQLEvent = "UPDATE um_consultas_dashboard SET I_D_Interconsultas_Solicitadas = " + (row[0]["I_D_Interconsultas_Solicitadas"] + 1) + " WHERE I_D_Fecha = '" + fecha + "' and I_D_Servicio = " + servicio
            } else {
              connection.release();
              return (-1);
            }
            connection.query(MySQLEvent, (err, row) => {
              connection.release();
              if (err) console.log(err);
            });
          } else {
            if (affectedRows[0]["after"]["doc_estatus"] == "Evaluado") {
              MySQLEvent = inserts + "('" + fecha + "',1,1," + servicio + ")"
            } else if (affectedRows[0]["after"]["doc_estatus"] == "En Espera") {
              MySQLEvent = inserts + "('" + fecha + "',0,1," + servicio + ")"
            } else {
              connection.release();
              return (-1);
            }
            connection.query(MySQLEvent, (err, row) => {
              connection.release();
              if (err) console.log(err);
            })
          }
        } else {
          console.log(err)
        }
      })
    })
  } else if (affectedRows[0]["after"]["doc_estatus"] != affectedRows[0]["before"]["doc_estatus"]) {
    pool.getConnection((err, connection,) => {
      if (err) {
        console.log(err);
        throw err;
      }
      var fecha = affectedRows[0]["after"]["doc_fecha"];
      if (typeof (fecha) != "string")
        fecha = fecha.toISOString().slice(0, 10);
      else
        fecha = fecha.slice(0, 10)
      var servicio = affectedRows[0]["after"]["doc_servicio_solicitado"];
      connection.query("SELECT * FROM um_consultas_dashboard WHERE I_D_Fecha = '" + fecha + "' and I_D_Servicio = " + servicio, (err, row) => {
        if (!err) {
          if (row[0] != undefined) {
            MySQLEvent = "UPDATE um_consultas_dashboard SET I_D_Interconsultas_Atendidas = " + (row[0]["I_D_Interconsultas_Atendidas"] + 1) + " WHERE I_D_Fecha = '" + fecha + "' and I_D_Servicio = " + servicio
            connection.query(MySQLEvent, (err, row) => {
              connection.release();
              if (err) console.log(err);
            });
          } else {
            MySQLEvent = inserts + "('" + fecha + "',1,1," + servicio + ")"
            connection.query(MySQLEvent, (err, row) => {
              connection.release();
              if (err) console.log(err);
            })
          }
        } else {
          console.log(err)
        }
      })
    })
  }
}

function getDataRegistroPacientesIngresados(affectedRows) {
  console.log(affectedRows)
  if (affectedRows[0]["before"] == undefined) {
    pool.getConnection((err, connection,) => {
      if (err) {
        console.log(err);
        throw err;
      }
      var fecha = affectedRows[0]["after"]["fecha_ingreso"];
      var queryAux = ""
      if (typeof (fecha) != "string")
        fecha = fecha.toISOString().slice(0, 10);
      else
        fecha = fecha.slice(0, 10)
      var servicio = affectedRows[0]["after"]["ingreso_servicio"];
      var inserts = "INSERT um_consultas_dashboard (I_D_Fecha, I_D_Pacientes_Ingresados_Pro,I_D_Pacientes_Ingresados_Urg,I_D_Servicio) VALUES ";
      connection.query("SELECT * FROM um_consultas_dashboard WHERE I_D_Fecha = '" + fecha + "' and I_D_Servicio = " + servicio, (err, row) => {
        if (!err) {
          if (row[0] != undefined) {
            if (affectedRows[0]["after"]["tipo_ingreso"] == "Programado") {
              queryAux = "UPDATE um_consultas_dashboard SET I_D_Pacientes_Ingresados_Pro = " + (row[0]["I_D_Pacientes_Ingresados_Pro"] + 1) + " WHERE I_D_Fecha = '" + fecha + "' and I_D_Servicio = " + servicio;
            } else if (affectedRows[0]["after"]["tipo_ingreso"] == "Urgente") {
              queryAux = "UPDATE um_consultas_dashboard SET I_D_Pacientes_Ingresados_Urg = " + (row[0]["I_D_Pacientes_Ingresados_Urg"] + 1) + " WHERE I_D_Fecha = '" + fecha + "' and I_D_Servicio = " + servicio;
            }
            connection.query(queryAux, (err, row) => {
              connection.release();
              if (err) console.log(err);
            });
          } else {
            if (affectedRows[0]["after"]["tipo_ingreso"] == "Programado") {
              queryAux = inserts + "('" + fecha + "',1,0," + servicio + ")";
            } else if (affectedRows[0]["after"]["tipo_ingreso"] == "Urgente") {
              queryAux = inserts + "('" + fecha + "',0,1," + servicio + ")";
            }
            connection.query(queryAux, (err, row) => {
              connection.release();
              if (err) console.log(err);
            })
          }
        } else {
          console.log(err)
        }
      })
    })
  }
}

function getDataRegistroPicIndicioEmbarazo(affectedRows) {
  console.log(affectedRows)
  var emb = 0
  if (affectedRows[0]["before"] != undefined) {
    console.log(affectedRows[0]["before"]["pic_indicio_embarazo"] == affectedRows[0]["after"]["pic_indicio_embarazo"])
    if (affectedRows[0]["before"]["pic_indicio_embarazo"] == affectedRows[0]["after"]["pic_indicio_embarazo"]) {
      console.log("emb1")
      return 0;
    } else if (affectedRows[0]["after"]["pic_indicio_embarazo"] == "Si") {
      emb = 1;
    } else {
      emb = -1;
    }
  } else if (affectedRows[0]["after"]["pic_indicio_embarazo"] == "Si") {
    emb = 1;
  }
  console.log("emb")
  console.log(emb)
  pool.getConnection((err, connection,) => {
    if (err) {
      console.log(err);
      throw err;
    }
    connection.query("SELECT * FROM doc_43051 WHERE triage_id = " + affectedRows[0]["after"]["triage_id"], (err, row) => {
      if (!err && (row[0] != undefined)) {
        var fecha = row[0]["fecha_ingreso"];
        var queryAux = ""
        if (fecha != null) {
          if ("string" != typeof (fecha)) {
            fecha = fecha.toISOString().slice(0, 10);
          } else {
            if (fecha.search("/") != -1) {
              var f = fecha.slice(0, 10).split("/")
              fecha = f[2] + "-" + f[0] + "-" + f[1];
            }
          }
        }
        var servicio = row[0]["ingreso_servicio"];
        console.log(servicio)
        console.log(fecha)
        var inserts = "INSERT um_consultas_dashboard (I_D_Fecha,pic_indicio_embarazo,I_D_Servicio) VALUES ";
        connection.query("SELECT * FROM um_consultas_dashboard WHERE I_D_Fecha = '" + fecha + "' and I_D_Servicio = " + servicio, (err, row) => {
          console.log(row)
          if (!err) {
            if (row[0] != undefined) {
              queryAux = "UPDATE um_consultas_dashboard SET pic_indicio_embarazo = " + (row[0]["pic_indicio_embarazo"] + emb) + " WHERE I_D_Fecha = '" + fecha + "' and I_D_Servicio = " + servicio;
              connection.query(queryAux, (err, row) => {
                connection.release();
                if (err) console.log(err);
              });
            } else {
              if (affectedRows[0]["after"]["tipo_ingreso"] == "Programado") {
                queryAux = inserts + "('" + fecha + "',1," + servicio + ")";
                connection.query(queryAux, (err, row) => {
                  connection.release();
                  if (err) console.log(err);
                })
              }
            }
          } else {
            connection.release();
            console.log(err)
          }
        })
      } else {
        connection.release();
        console.log(err)
      }
    })
  })
}

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms))
}

function registroAltaPreAlta(estado) {
  var values = "";
  var col = "";
  var proceso = estado["proceso"];
  var triage = estado["triage_id"];
  pool.getConnection((err, connection) => {
    if (err)
      throw err;
    var fecha = new Date().toISOString().slice(0, 10);
    connection.query("SELECT * FROM um_ingresos_hospitalario WHERE triage_id = " + triage, (err, row) => {
      if (!err) {
        if (row[0] != null) {
          var id_servicio = row[0]["id_servicio"]
          connection.query("SELECT * FROM um_consultas_dashboard WHERE I_D_Fecha = '" + fecha + "' AND I_D_Servicio = " + id_servicio, async (err, row,) => {
            if (!err) {
              if (row[0] == undefined) {
                values = "INSERT um_consultas_dashboard (I_D_Fecha,I_D_Prealtas,I_D_Altas_Pacientes,I_D_Servicio) VALUES "
                if (proceso == 1) {
                  values += "('" + fecha + "',1,0," + id_servicio + ")"
                } else if (proceso == 2) {
                  values += "('" + fecha + "',0,1," + id_servicio + ")"
                }
                connection.query(values, (err, row,) => {
                  if (err) console.log(err);
                });
              } else {
                if (proceso == 1) {
                  values = row[0]["I_D_Prealtas"] + 1;
                  col = "I_D_Prealtas"
                } else if (proceso == 2) {
                  values = row[0]["I_D_Altas_Pacientes"] + 1;
                  col = "I_D_Altas_Pacientes"
                }
                connection.query("UPDATE um_consultas_dashboard SET " + col + " = " + values + " WHERE interconsultas_dashboard_id =" + row[0]["interconsultas_dashboard_id"], (err, row) => {
                  if (err) console.log(err);
                });
              }
            } else {
              console.log(err)
            }
          })
        }
        connection.release();
      } else {
        console.log(err)
      }
    })
  });
}

/* Interconsultas Solicitudes/atendidas (I_D_Interconsultas_Atendidas)*/
function registroSolicitudesAtendidas() {
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    connection.query("SELECT * FROM doc_430200", async (err, row) => {
      var Solicitudes_Atendidas = {}
      if (!err) {
        for (r in row) {
          if (Solicitudes_Atendidas[row[r]["doc_fecha"] + row[r]["doc_servicio_solicitado"]] == undefined) {
            if (row[r]["doc_estatus"] == "Evaluado") {
              Solicitudes_Atendidas[row[r]["doc_fecha"] + row[r]["doc_servicio_solicitado"]] = { "noAtendidas": 1, "noSolicitudes": 1, "servicio": row[r]["doc_servicio_solicitado"], "fecha": row[r]["doc_fecha"] };
            } else if (row[r]["doc_estatus"] == "En Espera") {
              Solicitudes_Atendidas[row[r]["doc_fecha"] + row[r]["doc_servicio_solicitado"]] = { "noAtendidas": 0, "noSolicitudes": 1, "servicio": row[r]["doc_servicio_solicitado"], "fecha": row[r]["doc_fecha"] };
            }
          } else {
            Solicitudes_Atendidas[row[r]["doc_fecha"] + row[r]["doc_servicio_solicitado"]]["no"] += 1;
            if (row[r]["doc_estatus"] == "Evaluado") {
              Solicitudes_Atendidas[row[r]["doc_fecha"] + row[r]["doc_servicio_solicitado"]]["noAtendidas"] += 1;
              Solicitudes_Atendidas[row[r]["doc_fecha"] + row[r]["doc_servicio_solicitado"]]["noSolicitudes"] += 1;
            } else if (row[r]["doc_estatus"] == "En Espera") {
              Solicitudes_Atendidas[row[r]["doc_fecha"] + row[r]["doc_servicio_solicitado"]]["noSolicitudes"] += 1;
            }
          }
        }
        var queryArg = "SELECT * FROM um_consultas_dashboard"
        var insertsData = "";
        var update = '';
        var found = true;
        var fs = "";
        var inserts = "INSERT um_consultas_dashboard (I_D_Fecha, I_D_Interconsultas_Atendidas, I_D_Interconsultas_Solicitadas,I_D_Servicio) VALUES ";
        connection.query(queryArg, (err, row) => {
          if (!err) {
            for (r in row) {
              row[r]["I_D_Fecha"] = row[r]["I_D_Fecha"].toISOString().slice(0, 10)
            }
            for (s in Solicitudes_Atendidas) {
              found = true;
              for (r in row) {
                fs = row[r]["I_D_Fecha"] + row[r]["I_D_Servicio"]
                if (s == fs) {
                  update += "UPDATE um_consultas_dashboard SET I_D_Interconsultas_Atendidas = " + (Solicitudes_Atendidas[fs]["noAtendidas"]) + ", I_D_Interconsultas_Solicitadas = " + (Solicitudes_Atendidas[fs]["noSolicitudes"]) + " WHERE interconsultas_dashboard_id =" + row[r]["interconsultas_dashboard_id"] + ";\n"
                  found = false;
                  break
                }
              }
              if (found) {
                insertsData += " ('" + Solicitudes_Atendidas[s]["fecha"] + "'," + (Solicitudes_Atendidas[s]["noAtendidas"]) + "," + Solicitudes_Atendidas[s]["noSolicitudes"] + "," + Solicitudes_Atendidas[s]["servicio"] + "),"
              }
            }
            if (insertsData != "") {
              insertsData = insertsData.slice(0, -1) + ";"
              connection.query(inserts + insertsData, (err, row,) => {
                if (err) console.log(err);
                if (update.length > 0) {
                  connection.query(update, (err, row,) => {
                    connection.release();
                    if (err) console.log(err);
                    else console.log("actualización de interconsultas completa 1")
                  })
                } else {
                  connection.release();
                  console.log("actualización de interconsultas completa 2")
                }
              })
            } else {
              if (update.length > 0) {
                connection.query(update, (err, row,) => {
                  connection.release();
                  if (err) console.log(err)
                  else console.log("actualización de interconsultas completa 3")
                })
              } else {
                connection.release(); 
                console.log("actualización de interconsultas completa 4")
              }
            }
          } else {
            console.log(err)
          }
        })
      } else {
        console.log(err)
      }
    })
  })
}

/* Pacientes ingresados (I_D_Pacientes_Ingresados)*/
function registroPacientesIngresados() {
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    connection.query("SELECT * FROM doc_43051", async (err, row) => {
      var Pacientes_Ingresados = {}
      if (!err) {
        for (r in row) {
          if (row[r]["fecha_ingreso"] != null) {
            if ("string" != typeof (row[r]["fecha_ingreso"])) {
              row[r]["fecha_ingreso"] = row[r]["fecha_ingreso"].toISOString().slice(0, 10);
            } else {
              if (row[r]["fecha_ingreso"].search("/") != -1) {
                var f = row[r]["fecha_ingreso"].slice(0, 10).split("/")
                row[r]["fecha_ingreso"] = f[2] + "-" + f[0] + "-" + f[1];
              }
            }
          }
        }
        for (r in row) {
          if (row[r]["ingreso_servicio"] != null) {
            if (Pacientes_Ingresados[row[r]["fecha_ingreso"] + row[r]["ingreso_servicio"]] == undefined) {
              if (row[r]["tipo_ingreso"] == "Programado") {
                Pacientes_Ingresados[row[r]["fecha_ingreso"] + row[r]["ingreso_servicio"]] = { "noUrg": 0, "noPro": 1, "servicio": parseInt(row[r]["ingreso_servicio"]), "fecha": row[r]["fecha_ingreso"] };
              } else if (row[r]["tipo_ingreso"] == "Urgente") {
                Pacientes_Ingresados[row[r]["fecha_ingreso"] + row[r]["ingreso_servicio"]] = { "noUrg": 1, "noPro": 0, "servicio": parseInt(row[r]["ingreso_servicio"]), "fecha": row[r]["fecha_ingreso"] };
              }
            } else {
              if (row[r]["tipo_ingreso"] == "Programado") {
                Pacientes_Ingresados[row[r]["fecha_ingreso"] + row[r]["ingreso_servicio"]]["noPro"] += 1;
              } else if (row[r]["tipo_ingreso"] == "Urgente") {
                Pacientes_Ingresados[row[r]["fecha_ingreso"] + row[r]["ingreso_servicio"]]["noUrg"] += 1;
              }
            }
          }
        }
        var queryArg = "SELECT * FROM um_consultas_dashboard";
        var insertsData = "";
        var update = "";
        var found = true;
        var fs = "";
        var inserts = "INSERT um_consultas_dashboard (I_D_Fecha, I_D_Pacientes_Ingresados_Pro,I_D_Pacientes_Ingresados_Urg,I_D_Servicio) VALUES ";
        connection.query(queryArg, (err, row) => {
          if (!err) {
            for (r in row) {
              row[r]["I_D_Fecha"] = row[r]["I_D_Fecha"].toISOString().slice(0, 10);
            }
            for (s in Pacientes_Ingresados) {
              found = true;
              for (r in row) {
                fs = row[r]["I_D_Fecha"] + row[r]["I_D_Servicio"];
                if (s == fs) {
                  update += "UPDATE um_consultas_dashboard SET I_D_Pacientes_Ingresados_Pro = " + Pacientes_Ingresados[fs]["noPro"] + ", I_D_Pacientes_Ingresados_Urg = " + Pacientes_Ingresados[fs]["noUrg"] + " WHERE interconsultas_dashboard_id = " + row[r]["interconsultas_dashboard_id"] + ";\n"
                  found = false;
                  break
                }
              }
              if (found) {
                insertsData += " ('" + Pacientes_Ingresados[s]["fecha"] + "'," + Pacientes_Ingresados[s]["noPro"] + "," + Pacientes_Ingresados[s]["noUrg"] + "," + Pacientes_Ingresados[s]["servicio"] + "),"
              }
            }
            if (insertsData != "") {
              insertsData = insertsData.slice(0, -1) + ";"
              connection.query(inserts + insertsData, (err) => {
                if (err) console.log(err);
                if (update.length > 0) {
                  connection.query(update, (err, row,) => {
                    connection.release();
                    if (err) console.log(err);
                    registroIndicioEmbarazo();
                  })
                } else {
                  connection.release();
                  registroIndicioEmbarazo();
                }
              })
            } else {
              if (update.length > 0) {
                connection.query(update, (err, row,) => {
                  connection.release();
                  if (err) console.log(err);
                  registroIndicioEmbarazo();
                })
              } else {
                connection.release();
                registroIndicioEmbarazo();
              }
            }
          }
        })
      }
    })
  })
}

/* Pacientes ingresados (I_D_Pacientes_Ingresados)*/
function registroIndicioEmbarazo() {
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    connection.query("SELECT * FROM paciente_info, doc_43051 WHERE paciente_info.triage_id = doc_43051.triage_id and paciente_info.pic_indicio_embarazo = 'Si'", async (err, row) => {
      console.log(row)
      var Pacientes_Ingresados = {}
      if (!err) {
        for (r in row) {
          if (row[r]["fecha_ingreso"] != null) {
            if ("string" != typeof (row[r]["fecha_ingreso"])) {
              row[r]["fecha_ingreso"] = row[r]["fecha_ingreso"].toISOString().slice(0, 10);
            } else {
              if (row[r]["fecha_ingreso"].search("/") != -1) {
                var f = row[r]["fecha_ingreso"].slice(0, 10).split("/")
                row[r]["fecha_ingreso"] = f[2] + "-" + f[0] + "-" + f[1];
              }
            }
          }
        }
        for (r in row) {
          if (row[r]["ingreso_servicio"] != null) {
            if (Pacientes_Ingresados[row[r]["fecha_ingreso"] + row[r]["ingreso_servicio"]] == undefined) {
              Pacientes_Ingresados[row[r]["fecha_ingreso"] + row[r]["ingreso_servicio"]] = { "no": 1, "servicio": parseInt(row[r]["ingreso_servicio"]), "fecha": row[r]["fecha_ingreso"] };
            } else {
              Pacientes_Ingresados[row[r]["fecha_ingreso"] + row[r]["ingreso_servicio"]]["no"] += 1;
            }
          }
        }
        var queryArg = "SELECT * FROM um_consultas_dashboard";
        var insertsData = "";
        var update = "";
        var found = true;
        var fs = "";
        var inserts = "INSERT um_consultas_dashboard (I_D_Fecha,pic_indicio_embarazo,I_D_Servicio) VALUES ";
        connection.query(queryArg, (err, row) => {
          if (!err) {
            for (r in row) {
              row[r]["I_D_Fecha"] = row[r]["I_D_Fecha"].toISOString().slice(0, 10);
            }
            for (s in Pacientes_Ingresados) {
              found = true;
              for (r in row) {
                fs = row[r]["I_D_Fecha"] + row[r]["I_D_Servicio"];
                if (s == fs) {
                  update += "UPDATE um_consultas_dashboard SET pic_indicio_embarazo = " + Pacientes_Ingresados[fs]["no"] + " WHERE interconsultas_dashboard_id = " + row[r]["interconsultas_dashboard_id"] + ";\n"
                  found = false;
                  break
                }
              }
              if (found) {
                insertsData += " ('" + Pacientes_Ingresados[s]["fecha"] + "'," + Pacientes_Ingresados[s]["no"] + "," + Pacientes_Ingresados[s]["servicio"] + "),"
              }
            }
            if (insertsData != "") {
              insertsData = insertsData.slice(0, -1) + ";"
              connection.query(inserts + insertsData, (err) => {
                if (err) console.log(err);
                if (update.length > 0) {
                  connection.query(update, (err, row,) => {
                    connection.release();
                    if (err) console.log(err);
                    registroSolicitudesAtendidas();
                  })
                } else {
                  connection.release();
                  registroSolicitudesAtendidas();
                }
              })
            } else {
              if (update.length > 0) {
                connection.query(update, (err, row,) => {
                  connection.release();
                  if (err) console.log(err);
                  registroSolicitudesAtendidas();
                })
              } else {
                connection.release();
                registroSolicitudesAtendidas();
              }
            }
          }
        })
      }
    })
  })
}

//Detect mysql events
const MySQLEvents = require('@rodrigogs/mysql-events');
const { pathToFileURL } = require("url");
const getDataPacientesAreasCriticasTablas = ["um_pacientes_uci", "os_camas", "os_triage"]

const program = async () => {
  const connection = mysql.createPool({
    connectionLimit: 200,
    host: 'localhost',
    user: 'sih_um5293',
    password: 'sihUM-5293-#$',
    //debug           : true
  });
  const instance = new MySQLEvents(connection, {
    startAtEnd: true,
    excludedSchemas: {
      mysql: true,
    },
  });
  await instance.start();
  instance.addTrigger({
    name: 'TEST1',
    expression: 'sih_umae.*',
    statement: MySQLEvents.STATEMENTS.ALL,
    onEvent: async (event) => { // You will receive the events here
      if (event.table == "os_camas") {
        getData(event.affectedRows)
        if (event.affectedRows[0]["after"]["proceso"] != event.affectedRows[0]["before"]["proceso"]) {
          if (event.affectedRows[0]["after"]["proceso"] == 1 || event.affectedRows[0]["after"]["proceso"] == 2) {
            registroAltaPreAlta(event.affectedRows[0]["after"])
          }
        }
      } if (getDataPacientesAreasCriticasTablas.find(element => element.trim() === event.table)) {
        getDataPacientesAreasCriticas("UCI", "")
      } if (event.table == "os_camas_notas") {
        getDataCamasNotas(event.affectedRows)
      } if (event.table == "doc_43051") {
        getDataRegistroPacientesIngresados(event.affectedRows)
      } if (event.table == "doc_430200") {
        getDataRegistroSolicitudesAtendidas(event.affectedRows)
      } if (event.table == "paciente_info") {
        getDataRegistroPicIndicioEmbarazo(event.affectedRows)
      } if (event.table == "os_asistentesmedicas") {
        updateRegistroPacientesAtencionMedicaAdmisionContinua(event.affectedRows[0]["after"])
      } if (event.table == "um_consultas_dashboard") {
        io.sockets.emit("realTimeUpdateDashboard", event.affectedRows[0]["after"]);
      }
    },
  });
  instance.on(MySQLEvents.EVENTS.CONNECTION_ERROR, console.error);
  instance.on(MySQLEvents.EVENTS.ZONGJI_ERROR, console.error);
};
program()
  .then(() => console.log('Waiting for database events...'))
  .catch(console.error);
