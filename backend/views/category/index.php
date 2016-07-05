<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use common\models\BlogCategory;
use yii\bootstrap\Nav;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý danh mục';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ DANH MỤC
                <!-- <small>
                    Some examples to get you started
                </small> -->
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
                                        'label' => 'col-sm-3',
                                        'offset' => 'col-sm-offset-3',
                                        'wrapper' => ' col-md-9 col-sm-9 col-xs-12',
                                        'error' => '',
                                        'hint' => '',
                                    ],
                                ],
                    ]);
                    ?>  
                    <?=
                    $this->render('_form', [
                        'model' => $new,
                        'form' => $form
                    ])
                    ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách danh mục</h2>        
             
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?=
                    GridView::widget([
                        'id' => 'girdCategory',
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
                                'attribute' => 'name',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return $data->getIndent($data->level) . $data->name;
                                }
                            ],
                            [
                                'attribute' => 'icon',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return $data->icon;
                                }
                            ],
                            [
                                'attribute' => 'description',
                                'label' => 'Mô tả',
                            ],
                            [
                                'attribute' => 'publish',
                                'label' => 'Trạng thái',
                                'format' => 'raw',
                                'value' => function($data) {
                                    if ($data['publish'] == BlogCategory::STATUS_ACTIVE)
                                        $check = 'checked';
                                    else
                                        $check = '';
                                    return '<input type="checkbox" name="publish" ' . $check . '>';
                                }
                            ],
                            ['class' => 'backend\components\columns\ActionColumn'],
                        ],
                        'tableOptions' => [ 'class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
                    ]);
                    ?>


                    <?= Html::a("Xóa", "javascript:void(0)", ["class" => "btn_delete_multiple btn btn-danger"]) ?> 
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('
    $(".btn_delete_multiple").click(function () {
           var keys = $("#girdCategory").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn xóa các mẫu tin này không (s)");
        }
    if (msg == true) {
     if(keys!=""){
      var url = "' . Yii::$app->urlManager->createUrl(["category/delete"]) . '";  
         window.location.href = url + "/?id=" + keys;  
         }
    }
    return false;
});

');
?>
<?= $this->registerJs('$("[name=publish]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=publish]").on("switchChange.bootstrapSwitch", function(event, state) {
    var key = $(this).parent().parent().parent().parent("tr").attr("data-key");
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["category/status"]) . '", data: {id: key,state:state}, success: function (data) {
            }, });
});
') ?>
