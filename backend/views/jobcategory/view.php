<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $this->title ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">
                    <div class="row">
                        <label class="col-md-2 col-sm-2 col-xs-12">Tên danh mục</label><div class="col-md-4 col-sm-6 col-xs-12"><?= $model->name ?></div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 col-sm-2 col-xs-12">Mô tả</label><div class="col-md-4 col-sm-6 col-xs-12"><?= $model->description ?></div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 col-sm-2 col-xs-12">Icon</label><div class="col-md-4 col-sm-6 col-xs-12"><?= $model->icon ?></div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 col-sm-2 col-xs-12">Thời gian cho bài test</label><div class="col-md-4 col-sm-6 col-xs-12"><?= $model->test_time ?></div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 col-sm-2 col-xs-12">Số câu cho bài test</label><div class="col-md-4 col-sm-6 col-xs-12"><?= $model->test_number ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-2 col-md-4 col-sm-6 col-xs-12">
                            <?= Html::a('Cập nhật', ['jobcategory/update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                            <?=
                            Html::a('Xóa', ['jobcategory/delete', 'id' => $model->id], [
                                'data-confirm' => 'Bạn có muốn xóa mẫu tin này không?',
                                'data-method' => 'GET',
                                'class' => 'btn btn-danger'
                                    ]
                            );
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>