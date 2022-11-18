<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>UMAE</title>
        <!-- Latest compiled and minified CSS -->
             
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <!--html5imageupload--->
        <link href="<?=  base_url()?>assets/libs/html5imageupload/html5imageupload.css" rel="stylesheet" type="text/css"/>
        <link href="<?=  base_url()?>assets/libs/html5imageupload/demo.html5imageupload.css" rel="stylesheet" type="text/css"/>
    
    </head>
    <body>
        <div class="panel panel-primary">
            <div class="panel-heading"> 
                <h3 class="panel-title">Cambiar imagen de Perfil</h3> 
            </div> 
            <div class="panel-body"> 
                <center>
                    <form class="save-img-perfil">
                        <div class="form-group" style="margin-top: 0px">
                            <div id="retrievingfilename" class="html5imageupload" data-width="200" data-height="200" data-url="<?=  base_url()?>config/upload_image_pt?tipo=img/perfiles" style="width: 200px;height: 200px;">
                                <input type="file" name="thumb" style="height: 200px!important">
                            </div>
                            <input type="hidden" name="empleado_perfil" id="filename"  class="form-control" />
                            <input type="hidden" name="empleado_id" value="<?=$_SESSION['UMAE_USER']?>"><br>
                            <input type="hidden" name="csrf_token" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <button class="btn btn-primary " type="submit">Guardar</button>
                        </div>	 
                    </form>
                </center>
            </div> 
        </div>
    </body>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-2.1.4.js" type="text/javascript"></script>
    <script src="<?=  base_url()?>assets/libs/html5imageupload/html5imageupload.js" type="text/javascript" type="text/javascript"></script>
    <script>
        var base_url='<?=  base_url()?>';
        $('#retrievingfilename').html5imageupload({
            onAfterProcessImage: function() {
                    $('#filename').val($(this.element).data('name'));
            },
            onAfterCancel: function() {
                    $('#filename').val('');
            }
        });

        $('#save').html5imageupload({
            onSave: function(data) {
                    console.log(data);
            },

        }); 
        $('.save-img-perfil').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: base_url+"configuracion/usuario/cambiar_img_perfil",
                type: 'POST',
                dataType: 'json',
                data:$(this).serialize(),
                success: function (data, textStatus, jqXHR) {
                    if(data.accion=='1'){
                        window.opener.location.reload();
                        window.close();
                    }
                },error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error al actualizar la imagen de perfil')
                }
            })
        })
    </script>
</html>
