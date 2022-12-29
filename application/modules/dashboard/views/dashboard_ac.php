<?php
function getServerIp()
{
    if ($_SERVER['SERVER_ADDR'] === "::1") {
        return "localhost";
    } else {
        return $_SERVER['SERVER_ADDR'];
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta name="description" content="<?= $this->UM_CLASIFICACION ?> | <?= $this->UM_NOMBRE ?>" />
    <!-- Le styles -->
    <link href="<?= base_url() ?>assets/libs/assets/animate.css/animate.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/assets_ac/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/assets_ac/css/main.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/assets_ac/css/font-style.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/assets_ac/css/flexslider.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/libs/assets/font-awesome/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/libs/jquery/bootstrap/dist/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/assets_ac/css/table.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 0px;
            background-color: black;
        }

        #contenidoTabla {
            font-size: 30px;
        }

        tr {
            font-size: 40px;
            color: white;
            font-weight: bold;
        }

        table thead th {
            border-right: 0px solid #ccc;
            font-size: 40px;
            color: #FFFF3E;
        }

        table td {
            padding: 8px 10px;
            border-top: 4px solid #ccc;
            border-right: 0px solid #ccc;
        }

        table thead tr {
            background: #2A3A5A;
            height: 30px;
        }

        video {
            width: 100%;
            height: auto;
        }

        table tr.odd {
            background-color: #182132;
        }
        table tr.even {
            background-color: #2A3A5A;
        }

        div.panel {
            margin-bottom: 20px;
            background-color: black; 
            border: 1px solid transparent;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="box-row" style="margin-top: 10px">
        <div class="box-cell col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default " style="height: calc(50%)">
                        <div class="panel-body b-b b-light">
                            <div class="row">
                                <div id="titulo" class="col-md-12 last_lista_no">
                                    <table class="table m-b-none consultoriosespecialidad_last_lista" style="border: none!important">
                                        <tbody style="border: none!important">
                                            <tr class="" style="border: none!important">
                                                <td colspan="4" style="border: none!important">
                                                    <h2 style="font-size: 55px;text-align: center;font-weight: bold;margin-top: 40px;color:#9BD7FF">
                                                        UMAE | Hospital de Especilidades del CMN Siglo XXI<br>
                                                    </h2>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="tableroVideo" class="col-md-12">
                                    <div class="row">
                                        <!--<div class="col-md-1 col-seccion-1">
                                            <!--<img src="<?= base_url() ?>assets/multimedia/ser_imss.jpg" style="width: 100%;margin-top: 5px;height: 266px;">
                                        </div>-->
                                        <div id="divVideos" class="col-md-12">
                                            <!--<video muted="muted" id="triageVideo" src="<?= base_url() ?>assets/multimedia/triage.mp4" width="640" height="480" autoplay controls></video>-->
                                        </div>
                                    </div>
                                </div>
                                <div id="tableroAeropuerto" class="col-md-12" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url() ?>assets/libs/jquery/jquery/dist/jquery.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/assets_ac/js/bootstrap.js"></script>
    <script src="<?= base_url() ?>assets/assets_ac/js/jquery.flexslider.js" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/Dashboard.js?') . md5(microtime()) ?>" type="text/javascript"></script>
    <script src="<?= "http://" . getServerIp() . ':3001/socket.io/socket.io.js' ?>" type="text/javascript"></script>
    <script type="text/javascript">
        var videosName = ['triage.mp4'];
        var videosNameRandom = [];
        var videoEnReproduccion = "";
        $(document).ready(function() {
            $("#mi-video").on('ended', function() {
                alert('El video ha finalizado!!!');
            });
        });

        function carga03(e) {
            if (a != e) {
                if (a != "") a.style.opacity = 1;
                a = e;
                e.style.opacity = 0.4;
                document.getElementById("subTVideo").innerHTML = 'POOMSAE TAEBAEK';
                document.getElementById("mp4_src").src = "<?= base_url() ?>assets/multimedia/triage.mp4";
                document.getElementById("myVideo").load();
            }
        }
        var dashboardDataTable = {};

        function actualizarDashboard_ac(data) {
            var triage_id = data["triage_id"].toString().replaceAll("0", "")
            console.log(data["tipo"])
            console.log(triage_id)
            if (data["tipo"] == "updateNew") {
                if (dashboardDataTable[triage_id] == undefined) {
                    dashboardDataTable[triage_id] = {};
                }
                dashboardDataTable[triage_id]["nombre"] = data["triage_nombre_ap"] + " " + data["triage_nombre_am"] + " " + data["triage_nombre"]
                dashboardDataTable[triage_id]["cama"] = data["cama_nombre"]
                dashboardDataTable[triage_id]["estado"] = data["hf_estadosalud"]
            } else if (data["tipo"] == "delete") {
                delete dashboardDataTable[triage_id];
            } else if (data["tipo"] == "updateestadosalud") {
                dashboardDataTable[triage_id]["estado"] = data["hf_estadosalud"]
            }
            actualizarDashboard()
        }
        var idTables = []

        function actualizarDashboard() {
            idTables = []
            var thead1_a = '<table style="display:none;" class="display" id="'
            var thead1_b = '<table class="display" id="'
            var thead2 = '"><thead><tr><th>NOMBRE DEL PACIENTE</th><th>CAMA</th><th>ESTADO</th></tr></thead><tbody>'
            var tableroAeropuerto = document.getElementById("tableroAeropuerto");
            var class_name = "";
            var n = 0;
            var t = document.getElementById(n + "thead")
            var aux = ""
            if (t != undefined) {
                if (t.style.display == "none") {
                    aux = thead1_a
                } else {
                    aux = thead1_b
                }
            } else {
                aux = thead1_a
            }
            var tr = aux + n + "thead" + thead2;
            idTables.push(n + "thead")
            for (a in dashboardDataTable) {
                class_name = ""
                if (n % 10 == 0 && n != 0) {
                    t = document.getElementById(n + "thead")
                    aux = ""
                    if (t != undefined) {
                        if (t.style.display == "none") {
                            aux = thead1_a
                        } else {
                            aux = thead1_b
                        }
                    } else {
                        aux = thead1_a
                    }
                    tr += '</tbody></table>' + aux + n + "thead" + thead2;
                    idTables.push(n + "thead")
                }
                if (n % 2 == 0) class_name += "odd";
                else class_name += "even";
                var nombre = dashboardDataTable[a]["nombre"];
                var cama = dashboardDataTable[a]["cama"];
                var estado = dashboardDataTable[a]["estado"];
                var triage = a
                tr += "<tr class='" + class_name + "' id = '" + a + "'><td>" + nombre + "</td><td>" + cama + "</td><td>" + estado + "</td></tr>";
                n++;
            }
            tableroAeropuerto.innerHTML = tr + '</tbody></table>'

        }

        function getDataDashboard_ac(data) {
            for (d in data) {
                var triage_id = data[d]["triage_id"].toString().replaceAll("0", "")
                dashboardDataTable[triage_id] = {}
                dashboardDataTable[triage_id]["nombre"] = data[d]["triage_nombre_ap"] + " " + data[d]["triage_nombre_am"] + " " + data[d]["triage_nombre"]
                dashboardDataTable[triage_id]["cama"] = data[d]["cama_nombre"]
                dashboardDataTable[triage_id]["estado"] = data[d]["hf_estadosalud"]
            }
            actualizarDashboard()
        }
        const socket = io(":3001", {
            cors: {
                "force new connection": true,
                "reconnectionAttempts": "Infinity",
                "timeout": 10000,
                "transports": ["websocket"]
            }
        });
        socket.on("actualizarDashboard_ac", function(data) {
            actualizarDashboard_ac(data)
        })
        socket.on("getDataDashboard_ac", function(data) {
            getDataDashboard_ac(data)
        })
        socket.emit("getDataDashboard_ac", {
            "text": "hola mundo"
        })

        function stateChange2() {
            var vnrl = videosNameRandom.length
            if (vnrl == 0)
                for (var i = 0; i < videosName.length; i++)
                    videosNameRandom.push(i)
            var na = Math.floor(Math.random() * vnrl);
            var n = videosNameRandom[na];
            videosNameRandom.splice(na, 1);
            videoEnReproduccion = "video" + n
            document.getElementById("titulo").style.display = "none";
            document.getElementById("tableroAeropuerto").style.display = "none";
            document.getElementById("tableroVideo").style.display = null;
            document.getElementById(videoEnReproduccion).style.display = null;
            document.getElementById(videoEnReproduccion).play();
        }

        function iniciarVideos() {
            var videoDiv1 = '<video style="display:none;" muted="muted" id="'
            var videoDiv2 = '" src="<?= base_url() ?>assets/multimedia/dashboard_ac/'
            var videoDiv3 = '" width="640" height="480" autoplay controls></video>'
            var divVideos = document.getElementById("divVideos");
            for (v in videosName) {
                divVideos.innerHTML += videoDiv1 + "video" + v + videoDiv2 + videosName[v] + videoDiv3
            }
            var divVideos = document.getElementById("divVideos");
            for (var i = 0; i < videosName.length; i++) {
                console.log("video" + i)
                document.getElementById("video" + i).addEventListener("ended", async function() {
                    document.getElementById("tableroVideo").style.display = "none";
                    document.getElementById(videoEnReproduccion).style.display = "none";
                    document.getElementById("titulo").style.display = null;
                    document.getElementById("tableroAeropuerto").style.display = null;
                    for (id in idTables) {
                        if (document.getElementById(idTables[id]) != undefined) {
                            document.getElementById(idTables[id]).style.display = null;
                            await new Promise(resolve => setTimeout(resolve, 17000));
                        }
                        if (document.getElementById(idTables[id]) != undefined) {
                            document.getElementById(idTables[id]).style.display = "none";
                        }
                    }
                    stateChange2()
                })
            }
        }
        iniciarVideos()
        stateChange2()
    </script>
</body>

</html>