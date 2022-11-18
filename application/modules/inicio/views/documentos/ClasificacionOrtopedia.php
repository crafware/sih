<?php ob_start(); ?>
<page>
    <page_header>
       
        
    </page_header>
    <img src="<?=  base_url()?>assets/doc/ClasificacionOrt.jpg" style="position: absolute;width: 100%;margin-top: -15px;margin-left: -5px;">
        <div style="position: absolute;top: 25px;left: 60px;font-size: 10px;width: 83%;height: 10px;padding: 10px;text-transform: uppercase;background: black;color: white;border-radius: 5px;text-align: center;font-weight: bold">
            DESTINO: <?=$info[0]['triage_consultorio_nombre']?>
        </div>
        <div style="position: absolute;top: 70px;left: 60px;font-size: 10px;width: 83%;height: 10px;padding: 10px;text-transform: uppercase;border:1px solid black">
            <b>DIAGNOSTICO: </b><?=$AdmisionContinua['ac_diagnostico']?>
        </div>
        <div style="position: absolute;top: 239px;left: 200px;font-size: 10px"><?=$this->UM_CLASIFICACION?> | <?=$this->UM_NOMBRE?></div>
        <div style="position: absolute;top: 237px;left: 440px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[2]?></div>
        <div style="position: absolute;top: 237px;left: 490px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[1]?></div>
        <div style="position: absolute;top: 237px;left: 530px;font-size: 10px"><?=  explode('-', $info[0]['triage_fecha_clasifica'])[0]?></div>
        <div style="position: absolute;top: 237px;left: 625px;font-size: 10px"><?=  explode(':', $info[0]['triage_hora_clasifica'])[0]?></div>
        <div style="position: absolute;top: 237px;left: 650px;font-size: 10px"><?=  explode(':', $info[0]['triage_hora_clasifica'])[1]?></div>
        <!---Seccion 2-->
        <div style="position: absolute;top: 260px;left: 115px;font-size: 10px"><?=$info[0]['triage_nombre_ap']?> <?=$info[0]['triage_nombre_am']?> <?=$info[0]['triage_nombre']?></div>
        <!---Seccion 3-->
        <?php if($_GET['via']=='Choque'){?>
        <div style="position: absolute;top: 304px;left: 145px;font-size: 10px"><?=  explode('/', $class_choque[0]['sv_ta'])[0]?>&nbsp;&nbsp;&nbsp;&nbsp;<?=  explode('/', $class_choque[0]['sv_ta'])[1]?></div> 
        <div style="position: absolute;top: 304px;left: 280px;font-size: 10px"><?=$class_choque[0]['sv_temp']?></div>
        <div style="position: absolute;top: 304px;left: 455px;font-size: 10px"><?=$class_choque[0]['sv_fc']?></div>
        <div style="position: absolute;top: 304px;left: 630px;font-size: 10px"><?=$class_choque[0]['sv_fr']?></div>
        <?php }else{?>
        <div style="position: absolute;top: 304px;left: 145px;font-size: 10px"><?=  explode('/', $SignosVitales['sv_ta'])[0]?>&nbsp;&nbsp;&nbsp;&nbsp;<?=  explode('/', $SignosVitales['sv_ta'])[1]?></div> 
        <div style="position: absolute;top: 304px;left: 280px;font-size: 10px"><?=$SignosVitales['sv_temp']?></div>
        <div style="position: absolute;top: 304px;left: 455px;font-size: 10px"><?=$SignosVitales['sv_fc']?></div>
        <div style="position: absolute;top: 304px;left: 630px;font-size: 10px"><?=$SignosVitales['sv_fr']?></div>
        <?php }?>
        <!--Seccion 4 Pregunta 1-->
        <div style="position: absolute;top: 370px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg1_s1']==0){echo 'X';}?></div>
        <div style="position: absolute;top: 370px;left: 570px;font-size: 10px"><?php if($info[0]['triage_preg1_s1']!=0){echo 'X';}?></div>
        <!--Seccion 4 Pregunta 2-->
        <div style="position: absolute;top: 385px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg2_s1']==0){echo 'X';}?></div>
        <div style="position: absolute;top: 385px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg2_s1']!=0){echo 'X';}?></div>
        <!--Seccion 4 Pregunta 3-->
        <div style="position: absolute;top: 400px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg3_s1']==0){echo 'X';}?></div>
        <div style="position: absolute;top: 400px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg3_s1']!=0){echo 'X';}?></div>
        <!--Seccion 4 Pregunta 4-->
        <div style="position: absolute;top: 415px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg4_s1']==0){echo 'X';}?></div>
        <div style="position: absolute;top: 415px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg4_s1']!=0){echo 'X';}?></div>
        <!--Seccion 4 Pregunta 5-->
        <div style="position: absolute;top: 430px;left: 370px;font-size: 10px"><?php if($clasificacion[0]['triage_preg5_s1']==0){echo 'X';}?></div>
        <div style="position: absolute;top: 430px;left: 570px;font-size: 10px"><?php if($clasificacion[0]['triage_preg5_s1']!=0){echo 'X';}?></div>
        <!--Seccion 4 Total-->
        <div style="position: absolute;top: 443px;left: 580px;font-size: 10px"><?=$clasificacion[0]['triege_preg_puntaje_s1']?></div>
        <!--Seccion 5 Pregunta 1-->
        <div style="position: absolute;top: 505px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg1_s2']?></div>
        <!--Seccion 5 Pregunta 2-->
        <div style="position: absolute;top: 518px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg2_s2']?></div>
        <!--Seccion 5 Pregunta 3-->
        <div style="position: absolute;top: 536px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg3_s2']?></div>
        <!--Seccion 5 Pregunta 4-->
        <div style="position: absolute;top: 550px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg4_s2']?></div>
        <!--Seccion 5 Pregunta 5-->
        <div style="position: absolute;top: 563px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg5_s2']?></div>
        <!--Seccion 5 Pregunta 6-->
        <div style="position: absolute;top: 574px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg6_s2']?></div>
        <!--Seccion 5 Pregunta 7-->
        <div style="position: absolute;top: 590px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg7_s2']?></div>
        <!--Seccion 5 Pregunta 8-->
        <div style="position: absolute;top: 605px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg8_s2']?></div>
        <!--Seccion 5 Pregunta 9-->
        <div style="position: absolute;top: 619px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg9_s2']?></div>
        <!--Seccion 5 Pregunta 10-->
        <div style="position: absolute;top: 630px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg10_s2']?></div>
        <!--Seccion 5 Pregunta 11-->
        <div style="position: absolute;top: 648px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg11_s2']?></div>
        <!--Seccion 5 Pregunta 12-->
        <div style="position: absolute;top: 667px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg12_s2']?></div>
        <!--Seccion 5 Total-->
        <div style="position: absolute;top: 680px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triege_preg_puntaje_s2']?></div>
        <!--Seccion 6 Pregunta l-->
        <div style="position: absolute;top: 730px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg1_s3']?></div>
        <!--Seccion 6 Pregunta 2-->
        <div style="position: absolute;top: 740px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg2_s3']?></div>
        <!--Seccion 6 Pregunta 3-->
        <div style="position: absolute;top: 753px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg3_s3']?></div>
        <!--Seccion 6 Pregunta 4-->
        <div style="position: absolute;top: 765px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg4_s3']?></div>
        <!--Seccion 6 Pregunta 4-->
        <div style="position: absolute;top: 776px;left: 630px;font-size: 10px"><?=$clasificacion[0]['triage_preg5_s3']?></div>
        <!--Seccion 6 Total Final-->
        <div style="position: absolute;top: 790px;left: 627px;font-size: 10px"><?=$clasificacion[0]['triage_puntaje_total']?></div>
        <div style="position: absolute;top: 893px;left: 95px;font-size:9px;width: 140px;text-align: center" >
            <?=$medico[0]['empleado_nombre']?> <?=$medico[0]['empleado_apellidos']?>
        </div>
        <div style="position: absolute;top: 893px;left: 310px;font-size:9px;width:126px;text-align: center">
            <?=$medico[0]['empleado_matricula']?>
        </div>
        <div style="position: absolute;left: 280px;top: 980px">
            <barcode type="C128A" value="<?=$info[0]['triage_id']?>" style="height: 20px;" ></barcode>
        </div>
        <page_footer>
            
            <?php 
            if($clasificacion[0]['triage_puntaje_total']>30){
                $color='#E50914';
                $color_name='Rojo';
                $tiempo='Inmediatamente';
            }if($clasificacion[0]['triage_puntaje_total']>=21 && $clasificacion[0]['triage_puntaje_total']<=30){
                $color='#FF7028';
                $color_name='Naranja';
                $tiempo='10 Minutos';
            }if($clasificacion[0]['triage_puntaje_total']>=11 && $clasificacion[0]['triage_puntaje_total']<=20){
                $color='#FDE910';
                $color_name='Amarillo';
                $tiempo='11-60 Minutos';
            }if($clasificacion[0]['triage_puntaje_total']>=6 && $clasificacion[0]['triage_puntaje_total']<=10){
                $color='#4CBB17';
                $color_name='Verde';
                $tiempo='61-120 Minutos';
            }if($clasificacion[0]['triage_puntaje_total']<=5){
                $color='#0000FF';
                $color_name='Azul';
                $tiempo='121-240 Minutos';
            }
            
            ?> 
            <div style="height: 15px;width: 85%;background: black;margin: auto;color: white;text-align: center;padding: 10px;border-radius: 5px;font-weight: bold;text-transform: uppercase">
                Puntaje Total:<?=$clasificacion[0]['triage_puntaje_total']?> | Color : <?=$color_name?> <?=$tiempo?>
            </div>
        </page_footer>
</page>
<?php 
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->SetTitle('CLASIFICACIÓN DE PACIENTES');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->Output('CLASIFICACIÓN DE PACIENTES (TRIAGE).pdf');
?>