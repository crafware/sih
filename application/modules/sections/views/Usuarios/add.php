<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner col-md-10 col-centered" style="margin-top: 10px">
            <div class="card"  >
                <div class="card-heading back-imss">
                    <h2 class="mayus-bold">Agregar usuario</h2>
                </div>
                <div class="card-body">
                    <form id="registrar-usuario">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">Matricula:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-id-card-o"></i>
                                        </span>
                                        <input type="text" class="form-control" name="empleado_matricula" required="" value="<?=$info[0]['empleado_matricula']?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">NOMBRE:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" name="empleado_nombre" required="" value="<?=$info[0]['empleado_nombre']?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">APELLIDOS:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" name="empleado_apellidos" value="<?=$info[0]['empleado_apellidos']?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">SEXO:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <select name="empleado_sexo"  class="form-control " data-value="<?=$info[0]['empleado_sexo']?>">
                                            <option value="M">HOMBRE</option>
                                            <option value="F">MUJER</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">FECHA DE NACIMIENTO:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control dp-yyyy-mm-dd" name="empleado_fecha_nac" value="<?=$info[0]['empleado_fecha_nac']?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">ESTADO:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-map-o"></i>
                                        </span>
                                        <select class="form-control" name="empleado_estado" data-value="<?=$info[0]['empleado_estado']?>" style="width: 100%">
                                            <option value="">Seleccionar</option>
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
                                            <option value="Estado de México" selected="">Estado de México</option>
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
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">TELEFONO:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-phone"></i>
                                        </span>
                                        <input type="text" class="form-control" name="empleado_tel" value="<?=$info[0]['empleado_tel']?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">EMAIL:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="text" class="form-control" name="empleado_email" value="<?=$info[0]['empleado_email']?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">TURNO:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                        <select name="empleado_turno" class="form-control" data-value="<?=$info[0]['empleado_turno']?>">
                                            <option value="Matutino">Matutino</option>
                                            <option value="Vespertino">Vespertino</option>
                                            <option value="Nocturno">Nocturno</option>
                                            <option value="Jornada Acumulada">Jornada Acumulada</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">CATEGORIA:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-align-justify"></i>
                                        </span>
                                        <input type="text" class="form-control" name="empleado_categoria" value="<?=$info[0]['empleado_categoria']?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">DEPARTAMENTO:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-window-restore"></i>
                                        </span>
                                        <input type="text" class="form-control" name="empleado_departamento" value="<?=$info[0]['empleado_departamento']?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">ESPECIALIDAD/SERVICIO ADSCRITO:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-user-md"></i>
                                        </span>
                                        <select name="empleado_servicio" class="form-control" data-value="<?=$info[0]['empleado_servicio']?>">
                                            <option value='' disabled selected>Seleccionar</option>
                                            <?php foreach ($Especialidades as $value) {?>
                                            <option value="<?=$value['especialidad_id']?>"><?=$value['especialidad_nombre']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mayus-bold">CÉDULA PROFESIONAL:</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa fa-credit-card"></i>
                                        </span>
                                        <input type="text" class="form-control" name="empleado_cedula" value="<?=$info[0]['empleado_cedula']?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="empleado_jefe_servicio" name="empleado_jefe_servicio">  ¿Es Jefe de Servicio?

                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="empleado_status" name="empleado_status">  Activar Usuario
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                
                                <div class="form-group" >
                                    <label class="mayus-bold">SELECCIONAR ROL</label>
                                    <div class="input-group m-b">
                                        <span class="input-group-addon back-imss border-back-imss">
                                            <i class="fa fa-unlock-alt"></i>
                                        </span>
                                        <select class="select2" multiple="" name="rol_id[]" id="rol_id" required="" data-value="<?=$info[0]['empleado_roles']?>" style="width: 100%">
                                        <?php foreach ($roles as $value) {?>
                                            <option value="<?=$value['rol_id']?>"><?=$value['rol_nombre']?></option>
                                        <?php }?>
                                        </select>
                                    </div>  
                                </div>   
                            </div>
                            <div class="col-md-4 pull-right">
                                <input type="hidden" id="jtf_accion" name="jtf_accion"  value="<?=$_GET['a']?>">
                                <input type="hidden"name="empleado_id" value="<?=$this->uri->segment(4)?>">
                                <input type="hidden" name="csrf_token">
                                <input type="hidden" name="empleado_modulo" value="Administrador">
                                <button  type="submit" class="btn-save btn back-imss btn-block" style="margin-top: 5px">Guardar</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    if(<?=$info[0]['empleado_jefe_servicio']?> == 1){
        document.getElementById('empleado_jefe_servicio').checked = true;
    }
    if(<?=$info[0]['empleado_status']?> == 1){
        document.getElementById('empleado_status').checked = true;
    }
</script> 
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/Usuarios.js?'). md5(microtime())?>" type="text/javascript"></script> 