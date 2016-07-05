<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Posts;
use yii\widgets\Menu;
use backend\components\widgets\ActionWidget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý nội dung';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ NHẬN XÉT CỦA KHÁCH HÀNG
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

                <div class="x_content">
                    <?=
                    $this->render('_form', [
                        'id' => $id,
                        'new' => $new
                    ])
                    ?>

                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách nhận xét của khách hàng</h2>
                    <?php
                    echo Menu::widget([
                        'items' => [
                            ['label' => 'Thêm mới', 'template' => '<a href="{url}" class="btn-success">{label}</a>', 'url' => ['create'], 'visible' => \Yii::$app->user->can('/post/index')],
                        ],
                        'options' => ['class' => 'nav navbar-right panel_toolbox'],
                    ]);
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php
                    Pjax::begin([
                        'id' => 'pjax_gridview_post',
                    ])
                    ?>
                    <?=
                    GridView::widget([
                        'id' => 'girdPost',
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
                                'attribute' => 'Hình ảnh',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return '<image width="80" src="'.$data->thumbnail.'">';
                                }
                            ],
                            [
                                'attribute' => 'Khách hàng',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return '<p>'.$data->name.'</p><p><i class="fa fa-map-marker"></i> '.$data->description.'</p>';
                                }
                            ],
                            [
                                'attribute' => 'publish',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->publish == Posts::STATUS_ACTIVE)
                                        $check = 'checked';
                                    else
                                        $check = '';
                                    return '<input type="checkbox" id="checkstatus" name="publish" ' . $check . '>';
                                }
                            ],
                            [
                                'attribute' => 'created_at',
                                'value' => function ($data) {
                                    return date('H:i d/m/Y', $data->created_at);
                                }
                            ],
                            ['class' => 'backend\components\columns\ActionColumn'],
                        ],
                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
                    ]);
                    ?>
                    <?php Pjax::end() ?> 
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('
    $(".btn_delete_multiple").click(function () {
    var keys = $("#girdPost").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn hiển thị hình này không (s)");
        }
     if (msg == true) {
     if(keys!=""){
      var url = "' . Yii::$app->urlManager->createUrl(["post/delete"]) . '";  
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
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["post/status"]) . '", data: {id: key,state:state}, success: function (data) {
            }, });
});
') ?>
