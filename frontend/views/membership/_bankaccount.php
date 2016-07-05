<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="work-progress">
    <div class="row">  
        <div class="col-md-1 col-sm-2 col-xs-3">
            <i class="icon icon-bank-account"></i>
        </div>
        <div class="col-md-11 col-sm-10 col-xs-9">
            <div class="row">
                <div class="col-md-10 col-sm-11 col-xs-12">
                    <h4 class="text-blue">
                        <b>Thông tin tài khoản ngân hàng</b>
                    </h4>
                </div>
                <div class="col-md-2 col-sm-1 col-xs-12">
                    <a class="btn bank_edit" title="Quá trình làm việc"><i class="fa fa-pencil"></i> Chỉnh sửa</a>
                </div>
            </div>
            <p>Thông tin tài khoản ngân hàng của cá nhân bạn để thực hiện các giao dịch trên Giaonhanviec</p>
        </div>
        <div class="col-md-11 col-sm-10 col-xs-12 pull-right work-list">
            <?php if (!empty($bankaccount)) {?>
            <p>Chủ tài khoản: <b><?=$bankaccount->account_holder?></b></p>
            <p>Số tài khoản: <b><?=$bankaccount->bankaccount?></b></p>
            <p>Tỉnh/Thành phố: <b><?=$bankaccount->findCity($bankaccount->bank_local)->name;?></b></p>
            <p>Tên ngân hàng: <b><?=$bankaccount->findBank($bankaccount->bank_name)->name;?></b></p>
            <p>Chi nhánh ngân hàng: <b><?=$bankaccount->findBranch($bankaccount->branch_bank)->name;?></b></p>
            <?php }?>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg work-progress in" id="bankaccount" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">TÀI KHOẢN NGÂN HÀNG</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'frmprogress', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>  
                <div id="bank_account" class="list-info">
                    <div class="form-group field-bankaccount-account_holder">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label for="bankaccount-account_holder" class="control-label">Chủ tài khoản</label>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <input type="text" value="<?php if (!empty($bankaccount)) {echo $bankaccount->account_holder;}?>" name="account_holder" class="form-control txtaccount_holder txt_bank">
                            <p class="help-block help-block-error txtaccount_holder-error text-red"></p>
                        </div>
                    </div>                    
                    <div class="form-group field-bankaccount-bankaccount">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label for="bankaccount-bankaccount" class="control-label">Số tài khoản</label>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <input type="text" value="<?php if (!empty($bankaccount)) {echo $bankaccount->bankaccount;}?>" name="bankaccount" class="form-control txtbankaccount txt_bank">
                            <p class="help-block help-block-error txtbankaccount-error text-red"></p>
                        </div>
                    </div>                    
                    <div class="form-group field-bankaccount-bank_local">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label for="bankaccount-bank_local" class="control-label">Tỉnh/Thành phố</label>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <select class="form-control txtbank_local txt_bank" id="bank_local">
                                    <option value="">Chọn địa điểm</option>
                                <?php foreach ($city as $value) {?>        
                                    <option value="<?=$value->_id?>" <?php if((!empty($bankaccount))&&($value->_id==$bankaccount->bank_local)){echo 'selected="selected"';}?>><?=$value->name?></option>
                                <?php }?>
                            </select>
                            <p class="help-block help-block-error txtbank_local-error text-red"></p>
                        </div>
                    </div>                    
                    <div class="form-group field-bankaccount-bank_name">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label for="bankaccount-bank_name" class="control-label">Tên ngân hàng</label>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <select id="bankname" class="form-control txtbank_name txt_bank">
                                <option value="">Chọn ngân hàng</option>
                                <?php 
                                if(!empty($bankaccount)){
                                    $listbank = $bankaccount->listbank($bankaccount->bank_local);
                                    foreach ($listbank as $value) {
                                ?>        
                                <option value="<?=$value['id']?>" <?php if($value['id'] == $bankaccount->bank_name){echo 'selected="selected"';}?>><?=$value['name'].' - '.$value['code']?></option>
                                <?php }}?>
                            </select>
                            <p class="help-block help-block-error txtbank_name-error text-red"></p>
                        </div>
                    </div>                    
                    <div class="form-group field-bankaccount-branch_bank">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label for="bankaccount-branch_bank" class="control-label">Chi nhánh ngân hàng</label>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <select id="bankbranch" class="form-control txtbranch_bank txtbranch_bank">
                                <option value="">Chọn chi nhánh</option>
                                <?php 
                                if(!empty($bankaccount)){
                                    $listbranch = $bankaccount->listbranch($bankaccount->bank_local, $bankaccount->bank_name);
                                    foreach ($listbranch as $value) {
                                ?>        
                                <option value="<?=$value['id']?>" <?php if($value['id'] == $bankaccount->branch_bank){echo 'selected="selected"';}?>><?=$value['name']?></option>
                                <?php }}?>
                            </select>
                            <p class="help-block help-block-error txtbranch_bank-error text-red"></p>
                        </div>
                    </div>
                </div>
                <div class="row-item">
                    <a href="javascript:void(0)" class="btn btn-blue submit-bank">Lưu lại</a>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div> 

