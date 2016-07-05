<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use common\models\BudgetPacket;
use common\models\BudgetPrice;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý gói';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ GÓI
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
                                        'label' => 'col-sm-2',
                                        'offset' => 'col-sm-offset-4',
                                        'wrapper' => ' col-md-10 col-sm-10 col-xs-12',
                                        'error' => '',
                                        'hint' => '',
                                    ],
                                ],
                    ]);
                    echo $this->render('_form', ['form' => $form, 'model' => $model]);
                    ?>  
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-3 col-sm-6 col-xs-12">
                            <?= Html::submitButton('Thêm mới', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách gói</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <?=
                    GridView::widget([
                        'id' => 'girdBudgetpacket',
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
                                'attribute' => 'category_id',
                                'format' => 'raw',
                                'value' => function($data)
                                {
                                    return $data->category->name;
                                }
                            ],
                            [
                                'attribute' => 'sectors',
                                'format' => 'raw',
                                'value' => function($data)
                                {
                                    $html = '';
                                    foreach ($data->sectors as $value)
                                    {
                                        $sector = $data->getSector($value);
                                        $html .= '- ' . $sector['name'] . '<br>';
                                    }
                                    return $html;
                                }
                            ],
                            [
                                'attribute' => 'options',
                                'format' => 'raw',
                                'value' => function($data)
                                {
                                    $html = '';
                                    foreach ($data->options as $key => $value)
                                    {
                                        $html .= number_format($value['min'], 0, '', '.') . ' - ' . number_format($value['max'], 0, '', '.') . '<br>';
                                    }
                                    return $html;
                                }
                            ],
                            [
                                'attribute' => 'publish',
                                'format' => 'raw',
                                'value' => function ($data)
                                {
                                    if ($data->publish == BudgetPacket::PUBLISH_ACTIVE)
                                        $check = 'checked';
                                    else
                                        $check = '';
                                    return '<input type="checkbox" id="checkstatus" name="publish" ' . $check . '>';
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
    var keys = $("#girdBudgetpacket").yiiGridView("getSelectedRows");
        if(keys==""){
        var msg = confirm("Bạn chưa chọn mục tin nào");
        } else {
            var msg = confirm("Bạn có chắc chắn muốn xóa các mẫu tin này không (s)");
        }
      if (msg == true) {
     if(keys!=""){
      var url = "' . Yii::$app->urlManager->createUrl(["budgetpacket/delete"]) . '";  
         window.location.href = url + "/?id=" + keys;  
         }
    }
    return false;
});
');
?>

<?= $this->registerJs('
$("#budgetpacket-category_id").on("change",function(){    
    $.ajax({
        url:"' . Yii::$app->urlManager->createUrl(["job/sector"]) . '",
        type:"POST",            
        data:"id="+$("#budgetpacket-category_id option:selected").val(),
        dataType:"json",
        success:function(data){     
            if(data){
                var html = "<option>Chọn chuyên mục</option>";
                for (index = 0; index < data.length; ++index) {
                    html += "<option value="+data[index].id+">"+data[index].name+"</option>";
                }    
            } else{
                html = "<option>Chuyên mục này chưa có</option>";
            }
            $("#budgetpacket-sectors").html(html);
        }
    });
});'); ?>
<?= $this->registerJs('
     $(document).on("click",".addrow", function (event){
    var num = parseInt($("#num").val())+1;
    var order = num +1;
    var html ="<div class=\"row\" style=\"margin-bottom:15px\" id=row-"+num+">";
        html+="<div class=\"col-md-2 col-sm-1 col-xs-2 order\"><input type=\"text\" id=order-"+order+" class=\"form-control col-md-5\" name=order["+num+"] value="+order+"></div>";
        html+="<div class=\"col-md-4 col-sm-4 col-xs-12 min\"><input type=\"text\" class=\"form-control col-md-5\" name=min["+num+"] placeholder=\"Giá nhỏ nhất\"></div>";
        html+="<div class=\"col-md-4 col-sm-4 col-xs-12 max\"><input type=text class=\"form-control col-md-5\" name=max["+num+"] placeholder=\"Giá cao nhất\"></div>";
        html+="<div class=\"col-md-2 col-sm-2 col-xs-12\"><a href=\"javascript:void(0)\" class=\"delrow\" data="+num+">Xóa</a></div>";
        html+="</div>";
    $("#num").val(num);
    $(".packets").append(html);
    return false;
});

  $(document).on("click",".delrow", function (event){
    var row = $(this).attr("data");
    $("#row-"+row).remove();
    var num = $("#num").val();
    var max = parseInt(num)-1;
    $("#row-"+num+" .min input").attr("name", "min["+row+"]");
    $("#row-"+num+" .max input").attr("name", "max["+row+"]");
    $("#row-"+num+" .order input").attr("name", "order["+row+"]");
    $("#row-"+num+" div a").attr("data", row);
    if(max != 0){
        if(row != num){
     document.getElementById("row-"+num).setAttribute("id", "row-"+row);
     }
    }
    $("#num").val(max);
    return false;
});
');
?>
<?= $this->registerJs('$("[name=publish]").bootstrapSwitch({onText:"&nbsp;",offText:"&nbsp;",onColor:"default",offColor:"default"});') ?>
<?= $this->registerJs('
$("input[name=publish]").on("switchChange.bootstrapSwitch", function(event, state) {
    var key = $(this).parent().parent().parent().parent("tr").attr("data-key");
        $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["budgetpacket/status"]) . '", data: {id: key,state:state}, success: function (data) {
            }, });
});
') ?>
