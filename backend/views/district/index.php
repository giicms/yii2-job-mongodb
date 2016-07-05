<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý quận/huyện';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý tỉnh/thành', 'url' => ['city/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ QUẬN/HUYỆN
                <!-- <small>
                    Some examples to get you started
                </small> -->
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách quận/huyện</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['district/create', 'id' => $id]) ?>" class="btn btn-success">Thêm mới</a> </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'city_id',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return $data->city->name;
                                },
                            ],
                            'name',
                            ['class' => 'backend\components\columns\ActionColumn'],
                        ],
                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>