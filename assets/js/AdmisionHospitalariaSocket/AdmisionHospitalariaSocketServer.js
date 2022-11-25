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
  socket.on("getDataFechaSuciaTooltip", (data => {
    getDataFechaSuciaTooltip(data["id"], socket);
  }))
  socket.on("getDataNotesTooltip", (data => {
    getDataNotesTooltip(data["id"],data["cama_nombre"],data["tipo_nota"], socket);
  }))
  socket.on("getDataPacientesAreasCriticas", (data => {
    console.log(data);
    getDataPacientesAreasCriticas(data["area"], socket);
  }))
  //Update dates
  socket.on("setDataNotesEstado", (data => {
    console.log(data);
    setDataNotesEstado(data, socket);
  }))

})


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
            io.sockets.emit("setDataNotesEstado", { "cama_id": cama_id,"cama_nombre": cama_nombre,"error": false});
        } catch (e) {
          // statements to handle any exceptions
          console.log(e); // pass exception object to error handler
          io.sockets.emit("setDataNotesEstado", { "cama_id": cama_id,"cama_nombre": cama_nombre,"error": true});
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
    connection.query('SELECT * FROM os_pisos  where area_id = ' + area_id, (err, rows,) => {
      connection.release(); // return the connection to pool
      if (!err) {
        console.log("rows-------------------------");
        console.log(bed);
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
    connection.query('SELECT * FROM os_triage  where triage_id = ' + triage_id, (err, rows,) => {
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


function getDataFechaSuciaTooltip(cama_id_piso, socket) {
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
          io.sockets.to(socket.id).emit("getDataFechaSuciaTooltip", { "dataTooltip": rows, "id": cama_id_piso });
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

function getDataNotesTooltip(cama_id,cama_nombre, tipo_nota, socket) {
  var end = true;
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    //connection.query('SELECT MAX(fecha_hora) as fecha FROM os_camas_estados WHERE cama_id = ' + cama_id, (err, rows,) => {
    connection.query('SELECT * FROM os_camas_notas WHERE estado = 0 and cama_id =' + cama_id + " and tipo_nota = " + tipo_nota, (err, rows,) => {
    connection.release(); // return the connection to pool
      if (!err) {
        try {
          io.sockets.to(socket.id).emit("getDataNotesTooltip", { "dataTooltip": rows, "id": cama_id, "cama_nombre":cama_nombre });
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

function getDataCamasNotas(data){
  cama_id = data[0]["after"]["cama_id"]
  pool.getConnection((err, connection,) => {
    if (err)
      throw err;
    //connection.query('SELECT MAX(fecha_hora) as fecha FROM os_camas_estados WHERE cama_id = ' + cama_id, (err, rows,) => {
    connection.query('SELECT * FROM os_camas_notas WHERE estado = 0 and cama_id =' + cama_id, (err, rows,) => {
    connection.release(); // return the connection to pool
      if (!err) {
        try {
          io.sockets.emit("getDataCamasNotas", {"cama_id":cama_id, "note_len": rows});
        } catch (e) {
          console.log(e); // pass exception object to error handler
        }
      } else {
        console.log(err);
      }
    });
  });
}

//Detect mysql events
const MySQLEvents = require('@rodrigogs/mysql-events');
const { pathToFileURL } = require("url");
const getDataPacientesAreasCriticasTablas = ["um_pacientes_uci", "os_camas", "os_triage"]

const program = async () => {
  const connection = mysql.createPool({
    connectionLimit : 200,
    host            : 'localhost',
    user            : 'sih_um5293',
    password        : 'sihUM-5293-#$',
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
      } if (getDataPacientesAreasCriticasTablas.find(element => element.trim() === event.table)) {
        getDataPacientesAreasCriticas("UCI", "")
      }if (event.table == "os_camas_notas"){
        getDataCamasNotas(event.affectedRows)
      }
    },
  });
  instance.on(MySQLEvents.EVENTS.CONNECTION_ERROR, console.error);
  instance.on(MySQLEvents.EVENTS.ZONGJI_ERROR, console.error);
};

program()
  .then(() => console.log('Waiting for database events...'))
  .catch(console.error);