<?=
$this->registerJs('$(document).ready(function (){
    $(document).on("click", ".bank_edit", function () {
        $("#bankaccount").modal("show");
    });
});');?>
<?= $this->registerJs('
    $("#bank_local").on("change",function(){  
    var id = $(this).val();
    $.ajax({
        url:"' . Yii::$app->urlManager->createUrl(["membership/selectbank"]) . '",
        type:"POST",            
        data:{id: id}, 
        dataType:"json",
        success:function(data){     
            if(data){
                var html = "<option value>Chọn ngân hàng</option>";
                for (index = 0; index < data.length; ++index) {
                    html += "<option value="+data[index].id+">"+data[index].name+" - "+data[index].code+"</option>";
                }    
            } else{
                html = "<option value>Chưa có ngân hàng</option>";
            }
            $("#bankname").html(html);
        }
    });
});'); ?>
<?= $this->registerJs('
    $("#bankname").on("change",function(){  
    var bank = $(this).val();
    var bank_local = $("#bank_local").val();
    if(!bank || !bank_local){
        return false;
    }
    $.ajax({
        url:"' . Yii::$app->urlManager->createUrl(["membership/selectbranch"]) . '",
        type:"POST",            
        data:{bank: bank, bank_local:bank_local}, 
        dataType:"json",
        success:function(data){     
            if(data){
                var html = "<option value>Chọn chi nhánh</option>";
                for (index = 0; index < data.length; ++index) {
                    html += "<option value="+data[index].id+">"+data[index].name+"</option>";
                }    
            } else{
                html = "<option value>Chưa có ngân hàng</option>";
            }
            $("#bankbranch").html(html);
        }
    });
});'); ?>
<?= $this->registerJs("$(document).on('click', '.submit-bank', function (event){
    event.preventDefault();
    var account_holder = $('.txtaccount_holder').val();
    var bankaccount = $('.txtbankaccount').val();
    var bank_local = $('.txtbank_local').val();
    var bank_name = $('.txtbank_name').val();
    var branch_bank = $('.txtbranch_bank').val();
    var complete = true;
    if(!branch_bank){
        $('.txtbranch_bank').focus();
        $('.txtbranch_bank-error').html('Vui lòng điền thông tin');
        complete = false;
    }else{
        $('.txtbranch_bank-error').html('');
    }
    if(!bank_name){
        $('.txtbank_name').focus();
        $('.txtbank_name-error').html('Vui lòng điền thông tin');
        complete = false;
    }else{
        $('.txtbank_name-error').html('');
    }
    if(!bank_local){
        $('.txtbank_local').focus();
        $('.txtbank_local-error').html('Vui lòng điền thông tin');
        complete = false;
    }else{
        $('.txtbank_local-error').html('');
    }
    if(!bankaccount){
        $('.txtbankaccount').focus();
        $('.txtbankaccount-error').html('Vui lòng điền thông tin');
        complete = false;
    }else{
        $('.txtbankaccount-error').html('');
    }
    if(!account_holder){
        $('.txtaccount_holder').focus();
        $('.txtaccount_holder-error').html('Vui lòng điền thông tin');
        complete = false;
    }else{
        $('.txtaccount_holder-error').html('');
    }
    
    if(complete){
        $.ajax({
            url: '" . Yii::$app->urlManager->createUrl(["ajax/bankaccount"]) . "',
            type: 'post',
            data: {'account_holder':account_holder, 'bankaccount':bankaccount, 'bank_local':bank_local, 'bank_name':bank_name, 'branch_bank':branch_bank},
            success: function(data) {
                location.reload();
            }
        });
    }else{
        return false();
    }
});") ?>