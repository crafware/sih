<div class="modal fade" id="myModaL_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modalTamanioT">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="myModalLabel">Estudios de Laboratorio</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                <select  class="form-control" id="menu" onchange="dimePropiedades();">
                <?php
                foreach($um_catalogo_laboratorio_area as $area){ ?>
                  <option value="<?= $area['area']?>"> <label><b><?= $area['area'] ?></b></label></option>
                <?php }?>
                </select>
                    <?php
                    $ahidden = "";
                    foreach($um_catalogo_laboratorio_area as $area){
                    ?>
                    <div class="col-md-12 <?= $ahidden ?>" id ="area-<?= $area['area'] ?>">   
                        <div class="row">
                            <label><b>---------<?= $area['area'] ?>---------</b></label> 
                        </div>
                        <?php
                        foreach ($um_catalogo_laboratorio_tipos[$area['area'] ] as $tipo) {
                        ?>
                            <div class="col-md-2">                                     
                            <div class="checkbox">
                                <div class="row">
                                <label class="label" style="background-color: #4169E1"><?= $tipo['tipo'] ?></label>
                                </div>
                                <?php
                                foreach($um_catalogo_laboratorio as $estudios){
                                    if($estudios['tipo']==$tipo['tipo'] && $estudios['area']==$area['area']){
                                        $value_estudios = $estudios['catalogo_id'].'&'.$estudios['area'].'&'.$estudios['tipo'].'&'.$estudios['estudio'];
                                        if(property_exists($objeto_, $value_estudios)){
                                ?>
                                            <div class="row">
                                            <label style="TEXT-ALIGN:justify"><input type="checkbox" checked class="catalogo_estudio" name="<?= $estudios['catalogo_id']?>" id="<?= 'check_catalogo_'.$estudios['catalogo_id']?>" value="<?= $value_estudios?>"><?= $estudios['estudio'] ?></label>
                                            </div>
                                        <?php 
                                        }else{
                                        ?>
                                            <div class="row">
                                                <label style="TEXT-ALIGN:justify"><input type="checkbox"  class="catalogo_estudio" name="<?= $estudios['catalogo_id']?>" id="<?= 'check_catalogo_'.$estudios['catalogo_id']?>" value="<?= $value_estudios?>"><?= $estudios['estudio'] ?></label>
                                            </div>
                                <?php
                                        }
                                    }
                                }
                                ?>                                          
                            </div>
                            </div>

                        <?php
                        }
                        ?>
                        </div>
                <?php
                        $ahidden = "hidden";
                    }
                ?>
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
