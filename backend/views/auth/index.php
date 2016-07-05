<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý cấp quyền';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ CẤP QUYỀN
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
                    <h2>Danh sách cấp quyền</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['auth/create']) ?>" class="btn btn-success">Thêm mới</a> </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= Html::a("Xóa", "javascript:void(0)", ["class" => "btn_delete_multiple btn btn-danger"]) ?>
                    <?php
                    Pjax::begin([
                        'id' => 'pjax_gridview_role',
                    ])
                    ?>
                    <?=
                    GridView::widget([
                        'id' => 'girdRole',
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'multiple' => true,
                            ],
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'user_id',
                                'value' => function ($data) {
                                    return $data->user->name;
                                }
                            ],
                            [
                                'attribute' => 'item_name',
                                 'format'=>'raw',
                                'value' => function ($data) {
                                    return Html::a($data->item_name, ['child/index', 'parent' => $data->item_name], ['target' => '_blank']);
                                }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{update} {delete}',
                                    ],
                                ],
                                'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
                            ]);
                            ?>
                            <?php Pjax::end() ?> 
                            <?= Html::a("Xóa", "javascript:void(0)", ["class" => "btn_delete_multiple btn btn-danger"]) ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->registerJs('
    $(".btn_delete_multiple").click(function () {
    var keys = $("#girdRole").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn xóa các mẫu tin này không (s)");
        }
    if (msg == true) {
      if(keys!=""){
            $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["account/deleteall"]) . '", data: {ids: keys}, success: function (data) {
                if(data=="ok"){
                window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
                  }
                }
            });
            }
    }
    return false;
});
');
        ?>
