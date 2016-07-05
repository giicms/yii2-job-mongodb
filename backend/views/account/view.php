<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use common\models\Account;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
if ((string) Yii::$app->user->identity->id != $model->id)
    $this->params['breadcrumbs'][] = ['label' => 'Quản lý account', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                <div class="x_title">
                    <h2>Chi tiết</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>     
                            <?= Html::a('Cập nhật', ['update', 'id' => (string) $model->_id], ['class' => 'btn btn-primary']) ?>
                        </li>
                        <li>            <?=
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
                    DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th width=200>{label}</th><td>{value}</td></tr>',
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
                            [
                                'attribute' => 'status',
                                'value' => ($model->status == Account::STATUS_ACTIVE) ? "Đã kích hoạt" : "Chưa kích hoạt"
                            ],
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
                            [
                                'label' => 'Quyền hạn',
                                'format' => ['raw'],
                                'value' => $model->listauth
                            ],
                        ],
                    ])
                    ?>

                </div>

            </div>
        </div>
    </div>
</div>
