<?php ob_start(); ?>
<page backright="0mm">
    <div style="position: absolute;top: -5px">
        <div style="position: absolute;left: 250px">
            <barcode type="C128A" value="<?=$info['id']?>" style="height: 80px;width: 200px" ></barcode>
        </div>
        
        <div style="position: absolute;left: 460px;width: 500px;">
            <b style="font-size: 16px;">UMAE HOSPITAL DE ESPECIALIDADES CMN SIGLO XXI </b>
            <?php 
            if(strlen($info['nombre'])>=30){
                $font_size_nombre='17px';
                $font_size='14px';
                $margin_top='6px';
            }else{
                $font_size_nombre='17px';
                $font_size='14px';
                $margin_top='6px';
            }
            ?>
          <div style="position: absolute;left: 0px;width: 500px;">
            <b style="font-size: <?=$font_size_nombre?>;margin-top: 20px"><?=$info['nombre']?> </b><br>
            <b style="margin-top: <?=$margin_top?>;font-size:<?=$font_size?>"><?=$info['nss']?></b><br>
            <b style="margin-top: <?=$margin_top?>;font-size:<?=$font_size?>">FECHA DE CIRUGÍA: <?=$info['fecha_cirugia']?></b>
        </div>
        </div>
        <div style="position: absolute;left: 890px;">
            <img src="<?= base_url()?>assets/img/imss3.png" style="width: 90px;">
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