<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">KINH NGHIỆM LÀM VIỆC </h4>
</div>
<div class="modal-body">
    <?php $form = ActiveForm::begin(['id' => 'workprocess', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal  frm-Workprogress']]); ?>  
    <div class="row tb-head">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <b>Tên công ty</b>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <b>Vị trí công việc</b>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6">
            <b>Thời gian từ</b>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6">
            <b>Đến </b>
        </div>
    </div>
    <div id="list_work" class="list-info row">
        <?php
        if (count($work) > 2)
            $countwork = count($work);
        else
            $countwork = 2;
        for ($i = 0; $i < 5; $i++) {

            if ($i > $countwork)
                $display = "none";
            else
                $display = "block";
            ?>
            <div class="row-item row row-item-work-<?= $i ?>" style="display:<?= $display ?>">
                <input type="hidden" name ="work_id[<?= $i ?>]" value="<?= !empty($work[$i]) ? (string)$work[$i]->_id : "" ?>">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input name="Workprocess[company][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($work[$i]) ? $work[$i]->company : "" ?>" placeholder="<?= !empty($work[$i]->company) ? $work[$i]->company : "" ?>">
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input name="Workprocess[position][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($work[$i]) ? $work[$i]->position : "" ?>" placeholder="<?= !empty($work[$i]) ? $work[$i]->position : "" ?>">
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <input name="Workprocess[created_begin][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($work[$i]) ? $work[$i]->created_begin : "" ?>" placeholder="<?= !empty($work[$i]) ? $work[$i]->created_begin : "" ?>">
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <input name="Workprocess[created_end][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($work[$i]) ? $work[$i]->created_end : "" ?>" placeholder="<?= !empty($work[$i]) ? $work[$i]->created_end : "" ?>">
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="row-item field-work">
        <a class="add-field" data-count="2" href="#"><i class="fa fa-plus"></i> Thêm mới </a>
    </div>

    <div class="row-item">
        <button type="submit" class="btn btn-blue">Lưu lại</button>
    </div>
    <?php ActiveForm::end(); ?>
</div>
