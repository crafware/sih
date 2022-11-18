<?php ob_start(); ?>
<page>
    <page_header>
        <div style="border:1px solid black;padding: 5px;">
            <img src="<?=  base_url()?>assets/img/logo_left.jpg" style="width: 70%">
        </div>
        <div style="border-left:1px solid black;border-right: 1px solid black;border-top: 1px solid black;padding: 5px;margin-top: 5px;margin-right: -2px">
            <div style="width: 30%;float: left!important;">
                <img src="<?=  base_url()?>assets/img/logo.png" style="width: 30%;margin-left: 50px">
            </div>
            <div style="width: 60%;float: left!important;margin-left: 200px;text-align: center;margin-top: -95px">
                <p><strong>INSTITUTO MEXICANO DEL SEGURO SOCIAL DIRECCIÓN DE PRESTACIONES MÉDICAS</strong></p>
                <p style="margin-top: -6px;font-size: 11px">UNIDAD DE ATENCIÓN MÉDICACOORDINACIÓN DE UNIDADES MÉDICAS DE ALTA ESPECIALIDAD</p>
                <p style="margin-top: -6px;font-size: 11px">CLASIFICACIÓN DE PACIENTES (TRIAGE)</p>
            </div>
        </div>
    </page_header>
    <page_footer>

        <div style="text-align: center;">
            Página [[page_cu]]/[[page_nb]]<br>
            <!--CONTRATO DE ADQUISICION PARA PERSONA FISICA MAYOR OK-->
        </div>
        <div style="float: right;position: absolute;right: 10px;bottom: 0px">
            Clave: 2430-003-039
        </div>
    </page_footer>
    <style>table {border-collapse: collapse; width: 100%;}th, td {text-align: left;padding: 8px;}tr:nth-child(even){background-color: #f2f2f2} th {}</style>
        
    <div style="text-align: center;margin-top: 170px;font-size: 13px;font-weight: 200;border: 1px solid black;">
        
        <span style="margin-top: 20px;margin-bottom: 20px">Estudios Clinicos Solicitados</span><br>
        <table class="table"  style="border:1px solid black;width: 100%; border-collapse: separate;margin-left: 10px;text-align: left;margin-top: 30px">
            <thead>
                <tr >
                    <td style="width: 50%">Caso Clinico Solicitado</td>
                    <td style="width: 47%">Datos Clinicos</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Casos as $value) {?>
                    <tr>
                        <td style="padding: 3px">
                            <p style="font-size: 11px;margin-top: 0px;">&nbsp;&nbsp; <?=$value['casoclinico_nombre']?></p>
                        </td>
                        <td style="border-left: 1px solid black;padding: 3px">
                            <p style="font-size: 11px;margin-top: 0px">&nbsp;&nbsp; <?=$value['casoclinico_datos']?></p>
                        </td>

                    </tr>    
                
                <?php }?>
            </tbody>
            
        </table>
        <br>
        
        
        <br>
    </div>

</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS('print(TRUE)');
    $pdf->Output('Estudios Clinicos.pdf');
?>