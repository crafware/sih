        </main>
        <audio id="player" src="<?=  base_url()?>assets/sound/sound.ogg"> </audio>
        <script>
            var base_url = "<?= base_url(); ?>"
            var url_string="<?=$this->uri->uri_string()?>";
        </script>
        <script src="<?=  base_url()?>assets/libs/jquery/jquery/dist/jquery.js"></script>
        <script src="<?=  base_url()?>assets/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
        <script src="<?=  base_url()?>assets/libs/jquery/waves/dist/waves.js"></script>
        <script src="<?=  base_url()?>assets/scripts/ui-load.js"></script>
        <script src="<?=  base_url()?>assets/scripts/ui-jp.config.js"></script>
        <script src="<?=  base_url()?>assets/scripts/ui-jp.js"></script>
        <script src="<?=  base_url()?>assets/scripts/ui-nav.js"></script>
        <script src="<?=  base_url()?>assets/scripts/ui-toggle.js"></script>
        <script src="<?=  base_url()?>assets/scripts/ui-form.js"></script>
        <script src="<?=  base_url()?>assets/scripts/ui-waves.js"></script>
        <script src="<?=  base_url()?>assets/scripts/ui-client.js"></script>
        <script src="<?=  base_url()?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?=  base_url()?>assets/libs/bootstrap-fileinput/js/fileinput.js"></script>
        <script src="<?=  base_url()?>assets/libs/bootstrap-fileinput/js/fileinput_locale_es.js"></script>
        <script src="<?=  base_url()?>assets/libs/pace/pace.min.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/underscore-min.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/backbone-min.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/jquery-notifications/js/demo/demo.js" type="text/javascript" ></script>
        <script src="<?=  base_url()?>assets/libs/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/jquery-autonumeric/autoNumeric.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/jquery-notifications/js/messenger.min.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/jquery-notifications/js/messenger-theme-future.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/jquery-notifications/js/demo/location-sel.js" type="text/javascript" ></script>
        <script src="<?=  base_url()?>assets/libs/jquery-notifications/js/demo/theme-sel.js" type="text/javascript" ></script>
        <script src="<?=  base_url()?>assets/libs/html5imageupload/html5imageupload.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/bootstrap-tag/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/boostrap-clockpicker/bootstrap-clockpicker.min.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/libs/bootstrap-select2/select2.min.js"></script>
        <script src="<?=  base_url()?>assets/libs/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js"></script>
        <script src="<?=  base_url()?>assets/libs/footable/footable.all.min.js"></script>
        <script src="<?=  base_url()?>assets/libs/jquery-validation/js/jquery.validate.min.js"></script>
        <!-- <script src="<?=  base_url()?>assets/libs/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script> -->
        <script src="<?=  base_url()?>assets/libs/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
        <script src="<?=  base_url()?>assets/js/bootbox.min.js"></script>
        <script src="<?=  base_url()?>assets/libs/md5.js"></script>
        <script src="<?=  base_url()?>assets/js/jquery.cookie.js"></script>
        <script src="<?=  base_url()?>assets/js/Mensajes.js?time=<?= sha1(microtime())?>" type="text/javascript"></script>
    	<script type="text/javascript">
                Pace.options={
                    ajax:false
                }
                var csrf_token = $.cookie('csrf_cookie');
                $('body input[name=csrf_token]').val(csrf_token);
                setInterval(function() {
                    Pace.ignore(function() {
                        //CerrarSesion();
                    })
                },10000);
                $('.notificaciones-total-list').click(function(e) {
                    $.ajax({
                        url: base_url+"Sections/Notificaciones/AjaxObtenerNotificaciones",
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            var Notificaciones='';
                            $.each(data.Notificaciones,function(i,e) {
                                Notificaciones+='<div class="col-sm-12">'+
                                                    '<h5 style="line-height:1.4;margin-top: -5px;"><b>Mensaje: </b>'+ e.notificacion_descripcion+'</h5>'+
                                                    '<h5 style="line-height:1.4"><b>Fecha: </b>'+e.notificacion_fecha+' '+e.notificacion_hora+ '</h5>'+
                                                '</div>';
                            })
                            bootbox.dialog({
                                title: '<h6>NOTIFICACIONES</h6>',
                                message:'<div class="row ">'+Notificaciones+'</div>'
                                //,size:'small'
                                ,onEscape : function() {}
                            });
                            LeerNotificaciones()
                        },error: function (e) {
                            console.log('ERROR AL OBTENER NOTIFICACIONES DE ESTA ÁREA');
                        }
                    });
                });
                var treeviewMenu = $('.app-menu');
                $('[data-toggle="sidebar"]').click(function(event) {
                    event.preventDefault();
                    $('.app').toggleClass('sidenav-toggled');
                });

                // Activate sidebar treeview toggle
                $("[data-toggle='treeview']").click(function(event) {
                    event.preventDefault();
                    if(!$(this).parent().hasClass('is-expanded')) {
                        treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
                    }
                    $(this).parent().toggleClass('is-expanded');
                });

                // Set initial active toggle
                $("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

                //Activate bootstrip tooltips
                $("[data-toggle='tooltip']").tooltip();

                // Menu activo
                $('.app-menu li a').click(function(){
        
                    $('li a.activo').removeClass('active');
                    $(this).addClass('active');
                });
            </script>
        </body>
</html>
