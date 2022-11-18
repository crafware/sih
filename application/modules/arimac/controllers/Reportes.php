<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Reportes
 *
 * @author bienTICS
 */
include_once APPPATH.'modules/config/controllers/Config.php';
include_once APPPATH.'third_party/PHPExcel/PHPExcel.php';
class Reportes extends Config{
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        if($_GET['inputFechaInicio']){
            $fi=$_GET['inputFechaInicio'];
            $ff=$_GET['inputFechaTermino'];
            $sql['info']= $this->config_mdl->_query("SELECT os_triage.triage_id,os_triage.triage_nombre, os_triage.triage_nombre_ap, os_triage.triage_nombre_am,os_triage.triage_horacero_f,os_triage.triage_horacero_h,
                                                    os_triage.triage_fecha, os_triage.triage_hora,
                                                    os_triage.triage_fecha_clasifica,os_triage.triage_hora_clasifica ,
                                                    os_triage.triage_color ,paciente_diagnosticos.tipo_diagnostico,paciente_diagnosticos.complemento,um_cie10.cie10_id,um_cie10.cie10_nombre,paciente_info.pia_procedencia_hospital, paciente_info.pia_procedencia_espontanea,paciente_info.pum_delegacion,paciente_info.pum_umf
                                                    FROM os_triage INNER JOIN paciente_diagnosticos ON 
                                                    os_triage.triage_id = paciente_diagnosticos.triage_id
                                                    INNER JOIN um_cie10 ON 
                                                    paciente_diagnosticos.cie10_id = um_cie10.cie10_id

                                                    INNER JOIN paciente_info ON 
                                                    os_triage.triage_id = paciente_info.triage_id

                                                    WHERE
                                                    os_triage.triage_fecha_clasifica BETWEEN '$fi' AND '$ff' AND os_triage.triage_fecha_clasifica!='' AND paciente_diagnosticos.tipo_diagnostico = '0'");
        }else{
            $sql['info']='';
        }
        $this->load->view('Reportes/index',$sql);
    }
    public function ReporteGeneral() {
        error_reporting(1);
        ini_set('max_execution_time', 0); 
        ini_set('memory_limit','600M');
        $fi=$_GET['inputFechaInicio'];
        $ff=$_GET['inputFechaTermino'];

            /*
        $sql= $this->config_mdl->_query("SELECT triage_id,triage_nombre, triage_nombre_ap, triage_nombre_am,triage_horacero_f,triage_horacero_h,
                                                triage_fecha, triage_hora,
                                                triage_fecha_clasifica,triage_hora_clasifica ,
                                                triage_color
                                                FROM os_triage WHERE 
                                                triage_fecha_clasifica BETWEEN '$fi' AND '$ff' AND triage_fecha_clasifica!=''");

        */

        $sql= $this->config_mdl->_query("SELECT os_triage.triage_id,os_triage.triage_nombre, os_triage.triage_nombre_ap, os_triage.triage_nombre_am,os_triage.triage_horacero_f,os_triage.triage_horacero_h,
                                                    os_triage.triage_fecha, os_triage.triage_hora,
                                                    os_triage.triage_fecha_clasifica,os_triage.triage_hora_clasifica ,
                                                    os_triage.triage_color ,paciente_diagnosticos.tipo_diagnostico,paciente_diagnosticos.complemento,um_cie10.cie10_id,um_cie10.cie10_nombre,paciente_info.pia_procedencia_hospital, paciente_info.pia_procedencia_espontanea,paciente_info.pum_delegacion,paciente_info.pum_umf
                                                    FROM os_triage INNER JOIN paciente_diagnosticos ON 
                                                    os_triage.triage_id = paciente_diagnosticos.triage_id
                                                    INNER JOIN um_cie10 ON 
                                                    paciente_diagnosticos.cie10_id = um_cie10.cie10_id

                                                    INNER JOIN paciente_info ON 
                                                    os_triage.triage_id = paciente_info.triage_id

                                                    WHERE
                                                    os_triage.triage_fecha_clasifica BETWEEN '$fi' AND '$ff' AND os_triage.triage_fecha_clasifica!='' AND paciente_diagnosticos.tipo_diagnostico = '0'");


        // Se crea el objeto PHPExcel
        $objPHPExcel = new PHPExcel();
        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("UMAE | Hospital de Espacialidades CMN Siglo XXI") // Nombre del autor
            ->setLastModifiedBy("UMAE | Hospital de Espacialidades CMN Siglo XXI") //Ultimo usuario que lo modificó
            ->setTitle("UMAE | Hospital de Espacialidades CMN Siglo XXI") // Titulo
            ->setSubject("UMAE | Hospital de Espacialidades CMN Siglo XXI") //Asunto
            ->setDescription("REPORTE DE PACIENTES") //Descripción
            ->setKeywords("REPORTE DE PACIENTES") //Etiquetas
            ->setCategory("REPORTE DE PACIENTES"); //Categorias
        $tituloReporte = "REPORTE DE PACIENTES DEL ".$fi.' AL '.$ff.'('.count($sql).') PACIENTES';
        $titulosColumnas = array(
            'cvePresupuestal', //A
            'nss', //B
            'agregadoMedico', //C
            'nombre',//D
            'paterno',//E
            'materno',//F
            'triageClasific',//G
            'FechaHoraRegistro',// H
            'llegadaFechaHora', // I
            'triageFechaHoraIni', // J
            'triageFechaHoraFin', // K
            'pimContactoFechaHora', // L
            'Usr', // M
            'destino' //N

        );
        // Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:N1');

        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1',$tituloReporte) // Titulo del reporte
            ->setCellValue('A3',  $titulosColumnas[0])  //Titulo de las columnas
            ->setCellValue('B3',  $titulosColumnas[1])
            ->setCellValue('C3',  $titulosColumnas[2])
            ->setCellValue('D3',  $titulosColumnas[3])
            ->setCellValue('E3',  $titulosColumnas[4])
            ->setCellValue('F3',  $titulosColumnas[5])
            ->setCellValue('G3',  $titulosColumnas[6])
            ->setCellValue('H3',  $titulosColumnas[7])
            ->setCellValue('I3',  $titulosColumnas[8])
            ->setCellValue('J3',  $titulosColumnas[9])
            ->setCellValue('K3',  $titulosColumnas[10])
            ->setCellValue('L3',  $titulosColumnas[11])
            ->setCellValue('M3',  $titulosColumnas[12])
            ;
        //Se agregan los datos de los alumnos
        $i = 4; //Numero de fila donde se va a comenzar a rellenar
        foreach ($sql as $value) {
            // if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value['triage_horacero_f'] ) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value['triage_fecha_clasifica'] )){
            //     $TiempoHoraCero=Modules::run('Config/CalcularTiempoTranscurrido',array(
            //         'Tiempo1'=>$value['triage_horacero_f'].' '.$value['triage_horacero_h'],
            //         'Tiempo2'=>$value['triage_fecha_clasifica'].' '.$value['triage_hora_clasifica'],
            //     ));
            //     $Tiempo=$TiempoHoraCero->h*60 + $TiempoHoraCero->i;
            // }else{
            //     $Tiempo=0;
            // }
            $clavePresupuestal = '37B5091C2153';
            switch ($value['triage_color']) {
                case 'Rojo':
                    $colorClasific = 'r';
                    break;
                case 'Naranja':
                    $colorClasific = 'n';
                    break;
                case 'Amarillo':
                    $colorClasific = 'a';
                    break;
                case 'Verde':
                    $colorClasific = 'v';
                    break;
                case 'Azul':
                    $colorClasific = 'z';
                    break;
            }
            
            
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$clavePresupuestal)
                ->setCellValue('B'.$i, $value['pum_nss'])
                ->setCellValue('C'.$i, $value['pum_nss_agregado'])
                ->setCellValue('D'.$i, $value['triage_nombre'])
                ->setCellValue('E'.$i, $value['triage_nombre_ap'])
                ->setCellValue('F'.$i, $value['triage_nombre_am'])
                ->setCellValue('G'.$i, $colorClasific)
                ->setCellValue('H'.$i, $value['triage_fecha'].' '.$value['triage_hora'],'')
                ->setCellValue('I'.$i, $value['triage_horacero_f'].' '.$value['triage_horacero_h'])
                ->setCellValue('J'.$i, $value['triage_fecha_clasifica'].' '.$value['triage_horaInicio_clasifica'])
                ->setCellValue('K'.$i, $value['triage_fecha_clasifica'].' '.$value['triage_hora_clasifica'])
                ->setCellValue('L'.$i, $value)
                ->setCellValue('M'.$i, $value['cie10_nombre'])
                ->setCellValue('N'.$i, $value['complemento']);
                //->setCellValue('G'.$i,$Tiempo.' Minutos' );
             $i++;
         }
         
        for($i = 'A'; $i <= 'M'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
        }
        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('REPORTES');
        //
        
        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $styleArray = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'FFFFFF'),
            'size'  => 15,
            'name'  => 'Verdana',
        ));
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:M1')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '256659')
                            )
                        )
                    );
        $styleArrayCols = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'FFFFFF'),
            'size'  => 10,
            'name'  => 'Verdana',
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A3:M3')->applyFromArray($styleArrayCols)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A3:M3')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '256659')
                            )
                        )
                    );
        // Inmovilizar paneles
        //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
        $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);
        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="REPORTE_DE_PACIENTES.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function ReportesGeneralCamas() {
        $sql= $this->config_mdl->_query("SELECT * FROM os_areas, os_camas, os_pisos, os_pisos_camas WHERE
            os_areas.area_id=os_camas.area_id AND os_areas.area_modulo='Pisos' AND
            os_pisos.piso_id=os_pisos_camas.piso_id AND os_camas.cama_id=os_pisos_camas.cama_id");
        // Se crea el objeto PHPExcel
        $objPHPExcel = new PHPExcel();
        // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("UMAE | Dr. Victorio de la Fuente Narváez") // Nombre del autor
            ->setLastModifiedBy("UMAE | Dr. Victorio de la Fuente Narváez") //Ultimo usuario que lo modificó
            ->setTitle("UMAE | Dr. Victorio de la Fuente Narváez") // Titulo
            ->setSubject("UMAE | Dr. Victorio de la Fuente Narváez") //Asunto
            ->setDescription("REPORTE GENERAL DE CAMAS") //Descripción
            ->setKeywords("REPORTE GENERAL DE CAMAS") //Etiquetas
            ->setCategory("REPORTE GENERAL DE CAMAS"); //Categorias
        $tituloReporte = "REPORTE GENERAL DE CAMAS";
        $titulosColumnas = array(
            'PISO ', //A
            'ÁREA', //B
            'CAMAS', //C
            'ESTADO',//D
            'FECHA DE ESTADO',//E
            'TIEMPO TRANSCURRIDO',//F
        );
        // Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:F1');

        // Se agregan los titulos del reporte
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1',$tituloReporte) // Titulo del reporte
            ->setCellValue('A3',  $titulosColumnas[0])  //Titulo de las columnas
            ->setCellValue('B3',  $titulosColumnas[1])
            ->setCellValue('C3',  $titulosColumnas[2])
            ->setCellValue('D3',  $titulosColumnas[3])
            ->setCellValue('E3',  $titulosColumnas[4])
            ->setCellValue('F3',  $titulosColumnas[5]);
        //Se agregan los datos de los alumnos
        $i = 4; //Numero de fila donde se va a comenzar a rellenar
        foreach ($sql as $value) {
            if($value['cama_fh_estatus']!=''){
                $TiempoHoraCero=Modules::run('Config/CalcularTiempoTranscurrido',array(
                    'Tiempo1'=>$value['cama_fh_estatus'],
                    'Tiempo2'=> date('Y-m-d H:i:s'),
                ));
                $Tiempo=$TiempoHoraCero->d.' Días '.$TiempoHoraCero->h.' Hrs '.$TiempoHoraCero->i.' Min';
            }else{
                $Tiempo='NO SE PUEDE DETERMINAR';
            }
            
            
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $value['piso_nombre'])
                ->setCellValue('B'.$i, $value['area_nombre'])
                ->setCellValue('C'.$i, $value['cama_nombre'].'  ')
                ->setCellValue('D'.$i, $value['cama_status'])
                ->setCellValue('E'.$i, $value['cama_fh_estatus'])
                ->setCellValue('F'.$i, $Tiempo);
             $i++;
         }
         
        for($i = 'A'; $i <= 'F'; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
        }
        // Se asigna el nombre a la hoja
        $objPHPExcel->getActiveSheet()->setTitle('REPORTES');
        //
        
        // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
        $styleArray = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'FFFFFF'),
            'size'  => 15,
            'name'  => 'Verdana',
        ));
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:F1')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '256659')
                            )
                        )
                    );
        $styleArrayCols = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'FFFFFF'),
            'size'  => 10,
            'name'  => 'Verdana',
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($styleArrayCols)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()
                    ->getStyle('A3:F3')
                    ->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '256659')
                            )
                        )
                    );
        // Inmovilizar paneles
        //$objPHPExcel->getActiveSheet(0)->freezePane('A4');
        $objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);
        // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="REPORTE_GENERAL_DE_CAMAS.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
    public function ReporteGeneralCamasPDF() {
        $fecha=$_GET['fecha'];
        $sql['Gestion']= $this->config_mdl->_query("SELECT * FROM os_areas, os_camas, os_pisos, os_pisos_camas, cm_camas_log WHERE
        os_areas.area_id=os_camas.area_id AND os_areas.area_modulo='Pisos' AND
        os_pisos.piso_id=os_pisos_camas.piso_id AND os_camas.cama_id=os_pisos_camas.cama_id AND
        os_camas.cama_id=cm_camas_log.cama_id AND cm_camas_log.log_fecha='$fecha'");
        $this->load->view('Reportes/ReportesCamas',$sql);
    }
    public function ImportarDiagnosticos() {
        header("Content-Type: text/html;charset=utf-8");
        //Nombre del Archivo a leer
        $objPHPExcel = PHPExcel_IOFactory::load('assets/CIE10.xlsx');
        //Asigno la hoja de calculo activa
        $objPHPExcel->setActiveSheetIndex(0);
        //Obtengo el numero de filas del archivo
        $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        for ($i = 1; $i <= $numRows; $i++) {
            if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()!='Clave' && $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()!=''){
                $this->config_mdl->_insert('um_hojafrontal_diagnosticoscie10',array(
                    'diagnostico_clave' => $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
                    'diagnostico_nombre'=> $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue(),
                    
                ));
                
            }
        }
        $this->setOutput(array('accion'=>'1'));
    }
    /*
     * REPORTES DE TIEMPO PROMEDIO DE HORACERO - MÉDICO TRIAGE POR COLOR DE 
     * CLASIFICACIÓN
     */
    public function TiemposHoraceroMedico() {
        if(isset($_GET['inputFecha'])){
            $inputFecha=$_GET['inputFecha'];
            $sqlClassRojo= $this->config_mdl->_query("SELECT triage_horacero_f,triage_horacero_h,triage_fecha_clasifica,triage_hora_clasifica FROM os_triage WHERE 
                                                    triage_color='Rojo'  AND triage_fecha_clasifica='$inputFecha'");
            $TotalTiempoRojo=0;
            foreach ($sqlClassRojo as $value) {
                $TotalTiempoRojo= Modules::run('Config/TiempoTranscurridoResult',array(
                    'fecha1'=>$value['triage_horacero_f'].' '.$value['triage_horacero_h'],
                    'fecha2'=>$value['triage_fecha_clasifica'].' '.$value['triage_hora_clasifica'],
                ))+$TotalTiempoRojo;
                
            }
            $sqlClassNaranja= $this->config_mdl->_query("SELECT triage_horacero_f,triage_horacero_h,triage_fecha_clasifica,triage_hora_clasifica FROM os_triage WHERE 
                                                    triage_color='Naranja'  AND triage_fecha_clasifica='$inputFecha'");
            $TotalTiempoNaranja=0;
            foreach ($sqlClassNaranja as $value) {
                $TotalTiempoNaranja= Modules::run('Config/TiempoTranscurridoResult',array(
                    'fecha1'=>$value['triage_horacero_f'].' '.$value['triage_horacero_h'],
                    'fecha2'=>$value['triage_fecha_clasifica'].' '.$value['triage_hora_clasifica'],
                ))+$TotalTiempoNaranja;
                
            }
            $sqlClassAmarillo= $this->config_mdl->_query("SELECT triage_horacero_f,triage_horacero_h,triage_fecha_clasifica,triage_hora_clasifica FROM os_triage WHERE 
                                                    triage_color='Amarillo'  AND triage_fecha_clasifica='$inputFecha'");
            $TotalTiempoAmarillo=0;
            foreach ($sqlClassAmarillo as $value) {
                $TotalTiempoAmarillo= Modules::run('Config/TiempoTranscurridoResult',array(
                    'fecha1'=>$value['triage_horacero_f'].' '.$value['triage_horacero_h'],
                    'fecha2'=>$value['triage_fecha_clasifica'].' '.$value['triage_hora_clasifica'],
                ))+$TotalTiempoAmarillo;
                
            }
            $sqlClassVerde= $this->config_mdl->_query("SELECT triage_horacero_f,triage_horacero_h,triage_fecha_clasifica,triage_hora_clasifica FROM os_triage WHERE 
                                                    triage_color='Verde'  AND triage_fecha_clasifica='$inputFecha'");
            $TotalTiempoVerde=0;
            foreach ($sqlClassVerde as $value) {
                $TotalTiempoVerde= Modules::run('Config/TiempoTranscurridoResult',array(
                    'fecha1'=>$value['triage_horacero_f'].' '.$value['triage_horacero_h'],
                    'fecha2'=>$value['triage_fecha_clasifica'].' '.$value['triage_hora_clasifica'],
                ))+$TotalTiempoVerde;
                
            }
            $sqlClassAzul= $this->config_mdl->_query("SELECT triage_horacero_f,triage_horacero_h,triage_fecha_clasifica,triage_hora_clasifica FROM os_triage WHERE 
                                                    triage_color='Azul'  AND triage_fecha_clasifica='$inputFecha'");
            $TotalTiempoAzul=0;
            foreach ($sqlClassAzul as $value) {
                $TotalTiempoAzul= Modules::run('Config/TiempoTranscurridoResult',array(
                    'fecha1'=>$value['triage_horacero_f'].' '.$value['triage_horacero_h'],
                    'fecha2'=>$value['triage_fecha_clasifica'].' '.$value['triage_hora_clasifica'],
                ))+$TotalTiempoAzul;
                
            }
        }else{
            $TotalTiempoRojo=0;
            $TotalTiempoNaranja=0;
            $TotalTiempoAmarillo=0;
            $TotalTiempoVerde=0;
            $TotalTiempoAzul=0;
        }
        $this->load->view('Reportes/TiemposHoraceroMedico',array(
            'TiempoClassRojo'=>$TotalTiempoRojo/count($sqlClassRojo),
            'TiempoClassNaranja'=>$TotalTiempoNaranja/count($sqlClassNaranja),
            'TiempoClassAmarillo'=>$TotalTiempoAmarillo/count($sqlClassAmarillo),
            'TiempoClassVerde'=>$TotalTiempoVerde/count($sqlClassVerde),
            'TiempoClassAzul'=>$TotalTiempoAzul/count($sqlClassAzul)
        ));
    }

    public function infoDashboardArimac()
    {
        $total = $this->config_mdl->_query("SELECT idPaciente FROM um_pacientes");
        $hombres = $this->config_mdl->sqlGetDataCondition('um_pacientes',array(
                    'sexo' => 'HOMBRE'));
        $mujeres = $this->config_mdl->sqlGetDataCondition('um_pacientes',array(
                    'sexo' => 'MUJER'));
        $totalPrestados = $this->config_mdl->_query("SELECT idsolicitud FROM um_arimac_expedientes WHERE estado='prestado'");
        $registradosDia = $this->config_mdl->_query("SELECT idPaciente FROM um_pacientes WHERE DATE_FORMAT(fechaReg,'%Y-%m-%d') = CURDATE()");
        $prestadosDia = $this->config_mdl->_query("SELECT idsolicitud FROM um_arimac_expedientes WHERE fecha_solicitud= DATE_FORMAT(CURDATE(), '%d-%m-%Y')");

        $this->setOutput(array(
            'total'           => COUNT($total),
            'hombres'         => COUNT($hombres),
            'mujeres'         => COUNT($mujeres),
            'total_prestados' => COUNT($totalPrestados),
            'registrados_dia' => COUNT($registradosDia),
            'prestados_dia'   => COUNT($prestadosDia)
             ));

    }
    
}
