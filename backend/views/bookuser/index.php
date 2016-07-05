<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\UserBid;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý book nhân viên';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ BOOK NHÂN VIÊN
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
                    <h2>Danh sách</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form>
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Nhập từ khóa</label><input type="text" class="form-control" name="key" value="<?= !empty($_GET['key']) ? $_GET['key'] : "" ?>"></div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Trạng thái</label>
                                <select class="form-control" name="status">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="<?= UserBid::STATUS_NOACCEPT ?>" <?= (!empty($_GET['status']) && ($_GET['status'] == UserBid::STATUS_NOACCEPT)) ? 'selected' : '' ?>>Chưa chấp nhận</option>
                                    <option value="<?= UserBid::STATUS_ACCEPT ?>" <?= (!empty($_GET['status']) && ($_GET['status'] == UserBid::STATUS_ACCEPT)) ? 'selected' : '' ?>>Đã chấp nhận</option>
                                    <option value="<?= UserBid::STATUS_CLOSE ?>" <?= (!empty($_GET['status']) && ($_GET['status'] == UserBid::STATUS_CLOSE)) ? 'selected' : '' ?>>Đã hủy bỏ</option>
                                    <option value="<?= UserBid::STATUS_PENDING ?>" <?= (!empty($_GET['status']) && ($_GET['status'] == UserBid::STATUS_PENDING)) ? 'selected' : '' ?>>Đang làm việc</option>
                                </select>
                            </div>
                                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label>Ngày đăng từ</label>
                                <div id="reportrange_right" class="form-control" style="line-height: 20px; cursor: pointer;">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                    <input id="datefrom" value="" type="hidden" name="datefrom">
                                    <input id="dateto" value="" type="hidden" name="dateto">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <button type="submit" class="btn btn-success" style="margin-top:23px">Lọc</button>
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['bookuser']) ?>" class="btn btn-primary" style="margin-top:23px">Reset</a>
                            </div>
                        </div>
                        <?php
                        Pjax::begin([
                            'id' => 'pjax_gridview_new',
                        ]);

                        $gridColumns = [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'multiple' => true,
                            ],
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'owner_id',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return Html::a($data->owner->name, ['boss/view', 'id' => $data->owner_id]);
                                }
                                    ],
                                    [
                                        'attribute' => 'actor_id',
                                        'format' => 'html',
                                        'value' => function ($data) {
                                            return Html::a($data->actor->name, ['member/view', 'id' => $data->actor_id]);
                                        }
                                            ],
                                            [
                                                'attribute' => 'created_at',
                                                'format' => 'html',
                                                'value' => function ($data) {
                                                    return date('d/m/Y', $data->created_at);
                                                }
                                            ],
                                            [
                                                'attribute' => 'status',
                                                'format' => 'raw',
                                                'value' => function ($data) {
                                                    $html = '<div class="col-md-4"><select class="form-control userbid-status" id="status-' . $data->id . '" data-id="' . $data->id . '">';
                                                    foreach ($data->dropstatus as $key => $status) {
                                                        if ($key == $data->status)
                                                            $selected = "selected";
                                                        else
                                                            $selected = "";
                                                        $html .= '<option ' . $selected . ' value="' . $key . '">' . $status . '</option>';
                                                    }
                                                    $html .= "</select></div>";
                                                    return $html;
                                                }
                                            ],
                                            ['class' => 'backend\components\columns\ActionColumn'],
                                        ];
                                        ?>
                                        <?=
                                        GridView::widget([
                                            'id' => 'girUserbook',
                                            'dataProvider' => $dataProvider,
                                            'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                                            'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                                            'columns' => $gridColumns,
                                            'tableOptions' => ['class' => 'table table-striped responsive-utilities jambo_table bulk_action'],
                                        ]);
                                        ?>
                                        <?php Pjax::end() ?> 
                                        <?php //  Html::a("Khóa tài khoản", "javascript:void(0)", ["class" => "btn_close_multiple btn btn-danger"]) ?> 
                                        <?php //  Html::a("Mở tài khoản", "javascript:void(0)", ["class" => "btn_open_multiple btn btn-success"])  ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->registerJs('
$(".userbid-status").on("change",function(){    
var id = $(this).attr("data-id");
var status = $("#status-"+id+" option:selected").val();
    $.ajax({
    url:"' . Yii::$app->urlManager->createUrl(["ajax/userbookstatus"]) . '",
   type:"POST",            
   data:{id:id,status:status},
   success:function(data){     
       }
      });
    });

'); ?>
