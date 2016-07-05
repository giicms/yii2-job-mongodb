<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use common\models\Category;
use common\models\Sectors;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý danh mục công việc';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ DANH MỤC CÔNG VIỆC
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
                    <h2>Danh sách danh mục công việc</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>     
                        <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['jobcategory/create']) ?>" class="btn btn-success">Thêm mới</a> </li>
                        </li>
                    </ul>
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
                                'label' => 'Tên danh mục',
                            ],
                            [

                                'attribute' => 'sector',
                                'label' => 'Tên lĩnh vực',
                            ],
                            [
                                'attribute' => 'test_number',
                                'label' => 'Số câu cho bài test (câu)',
                            ],
                  
                            [
                                'attribute' => 'test_time',
                                'label' => 'Thời gian cho bài test (phút)',
                            ],
                            [
                                'label' => 'Thêm lĩnh vực',
                                'format' => 'raw',
                                'value' => function($data) {
                                    if ($data['create_sector'] == 1)
                                        $link = Html::a('<span class="fa fa-plus-square fa-lg"></span>', ['jobcategory/create', 'id' => $data['id']]);
                                    else
                                        $link = '';
                                    return $link;
                                }
                                    ],
                                    [
                                        'attribute' => 'publish',
                                        'label' => 'Trạng thái',
                                        'format' => 'raw',
                                        'value' => function($data) {
                                            if ($data['publish'] == Category::STATUS_ACTIVE)
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

                            <?php
                            if (\Yii::$app->user->can('/jobcategory/delete')) {
                                ?>
                                <?= Html::a("Xóa", "javascript:void(0)", ["class" => "btn_delete_multiple btn btn-danger"]) ?> 
                            <?php } ?>
                            <?php
                            if (\Yii::$app->user->can('/jobcategory/status')) {
                                ?>
                                <?= Html::a("Không hiển thị", "javascript:void(0)", ["class" => "btn_action_multiple btn btn-primary", "data" => "close"]) ?> 
                                <?= Html::a("Hiển thị", "javascript:void(0)", ["class" => "btn_action_multiple btn btn-success", "data" => "open"]) ?> 
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->registerJs('
    //$("tr td ul").hide();
    $(".btn_action_multiple").click(function () {
    var keys = $("#girdCategory").yiiGridView("getSelectedRows");
    var act = $(this).attr("data");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn khóa các danh mục này không (s)");
        }
       if (msg == true) {
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["jobcategory/status"]) . '", data:{ids:keys,act:act}, success: function (data) {
            if(data=="ok"){
          window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
              }
            }, });
    }
    return false;
});
    $(".btn_open_multiple").click(function () {
      var keys = $("#girdCategory").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn hiện thị các danh mục này không (s)");
        }
    if (msg == true) {
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["jobcategory/status?act=1"]) . '", data: keys, success: function (data) {
            if(data=="ok"){
          window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
              }
            }, });
    }
    return false;
});
    $(".btn_delete_multiple").click(function () {
           var keys = $("#girdCategory").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn xóa các mẫu tin này không (s)");
        }
    if (msg == true) {
     if(keys!=""){
      var url = "' . Yii::$app->urlManager->createUrl(["jobcategory/delete"]) . '";  
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
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["jobcategory/status"]) . '", data: {id: key,state:state}, success: function (data) {
            }});
});
') ?>

        <!-- when checked category item, sector checked too-->
        <?=
        $this->registerJs('
    $(".cateall").change(function () {
        var cat = $(this).attr("data");
        $(".cate"+cat).prop("checked", $(this).prop("checked")); 
    });
')?>