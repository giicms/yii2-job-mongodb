<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Account;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý quyền';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ PERMISSION
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
                    <h2>Danh sách permission</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['permission/create']) ?>" class="btn btn-success">Thêm mới</a> </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    Pjax::begin([
                        'id' => 'pjax_gridview_account',
                    ])
                    ?>
                    <?=
                    GridView::widget([
                        'id' => 'girdPermission',
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [

                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
                            'description',
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view} {update} {delete}',
                            ],
                        ],
                        'tableOptions' => ['class' => 'table table-striped responsive-utilities bulk_action'],
                    ]);
                    ?>
                    <?php Pjax::end() ?> 
                </div>
            </div>
        </div>
    </div>
</div>

