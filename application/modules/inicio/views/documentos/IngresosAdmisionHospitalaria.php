<?php ob_start(); ?>
<page backleft="0mm" backright="0mm" backtop="40mm" backbottom="2mm">
    <page_header>
        <div style="position: absolute">
            <table style="width: 990px;margin-left: 45.8px;margin-top: -1px">
                <tbody>
                    <tr>
                        <td colspan="9" style="width: 100%;font-size: 12px; text-align: center;border: hidden;">
                            INSTITUTO MEXICANO DEL SEGURO SOCIAL
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" style="font-size: 12px; text-align: left;border: hidden;">
                            <img src="<?=  base_url()?>assets/img/logo.jpg"  width="50" height="60">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" style="width: 100%;font-size: 12px; text-align: center;border: hidden;">
                            REPORTE DE INGRESOS
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" style="width: 100%;font-size: 9px; text-align: center;border: hidden;">
                            <hr style="width: 990px;margin-top: -1px">
                        </td>
                    </tr>
                    <tr style="width: 100%;">
                        <td style="width: 3%;font-size:  10px;text-align: right; padding: 10px;border: hidden;"><!--border: hidden;-->
                            No.
                        </td>
                        <td style="width: 10%;font-size:  10px;text-align: center; padding: 10px;border: hidden;">
                            CAMA
                        </td>
                        <td style="width: 10%;font-size:  10px;text-align: leght;padding: 10px;border: hidden;">
                            SERVICIO <!--especialidad_nombre-->
                        </td>
                        <td style="width: 10%;font-size:  10px;text-align: center;padding: 10px;border: hidden;">
                            NSS
                        </td>
                        <td style="width: 15%;font-size:  10px;text-align: center;padding: 10px;border: hidden;">
                            NOMBRE
                        </td>
                        <td style="width: 10%;font-size: 10px;text-align: center;  padding: 10px;border: hidden;">
                            INGRESO
                        </td>
                        <td style="width: 25%;font-size: 10px;text-align: center;  padding: 10px;border: hidden;">
                            COMENTARIOS
                        </td>
                        <td style="width: 12%;font-size:  10px;text-align: center;  padding: 10px;border: hidden;">
                            DESCRIPCION
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" style="width: 100%;font-size: 9px; text-align: center;border: hidden;">
                            <hr style="width: 990px;margin-top: -1px">
                        </td>
                    </tr>      
                </tbody>
            </table> 
        </div>
    </page_header>
    <page_footer>
        <table style="width: 990px;margin-left: 45.8px;margin-top: -1px">
            <tr>
                <td colspan="9" style="width: 100%;font-size: 9px; text-align: center;border: hidden;">
                    <hr style="width: 990px;margin-top: -1px">
                </td>
            </tr>
            <tr style="border:0px solid transparent!important">
                <td style="width: 45%;text-align: right;border:0px solid transparent!important">Pagina [[page_cu]] de [[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
    <div style="position: absolute;">
        <style>
            table{border: 1px solid black; }td, th {border: 1px solid black; }
            table {border-collapse: collapse;width: 100%;}
            td {vertical-align: bottom;}.th_1{padding: 5px 2px 15px 2px;text-align: center}.th_2{padding: 5px 5px 15px 5px;}
        </style>
        <!--<hr style="margin-left: 45.8px; color:#000; background-color:#000; margin-right: 45.8px;width: 2.1% width: 90px;margin-left: 45.8px;">-->
        <table style="width: 1032px;margin-left: 45.8px;margin-top: -1px">
            <tbody>
                <?php $No = 0 ?>
                <?php foreach ($Gestion as $value) { ?>
                <?php $No += 1; ?>
                <tr style="width: 100%;border: hidden;">
                    <td style="width: 4%;font-size:  10px;text-align: right; padding: 10px;border: hidden;"><!--border: hidden;-->
                        <?=$No?>
                    </td>
                    <td style="width: 10%;font-size:  10px;text-align: center; padding: 10px;border: hidden;">
                        <?=$value['cama_nombre']?>-<?=$value['piso_nombre_corto']?>
                    </td>
                    <td style="width: 10%;font-size:  10px; padding: 10px;border: hidden;">
                        <?=$value['especialidad_nombre']?>
                    </td>
                    <td style="width: 10%;font-size:  10px;text-align: leght;  padding: 10px;border: hidden;">
                        <?=$value['pum_nss']?>
                    </td>
                    <td style="width: 15%;font-size:  10px; padding: 10px;border: hidden;">
                        <?=$value['triage_nombre']?> <?=$value['triage_nombre_ap']?> <?=$value['triage_nombre_am']?>
                    </td>
                    <td style="width:10%;font-size: 10px;text-align: center; padding: 10px;border: hidden;">
                        <?=$value['fecha_asignacion']?>
                    </td>
                    <td style="width:25%;font-size: 10px; padding: 10px;border: hidden;">
                        Dr. <?=$value['empleado_nombre']?> 
                        <?=$value['empleado_apellidos']?>.
                        <?php
                            if($value['diagnostico_presuntivo'] != null){
                                echo  "<br>DX: ".$value['diagnostico_presuntivo'];
                            }
                        ?>
                    </td>
                    <td style="width:12%; font-size: 10px; padding: 15px;border: hidden;">
                        Delegacion: <?=$value['pum_delegacion']?><br>
                        UMF: <?=$value['pum_umf']?>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table> 
    </div>
    
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('L','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->setTitle('Egreso Registros 4-30-21/35/90 E');
    //$pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('Egreso Registros 4-30-21/35/90 E.pdf');
?>