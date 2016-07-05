<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\Menu;
use common\models\Bank;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý danh sách ngân hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ DANH SÁCH NGÂN HÀNG
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
                    <h2>Thêm mới</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    $form = ActiveForm::begin([
                                'fieldConfig' => [
                                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                    'horizontalCssClasses' => [
                                        'label' => 'col-sm-4',
                                        'offset' => 'col-sm-offset-4',
                                        'wrapper' => ' col-md-8 col-sm-8 col-xs-12',
                                        'error' => '',
                                        'hint' => '',
                                    ],
                                ],
                    ]);
                    ?>  
                    <?=$this->render('_form', ['model' => $model, 'form' => $form, 'num' => 0, 'action' => 'index'])?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách Ngân hàng</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'id' => 'girdCity',
                        'dataProvider' => $dataProvider,
                        'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                        'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                        'columns' => [
                            // [
                            //     'class' => 'yii\grid\CheckboxColumn',
                            //     'multiple' => true,
                            // ],
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Tên ngân hàng',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return $data->name.' (<b>'.$data->code.'</b>)';
                                },
                            ],
                            [
                                'label' => 'Các địa điểm',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return $data->cityid;
                                },
                            ],
                            [
                                'label' => 'Hiển thị',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->publish == Bank::PUBLISH_ACTIVE)
                                        $check = 'checked';
                                    else
                                        $check = '';
                                    return '<input type="checkbox" id="checkstatus" name="publish" ' . $check . '>';
                                },
                                'visible' => Yii::$app->user->can('/member/block')
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update}',
                            ],
                        ],
                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
                    ]);
                    ?>
                    <!--<?//= Html::a("Xóa", "javascript:void(0)", ["class" => "btn_delete_multiple btn btn-danger"]) ?> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?= $this->registerJs('
    $(".btn_delete_multiple").click(function () {
        var keys = $("#girdCity").yiiGridView("getSelectedRows");
        if(keys==""){
            var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có muốn xóa các mẫu tin này không (s)");
        }
        if (msg == true) {
            if(keys!=""){
                var url = "' . Yii::$app->urlManager->createUrl(["bank/delete"]) . '";  
                window.location.href = url + "?id=" + keys;  
            }
        }
        return false;
    });
');?>
<?= $this->registerJs('$("[name=publish]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=publish]").on("switchChange.bootstrapSwitch", function(event, state) {
    var key = $(this).parent().parent().parent().parent("tr").attr("data-key");
    $.ajax({
        type: "POST", 
        url:"' . Yii::$app->urlManager->createUrl(["bank/publish"]) . '", 
        data: {id: key,state:state}, 
        success: function (data) {

        }, 
    });
});') ?>