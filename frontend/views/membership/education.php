<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">TRÌNH ĐỘ HỌC VẤN </h4>
</div>
<div class="modal-body">
    <?php $form = ActiveForm::begin(['id' => 'education', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal  frm-Workprogress']]); ?>  
    <div class="row tb-head">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <b>Tên trường</b>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <b>Ngành học</b>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6">
            <b>Thời gian từ</b>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-6">
            <b>Đến </b>
        </div>
    </div>
    <div id="list_education" class="list-info row">
        <?php
        if (count($education) > 2)
            $counteducation = count($education);
        else
            $counteducation = 2;
        for ($i = 0; $i < 5; $i++) {

            if ($i > $counteducation)
                $display = "none";
            else
                $display = "block";
            ?>
            <div class="row-item row row-item-education-<?= $i ?>" style="display:<?= $display ?>">
                <input type="hidden" name ="education_id[<?= $i ?>]" value="<?= !empty($education[$i]) ? (string) $education[$i]->_id : "" ?>">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input name="Education[school][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($education[$i]) ? $education[$i]->school : "" ?>" placeholder="<?= !empty($education[$i]->school) ? $education[$i]->school : "" ?>">
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input name="Education[course][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($education[$i]) ? $education[$i]->course : "" ?>" placeholder="<?= !empty($education[$i]) ? $education[$i]->course : "" ?>">
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <input name="Education[created_begin][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($education[$i]) ? $education[$i]->created_begin : "" ?>" placeholder="<?= !empty($education[$i]) ? $education[$i]->created_begin : "" ?>">
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6">
                    <input name="Education[created_end][<?= $i ?>]" type="text" class="form-control txt-input" value="<?= !empty($education[$i]) ? $education[$i]->created_end : "" ?>" placeholder="<?= !empty($education[$i]) ? $education[$i]->created_end : "" ?>">
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="row-item field-education">
        <a class="add-education" data-count="2" href="#"><i class="fa fa-plus"></i> Thêm mới </a>
    </div>

    <div class="row-item">
        <button type="submit" class="btn btn-blue">Lưu lại</button>
    </div>
    <?php ActiveForm::end(); ?>
</div>
