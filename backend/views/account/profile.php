<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Thông tin cá nhân';
$this->params['breadcrumbs'][] = 'Thông tin cá nhân';
?>
<div class="account-create">
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
                    <h2>Chi tiết</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>     
                            <?= Html::a('Thay đổi thông tin', ['changeprofile'], ['class' => 'btn btn-primary']) ?>
                        </li>
                        <li>     
                            <?= Html::a('Thay đổi mật khẩu', ['changepassword', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th width=200>{label}</th><td>{value}</td></tr>',
                        'options' => ['class' => 'table table-striped table-bordered detail-view'],
                        'attributes' => [
                            [
                                'attribute' => 'avatar',
                                'format' => ['html'],
                                'value' => !empty($model->avatar) ? '<img width=100 src="' . $model->avatar . '">' : "Chưa cập nhật"
                            ],
                            'email',
                            'name',
                            'phone',
                            'address',
                            'role',
                            'status',
                            [
                                'attribute' => 'created_at',
                                'value' => date('d/m/Y', $model->created_at)
                            ],
                            'secret',
                            [
                                'label' => 'Mã code',
                                'format' => ['html'],
                                'value' => '<img src="' . $ga->getQRCodeGoogleUrl($model->username, $model->secret) . '">'
                            ],
                        ],
                    ])
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>