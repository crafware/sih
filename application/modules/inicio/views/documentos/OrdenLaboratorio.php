<?php 
///----------------------------------mhma----------------------
ob_start(); ?>
<page backtop="80mm" backbottom="50mm" backleft="48" backright="1mm">
    <page_header>

        <img src="<?=  base_url()?>assets/doc/sol_labora.png" style="position: absolute;width: 805px;margin-top: 0px;margin-left: -10px;">
        <div style="position: absolute;margin-top: 15px">

            <div style="position: absolute;top: 80px;left: 120px;width: 270px;">
                <!--<b><?=_UM_CLASIFICACION?> | <?=_UM_NOMBRE?></b> -->
            </div>


            <?php $margin = 105 ?>


            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+0?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>NOMBRE DEL PACIENTE: </b> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
            </div>

            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+20?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>N.S.S: </b> <?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?>
            </div>

            <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac'])); ?>

            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+40?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>EDAD DEL PACIENTE: </b> <?=$fecha->y==0 ? $fecha->m.' MESES' : $fecha->y.' AÑOS'?>
            </div>

            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+60?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>NOMBRE DEL MEDICO: </b> <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?>
            </div>

            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+80?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>MATRICULA: </b> <?=$Medico['empleado_matricula']?>
            </div>

            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+100?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>FIRMA: </b>
            </div>

            <div style="position: absolute;margin-left: 500px;margin-top: <?=$margin+120?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>_________________________ </b>    
            </div>


            <div style="position: absolute;margin-left: 80px;margin-top: <?=$margin+0?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <?=$solicitud_laboratorio['fecha_solicitud']?>
            </div>
    
            <!-- Ubicación de paciente -->
            <?php 
                    $cama = $this->config_mdl->_query("SELECT cama_nombre,piso_nombre_corto FROM os_camas,os_pisos WHERE 
                                                       os_camas.area_id=os_pisos.area_id AND triage_id = ".$solicitud_laboratorio['triage_id'])[0];
            
            ?> 
            <div style="position: absolute;margin-left: 235px;margin-top: <?=$margin+0?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <?php echo (!empty($cama) ? $cama['cama_nombre'].' '.$cama['piso_nombre_corto'] :  $_GET['tipo']);?>
            </div>



            <div style="position: absolute;margin-left: 55px;margin-top: <?=$margin+27?>px;width: 360px;font-size: 11px;text-align: left;">
                <?=$medicoEspecialidad['especialidad_nombre']?>
            </div>

              <div style="position: absolute;margin-left: 295px;margin-top: <?=$margin+27?>px;width: 360px;font-size: 11px;text-align: left;">
                X
            </div>


             <div style="position: absolute;margin-left: 40px;margin-top: <?=$margin+80?>px;width: 330px;  font-size: 11px;text-align: left;">
                  <?=$Diagnosticos[0]['cie10_clave']?> - <?=$Diagnosticos[0]['cie10_nombre']?><br>
            </div>

            <!-- border: 1px solid red; -->


            <?php 
            $estudios_obj  = json_decode($solicitud_laboratorio['estudios']);
            $lista_lab = array();
            foreach ($estudios_obj as $nombre => $valor) { 
                $estudios = explode("&", $nombre);
                $lista_lab[] = $estudios[3];
            }?>

            <div style="position: absolute;margin-left: 40px;margin-top: <?=$margin+180?>px;width: 700px;font-size: 12px;text-align: left;">
                <?=implode(', ', $lista_lab);?>
            </div>



            <?php $margin = 640 ?>


            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+0?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>NOMBRE DEL PACIENTE: </b> <?=$info['triage_nombre_ap']?> <?=$info['triage_nombre_am']?> <?=$info['triage_nombre']?>
            </div>

            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+20?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>N.S.S: </b> <?=$PINFO['pum_nss']?>-<?=$PINFO['pum_nss_agregado']?>
            </div>

            <?php $fecha= Modules::run('Config/ModCalcularEdad',array('fecha'=>$info['triage_fecha_nac'])); ?>

            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+40?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>EDAD DEL PACIENTE: </b> <?=$fecha->y==0 ? $fecha->m.' MESES' : $fecha->y.' AÑOS'?>
            </div>

            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+60?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>NOMBRE DEL MEDICO: </b> <?=$Medico['empleado_nombre']?> <?=$Medico['empleado_apellidos']?>
            </div>

            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+80?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>MATRICULA: </b><?=$Medico['empleado_matricula']?>
            </div>

            <div style="position: absolute;margin-left: 400px;margin-top: <?=$margin+100?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>FIRMA: </b>
            </div>

            <div style="position: absolute;margin-left: 500px;margin-top: <?=$margin+120?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <b>_________________________ </b>    
            </div>



            <div style="position: absolute;margin-left: 80px;margin-top: <?=$margin+0?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <?=$solicitud_laboratorio['fecha_solicitud']?>
            </div>

            <!-- Ubicacion del paceinte -->
            <div style="position: absolute;margin-left: 235px;margin-top: <?=$margin+0?>px;width: 360px;text-transform: uppercase;font-size: 11px;text-align: left;">
                <?php echo (!empty($cama) ? $cama['cama_nombre'].' '.$cama['piso_nombre_corto'] :  $_GET['tipo']);?>
            </div>

            <div style="position: absolute;margin-left: 55px;margin-top: <?=$margin+27?>px;width: 360px;font-size: 11px;text-align: left;">
                <?=$medicoEspecialidad['especialidad_nombre']?>
            </div>

              <div style="position: absolute;margin-left: 295px;margin-top: <?=$margin+27?>px;width: 360px;font-size: 11px;text-align: left;">
                X
            </div>


             <div style="position: absolute;margin-left: 40px;margin-top: <?=$margin+80?>px;width: 330px;font-size: 11px;text-align: left;">
                  <?=$Diagnosticos[0]['cie10_clave']?> - <?=$Diagnosticos[0]['cie10_nombre']?><br>
            </div>


            <?php 
            $estudios_obj  = json_decode($solicitud_laboratorio['estudios']);
            $lista_lab = array();
            foreach ($estudios_obj as $nombre => $valor) { 
                $estudios = explode("&", $nombre);
                $lista_lab[] = $estudios[3];
            }?>

            <div style="position: absolute;margin-left: 40px;margin-top: <?=$margin+180?>px;width: 700px;font-size: 12px;text-align: left;">
                <?=implode(', ', $lista_lab);?>
            </div>

        </div>
    </page_header>

    
    
    <page_footer>


    
    </page_footer>
</page>
<?php
    $html=  ob_get_clean();
    $pdf=new HTML2PDF('P','A4','fr','UTF-8');
    $pdf->writeHTML($html);
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->pdf->SetTitle('NOTA INICIAL ADMISION CONTINUA');
    $pdf->Output($Nota['notas_tipo'].'.pdf');
?>