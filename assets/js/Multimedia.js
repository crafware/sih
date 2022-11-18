var videosName          = ["AdmisionContinua.mp4",  "RegistroPacienteEnAdmisionHospitalaria-2.mp4", "AsignacionDeCama-1.mp4"]
var screenshots         = ["AdmisionContinua.png",  "RegistroPacienteEnAdmisionHospitalaria.png",   "AsignacionDeCama.png"]
var videosDescription   = [ "Área Asistente Médica Admisión Continua.",          
                            "¿Como registrar un ingreso hospitalario?",             
                            "¿Cómo asignar cama al paciente?"]
var videoDuration       = []
var table = document.getElementsByClassName("app-main")[0];
var urlaux = window.location.href.split('/');
//var url = urlaux[0]+"/"+urlaux[1]+"/"+urlaux[2]+"/"+urlaux[3];
function showsVideos(){
    //var area = document.getElementsByClassName("app-main")[0].getElementsByTagName("h1")[0].innerText; 
    var area = document.getElementsByClassName("Registro-Admision"); 
    var str = ""
    console.log(area)
    if(area.length > 0){
        for(var i = 0 ; i< videosName.length ; i++){
            str +='<div class="col-lg-3 col-md-4 col-sm-6">'+
                    '<div class="video-item">'+
                        '<div class="thumb">'+
                            '<div class="hover-efect"></div>'+
                            '<small class="time timeView">'+undefined+'</small>'+
                            '<a href="#">'+
                            '<img class = "video-btn" src='+base_url+"/assets/multimedia/screenshots/"+ screenshots[i] + '   type="button" data-bs-toggle="modal" data-bs-target="#myModal" '+
                            'data-src =' +base_url+"/assets/multimedia/videos/"+ videosName[i] +'>'+
                            '</a>'+
                        '</div>'+
                        '<div class="video-info">'+
                            '<a href="#" class="title">'+videosDescription[i] +'</a>'+
                           // '<a class="channel-name" href="#">Dale liker<span>'+
                            //'<i class="fa fa-check-circle"></i></span></a>'+
                           // '<span class="views"><i class="fa fa-eye"></i>2.8M views </span>'+
                           // '<span class="date"><i class="fa fa-clock-o"></i>5 months ago </span>'+
                        '</div>'+
                    '</div>'+
                '</div>'
        }
        str += '<div class="modal" id="myModal" >'+
            '<div class="modal-dialog" style="max-width: 70%; width: auto;">'+
                '<div class="modal-content">'+
                    '<video " controls="" id="video1" style="width: 100%; height: auto; margin:0; frameborder:0; " src= "">'+
                        // '<source src='+url[0]+"/"+url[1]+"/"+url[2]+"/"+url[3]+"/assets/multimedia/videos/"+ videosName[i] +'    type="video/mp4">'+
                    '</video>'+
                '</div>'+
            '</div>'+
        '</div>';
        table.innerHTML += str;
        setTimeout(function(){
            getTimes()
        }, 1000);
    }
}

function getTimes(){
    tvs = document.getElementsByClassName("timeView")
    for(var i = 0 ; i< videosName.length ; i++){
        getTime(base_url+"/assets/multimedia/videos/"+videosName[i], tvs[i])
    }
}

function getTime(a, timrView) {
    var video = document.createElement('video');
    video.src = a;
    video.oncanplay = function () {
        var duration = video.duration;
        var minuto = parseInt(duration % 3600 / 60);
        var seg = parseInt(duration % 60);
        timrView.innerHTML = minuto + ":" + seg;
    }
}

$(document).ready(function() {
    var $videoSrc;
    $(".video-btn").click(function() {
      $videoSrc = $(this).data("src");
    });
    $("#myModal").on("shown.bs.modal", function(e) {
        setTimeout(function(){
            $("#video1").attr(
                "src",
                $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0"
            );
            $('#video1')[0].play();
        }, 1000);
    });
    $("#myModal").on("hide.bs.modal", function(e) {
      $("#video1").attr("src", ""); // Remove the video source.
    });
  });


showsVideos()