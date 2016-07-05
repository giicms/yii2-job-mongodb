<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\City */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'region')->textInput() ?>
<div class="form-group">
    <label class="<?= !empty($action) ? "col-md-4" : "col-md-3 col-sm-3" ?> control-label">Các quận/huyện</label>
    <div class="<?= !empty($action) ? "col-md-8 col-sm-8" : "col-md-6 col-sm-6" ?> col-xs-12">
        <div class="districts">
            <?php
            for ($i = 0; $i <= $num; $i ++) {
                ?>
                <div id="district-<?= $i ?>" class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php
                        if (empty($action)) {
                            ?>
                            <input type="hidden" name="district_id[<?= $i ?>]" value="<?= !empty($district[$i]->id) ? $district[$i]->id : "" ?>">
                            <?php
                        }
                        ?>
                        <input type="text" class="form-control" name="district[<?= $i ?>]" value="<?= !empty($district[$i]->name) ? $district[$i]->name : "" ?>">
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <input type="hidden" name="num" id="num" value="<?= $num ?>">
        <div class="pull-right"><a href="javascript:void(0)" class="addrow">Thêm quận/huyện</a></div>
    </div>
</div>
<div class="form-group">
    <div class="<?= !empty($action) ? "col-md-offset-4 col-md-4" : "col-md-offset-3 col-md-3" ?>">
        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
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
$this->registerCss('
        .districts input{
        margin-bottom: 20px;
    }
        ')?>