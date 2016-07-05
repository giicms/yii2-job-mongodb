<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
$this->title = 'Cập nhật cấu hình';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý cấu hình', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="setting-update">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $this->title ?></h3>

        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cập nhật</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="pull-right">            
                            <?=
                            Html::a('Xóa', ['delete', 'id' => (string) $model->_id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Bạn có muốn xóa mẫu tin này không?',
                                    'method' => 'post',
                                ],
                            ])
                            ?></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    $this->render('_form', [
                        'model' => $model,
                    ])
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>