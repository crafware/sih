<?php 

	$pdf=new HTML2PDF('P','A4','fr','UTF-8');
        ob_start(); 

        if($_GET['area_ac'] == 'Cons-Obs'){
        	include 'lechuga_cons_obs.php';
        }else if($_GET['area_ac'] == 'Triage'){
        	include 'lechuga_triage_jefatura.php';
        }
        $content=  ob_get_clean();
        $pdf->writeHTML($content);

        $pdf->pdf->SetTitle('DOCUMENTO 4.30.6 PORDUCTIVIDAD');
        //$pdf->pdf->IncludeJS("print(true);");
        $pdf->Output('DOCUMENTO 4.30.6 ADMISIONCONTINUA.pdf'); 
 
 ?>