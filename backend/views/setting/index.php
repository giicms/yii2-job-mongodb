<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý cấu hình';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ CẤU HÌNH
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
                    <h2>Danh sách cấu hình</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>     
                            <?= Html::a('Thêm mới', [ 'create'], ['class' => 'btn btn-success']) ?>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => false,
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'key',
                            'value',
                            'description',
                            ['class' => 'backend\components\columns\ActionColumn'
                            ],
                        ],
                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>