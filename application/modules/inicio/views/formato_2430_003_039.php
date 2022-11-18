<?php ob_start(); ?>
<page backleft="10mm" backright="10mm" backtop="7mm">
    <page_header>
        
    </page_header>
    <div style="position: absolute;">
        <img src="<?=  base_url()?>assets/doc/2430_003_039.png" style="position: absolute;width: 100%;">
        <div style="position: absolute;margin-left: 130px;margin-top: 205px;font-size: 9px">UMAE | Dr. Victorio de la Fuente Narváez</div>
        <div style="position: absolute;margin-left: 900px;margin-top: 205px;font-size: 9px"><?=  date('d/m/Y')?></div>
        <style>
            table{border: 1px solid black; }
            td, th {border: 1px solid black; }
            table {border-collapse: collapse;width: 100%;}
            td {vertical-align: bottom;}
            .th_1{padding: 5px 2px 15px 2px;text-align: center}
            .th_2{padding: 5px 5px 15px 5px;}
        </style>
        <table style="width: 100%;margin-left: 7px;margin-top: -2px;border-color: #555555">
            <?php foreach ($Gestion as $value) {?>
            <tr>
                <td style="width: 3.1%;padding: 2px;font-size: 6px"><?=$value['triage_id']?></td>
                <td style="width: 11.4%;font-size: 9px;padding: 2px"><?=$value['triage_paciente_afiliacion']?></td>
                <td style="width: 6.2%"></td>
                <td style="width: 14.5%;padding: 2px 2px 2px 2px;font-size: 9px"><?=$value['triage_nombre']?></td>
                <td style="width: 4.1%;font-size: 8px;padding: 2px"><?=$value['triage_horacero_h']?></td>
                <td style="width: 5.2%;font-size: 8px;padding: 2px"><?=$value['triage_paciente_umf']?></td>
                <td style="width: 5.2%;font-size: 8px;padding: 2px"></td>
                <td style="width: 3.1%;font-size: 7px;padding: 2px"><?=$value['triage_paciente_delegacion']?></td>
                <td style="width: 3.1%;font-size: 8px;padding: 2px"><?=$value['triage_procedencia']!='' ? 'Si' : 'No'  ?></td>
                <td style="width: 4.1%;font-size: 8px;padding: 2px"></td>
                <td style="width: 4.6%;font-size: 8px;padding: 2px"></td>
                <td style="width: 3%;font-size: 8px;padding: 2px"></td>
                <td style="width: 3.1%;font-size: 8px;padding: 2px"></td>
                <td style="width: 5.2%;font-size: 8px;padding: 2px"></td>
                <td style="width: 5.2%;font-size: 8px;padding: 2px"></td>
                <td style="width: 5.2%;font-size: 8px;padding: 2px"><?=$value['ce_hs']?></td>
                <td style="width: 12.9%;font-size: 8px;padding: 2px"><?=$value['triage_color']?></td>
            </tr>
            <?php }?>
        </table>
        
        
    </div>
    <page_footer></page_footer>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('L','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    //$pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('FORMATO_4.30.6_LECHUGA.pdf');
?>