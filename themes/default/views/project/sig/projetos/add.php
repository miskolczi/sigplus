<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('Criar Novo Projeto'); ?></h2>
    </div>
    
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                echo form_open_multipart("projetos/add", $attrib);
              
                ?>
                
                <div class="row">
                    <div class="col-lg-12">
                    <div class="col-md-12">
                            <div class="form-group">
                                <?= lang("Nome do Projeto", "slprojeto"); ?>
                                <?php echo form_input('nome_projeto', (isset($_POST['nome_projeto']) ? $_POST['nome_projeto'] : $slnumber), 'maxlength="200" class="form-control input-tip" required="required" id="slprojeto"'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                       
                        
                            
                       

                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("Data de Início", "sldateIni"); ?>
                                    <?php echo form_input('dateInicial', (isset($_POST['dateInicial']) ? $_POST['dateInicial'] : ""), 'class="form-control input-tip date" id="sldateIni" required="required"'); ?>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("Data Final Prevista", "sldateFim"); ?>
                                    <?php echo form_input('dateFim', (isset($_POST['dateFim']) ? $_POST['dateFim'] : ""), 'class="form-control input-tip date" id="sldateFim" required="required"'); ?>
                                </div>
                            </div>
                             
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <?= lang("Gerente do Projeto", "slGerenteArea"); ?>
                                            <div class="input-group">
                                             
                                                <?php
                                                $wu1[''] = '';
                                                foreach ($users as $user1) {
                                                    $wu1[$user1->first_name. ' '.$user1->last_name] = $user1->first_name. ' '.$user1->last_name;
                                                }
                                                echo form_dropdown('gerenteArea', $wu1, (isset($_POST['provider']) ? $_POST['provider'] : $Settings->default_supplier), 'id="slGerenteArea" class="form-control  select" data-placeholder="' . lang("Selecione") . ' " required="required" style="width:100%;" required="required"');
                                                ?>
                                                
                                                
                                             <div class="input-group-addon no-print" style="padding: 2px 8px;">
                                                    
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("Coordenador do Projeto", "coordenador"); ?>
                                <div class="input-group">

                                    <?php
                                    $wu1[''] = '';
                                    foreach ($users as $user1) {
                                        $wu1[$user1->first_name. ' '.$user1->last_name] = $user1->first_name. ' '.$user1->last_name;
                                    }
                                    echo form_dropdown('coordenador', $wu1, (isset($_POST['coordenador']) ? $_POST['coordenador'] : $Settings->default_supplier), 'id="coordenador" class="form-control  select" data-placeholder="' . lang("Selecione") . ' " required="required" style="width:100%;" ');
                                    ?>


                                 <div class="input-group-addon no-print" style="padding: 2px 8px;">

                                    </div>

                                </div>
                            </div>
                        </div>
                         
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("document", "document") ?>
                                <input id="document" type="file" data-browse-label="<?= lang('browse'); ?>" name="document" data-show-upload="false"
                                       data-show-preview="false" class="form-control file">
                            </div>
                        </div>

                        
                        
                        
                         <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("Cor do Projeto", "projeto_status"); ?>
                                <input class="form-control" type="color" name="cor" >              
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>

                      

                        
                        <div class="col-md-12">
                            <div
                                class="fprom-group"><?php echo form_submit('add_projeto', lang("submit"), 'id="add_projeto" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset"><?= lang('reset') ?></div>
                        </div>
                    </div>
                </div>
                

                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>

<div class="modal" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="prModalLabel"></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <?php if ($Settings->tax1) { ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?= lang('product_tax') ?></label>
                            <div class="col-sm-8">
                                <?php
                                $tr[""] = "";
                                foreach ($tax_rates as $tax) {
                                    $tr[$tax->id] = $tax->name;
                                }
                                echo form_dropdown('ptax', $tr, "", 'id="ptax" class="form-control pos-input-tip" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($Settings->product_serial) { ?>
                        <div class="form-group">
                            <label for="pserial" class="col-sm-4 control-label"><?= lang('serial_no') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pserial">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="pquantity" class="col-sm-4 control-label"><?= lang('quantity') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pquantity">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="poption" class="col-sm-4 control-label"><?= lang('product_option') ?></label>

                        <div class="col-sm-8">
                            <div id="poptions-div"></div>
                        </div>
                    </div>
                    <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) { ?>
                        <div class="form-group">
                            <label for="pdiscount"
                                   class="col-sm-4 control-label"><?= lang('product_discount') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pdiscount">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="pprice" class="col-sm-4 control-label"><?= lang('unit_price') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pprice">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?= lang('net_unit_price'); ?></th>
                            <th style="width:25%;"><span id="net_price"></span></th>
                            <th style="width:25%;"><?= lang('product_tax'); ?></th>
                            <th style="width:25%;"><span id="pro_tax"></span></th>
                        </tr>
                    </table>
                    <input type="hidden" id="punit_price" value=""/>
                    <input type="hidden" id="old_tax" value=""/>
                    <input type="hidden" id="old_qty" value=""/>
                    <input type="hidden" id="old_price" value=""/>
                    <input type="hidden" id="row_id" value=""/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="editItem"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="mModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="mModalLabel"><?= lang('add_product_manually') ?></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="mcode" class="col-sm-4 control-label"><?= lang('product_code') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mcode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mname" class="col-sm-4 control-label"><?= lang('product_name') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mname">
                        </div>
                    </div>
                    <?php if ($Settings->tax1) { ?>
                        <div class="form-group">
                            <label for="mtax" class="col-sm-4 control-label"><?= lang('product_tax') ?> *</label>

                            <div class="col-sm-8">
                                <?php
                                $tr[""] = "";
                                foreach ($tax_rates as $tax) {
                                    $tr[$tax->id] = $tax->name;
                                }
                                echo form_dropdown('mtax', $tr, "", 'id="mtax" class="form-control input-tip select" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="mquantity" class="col-sm-4 control-label"><?= lang('quantity') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mquantity">
                        </div>
                    </div>
                    <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) { ?>
                        <div class="form-group">
                            <label for="mdiscount"
                                   class="col-sm-4 control-label"><?= lang('product_discount') ?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="mdiscount">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="mprice" class="col-sm-4 control-label"><?= lang('unit_price') ?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mprice">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?= lang('net_unit_price'); ?></th>
                            <th style="width:25%;"><span id="mnet_price"></span></th>
                            <th style="width:25%;"><?= lang('product_tax'); ?></th>
                            <th style="width:25%;"><span id="mpro_tax"></span></th>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addItemManually"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#gccustomer').select2({
            minimumInputLength: 1,
            ajax: {
                url: site.base_url + "customers/suggestions",
                dataType: 'json',
                quietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });
        $('#genNo').click(function () {
            var no = generateCardNo();
            $(this).parent().parent('.input-group').children('input').val(no);
            return false;
        });
    });
</script>
