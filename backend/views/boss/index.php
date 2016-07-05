<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use yii\widgets\Menu;

//use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý boss';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ BOSS
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
                    <h2>Danh sách boss</h2>
                    <?php
                    echo Menu::widget([
                        'items' => [
                            ['label' => 'Thêm mới', 'template' => '<a href="{url}" class="btn-success">{label}</a>', 'url' => [ 'boss'], 'visible' => \Yii::$app->user->can('/boss/create')]
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

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Tài khoản</label>
                                <select class="form-control" name="status">
                                    <option value="">Chọn tài khoản</option>
                                    <option value="<?= User::STATUS_NOACTIVE ?>" <?= (!empty($_GET['status']) && ($_GET['status'] == User::STATUS_NOACTIVE)) ? 'selected' : '' ?>>Chưa kích hoạt</option>
                                    <option value="<?= User::STATUS_ACTIVE ?>" <?= (!empty($_GET['status']) && ($_GET['status'] == User::STATUS_ACTIVE)) ? 'selected' : '' ?>>Đã kích hoạt</option>
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
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <button type="submit" class="btn btn-success" style="margin-top:25px">Lọc</button>
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['boss']) ?>" class="btn btn-primary" style="margin-top:25px">Reset</a>
                            </div>
                        </div>
                    </form>

                    <?php
                    Pjax::begin([
                        'id' => 'pjax_gridview_boss',
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
//                                'headerOptions' => ['class' => 'sorting'],
                        ],
                        [
                            'attribute' => 'phone',
                            'format' => 'html',
                            'value' => function ($data) {
                                return $data->phone;
                            },
//                                'headerOptions' => ['class' => 'sorting'],
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
//                                'headerOptions' => ['class' => 'sorting'],
                        ],
                        [
                            'attribute' => 'Tài khoản',
                            'format' => 'raw',
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
                            'visible' => Yii::$app->user->can('/boss/block')
                        ],
                        ['class' => 'backend\components\columns\ActionColumn'],
                    ];
                    ?>

                    <?=
                    GridView::widget([
                        'id' => 'gridBoss',
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


');
?>

<?= $this->registerJs('$("[name=publish]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=publish]").on("switchChange.bootstrapSwitch", function(event, state) {
    var key = $(this).parent().parent().parent().parent("tr").attr("data-key");
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["boss/block"]) . '", data: {id: key,state:state}, success: function (data) {
   
            }, });
});
') ?>
