                    </div>
                </div>
            </div>
        </div>
        <script>var base_url='<?= base_url()?>';</script>
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
   

        <!-- <script src="<?=  base_url()?>assets/libs/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script> -->
         <script src="<?=  base_url()?>assets/libs/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script> 
        <script src="<?=  base_url()?>assets/js/bootbox.min.js"></script>
        <script src="<?=  base_url()?>assets/libs/md5.js"></script>
        <script src="<?=  base_url()?>assets/js/jquery.cookie.js"></script>
        <script>
            var csrf_token = $.cookie('csrf_cookie');
            $('body input[name=csrf_token]').val(csrf_token);
        </script>
    </body>

</html>
