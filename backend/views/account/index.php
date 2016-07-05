<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Account;
use yii\widgets\Menu;
use backend\components\widgets\ActionWidget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ ACCOUNT
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
                    <h2>Danh sách account</h2>
                    <?php
                    echo Menu::widget([
                        'items' => [
                            ['label' => 'Thêm mới', 'template' => '<a href="{url}" class="btn-success">{label}</a>', 'url' => [ 'create'], 'visible' => \Yii::$app->user->can('/account/create')]
                        ],
                        'options' => [ 'class' => 'nav navbar-right panel_toolbox'],
                    ]);
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form>
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Nhập từ khóa</label><input type="text" class="form-control" name="key" value="<?= !empty($_GET['key']) ? $_GET['key'] : "" ?>"></div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Trạng thái</label>
                                <select class="form-control" name="status">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="<?= Account::STATUS_ACTIVE ?>" <?= (!empty($_GET['status']) && ($_GET['status'] == User::STATUS_ACTIVE)) ? 'selected' : '' ?>>Chưa kích hoạt</option>
                                    <option value="<?= Account::STATUS_BLOCK ?>" <?= (!empty($_GET['status']) && ($_GET['status'] == User::STATUS_BLOCK)) ? 'selected' : '' ?>>Đã kích hoạt</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <button type="submit" class="btn btn-success" style="margin-top:25px">Lọc</button>
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['account']) ?>" class="btn btn-primary" style="margin-top:25px">Reset</a>
                            </div>
                        </div>
                    </form>
                    <?= Html::a("Xóa", "javascript:void(0)", ["class" => "btn_delete_multiple btn btn-danger"]) ?> 
                    <?php
                    Pjax::begin([
                        'id' => 'pjax_gridview_account',
                    ])
                    ?>

                    <?=
                    GridView::widget([
                        'id' => 'girdAccount',
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
                                'attribute' => 'avatar',
                                'format' => 'html',
                                'value' => function ($data) {
                                    if (!empty($data->avatar))
                                        $avatar = $data->avatar;
                                    else
                                        $avatar = Yii::$app->params['url_file'] . 'thumbnails/avatar.png';
                                    return '<img width=35 src="' . $avatar . '">';
                                }
                            ],
                            'name',
                            'username',
                            'email',
                            'phone',
                            'address',
                            'role',
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->status == Account::STATUS_ACTIVE)
                                        $check = 'checked';
                                    else
                                        $check = '';
                                    return '<input type="checkbox" id="checkstatus" name="publish" ' . $check . '>';
                                }
                            ],
                            [
                                'attribute' => 'created_at',
                                'value' => function ($data) {
                                    return date('d/m/Y', $data->created_at);
                                }
                            ],
                            ['class' => 'backend\components\columns\ActionColumn'
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
    <?= $this->registerJs('
    $(".btn_delete_multiple").click(function () {
    var keys = $("#girdAccount").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn mở các mẫu tin này không (s)");
        }
if (msg == true) {
     if(keys!=""){
      var url = "' . Yii::$app->urlManager->createUrl(["account/delete"]) . '";  
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
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["account/status"]) . '", data: {id: key,state:state}, success: function (data) {
            }, });
});
') ?>
