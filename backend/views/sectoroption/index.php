<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý yêu cầu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ YÊU CẦU
                <!-- <small>
                    Some examples to get you started
                </small> -->
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">

        <div class="col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách yêu cầu</h2>
                    <?php
                    echo Menu::widget([
                        'items' => [
                            ['label' => 'Danh sách đã xóa', 'template' => '<a href="{url}">{label}</a>', 'url' => [ 'trash'], 'visible' => \Yii::$app->user->can('/sectoroption/index')],
                            ['label' => 'Thêm mới', 'template' => '<a href="{url}" class="btn-success">{label}</a>', 'url' => [ 'create'], 'visible' => \Yii::$app->user->can('/sectoroption/create')]
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


                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><label>Danh mục</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">Chọn danh mục</option>
                                    <?php
                                    if (!empty($category))
                                    {
                                        foreach ($category as $value)
                                        {
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
                            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"><label>Lĩnh vực </label>
                                <select class="form-control" name="sector" id="sector">
                                    <option value="">Tất cả</option>
                                    <?php
                                    if (!empty($sector))
                                    {
                                        foreach ($sector as $value)
                                        {
                                            $select = '';
                                            if (($_GET["sector"] == $value->id))
                                            {
                                                $select = 'selected';
                                            }
                                            echo '<option value="' . $value->id . '" ' . $select . '>' . $value->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <button type="submit" class="btn btn-success" style="margin-top:25px">Lọc</button>
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['sectoroption']) ?>" class="btn btn-primary" style="margin-top:25px">Reset</a>
                            </div>
                        </div>
                    </form>
                    <?=
                    GridView::widget([
                        'id' => 'sectoroption',
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
                                'value' => function ($data)
                                {

                                    return $data->name . '<br><small>' . $data->sector->name . '</small>';
                                },
                            ],
                            [
                                'label' => 'Yêu cầu',
                                'format' => 'html',
                                'value' => function ($data)
                                {
                                    $options = $data->options;
                                    $html = '';
                                    if (!empty($options))
                                    {
                                        foreach ($options as $value)
                                        {
                                            $html .= $value . '<br>';
                                        }
                                    }
                                    return $html;
                                },
                            ],
                            [
                                'class' => 'backend\components\columns\ActionColumn',
                                'template' => '{update} {delete}',
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
    var keys = $("#sectoroption").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có muốn xóa các mẫu tin này không (s)");
        }
     if (msg == true) {
     if(keys!=""){
      var url = "' . Yii::$app->urlManager->createUrl(["sectoroption/delete"]) . '";  
         window.location.href = url + "/?id=" + keys;  
         }
    }
    return false;
});
');
?>
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
                html += "<option>Chuyên mục này chưa có</option>";
            }
            $("#sector").html(html);
        } 
    });
});
');
?>
