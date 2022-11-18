<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="modalTamanioG">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Puntuación de la Escala de Glasgow</h4>
            </div>
            <div class="modal-body">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border label_glasgow_ocular"><b>APERTURA OCULAR</b></legend>
                        <div class="form-group">
                            <label class="md-check">
                            <input type="radio" class='sum_glasgow' name="apertura_ocular" value="4" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Espontánea</label>&nbsp;&nbsp;
                            <label class="md-check">
                            <input type="radio" class='sum_glasgow' name="apertura_ocular" value="3" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Hablar</label>&nbsp;&nbsp;
                            <label class="md-check">
                            <input type="radio" class='sum_glasgow' name="apertura_ocular" value="2" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Dolor</label>&nbsp;&nbsp;
                            <label class="md-check">
                            <input type="radio" class='sum_glasgow' name="apertura_ocular" value="1" <?= ($hojafrontal[0]['hf_glasgow_ocular'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausente</label>
                        </div>
                </fieldset>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border label_glasgow_motora"><b>RESPUESTA MOTORA</b></legend>
                        <div class="form-group">
                            <label class="md-check">
                                <input type="radio" class='sum_glasgow' name="respuesta_motora" value="6" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 6 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Obedece</label>&nbsp;&nbsp;
                                <label class="md-check">
                                <input type="radio" class='sum_glasgow' name="respuesta_motora" value="5" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 5 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Localiza</label>&nbsp;&nbsp;
                                <label class="md-check">
                                <input type="radio" class='sum_glasgow' name="respuesta_motora" value="4" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Retira</label>
                                <label class="md-check">
                                <input type="radio" class='sum_glasgow' name="respuesta_motora" value="3" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Flexión normal</label>&nbsp;&nbsp;
                                <label class="md-check">
                                <input type="radio" class='sum_glasgow' name="respuesta_motora" value="2" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Extensión anormal</label>&nbsp;&nbsp;
                                <label class="md-check">
                                <input type="radio" class='sum_glasgow' name="respuesta_motora" value="1" <?= ($hojafrontal[0]['hf_glasgow_motora'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausencia de repuesta</label>
                        </div>
                </fieldset>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border label_glasgow_verbal"><b>RESPUESTA VERBAL</b></legend>
                        <div class="form-group">
                            <label class="md-check">
                            <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="5" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 5 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Orientado&nbsp;&nbsp;</label>
                            <label class="md-check">
                            <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="4" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 4 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Confuso&nbsp;&nbsp;</label>
                            <label class="md-check">
                            <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="3" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 3 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Incoherente&nbsp;&nbsp;</label>
                            <label class="md-check">
                            <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="2" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 2 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Sonidos Incomprensibles&nbsp;&nbsp;</label>
                            <label class="md-check">
                            <input type="radio" class='sum_glasgow' name="respuesta_verbal" value="1" <?= ($hojafrontal[0]['hf_glasgow_verbal'] == 1 )?"checked":""; ?> class="has-value"><i class="indigo"></i>Ausencia de respuesta</label>
                        </div>
                        <div class="form-group">PUNTUACIÓN TOTAL: &nbsp;<input type="text" name="hf_escala_glasgow" size="3" value="<?=$hojafrontal[0]['hf_escala_glasgow']?>" disable>
                        </div>
                </fieldset>
            </div> <!-- div del cuerpo del modal -->

            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn_modal_glasgow" data-dismiss="">Aceptar</button>
            </div>
        </div>
    </div>
</div>
