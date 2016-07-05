<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý nhân viên';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ NHÂN VIÊN
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
                    <h2>Danh sách nhân viên</h2>
                    <?php
                    echo Menu::widget([
                        'items' => [
                            ['label' => 'Thêm mới', 'template' => '<a href="{url}" class="btn-success">{label}</a>', 'url' => [ 'create'], 'visible' => \Yii::$app->user->can('/member/create')]
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
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Cấp bậc</label>
                                <select class="form-control" name="level">
                                    <option value="">Chọn cấp độ</option>
                                    <?php
                                    if (!empty($level)) {
                                        foreach ($level as $value) {
                                            if (!empty($_GET['level']) && ($_GET['level'] == $value->id))
                                                $sel = 'selected';
                                            else
                                                $sel = '';
                                            echo '<option ' . $sel . ' value="' . $value->id . '">' . $value->name . '</option>';
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Tài khoản</label>
                                <select class="form-control" name="status">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="<?= User::STATUS_NOACTIVE ?>" <?= (!empty($_GET['status']) && ($_GET['status'] == User::STATUS_NOACTIVE)) ? 'selected' : '' ?>>Chưa kích hoạt</option>
                                    <option value="<?= User::STATUS_ACTIVE ?>" <?= (!empty($_GET['status']) && ($_GET['status'] == User::STATUS_ACTIVE)) ? 'selected' : '' ?>>Đã kích hoạt</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Ngành nghề</label>
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
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Lĩnh vực </label>
                                <select class="form-control" id="sector" name="sector">
                                    <?php
                                    if (!empty($sector)) {
                                        foreach ($sector as $value) {
                                            if (!empty($_GET['sector']) && ($_GET['sector'] == $value->id))
                                                $sel = 'selected';
                                            else
                                                $sel = '';
                                            echo '<option ' . $sel . ' value="' . $value->id . '">' . $value->name . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">Chọn lĩnh vực</option>';
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Tỉnh thành </label>
                                <select class="form-control" name="city">
                                    <option value="">Chọn tỉnh/thành</option>
                                    <?php
                                    if (!empty($city)) {
                                        foreach ($city as $value) {
                                            if (!empty($_GET['city']) && ($_GET['city'] == $value->id))
                                                $sel = 'selected';
                                            else
                                                $sel = '';
                                            echo '<option ' . $sel . ' value="' . $value->id . '">' . $value->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <button type="submit" class="btn btn-success pull-right" style="margin-top:10px">Lọc</button>
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['member']) ?>" class="btn btn-primary pull-right" style="margin-top:10px">Reset</a>
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
                                'attribute' => 'avatar',
                                'format' => 'html',
                                'value' => function ($data) {
                                    if (!empty($data->avatar))
                                        $avatar = '60-' . $data->avatar;
                                    else
                                        $avatar = 'avatar.png';
                                    return '<img width=35 src="' . Yii::$app->params['url_file'] . 'thumbnails/' . $avatar . '">';
                                }
                            ],
                            [
                                'attribute' => 'name',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return $data->name . '<br><small>' . $data->email . '</small>';
                                },
                                'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'attribute' => 'phone',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return $data->phone;
                                },
                                'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'attribute' => 'category',
                                'format' => 'html',
                                'value' => function ($data) {
                                    $sector = $data->getSector($data->sector);
                                    $cat = $data->findcategory;
                                    return $cat['name'] . '<br><small>' . $sector['name'] . '</small>';
                                },
                                'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'attribute' => 'address',
                                'format' => 'html',
                                'value' => function ($data) {
                                    if ($data->city)
                                        $address = $data->address . '<br><small>' . $data->location->name . ', ' . $data->location->city->name . '</small>';
                                    else
                                        $address = 'Chua cap nhap';
                                    return $address;
                                },
                                'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'attribute' => 'level',
                                'value' => function ($data) {
                                    $level = $data->findlevel;
                                    return $level['name'];
                                },
                                'headerOptions' => ['class' => 'sorting'],
                            ],
                            [
                                'attribute' => 'Tài khoản',
                                'value' => function ($data) {
                                    switch ($data->status) {
                                        case User::STATUS_NOACTIVE:
                                            $status = 'Chưa kích hoạt';
                                            break;
                                        case User::STATUS_ACTIVE:
                                            $status = 'Đã kích hoạt';
                                            break;
                                    }
                                    return $status;
                                }
                            ],
                            [
                                'attribute' => 'Trạng thái',
                                'value' => function ($data) {
                                    return $data->step == 5 ? "Đã duyệt" : "Chưa duyệt";
                                }
                            ],
                            [
                                'attribute' => 'Hiển thị',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->publish == User::PUBLISH_ACTIVE)
                                        $check = 'checked';
                                    else
                                        $check = '';
                                    return '<input type="checkbox" id="checkstatus" name="publish" ' . $check . '>';
                                },
                                'visible' => Yii::$app->user->can('/member/block')
                            ],
                            ['class' => 'backend\components\columns\ActionColumn'],
                        ];
                        ?>
                        <?=
                        GridView::widget([
                            'id' => 'girdMember',
                            'dataProvider' => $dataProvider,
                            'summary' => "<p>Hiển thị {begin} đến {end} trong tổng số {count} mục</p>",
                            'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                            'columns' => $gridColumns,
//                        'options' => ['class' => 'grid-view gridview-newclass'],
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
$("#category").on("change",function(){    
 $.ajax({
   url:"' . Yii::$app->urlManager->createUrl(["member/sector"]) . '",
   type:"POST",            
   data:"id="+$("#category option:selected").val(),
   dataType:"json",
   success:function(data){     
         if(data){
         var html;
         for (index = 0; index < data.length; ++index) {
        
         html += "<option value="+data[index].id+">"+data[index].name+"</option>";
}    
         } else{
              html = "<option>Chuyên mục này chưa có</option>";
         }
               $("#sector").html(html);
       } 
      });
    });
//    $(".btn_close_multiple").click(function () {
//    var keys = $("#girdMember").yiiGridView("getSelectedRows");
//      if(keys==""){
//        var msg = confirm("Bạn chưa chọn mục tin nào");
//        } else {
//            var msg = confirm("Bạn có chắc chắn muốn mở các tài khoản này không (s)");
//        }
//    if (msg == true) {
//        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["member/closeall"]) . '", data: {ids: keys}, success: function (data) {
//            if(data=="ok"){
//          window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
//              }
//            }, });
//    }
//    return false;
//});
//    $(".btn_open_multiple").click(function () {
//    var keys = $("#girdMember").yiiGridView("getSelectedRows");
//      if(keys==""){
//        var msg = confirm("Bạn chưa chọn mục tin nào");
//        } else {
//            var msg = confirm("Bạn có chắc chắn muốn mở các tài khoản này không (s)");
//        }
//    if (msg == true) {
//        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["member/openall"]) . '", data: {ids: keys}, success: function (data) {
//            if(data=="ok"){
//          window.location.href = "' . $_SERVER['REQUEST_URI'] . '";        
//              }
//            }, });
//    }
//    return false;
//});
');
?>
<?= $this->registerJs('$("[name=publish]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=publish]").on("switchChange.bootstrapSwitch", function(event, state) {
    var key = $(this).parent().parent().parent().parent("tr").attr("data-key");
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["member/block"]) . '", data: {id: key,state:state}, success: function (data) {
            }, });
});
') ?>
