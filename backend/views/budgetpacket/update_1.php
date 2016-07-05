<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\BudgetPrice;

/* @var $this yii\web\View */
/* @var $model common\models\Skills */

$this->title = 'Cập nhật gói';
$this->params['breadcrumbs'][] = ['label' => 'Quản lý gói', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $this->title ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <?php
                    $form = ActiveForm::begin([
                                'layout' => 'horizontal',
                                'fieldConfig' => [
                                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                    'horizontalCssClasses' => [
                                        'label' => 'col-sm-3',
                                        'offset' => 'col-sm-offset-3',
                                        'wrapper' => ' col-md-6 col-sm-9 col-xs-12',
                                        'error' => '',
                                        'hint' => '',
                                    ],
                                ],
                    ]);
                    ?>  
                    <?= $form->field($model, 'category_id')->dropDownList($model->categories, ['prompt' => 'Chọn danh mục']) ?>
                    <?php echo $form->field($model, 'sector_id')->dropDownList($model->sectorList, ['prompt' => 'Chọn chuyên mục']); ?>     
                    <?= $form->field($model, 'description')->textarea() ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Các gói</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                            <div class="packets">
                                <div class="row" style="margin-bottom:15px">
                                    <div class="col-md-1 col-sm-1 col-xs-2">
                                        STT
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-4 min">
                                        Giá nhỏ nhất
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-4 max">
                                        Giá lớn nhất
                                    </div>

                                </div>
                                <?php
                                $null = [];
                                for ($i = 0; $i <= $num; $i ++) {
                                    ?>

                                    <div class="row" style="margin-bottom:15px" id="row-<?= $i ?>">
                                        <div class="col-md-1 col-sm-1 col-xs-2 order">
                                            <input type="text" class="form-control col-md-2" name="order[<?= $i ?>]" value="<?= !empty($get[$i]['order']) ? $get[$i]['order'] : $model->budgetPrice[$i]->order ?>">
                                        </div>
                                        <div class="col-md-5 col-sm-5 col-xs-4 min">
                                            <input type="text" class="form-control col-md-4" name="min[<?= $i ?>]" placeholder="Giá nhỏ nhất" value="<?= !empty($model->budgetPrice[$i]->min) ? $model->budgetPrice[$i]->min : "" ?>">
                                        </div>
                                        <div class="col-md-5 col-sm-5 col-xs-4 max">
                                            <input type="text" class="form-control col-md-4" name="max[<?= $i ?>] " placeholder="Giá cao nhất" value="<?= !empty($model->budgetPrice[$i]->max) ? $model->budgetPrice[$i]->max : "" ?>">
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-2">
                                            <?php
                                            if (!empty($model->budgetPrice[$i]->id)) {
                                                ?>
                                                <input type="checkbox" name="publish[<?= $i ?>]" <?= (!empty($model->budgetPrice[$i]->publish) && $model->budgetPrice[$i]->publish == BudgetPrice::PUBLISH_ACTIVE) ? "checked" : "" ?>>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="javascript:void(0)" class="delrow" data="<?= $i ?>">Xóa</a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="budgetprice"><input type="hidden" name="budgetprice_id[<?= $i ?>]" value="<?= !empty($model->budgetPrice[$i]->id) ? $model->budgetPrice[$i]->id : "" ?>"></div>
                                    </div>
                                    <?php
                                    if (!empty($error)) {
                                        if (empty($get[$i]['order']) or empty($get[$i]['min']) or empty($get[$i]['max']))
                                            $null[] = $i;
                                    }
                                }
                                ?>
                            </div>
                            <?php
                            if (!empty($error)) {
                                if (!empty($null))
                                    echo "<p class='help-block help-block-error red'>Giá trị nhỏ, lớn nhất hoặc stt không được rỗng</p>";

                                if (!empty($order_error))
                                    echo "<p class='help-block help-block-error red'>Số thứ tự chưa chính xác</p>";
                            }
                            ?>
                            <div class="pull-right"><a href="javascript:void(0)" class="addrow">Thêm mới</a></div>
                            <input type="hidden" id="num" name="num" value="<?= $num ?>">

                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-6 col-sm-9 col-xs-12">
                            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
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
            $("#budgetpacket-sector_id").html(html);
        }
    });
});'); ?>
<?= $this->registerJs('
    $(".addrow").click(function () {
    var num = parseInt($("#num").val())+1;
    var order = num +1;
    var html ="<div class=\"row\" style=\"margin-bottom:15px\" id=row-"+num+">";
        html+="<div class=\"col-md-1 col-sm-2 col-xs-2 order\"><input type=\"text\" id=order-"+order+" class=\"form-control col-md-5\" name=order["+num+"] value="+order+"></div>";
        html+="<div class=\"col-md-5 col-sm-4 col-xs-4 min\"><input type=\"text\" class=\"form-control col-md-5\" name=min["+num+"] placeholder=\"Giá nhỏ nhất\"></div>";
        html+="<div class=\"col-md-5 col-sm-4 col-xs-4 max\"><input type=text class=\"form-control col-md-5\" name=max["+num+"] placeholder=\"Giá cao nhất\"></div>";
        html+="<div class=\"col-md-1 col-sm-2 col-xs-2\"><a href=\"javascript:void(0)\" class=\"delrow\" data="+num+">Xóa</a></div>";
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