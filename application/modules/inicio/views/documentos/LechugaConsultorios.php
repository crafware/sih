<?php 

        $pdf=new HTML2PDF('P','A4','fr','UTF-8');

        ob_start(); 

        if(strpos($_SESSION['UMAE_AREA'], 'Medico Triage') !== false){
        	include 'Lechuga_mt.php';
        }else if(strpos($_SESSION['UMAE_AREA'], 'Consultorio') !== false){
        	include 'Lechuga_ac.php';
        }else if(strpos($_SESSION['UMAE_AREA'], 'Observación') !== false){
                include 'Lechuga_ac.php';
        }

        $content=  ob_get_clean();
        $pdf->writeHTML($content);

        $pdf->pdf->SetTitle('DOCUMENTO 4.30.6 CONSULTORIOS');
        //$pdf->pdf->IncludeJS("print(true);");
        $pdf->Output('DOCUMENTO 4.30.6 CONSULTORIOS.pdf'); 
 
 ?>