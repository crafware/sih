<?php ob_start(); ?>
<page backright="0mm">
    <div style="position: absolute;top: 5px">
        <div style="position: absolute;left: 10px;">
            <img src="<?= base_url()?>assets/img/imss3.png" style="width: 90px;">
        </div>
        <div style="position: absolute;left: 100px;width: 400px;">
            <b style="font-size: 14px;">HOSPITAL DE ESPECIALIDADES DEL CMN SIGLO XXI</b>
        </div>
        <div style="position: absolute;left: 100px; top:20px;width: 400px;">NÚMERO DE SEGURIDAD SOCIAL Y AGREGADO MÉDICO<br>
            <?php   $nssCompleto = $infoPaciente['nssCom'];
                    list ($nss, $agregado) = explode("-",$nssCompleto);
                    $numSS = substr($nss, 0, 4)." ".substr($nss, 4, 2)." ".substr($nss, 6, 4)."-".substr($nss, -1, 1)." ".$agregado;
            ?>
            <b style="font-size: 22px;">
                <?php echo $numSS; ?>
            </b>
        </div>
        <div style="position: absolute;left:100px;top:59;width: 300px;">
            <b style="font-size: 12px;">UMF:<?=$infoPaciente['umf']?>, DELEGACIÓN: <?=$infoPaciente['deleg']?></b>
        </div>
        <div style="position: absolute;left: 100px;top:75;width: 400px;">C.U.R.P.<br>
            <b style="font-size: 22px;"><?=$infoPaciente['curp']?></b>
        </div>
        
        <div style="position: absolute;left:0px;top:190;width: 300px;">
        <b style="font-size: 14px;">TEL: <?=$contacto['telefono']?></b>
        </div>
        <div class="font" style="position: absolute;left:0px;top:210;width: 300px;">
        ESPECIALIDAD<br>
        <b style="font-size: 14px;text-transform: uppercase;"><?=$especialidad['especialidad_nombre']?></b>
        </div>
        <div style="position: absolute;left: 0px;top: 110px;width:600px;">NOMBRES(S)<br>
            <b style="font-size: 22px;"><?=$infoPaciente['apellidop']?> <?=$infoPaciente['apellidom']?> <?=$infoPaciente['nombre']?></b>
        </div>
        
        <div style="position: absolute;left:0px;top:245;width: 300px;">
        <b style="font-size: 13px;">FECHA DE APERTURA: <?=date("d / m / Y",strtotime($infoPaciente['fechaReg']))?></b>
        </div>
      
        <div style="position: absolute;left: 285px;top:151;">
            <barcode type="C128A" value="<?=$infoPaciente['idPaciente']?>" style="height: 100px;width: 210px" ></barcode><br>    
        </div>
    </div>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('L','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('CaratulaExpediente.pdf');
?>
