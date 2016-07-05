<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý bài test';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ BÀI TEST
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
                    <h2>Danh sách bài test</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['test/create']) ?>" class="btn btn-success">Thêm mới</a> </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form>
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12"><label>Lọc theo</label></div>
                            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12">
                                <select class="form-control" name="category" id ="category">
                                    <option value="">Chọn ngành nghề</option>
                                    <?php
                                    if (!empty($category)) {
                                        foreach ($category as $value) {
                                            if (!empty($_GET['category']) && ($_GET['category'] == $value->id))
                                                $sel = 'selected';
                                            else
                                                $sel = '';
                                            echo '<option ' . $sel . ' value="' . $value->id . '">' . $value->name . '</option>';
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <button type="submit" class="btn btn-success">Lọc</button>
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['member']) ?>" class="btn btn-primary">Reset</a>
                            </div>
                        </div>

                    </form>
                    <?= Html::a("Xóa", "javascript:void(0)", ["class" => "btn_delete_multiple btn btn-danger"]) ?>
                    <?=
                    GridView::widget([
                        'id' => 'girdTest',
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
                                'format' => 'html',
                                'value' => function($data) {
                                    return $data->name;
                                }
                            ],
                            [
                                'attribute' => 'questions',
                                'format' => 'html',
                                'value' => function ($data) {
                                    $arr = [];
                                    if (!empty($data->questions)) {
                                        foreach ($data->questions as $key => $value) {
                                            $arr[] = $key . '. ' . $value;
                                        }
                                    }
                                    return implode('<br> ', $arr);
                                },
                                    ],
                                    'answers',
                                    [
                                        'attribute' => 'sector_id',
                                        'format' => 'html',
                                        'value' => function ($data) {
                                            $arr = [];
                                            if (!empty($data->sector)) {
                                                foreach ($data->sector as $key => $value) {
                                                    $arr[] = '- ' . $value;
                                                }
                                            }
                                            return implode('<br> ', $arr);
                                        },
                                            ],
                                            ['class' => 'backend\components\columns\ActionColumn',
                                                'template' => '{update}{delete}',
                                            ],
                                        ],
                                        'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
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
    var keys = $("#girdTest").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn xóa các mẫu tin này không (s)");
        }
    if (msg == true) {
      if(keys!=""){
            $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["test/deleteall"]) . '", data: {ids: keys}, success: function (data) {
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
