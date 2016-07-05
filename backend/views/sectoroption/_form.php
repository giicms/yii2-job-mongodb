<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\City */
/* @var $form yii\widgets\ActiveForm */
?>
<?= $form->field($model, 'name')->textInput() ?>
<?php
echo $form->field($model, 'options')->dropDownList($model->options, ['multiple' => TRUE]);
?>
<?php
echo $form->field($model, 'type')->dropDownList(['1' => 'Radio', '2' => 'Checkbox']);
?>
<div class="form-group">
    <div class="<?= !empty($action) ? "col-md-offset-4 col-md-4" : "col-md-offset-3 col-md-3" ?>">
        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?= $this->registerJs('

  $(document).on("click",".delrow", function (event){
    var row = $(this).attr("data");
    $("#options-"+row).remove();
    var num = $("#num").val();
    var max = parseInt(num)-1;
    $("#num").val(max);
    return false;
});
');
?>
<?=
$this->registerJs('
$("#sectoroptions-options").select2({
  tags: true,
  tokenSeparators: [","]
})
');
?>
<?= $this->registerJs('
$("#sectoroptions-category_id").on("change",function(){    
    $.ajax({
    url:"' . Yii::$app->urlManager->createUrl(["ajax/sector"]) . '",
   type:"POST",            
   data:"id="+$("#sectoroptions-category_id option:selected").val(),
   dataType:"json",
   success:function(data){     
   $(".field-sectoroptions-sectors .select2-selection__choice").remove();
         if(data){
         var html="";
         for (index = 0; index < data.length; ++index) {
         
         html += "<option value="+data[index].id+">"+data[index].name+"</option>";
}    
         } else{
              html = "<option>Chuyên mục này chưa có</option>";
         }
               $("#sectoroptions-sector_id").html(html);
       }
      });
    });

'); ?>