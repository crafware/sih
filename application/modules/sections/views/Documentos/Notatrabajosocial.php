<?= modules::run('Sections/Menu/HeaderBasico'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/libs/light-bootstrap/all.min.css" />
<link rel="stylesheet" href="<?= base_url()?>assets/libs/jodit-3.2.43/build/jodit.min.css"/>
<link rel="stylesheet" href="<?= base_url()?>assets/styles/notas.css"/>
<link rel="stylesheet" href="<?= base_url()?>assets/libs/bootstrap-toggle-master/css/bootstrap-toggle.min.css">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div class="media-left avatar"></div>
                        <div class="media-body">
                            <h4 class="media-heading nomPaciente"></h4>
                            <h1 class="media-heading noExpediente"></h1>
                        </div>
                    </div>
                </div>
  
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script type="text/javascript" src="<?= base_url()?>assets/libs/light-bootstrap/shieldui-all.min.js"></script>
