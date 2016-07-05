<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý cấp độ nhân viên';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ CẤP ĐỘ NHÂN VIÊN
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thêm mới</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    $form = ActiveForm::begin([
                                'layout' => 'horizontal',
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
                    <?=
                    $this->render('_form', [
                        'model' => $model,
                        'form' => $form,
                        'action' => 'index'
                    ])
                    ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách cấp độ nhân viên</h2>

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
                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
                            [
                                'label' => 'Mô tả',
                                'format' => 'html',
                                'value' => function ($data)
                                {
                                    $html = '';
                                    if (!empty($data->review))
                                    {
                                        $html .= 'Công việc hoàn thành: ' . $data->count_job . '<br>';
                                        $html .= 'Số review: ' . $data->review . '<br>';
                                        $html .= 'Điểm trung bình: ' . $data->rating . '<br>';
                                        $html .= 'Số lượng bid: ' . $data->rating;
                                    }

                                    return $html;
                                },
                            ],
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
      var url = "' . Yii::$app->urlManager->createUrl(["city/delete"]) . '";  
         window.location.href = url + "/?id=" + keys;  
         }
    }
    return false;
});
');
?>