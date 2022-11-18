<?php ob_start(); ?>
<page backright="0mm">
    <div style="position: absolute;top: -5px">
        <div style="position: absolute;left: 250px">
            <barcode type="C128A" value="<?=$info['triage_id']?>" style="height: 80px;width: 200px" ></barcode>
        </div>
        
        <div style="position: absolute;left: 460px;width: 500px;">
            <b style="font-size: 16px;">UMAE HOSPITAL DE ESPECIALIDADES CMN SIGLO XXI </b>
            <?php 
            if(strlen($info['triage_nombre_ap'].' '.$info['triage_nombre_am'].' '.$info['triage_nombre'])>=30){
                $font_size_nombre='16px';
                $font_size='14px';
                $margin_top='6px';
            }else{
                $font_size_nombre='17px';
                $font_size='14px';
                $margin_top='8px';
            }
            ?>
            <b style="font-size: <?=$font_size_nombre?>;margin-top: 6px"><?=$info['triage_nombre']=='' ? 'PSEUDONIMO: '.$info['triage_nombre_pseudonimo'] : $info['triage_nombre_ap'].' '.$info['triage_nombre_am'].' '.$info['triage_nombre']?> </b><br>
            <b style="margin-top: <?=$margin_top?>;font-size:<?=$font_size?>"><?=$PINFO['pum_nss']!='' ? 'N.S.S: '.$PINFO['pum_nss'].' '.$PINFO['pum_nss_agregado'] : 'N.S.S ARMARDO: '.$PINFO['pum_nss_armado'] ?></b><br>
            <b style="margin-top: <?=$margin_top?>;font-size:<?=$font_size?>">FECHA DE NAC: <?=$info['triage_fecha_nac']?></b>
        </div>
        <div style="position: absolute;left: 890px;">
            <img src="<?= base_url()?>assets/img/imss2.png" style="width: 90px;">
        </div>
    </div>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('L','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('Pulsera.pdf');
?>