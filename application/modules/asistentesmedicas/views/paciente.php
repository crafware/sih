<?= modules::run('Sections/Menu/index'); ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/libs/light-bootstrap/all.min.css" />

<style>
    hr.style-eight {
        border: 0;
        border-top: 2px dashed #8c8c8c;
        text-align: center;
    }

    hr.style-eight:after {
        content: attr(data-titulo);
        display: inline-block;
        position: relative;
        top: -13px;
        font-size: 1.2em;
        padding: 0 0.20em;
        background: white;
        font-weight: bold;
    }
</style>
<div class="box-row">
    <div class="box-cell">
        <div class="col-md-11 col-centered">
            <div class="box-inner padding">
                <form class="solicitud-paciente">
                    <div class="panel panel-default " style="margin-top: -10px">
                        <div class="hide triage-status-paciente" style="margin-top: -10px;height: 35px;">
                            <br>
                            <h5 class="text-center" style="margin-top: -8px;color: white"><b>BAJA</b></h5>
                        </div>
                        <?php if ($info[0]['triage_paciente_sexo'] == 'MUJER') { ?>
                            <div style="background: pink;width: 100%;height: 10px;border-radius: 3px 3px 0px 0px"></div>
                        <?php } ?>
                        <div class="panel-heading p teal-900 back-imss">
                            <span style="font-size: 15px;font-weight: 500;text-transform: uppercase">
                                <div class="row">
                                    <div style="position: relative">
                                        <div class="<?= Modules::run('Config/ColorClasificacion', array('color' => $info[0]['triage_color'])) ?>" style="height: 100px;width: 18px;position: absolute;top: -16px;left: -2px;"></div>
                                    </div>
                                    <div class="col-md-8" style="padding-left: 25px;">
                                        <h4 style="margin-top: -2px">
                                            <input type="text" readonly="" value="PACIENTE: <?= $info[0]['triage_nombre_ap'] ?> <?= $info[0]['triage_nombre_am'] ?> <?= $info[0]['triage_nombre'] ?>" style="font-weight: bold;width: 100%;margin-top: -10px;background: transparent;border: none;height: 44px;">

                                        </h4>
                                        <h4 style="margin-top: -17px">
                                            <b>EDAD: </b>
                                            <?php
                                            if ($info[0]['triage_fecha_nac'] != '') {
                                                $fecha = Modules::run('Config/ModCalcularEdad', array('fecha' => $info[0]['triage_fecha_nac']));
                                                echo $fecha->y . ' Años';
                                            } else {
                                                echo 'S/E';
                                            }
                                            ?>
                                            <?php
                                            $codigo_atencion = Modules::run('Config/ConvertirCodigoAtencion', $info[0]['triage_codigo_atencion']);
                                            echo ($codigo_atencion != '') ? "<br><b style='color:rgb(208, 0, 0);' >Código $codigo_atencion</b>" : "";
                                            ?>
                                        </h4>
                                        <h4 style="margin-top: -8px">
                                            FOLIO: <?= $info[0]['triage_id'] ?>
                                        </h4>

                                    </div>
                                    <div class="col-md-4 text-right">
                                        <h3 style="margin-top: -2px;font-size: 20px">
                                            <b><?= $info[0]['triage_consultorio_nombre'] ?></b>
                                        </h3>
                                        <h4 style="margin-top: -5px">
                                            <?php
                                            if ($info[0]['triage_fecha_nac'] != '') {
                                                $fecha = Modules::run('Config/ModCalcularEdad', array('fecha' => $info[0]['triage_fecha_nac']));
                                                if ($fecha->y < 15) {
                                                    echo 'PEDIATRICO';
                                                }
                                                if ($fecha->y > 15 && $fecha->y < 60) {
                                                    echo 'ADULTO';
                                                }
                                                if ($fecha->y > 60) {
                                                    echo 'GERIATRICO';
                                                }
                                            } else {
                                                echo 'S/E';
                                            }
                                            ?> | <?= $info[0]['triage_paciente_sexo'] ?>
                                            | <?= $PINFO['pia_procedencia_espontanea'] == 'Si' ? 'ESPONTANEA: ' . $PINFO['pia_procedencia_espontanea_lugar'] : 'PROCEDENCIA: ' . $PINFO['pia_procedencia_hospital'] . ' ' . $PINFO['pia_procedencia_hospital_num'] ?>
                                        </h4>
                                    </div>
                                </div>
                            </span>
                        </div>
                        <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                            <div class="col-md-12  text-center">
                                <h6><b> </b></h6>
                            </div>
                        </div>
                        <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                            <div class="col-md-12 back-imss text-center">
                                <h5><b>DATOS DE AFILIACION</b></h5>
                            </div>
                        </div>
                        <br />
                        <div class="panel-body b-b b-light">
                            <div class="card-body" style="padding-bottom: 0px">
                                <div class="row" style="margin-top: -20px">
                                    <div class="col-md-12" style="margin-top: 0px">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label style="text-transform: uppercase;font-weight: bold;">N.S.S</label>
                                                <div class="input-group">
                                                    <input class="form-control" name="pum_nss" placeholder="" value="<?= $PINFO['pum_nss'] ?>" data-inputmask="'mask': '9999-99-9999-9'" required>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-secondary" id="btnVerificarNSS">Verificar</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label style="text-transform: uppercase;font-weight: bold">N.S.S Agregado</label>
                                                    <input class="form-control" required name="pum_nss_agregado" placeholder="" value="<?= $PINFO['pum_nss_agregado'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label style="text-transform: uppercase;font-weight: bold">Vigencia de derechos</label>
                                                    <input class="form-control" required name="pia_vigencia" value="<?= $PINFO['pia_vigencia'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label style="text-transform: uppercase;font-weight: bold">Delegación IMSS</label>
                                                    <input class="form-control" required name="pum_delegacion" placeholder="" value="<?= $PINFO['pum_delegacion'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label style="text-transform: uppercase;font-weight: bold">U.M.F de Adscripción</label>
                                                    <input class="form-control" required name="pum_umf" placeholder="" value="<?= $PINFO['pum_umf'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label style="text-transform: uppercase;font-weight: bold">C.U.R.P</label>
                                                    <input class="form-control" required name="triage_paciente_curp" placeholder="" value="<?= $info[0]['triage_paciente_curp'] ?>">
                                                </div>
                                            </div>
                                            <!--   Modal para verificacion del la vigencia de afiliacion -->
                                            <div class="modal fade" id="ModalVigencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" id="modalTamanioG">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="myModalLabel">Validacion de Vigencia de Derechos</h4>
                                                        </div>
                                                        <div class="modal-body table-responsive" id="infoNSS">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                            <div class="col-md-12 back-imss text-center">
                                <h5><b>DATOS DEL DERECHOHABIENTE</b></h5>
                            </div>
                        </div>
                        <div class="panel-body b-b b-light">
                            <div class="card-body" style="padding-bottom: 0px">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Apellido Paterno</label>
                                            <input class="form-control" required name="triage_nombre_ap" required="" value="<?= $info[0]['triage_nombre_ap'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Apellido Materno</label>
                                            <input class="form-control" required name="triage_nombre_am" required="" value="<?= $info[0]['triage_nombre_am'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Nombre</label>
                                            <input class="form-control" required name="triage_nombre" required="" placeholder="" value="<?= $info[0]['triage_nombre'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Fecha de Nacimiento</label>
                                            <input class="form-control dd-mm-yyyy" required name="triage_fecha_nac" placeholder="06/10/2016" value="<?= $info[0]['triage_fecha_nac'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Sexo</label>
                                            <select class="form-control" name="triage_paciente_sexo" data-value="<?= $info[0]['triage_paciente_sexo'] ?>">
                                                <option value="">Seleccionar</option>
                                                <option value="HOMBRE">HOMBRE</option>
                                                <option value="MUJER">MUJER</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                            <div class="col-md-12 back-imss text-center">
                                <h5><b>DOMICILIO</b></h5>
                            </div>
                        </div>
                        <div class="panel-body b-b b-light">
                            <div class="card-body" style="padding-bottom: 0px">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Código Postal</label>
                                            <div class="input-group">
                                                <input class="form-control" required name="directorio_cp" placeholder="" value="<?= $DirPaciente['directorio_cp'] ?>">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-secondary" id="buscarCP"><i class="glyphicon glyphicon-search"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Calle y Número</label>
                                            <input class="form-control" required name="directorio_cn" placeholder="" value="<?= $DirPaciente['directorio_cn'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Colonia</label>
                                            <input class="form-control" required name="directorio_colonia" placeholder="" value="<?= $DirPaciente['directorio_colonia'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Municipio</label>
                                            <input class="form-control" required name="directorio_municipio" placeholder="" value="<?= $DirPaciente['directorio_municipio'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Estado</label>
                                            <input class="form-control" required name="directorio_estado" placeholder="" value="<?= $DirPaciente['directorio_estado'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Teléfono</label>
                                            <input class="form-control" type="number" required name="directorio_telefono" placeholder="" value="<?= $DirPaciente['directorio_telefono'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                            <div class="col-md-12 back-imss text-center">
                                <h5><b>FAMILIAR RESPONSABLE</b></h5>
                            </div>
                        </div>
                        <div class="panel-body b-b b-light">
                            <div class="card-body" style="padding-bottom: 0px">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">En Caso necesario llamar a</label>
                                            <input class="form-control" required name="pic_responsable_nombre" placeholder="" value="<?= $PINFO['pic_responsable_nombre'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Parentesco</label>
                                            <input class="form-control" required name="pic_responsable_parentesco" placeholder="" value="<?= $PINFO['pic_responsable_parentesco'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Teléfono Responsable:</label>
                                            <div class="input-group">
                                                <input class="form-control" type="number" name="pic_responsable_telefono" placeholder="" value="<?= $PINFO['pic_responsable_telefono'] ?>">
                                                <span class="input-group-btn">
                                                    <button target="_blank" data-original-title="Dar click cuando el responsable tenga el mismo número que el paciente" type="button" class="btn btn-secondary tip" id="btnTelefonoPaciente"><i class="glyphicon glyphicon-earphone"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                            <div class="col-md-12 back-imss text-center">
                                <h5><b>MÉDICO Y ASISTENTE MÉDICA</b></h5>
                            </div>
                        </div>
                        <div class="panel-body b-b b-light">
                            <div class="card-body" style="padding-bottom: 0px">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Médico Tratante</label>
                                            <input class="form-control" list="list_medicos" name="pic_mt" required="" placeholder="" value="<?= $PINFO['pic_mt'] ?>">
                                            <datalist id="list_medicos">
                                                <?php foreach ($MedicosTratantes as $value) { ?>
                                                    <option value="<?= $value['empleado_nombre'] ?> <?= $value['empleado_apellidos'] ?>"></option>
                                                <?php } ?>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Asistente Médica</label>
                                            <input class="form-control" name="pic_am" required="" readonly="" placeholder="" value="<?= $empleado[0]['empleado_nombre'] . ' ' . $empleado[0]['empleado_apellidos'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                            <div class="col-md-12 back-imss text-center">
                                <h5><b>TIPO DE ATENCIÓN</b></h5>
                            </div>
                        </div>
                        <div class="panel-body b-b b-light">
                            <div class="card-body" style="padding-bottom: 0px">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><b>PROCEDENCIA ESPONTÁNEA</b></label>&nbsp;
                                                <div>
                                                    <label class="md-check">
                                                        <input type="radio" name="pia_procedencia_espontanea" data-value="<?= $PINFO['pia_procedencia_espontanea'] ?>" value="Si" checked=""><i class="green"></i>SI
                                                    </label>&nbsp;&nbsp;
                                                    <label class="md-check">
                                                        <input type="radio" name="pia_procedencia_espontanea" value="No"><i class="green"></i>NO
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label style="text-transform: uppercase;font-weight: bold">Tipo de atención</label>
                                                <select class="form-control" id="pia_tipo_atencion" name="pia_tipo_atencion" data-value="<?= $PINFO['pia_tipo_atencion'] ?>">
                                                    <option value="">SELECCIONAR ATENCIÓN</option>
                                                    <option value="1.a VEZ">1.a VEZ</option>
                                                    <option value="SUBSECUENTE">SUBSECUENTE</option>
                                                    <option value="NO DERECHOHABIENTE">NO DERECHOHABIENTE</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-no-espontaneo hidden">
                                            <div class="form-group">
                                                <label><b>HOSPITAL DE PROCEDENCIA</b></label>
                                                <select name="pia_procedencia_hospital" data-value="<?= $PINFO['pia_procedencia_hospital'] ?>" class="form-control">
                                                    <option value="">SELECCIONAR</option>
                                                    <option value="UMF">UMF</option>
                                                    <option value="HGZ">HGZ</option>
                                                    <option value="UMAE">UMAE</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-no-espontaneo hidden">
                                            <div class="form-group">
                                                <label class="mayus-bold">NÚMERO DEL HOSPITAL</label>
                                                <input class="form-control" type="number" name="pia_procedencia_hospital_num" value="<?= $PINFO['pia_procedencia_hospital_num'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-no-espontaneo hidden">
                                            <div class="form-group">
                                                <label style="text-transform: uppercase;font-weight: bold">Documento</label>
                                                <input class="form-control" name="pia_documento" placeholder="" value="<?= $PINFO['pia_documento'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row lugar_trabajo omitir_st7 hide" style="padding: 14px;margin-top: -15px;margin-bottom: -35px;">
                            <div class="col-md-12 back-imss text-center">
                                <h5><b>DATOS DE LA EMPRESA</b></h5>
                            </div>
                        </div>
                        <div class="panel-body b-b b-light lugar_trabajo omitir_st7 hide">

                            <div class="card-body" style="padding-bottom: 0px">

                                <div class="row">
                                    <div class="col-md-6 lugar_trabajo omitir_st7 hide">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Empresa</label>
                                            <input class="form-control" name="empresa_nombre" placeholder="" value="<?= $Empresa['empresa_nombre'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 lugar_trabajo omitir_st7 hide">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Modalidad</label>
                                            <input class="form-control" name="empresa_modalidad" placeholder="" value="<?= $Empresa['empresa_modalidad'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 lugar_trabajo omitir_st7 hide">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Registro Patronal</label>
                                            <input class="form-control" name="empresa_rp" placeholder="" value="<?= $Empresa['empresa_rp'] ?>">
                                        </div>

                                    </div>
                                    <div class="col-md-6 lugar_trabajo omitir_st7 hide">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Fecha de Último Movimiento</label>
                                            <input class="form-control dd-mm-yyyy" name="empresa_fum" placeholder="" value="<?= $Empresa['empresa_fum'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 lugar_trabajo omitir_st7 hide">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Teléfono (Lada)</label>
                                            <input class="form-control" name="directorio_telefono_2" placeholder="" value="<?= $DirEmpresa['directorio_telefono'] ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4 lugar_trabajo omitir_st7 hide">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Código Postal</label>
                                            <input class="form-control" name="directorio_cp_2" placeholder="" value="<?= $DirEmpresa['directorio_cp'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 lugar_trabajo omitir_st7 hide">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Calle y Número</label>
                                            <input class="form-control" name="directorio_cn_2" placeholder="" value="<?= $DirEmpresa['directorio_cn'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 lugar_trabajo omitir_st7 hide">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Colonia</label>
                                            <input class="form-control" name="directorio_colonia_2" placeholder="" value="<?= $DirEmpresa['directorio_colonia'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 lugar_trabajo omitir_st7 hide">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Municipio</label>
                                            <input class="form-control" name="directorio_municipio_2" placeholder="" value="<?= $DirEmpresa['directorio_municipio'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 lugar_trabajo omitir_st7 hide">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Estado</label>
                                            <input class="form-control" name="directorio_estado_2" placeholder="" value="<?= $DirEmpresa['directorio_estado'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Horario de Entrada</label>
                                            <input class="form-control clockpicker" name="empresa_he" placeholder="Entrada" value="<?= $Empresa['empresa_he'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Horario de Salida</label>
                                            <input class="form-control clockpicker" name="empresa_hs" placeholder="Salida" value="<?= $Empresa['empresa_hs'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="text-transform: uppercase;font-weight: bold">Día de descanco P. al accidente</label>
                                            <input class="form-control" name="pia_dia_pa" placeholder="" value="<?= $PINFO['pia_dia_pa'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-8 col-md-2">
                            <button type="button" class="btn btn-imms-cancel btn-block" onclick="window.close()">Cancelar</button>
                        </div>
                        <div class="col-md-2">
                            <input type="hidden" name="url_tipo" value="Am">
                            <input type="hidden" name="csrf_token">
                            <input type="hidden" name="triage_id" value="<?= $this->uri->segment(3) ?>">
                            <input type="hidden" name="asistentesmedicas_id" value="<?= $solicitud[0]['asistentesmedicas_id'] ?>">
                            <input type="hidden" value="Asistente Médica" name="AsistenteMedicaTipo">
                            <button class="btn back-imss btn-block " type="submit">Guardar</button>
                        </div>
                        <br><br><br><br>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="ConfigHojaInicialAsistentes" value="<?= CONFIG_AM_HOJAINICIAL ?>">
<input type="hidden" name="CONFIG_AM_INTERACCION_LT" value="<?= CONFIG_AM_INTERACCION_LT ?>">
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url() ?>assets/libs/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/libs/light-bootstrap/shieldui-all.min.js"></script>
<script src="<?= base_url('assets/js/Enfermeriatriage.js?') . md5(microtime()) ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/Asistentemedica.js?') . md5(microtime()) ?>" type="text/javascript"></script>