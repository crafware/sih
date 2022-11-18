<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-12 col-centered" style="margin-top: 10px">
            <div class="panel panel-default ">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">PERFIL DE USUARIO</span>
                </div>
                <div class="panel-body b-b b-light">
                    <div class="row">
                        <div class="col-md-8">
                            <form  class="guardar-info-perfil">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mayus-bold"><b>MATRICULA</b></label>
                                            <input class="form-control" name="empleado_matricula" value="<?=$info[0]['empleado_matricula']?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mayus-bold"><b>NOMBRE</b></label>
                                            <input class="form-control" name="empleado_nombre" required=""  value="<?=$info[0]['empleado_nombre']?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mayus-bold">APELLIDOS</label>
                                            <input class="form-control" name="empleado_apellidos"   value="<?=$info[0]['empleado_apellidos']?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" >
                                            <label class="mayus-bold"><b>SEXO</b></label>
                                            <select name="empleado_sexo" id="empleado_sexo" data-value="<?=$info[0]['empleado_sexo']?>" class="select2 width100 ">>
                                                <option value="M">HOMBRE</option>
                                                <option value="F">MUJER</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mayus-bold"><b>FECHA DE NACIMIENTO</b></label>
                                            <input class="form-control dp-yyyy-mm-dd" name="empleado_fecha_nac" value="<?=$info[0]['empleado_fecha_nac']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mayus-bold"><b>ESTADO</b></label>
                                            <select data-value="<?=$info[0]['empleado_estado']?>" id="empleado_estado" class="width100" name="empleado_estado" style="width: 100%">
                                                <option value="">SELECCIONAR..</option>
                                                <option value="Aguascalientes">Aguascalientes</option>
                                                <option value="Baja California">Baja California</option>
                                                <option value="Baja California Sur">Baja California Sur</option>
                                                <option value="Campeche">Campeche</option>
                                                <option value="Chiapas">Chiapas</option>
                                                <option value="Chihuahua">Chihuahua</option>
                                                <option value="Coahuila">Coahuila</option>
                                                <option value="Colima">Colima</option>
                                                <option value="Distrito Federal">Distrito Federal</option>
                                                <option value="Durango">Durango</option>
                                                <option value="Estado de México">Estado de México</option>
                                                <option value="Guanajuato">Guanajuato</option>
                                                <option value="Guerrero">Guerrero</option>
                                                <option value="Hidalgo">Hidalgo</option>
                                                <option value="Jalisco">Jalisco</option>
                                                <option value="Michoacán">Michoacán</option>
                                                <option value="Morelos">Morelos</option>
                                                <option value="Nayarit">Nayarit</option>
                                                <option value="Nuevo León">Nuevo León</option>
                                                <option value="Oaxaca">Oaxaca</option>
                                                <option value="Puebla">Puebla</option>
                                                <option value="Querétaro">Querétaro</option>
                                                <option value="Quintana Roo">Quintana Roo</option>
                                                <option value="San Luis Potosí">San Luis Potosí</option>
                                                <option value="Sinaloa">Sinaloa</option>
                                                <option value="Sonora">Sonora</option>
                                                <option value="Tabasco">Tabasco</option>
                                                <option value="Tamaulipas">Tamaulipas</option>
                                                <option value="Tlaxcala">Tlaxcala</option>
                                                <option value="Veracruz">Veracruz</option>
                                                <option value="Yucatán">Yucatán</option>
                                                <option value="Zacatecas">Zacatecas</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mayus-bold"><b>TELEFONO</b></label>
                                            <input class="form-control" name="empleado_tel"  value="<?=$info[0]['empleado_tel']?>">
                                        </div> 
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label  class="mayus-bold"><b>EMAIL</b></label>
                                            <input class="form-control" name="empleado_email" value="<?=$info[0]['empleado_email']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mayus-bold">TURNO:</label>
                                            <select name="empleado_turno" class="form-control" data-value="<?=$info[0]['empleado_turno']?>">
                                                <option value="Matutino">Matutino</option>
                                                <option value="Vespertino">Vespertino</option>
                                                <option value="Nocturno">Nocturno</option>
                                                <option value="Jornada Acumulada">Jornada Acumulada</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mayus-bold"><b>CATEGORÍA</b></label>
                                            <input class="form-control" name="empleado_categoria"  value="<?=$info[0]['empleado_categoria']?>" readonly="">
                                        </div> 
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label  class="mayus-bold"><b>DEPARTAMENTO</b></label>
                                            <input class="form-control" name="empleado_departamento" value="<?=$info[0]['empleado_departamento']?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="mayus-bold">SERVICIO ADSCRITO:</label>
                                            <?php 
                                                
                                                $servicio = $this->config_mdl->_get_data_condition('um_especialidades', array(
                                                    'especialidad_id' => $info[0]['empleado_servicio'] ));
                                            ?>
                                            <input class="form-control" name="empleado_servicio" value="<?=$servicio[0]['especialidad_nombre']?>" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mayus-bold">CÉDULA PROFESIONAL:</label>
                                            <input type="text" class="form-control" name="empleado_cedula" value="<?=$info[0]['empleado_cedula']?>">
                                        </div>
                                        <div class="form-group text-justify">
                                            <label><b><i class="fa fa-unlock-alt icono-accion"></i> ROLES ASIGNADOS</b></label><br>
                                            <?php $Rol=''; foreach ($Roles as $value) {
                                                $Rol.=$value['rol_nombre'].', ';
                                            }?>
                                            <?= trim($Rol, ', ')?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="md-check">
                                                <input type="checkbox" class="has-value" name="empleado_sc" value="Si" data-value="<?=$info[0]['empleado_sc']?>">
                                                <i class="indigo"></i><b style="text-transform: uppercase">Solicitar Contraseña al Inicio de Sesión</b>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 empleado_sc hide">
                                        <div class="form-group">
                                            <input type="password" name="empleado_password" value="<?= base64_decode($info[0]['empleado_base64'])?>" class="form-control" placeholder="Contraseña">
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6 empleado_sc hide">
                                        <div class="form-group">
                                            <input type="password" name="empleado_password_c" value="<?= base64_decode($info[0]['empleado_base64'])?>" class="form-control" placeholder="Confirmar Contraseña">
                                        </div>
                                        <div class="form-group pull-right" style="margin-top: -10px;">
                                            <label class="md-check">
                                                <input type="checkbox" name="show_hide_password" class="has-value">
                                                <i class="blue"></i>Mostrar/Ocultar Contraseña
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-offset-8 col-md-4">
                                        <input type="hidden" name="csrf_token">
                                        <input type="hidden" name="empleado_id" value="<?=$info[0]['empleado_id']?>">
                                        <button class="btn btn-primary btn-block">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <img src="<?= base_url()?>assets/img/perfiles/<?=$info[0]['empleado_perfil']?>" style="width: 100%">
                            <br><br>
                            <button class="btn btn-primary btn-block btn-cambiar-perfil">
                                <i class="fa fa-pencil"></i>
                                Cambiar Imagen de Perfil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script type="text/javascript" src="<?= base_url()?>assets/js/Usuarios.js?<?= md5(microtime())?>"></script>