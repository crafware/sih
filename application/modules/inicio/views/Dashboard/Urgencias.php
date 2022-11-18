<?= modules::run('Sections/Menu/index'); ?>
<style type="text/css">
.widget {
  border-radius: 3px;
  -webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box;
  padding: 12px 17px;
  color: #f8f8f8;
  background: rgb(100 87 87 / 63%);
  margin-bottom: 30px;
  position: relative;

}

.tooltip-inner {
    max-width: none;
    white-space: nowrap;
    background:white;
    border:1px solid lightgray;
  -webkit-box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  -moz-box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  color:gray;
  margin:0;
  padding:0;
  
}
.tooltip.in{
	opacity: 1.9 !important;
}

.tooltip.bottom .tooltip-arrow {
  top: 50;
  left: 50%;
  margin-left: -10px;
  border-bottom-color: red; 
  border-width: 0 5px 5px;
}

div {cursor:pointer;}.tooltip-inner {
    max-width: none;
    white-space: nowrap;
    background:white;
    border:1px solid lightgray;
  -webkit-box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  -moz-box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  box-shadow: 0px 3px 3px 0px rgba(0,0,0,0.3);
  color:gray;
  margin:0;
  padding:0;
}

.tooltip-head {
    max-width:306px;position:relative;overflow:auto;
}

.tooltip-title {
    width:306px;background:#F2F2F2;line-height:30px;float:left;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;text-align:left;padding-left:15px;
}

.tooltip-paciente {
    width:150px;float:left; height:30px;line-height:30px;text-align:right;padding-left:15px;
}
.tooltip-folio {
    width:120px;float:right; height:30px;text-align:left;padding-left:30px;
}

.title-fragilidad {
    position:absolute;
    width:60px;
    height:15px;
    text-align:left;
    padding-left:15px;
    line-height:15px;
    top:60px;
    left:-1px;
    font-size:10px;
}

.title-funcionalidad {
    position:absolute;
    width:60px;
    height:15px;
    text-align:left;
    padding-left:1px;
    line-height:15px;
    top:60px;
    left:80px;
    font-size:10px;
}
.value-fragilidad {
    position:absolute;
    width:60px;
    height:15px;
    text-align:left;
    padding-left:1px;
    line-height:15px;
    top:75px;
    left:0px;
    font-size:12px;
}

.value-funcionalidad {
    position:absolute;
    width:60px;
    height:15px;
    text-align:left;
    padding-left:1px;
    line-height:15px;
    top:75px;
    left:80px;
    font-size:12px;
}

.tooltip-medico-nombre {
    width:299px;float:left;height:27px;text-align:left;padding-left:15px;padding-top:13x;line-height:40px;
}

.tooltip-sv-title {
    width:150px;float:left; height:30px;text-align:left;padding-left:15px;line-height:30px;font-size:10px;
}
.tooltip-medico2 {
    width:150px;float:left; height:30px;text-align:left;padding-left:15px;line-height:14px;font-size:10px;
}
.escalas{
	
	float: left;
	padding: 0px 0px 10px 15px;
}
.signosv{
	display: flex;
	float: left;
	padding: 0px 0px 10px 15px;
}
.divnamesv:not(:last-of-type) {
	border-right: 1px solid #ddd;
	margin-right: 8px;
    padding-right: 13px;

}
.div-sv{
	padding-right: 13px;

}
.sv-title.svname {
	color: #888;
    font-size: 11px;
    font-weight: 400;
}
.sv-title {
    color: #777;
    font-size: 10px;
    letter-spacing: .5px;
    line-height: 1em;
    margin: 0px 0 3px;
    text-transform: uppercase;
}

.value-sv.valuesv {
    font-size: 12px;
}
.value-sv{
    color: #333;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 0;
}
.tooltip-footer {
    width:306px;background:#F2F2F2;line-height:30px;float:left;
}

</style>

<div class="row">
	<div class="container-fluid">
		<h3>Servicio de Urgencias Admisión Continua</h3>
		<div class="col-md-12">
			<section class="widget">
				<header><h4>Camas Observación</h4></header>
				<div class="camas"></div>
			</section>
            <!--
			<section class="widget">
				<header><h4>Corta Estancia</h4></header>
				<div class="cortaEstancia"></div>
			</section> -->
		</div>
	</div>
</div>


<input type="hidden" name="area" value="<?= $this->UMAE_AREA?>">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Urgencias.js?'). md5(microtime())?>" type="text/javascript"></script>
