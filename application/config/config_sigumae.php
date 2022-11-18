<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['sexo'] = [
   1 => 'Hombre',
   2 => 'mujer'
];

/**
 * Tamaño máximo para subir archivo en KB
 */
$config['upload_size'] = [
   'materiales_img' => 8388.608
];

/**
 * Lugar donde se guardará el archivo
 */
$config['url_destino'] = [
   'materiales_img' => 'assets/img/materiales'
];

$config['allowed_types'] = [
   'materiales_img' => 'jpg|png|bmp'
];

$config['tipos_destino'] = [
   'quirofano' => '0',
   'piso' => '1'
];

$config['modulo'] = [
   'materiales_consumo' => '7' /*Materiales VAC*/
];

$config['estado_cirugia'] = [
   'revision' => '1',
   'sin_existencia' => '2',
   'devolucion' => '7',
   'finalizado' => '8'
];

$config['tipo_usuario'] = [
   'medico' => '7'
];


$config['max_dias_entrega_proveedor'] = 3;

$config['nombre_documentos'] = [
   'ruta' => 'documentos/formatos/pngs/',
   'reajuste_solicitud_1' => [
      'nombre' => 'Reajuste de solicitud de consumo',
      'alias' => 'RSCV'
   ],
   'reajuste_solicitud_2' => [
      'nombre' => 'Reajuste de solicitud de consumo',
      'alias' => 'RSCV-2'
   ],
   'entrega_solicitud' => [
      'nombre' => 'Entrega de consumo',
      'alias' => 'ECV',
      'archivo' => 'Doc.ECV-Entrega_de_consumo_VAC_Proveedor.png'
   ],
   'cancelacion_solicitud' => [
      'nombre' => 'Cancelación de consumo',
      'alias' => 'CCV'
   ],
   'solicitud_consumo' => [
      'nombre' => 'Solicitud de consumo VAC',
      'alias' => 'SCV',
      'archivo' => 'Doc.SCV-Solicitud_de_consumo_VAC.png',
      'ruta' => 'documentos_umae/solicitud_consumo'
   ]
];

$config['info_umae'] = [
   'delegacion' => 35,
   'umae' => '01',
   'unidades' => [
      'trauma' => 14,
      'fisica' => 20,
      'ortopedia' => 21
   ]
];

$config['solicitud_proveedor'] = [
   'entrega_tipo' => 'dias',
   'entrega_cantidad' => 3
];

/* End of file config_sigumae.php */
/* Location: ./application/config/config_sigumae.php */