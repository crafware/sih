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
            $sql['info']= $this->config_mdl->_query("SELECT os_triage.triage_id,os_triage.triage_nombre, os_triage.triage_nombre_ap, os_triage.triage_nombre_am,os_triage.triage_fecha_nac,
                                                            YEAR(triage_horacero_f)-YEAR(STR_TO_DATE(triage_fecha_nac,'%d/%m/%Y'))  AS edad,os_triage.triage_horacero_f,
                                                            os_triage.triage_horacero_h,os_triage.triage_fecha, os_triage.triage_hora,os_triage.triage_fecha_clasifica,
                                                            os_triage.triage_hora_clasifica,os_triage.triage_color,paciente_diagnosticos.tipo_diagnostico,
                                                            paciente_diagnosticos.complemento,um_cie10.cie10_id,um_cie10.cie10_nombre,paciente_info.pia_procedencia_hospital,
                                                            paciente_info.pia_procedencia_espontanea,paciente_info.pum_delegacion,paciente_info.pum_umf, 
                                                            os_consultorios_especialidad_hf.funcionalidad_barthel, os_consultorios_especialidad_hf.escala_fragilidad
                                                    FROM os_triage INNER JOIN paciente_diagnosticos ON 
                                                    os_triage.triage_id = paciente_diagnosticos.triage_id
                                                    INNER JOIN um_cie10 ON 
                                                    paciente_diagnosticos.cie10_id = um_cie10.cie10_id

                                                    INNER JOIN paciente_info ON 
                                                    os_triage.triage_id = paciente_info.triage_id

                                                    INNER JOIN os_consultorios_especialidad_hf  ON 
                                                    os_triage.triage_id = os_consultorios_especialidad_hf.triage_id

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
        $lugar=$_GET['selectArea'];

        if($lugar=='triage normal') 
        {
            $sql= $this->config_mdl->_query("SELECT os_triage.triage_id,os_triage.triage_nombre, os_triage.triage_nombre_ap, os_triage.triage_nombre_am,os_triage.triage_fecha_nac,
                                                    YEAR(triage_horacero_f)-YEAR(STR_TO_DATE(triage_fecha_nac,'%d/%m/%Y'))  AS edad,os_triage.triage_horacero_f,os_triage.triage_horacero_h,
                                                    os_triage.triage_fecha, os_triage.triage_hora,os_triage.triage_fecha_clasifica,os_triage.triage_hora_clasifica,
                                                    os_triage.triage_color ,paciente_diagnosticos.tipo_diagnostico,paciente_diagnosticos.complemento,um_cie10.cie10_id,
                                                    um_cie10.cie10_nombre,paciente_info.pia_procedencia_hospital, paciente_info.pia_procedencia_espontanea,paciente_info.pum_delegacion,
                                                    paciente_info.pum_umf,paciente_info.pum_nss,paciente_info.pum_nss_agregado,os_consultorios_especialidad_hf.funcionalidad_barthel,
                                                    os_consultorios_especialidad_hf.escala_fragilidad
                                            FROM os_triage INNER JOIN paciente_diagnosticos ON 
                                                 os_triage.triage_id = paciente_diagnosticos.triage_id
                                            INNER JOIN um_cie10 ON 
                                                paciente_diagnosticos.cie10_id = um_cie10.cie10_id
                                            INNER JOIN paciente_info ON 
                                                        os_triage.triage_id = paciente_info.triage_id
                                            INNER JOIN os_consultorios_especialidad_hf  ON 
                                                        os_triage.triage_id = os_consultorios_especialidad_hf.triage_id
                                            WHERE
                                                os_triage.triage_fecha_clasifica BETWEEN '$fi' AND '$ff' AND os_triage.triage_fecha_clasifica!='' AND paciente_diagnosticos.tipo_diagnostico = '0'");


            // Se crea el objeto PHPExcel
            $objPHPExcel = new PHPExcel();
            // Se asignan las propiedades del libro
            $objPHPExcel->getProperties()->setCreator("UMAE | ESPECIALIDADES CMN SXXI") // Nombre del autor
                ->setLastModifiedBy("UMAE | ESPECIALIDADES CMN SXXI") //Ultimo usuario que lo modificó
                ->setTitle("UMAE | Dr. Bernardo Sepúlveda G") // Titulo
                ->setSubject("UMAE | Dr. Dr. Bernardo Sepúlveda G") //Asunto
                ->setDescription("REPORTE DE PACIENTES") //Descripción
                ->setKeywords("REPORTE DE PACIENTES") //Etiquetas
                ->setCategory("REPORTE DE PACIENTES"); //Categorias
            $tituloReporte = "REPORTE DE PACIENTES DEL ".$fi.' AL '.$ff.'('.count($sql).') PACIENTES';
            $titulosColumnas = array(
                'FOLIO ', //A
                'NSS', //B
                'NOMBRE DEL PACIENTE ', //C
                'FECHA DE NACIMIENTO', //D
                'EDAD', //E
                'HORA CERO', //F
                'ENFERMERÍA TRIAGE',//G
                'MÉDICO TRIAGE',//H
                'CLASIFICACIÓN',//I
                'T.T HORACERO (min)',//J
                'DX DE INGRESO',// K
                'DX COMPLEMENTO', // L
                'ESPONTANEO', // M
                'REFERIDO', // N
                'DELEG', // O
                'UMF', // P
                'GRADO FUNCIONALIDAD', //Q
                'FRAGILIDAD', //R
            );
            // Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
            $objPHPExcel->setActiveSheetIndex(0)
                ->mergeCells('A1:R1');

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
                ->setCellValue('N3',  $titulosColumnas[13])
                ->setCellValue('O3',  $titulosColumnas[14])
                ->setCellValue('P3',  $titulosColumnas[15])
                ->setCellValue('Q3',  $titulosColumnas[16])
                ->setCellValue('R3',  $titulosColumnas[17]);
            //
            $i = 4; //Numero de fila donde se va a comenzar a rellenar
            foreach ($sql as $value) {
                if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value['triage_horacero_f'] ) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value['triage_fecha_clasifica'] )){
                    $TiempoHoraCero=Modules::run('Config/CalcularTiempoTranscurrido',array(
                        'Tiempo1'=>$value['triage_horacero_f'].' '.$value['triage_horacero_h'],
                        'Tiempo2'=>$value['triage_fecha_clasifica'].' '.$value['triage_hora_clasifica'],
                    ));
                    $Tiempo=$TiempoHoraCero->h*60 + $TiempoHoraCero->i;
                }else{
                    $Tiempo=0;
                }
                $nss=$value['pum_nss'].' '.$value['pum_nss_agregado'];
                
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $value['triage_id'])
                    ->setCellValue('B'.$i, $nss)
                    ->setCellValue('C'.$i, $value['triage_nombre_ap'].' '.$value['triage_nombre_am'].' '.$value['triage_nombre'])
                    ->setCellValue('D'.$i, $value['triage_fecha_nac'])
                    ->setCellValue('E'.$i, $value['edad'])
                    ->setCellValue('F'.$i, $value['triage_horacero_f'].' '.$value['triage_horacero_h'])
                    ->setCellValue('G'.$i, $value['triage_fecha'].' '.$value['triage_hora'],'')
                    ->setCellValue('H'.$i, $value['triage_fecha_clasifica'].' '.$value['triage_hora_clasifica'])
                    ->setCellValue('I'.$i, $value['triage_color'])
                    ->setCellValue('J'.$i, $Tiempo)
                    ->setCellValue('K'.$i, $value['cie10_nombre'])
                    ->setCellValue('L'.$i, $value['complemento'])
                    ->setCellValue('M'.$i, $value['pia_procedencia_espontanea'] )
                    ->setCellValue('N'.$i, $value['pia_procedencia_hospital'] )
                    ->setCellValue('O'.$i, $value['pum_delegacion'] )
                    ->setCellValue('P'.$i, $value['pum_umf'])
                    ->setCellValue('Q'.$i, $value['funcionalidad_barthel'])
                    ->setCellValue('R'.$i, $value['escala_fragilidad']);
                 $i++;
             }
             
            for($i = 'A'; $i <= 'R'; $i++){
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
            $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:R1')
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
            $objPHPExcel->getActiveSheet()->getStyle('A3:R3')->applyFromArray($styleArrayCols)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A3:R3')
                        ->applyFromArray(
                            array(
                                'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => '256659')
                                )
                            )
                        );
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A3:R3')
                        ->applyFromArray(
                            array(
                                    'borders' => array(
                                                        'right' => array(
                                                                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                                                                    'color' => array('rgb' => 'FFFFFF')
                                                                    )
                                    )
                                )   
                        );
        }else {
            $sql=$this->config_mdl->_query("SELECT triage_horacero_f,triage_horacero_h,triage_hora,triage_fecha_clasifica,triage_hora_clasifica, T.triage_id,
                                            CONCAT(T.triage_nombre,' ',T.triage_nombre_ap,' ',T.triage_nombre_am) AS nombre,
                                            CONCAT(P.pum_nss,'-',P.pum_nss_agregado) AS NSS,triage_paciente_sexo,triage_fecha_nac,
                                            FLOOR((CURDATE() - DATE_FORMAT(STR_TO_DATE(triage_fecha_nac, '%d/%m/%Y'), '%Y%m%d'))/10000) AS edad,
                                            P.pic_responsable_telefono AS telefono,
                                            triage_color,
                                            triage_motivoAtencion,
                                            triage_consultorio_nombre AS destino,
                                            sv_ta,
                                            sv_temp,
                                            sv_fc,
                                            sv_fr,
                                            sv_oximetria,
                                            sv_peso,
                                            sv_talla,
                                            sv_dextrostix,
                                            fiebre,
                                            tos,
                                            dolor_garganta,
                                            dolor_torax,
                                            cansancio,
                                            mialgia,
                                            cefalea,
                                            rinorrea,
                                            anosmia,
                                            conjuntivitis,
                                            disnea,
                                            edad,
                                            oximetria,
                                            glasgow,
                                            epoc,
                                            diabetes,
                                            hipertension,
                                            cardiopatia,
                                            nefropata,
                                            inmunodef,
                                            hepatopatia,
                                            fecha_vacuna,
                                            laboratorio
                                        FROM
                                            os_triage T,
                                            paciente_info P,
                                            os_triage_signosvitales SV,
                                            os_triage_clasificacion_resp CR
                                        WHERE
                                            T.triage_via_registro = 'Hora Cero TR'
                                        AND T.triage_id = P.triage_id
                                        AND T.triage_id = SV.triage_id
                                        AND T.triage_id = SV.triage_id
                                        AND T.triage_id = CR.triage_id
                                        AND triage_fecha_clasifica BETWEEN '$fi'
                                        AND '$ff'  ORDER BY triage_horacero_f ASC");

                // Se crea el objeto PHPExcel
            $objPHPExcel = new PHPExcel();
            // Se asignan las propiedades del libro
            $objPHPExcel->getProperties()->setCreator("UMAE | ESPECIALIDADES CMN SXXI") // Nombre del autor
                ->setLastModifiedBy("UMAE | ESPECIALIDADES CMN SXXI") //Ultimo usuario que lo modificó
                ->setTitle("UMAE | Dr. Bernardo Sepúlveda G") // Titulo
                ->setSubject("UMAE | Dr. Dr. Bernardo Sepúlveda G") //Asunto
                ->setDescription("REPORTE DE PACIENTES") //Descripción
                ->setKeywords("REPORTE DE PACIENTES") //Etiquetas
                ->setCategory("REPORTE DE PACIENTES"); //Categorias
            $tituloReporte = "REPORTE DE PACIENTES DEL ".$fi.' AL '.$ff.'('.count($sql).') PACIENTES';
            $titulosColumnas = array(
                'FECHA ', //A
                'HORA CERO', //B
                'HORA TRIAGE', //C
                'HORA CLASIFICA', //D
                'FOLIO',//E
                'NOMBRE',//F
                'NSS',//G
                'GENERO',//H
                'FECHA NACIMIENTO',// I
                'EDAD', // J
                'TELEFONO', // K
                'COLOR CLASIFICA', // L
                'MOTIVO ATENCIÓN', // M
                'DESTINO', // N
                'TIEMPO (min)', //O
                'TA (mmHG)', //P
                'TEMP (°C)', //Q
                'FC (lpm)', //R
                'FR (rpm)', //S
                'SPO2', //T
                'PESO (kg)', //U
                'TALLA (m)', //V
                'GLUCOSA (mg/dl)', //W
                'FIEBRE', //X
                'TOS', //Y
                'DOLOR DE GARGANTA', //Z
                'DOLOR TORAX', //AA 
                'CANSANCIO', //AB
                'MIALGIA', //AC
                'CEFALEA', //AD
                'RINORREA', //AE
                'ANOSMIA', //AF
                'CONJUTIVITIS', //AG
                'DESNEA', //AH
                'EDAD > 65 AÑOS', //AI
                'SP02 < 93 %', //AJ
                'GLASGOW', //AK
                'EPOC', //AL
                'DIABETES', //AM
                'HIPERTENSIÓN', //AO
                'CARDIOPATIA', //AP
                'NEFROPATIA', //AQ
                'INMUNODEFICIENCIA', //AR
                'HEPATOPATIA', //AS
                'VACUNA',
                'FECHA VACUNA'
            );
            // Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
            $objPHPExcel->setActiveSheetIndex(0)
                ->mergeCells('A1:AT1');

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
                ->setCellValue('N3',  $titulosColumnas[13])
                ->setCellValue('O3',  $titulosColumnas[14])
                ->setCellValue('P3',  $titulosColumnas[15])
                ->setCellValue('Q3',  $titulosColumnas[16])
                ->setCellValue('R3',  $titulosColumnas[17])
                ->setCellValue('S3',  $titulosColumnas[18])
                ->setCellValue('T3',  $titulosColumnas[19])
                ->setCellValue('U3',  $titulosColumnas[20])
                ->setCellValue('V3',  $titulosColumnas[21])
                ->setCellValue('W3',  $titulosColumnas[22])
                ->setCellValue('X3',  $titulosColumnas[23])
                ->setCellValue('Y3',  $titulosColumnas[24])
                ->setCellValue('Z3',  $titulosColumnas[25])
                ->setCellValue('AA3',  $titulosColumnas[26])
                ->setCellValue('AB3',  $titulosColumnas[27])
                ->setCellValue('AC3',  $titulosColumnas[28])
                ->setCellValue('AD3',  $titulosColumnas[29])
                ->setCellValue('AE3',  $titulosColumnas[30])
                ->setCellValue('AF3',  $titulosColumnas[31])
                ->setCellValue('AG3',  $titulosColumnas[32])
                ->setCellValue('AH3',  $titulosColumnas[33])
                ->setCellValue('AI3',  $titulosColumnas[34])
                ->setCellValue('AJ3',  $titulosColumnas[35])
                ->setCellValue('AK3',  $titulosColumnas[36])
                ->setCellValue('AL3',  $titulosColumnas[37])
                ->setCellValue('AM3',  $titulosColumnas[38])
                ->setCellValue('AN3',  $titulosColumnas[39])
                ->setCellValue('AO3',  $titulosColumnas[40])
                ->setCellValue('AP3',  $titulosColumnas[41])
                ->setCellValue('AQ3',  $titulosColumnas[42])
                ->setCellValue('AR3',  $titulosColumnas[43])
                ->setCellValue('AS3',  $titulosColumnas[44])
                ->setCellValue('AT3',  $titulosColumnas[45])


                ;
            //Se agregan los datos a ,las celdas
            $i = 4; //Numero de fila donde se va a comenzar a rellenar
            foreach ($sql as $value) {
                if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value['triage_horacero_f'] ) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value['triage_fecha_clasifica'] )){
                    $TiempoHoraCero=Modules::run('Config/CalcularTiempoTranscurrido',array(
                        'Tiempo1'=>$value['triage_horacero_f'].' '.$value['triage_horacero_h'],
                        'Tiempo2'=>$value['triage_fecha_clasifica'].' '.$value['triage_hora_clasifica'],
                    ));
                    $Tiempo=$TiempoHoraCero->h*60 + $TiempoHoraCero->i;
                }else{
                    $Tiempo=0;
                }
                
                
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.$i, $value['triage_horacero_f'])
                    ->setCellValue('B'.$i, $value['triage_horacero_h'])
                    ->setCellValue('C'.$i, $value['triage_hora'])
                    ->setCellValue('D'.$i, $value['triage_hora_clasifica'])
                    ->setCellValue('E'.$i, $value['triage_id'])
                    ->setCellValue('F'.$i, $value['nombre'])
                    ->setCellValue('G'.$i, $value['NSS'])
                    ->setCellValue('H'.$i, $value['triage_paciente_sexo'])
                    ->setCellValue('I'.$i, $value['triage_fecha_nac'])
                    ->setCellValue('J'.$i, $value['edad'])
                    ->setCellValue('K'.$i, $value['telefono'])
                    ->setCellValue('L'.$i, $value['triage_color'])
                    ->setCellValue('M'.$i, $value['triage_motivoAtencion'])
                    ->setCellValue('N'.$i, $value['destino'])
                    ->setCellValue('O'.$i, $Tiempo)
                    ->setCellValue('P'.$i, $value['sv_ta'])
                    ->setCellValue('Q'.$i, $value['sv_temp'])
                    ->setCellValue('R'.$i,$value['sv_fc'] )
                    ->setCellValue('S'.$i,$value['sv_fr'] )
                    ->setCellValue('T'.$i,$value['sv_oximetria'] )
                    ->setCellValue('U'.$i,$value['sv_peso'])
                    ->setCellValue('V'.$i,$value['sv_talla'])
                    ->setCellValue('W'.$i,$value['sv_dextrostix'])
                    ->setCellValue('X'.$i,$value['fiebre'])
                    ->setCellValue('Y'.$i,$value['tos'])
                    ->setCellValue('Z'.$i,$value['dolor_garganta'])
                    ->setCellValue('AA'.$i,$value['dolor_torax'])
                    ->setCellValue('AB'.$i,$value['cansancio'])
                    ->setCellValue('AC'.$i,$value['mialgia'])
                    ->setCellValue('AD'.$i,$value['cefalea'])
                    ->setCellValue('AE'.$i,$value['rinorrea'])
                    ->setCellValue('AF'.$i,$value['anosmia'])
                    ->setCellValue('AG'.$i,$value['conjuntivitis'])
                    ->setCellValue('AH'.$i,$value['disnea'])
                    ->setCellValue('AI'.$i,$value['edad'])
                    ->setCellValue('AJ'.$i,$value['oximetria'])
                    ->setCellValue('AK'.$i,$value['glasgow'])
                    ->setCellValue('AL'.$i,$value['epoc'])
                    ->setCellValue('AM'.$i,$value['diabetes'])
                    ->setCellValue('AN'.$i,$value['hipertension'])
                    ->setCellValue('AO'.$i,$value['cardiopatia'])
                    ->setCellValue('AP'.$i,$value['nefropata'])
                    ->setCellValue('AQ'.$i,$value['inmunodef'])
                    ->setCellValue('AR'.$i,$value['hepatopatia'])
                    ->setCellValue('AS'.$i,$value['laboratorio'])
                    ->setCellValue('AT'.$i,$value['fecha_vacuna']);
                 $i++;
             }
             
            for($i = 'A'; $i <= 'AT'; $i++){
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
            $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($styleArray)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A1:AT1')
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
            $objPHPExcel->getActiveSheet()->getStyle('A3:AT3')->applyFromArray($styleArrayCols)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()
                        ->getStyle('A3:AT3')
                        ->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '256659')
                                )
                            )
                        );

        } // FIN else
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
}
