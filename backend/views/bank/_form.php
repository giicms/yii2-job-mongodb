<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\City */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'name')->textInput() ?>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'code')->textInput(['class'=>'form-control ']) ?>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?= $form->field($model, 'city')->dropDownList($model->cityList, ['prompt' => 'Chọn địa điểm', 'class'=> 'form-control citylist', 'multiple' => 'multiple']) ?>  
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?= $this->registerJs('
     $(document).on("click",".addrow", function (event){
    var num = parseInt($("#num").val())+1;
    $("#num").val(num);
    $(".districts").append("<div id=district-"+num+" class=\"row\"><div class=\"col-md-10 col-sm-10 col-xs-10\"><input type=\"text\" class=\"form-control col-md-10 col-sm-10 col-xs-10\" name=district["+num+"]></div><div class=\"col-md-2 col-sm-2 col-xs-2\"> <a href=\"javascript:void(0)\" class=\"delrow\" data="+num+">Xóa</a></div>");
    return false;
});

  $(document).on("click",".delrow", function (event){
    var row = $(this).attr("data");
    $("#district-"+row).remove();
    var num = $("#num").val();
    var max = parseInt(num)-1;
    $("#num").val(max);
    return false;
});
');
?>

<?=
$this->registerJs('   
$(".citylist").select2({
    maximumSelectionLength: 4,
    placeholder: "With Max Selection limit 4",
    allowClear: true
}); 
');
?>
