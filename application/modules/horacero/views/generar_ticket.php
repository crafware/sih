<title><?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?></title>
<div style="margin-top: 0px;font-size: 30px;margin-left: -20px">
    <center>
        <p style="text-align: center;font-size: 18px;margin-left: -20px"><b>TRIAGE & URGENCIAS</b></p>
        
        <b style="text-align: center;font-size: 11px;margin-left: -20px;margin-top: -7px"><?=$this->UM_TIPO?> </b>
        
        <p style="text-align: center;font-size: 11px;margin-left: -25px;margin-top: 0px"><?=$this->UM_NOMBRE?></p>
        <p style="text-align: center;font-size: 10px;margin-left: -20px;margin-top: -2px"><b>HORA EMISIÓN : <?=$info['triage_horacero_f']?> <?=$info['triage_horacero_h']?></b></p>
        
        <img class="code128" style="margin-left:-20px "><br><br>
        <div style="width: 150px">
            <p style="text-align:  center;font-size: 8px;margin-left: -30px;line-height: 1"><?=$this->UM_DIRECCION?></p>
        </div>
    </center>
</div>
<script src="<?=  base_url()?>assets/libs/jquery/jquery/dist/jquery.js"></script>
<script src="<?= base_url('assets/js/os/barcode/jquery-barcode.js')?>" type="text/javascript"></script>
<script>
    $(document).ready(function (e){
        JsBarcode(".code128", "<?=$info['triage_id']?>",{
            displayValue: true,
            height: 30,
            width: 1
        });
        //print(true);
    })

</script>