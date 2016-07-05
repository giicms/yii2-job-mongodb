<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-3',
                    'offset' => 'col-sm-offset-3',
                    'wrapper' => 'col-md-6 col-sm-9 col-xs-12',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]);
?> 
<?= $form->field($model, 'name')->textarea(['class' => 'text-editor form-control']) ?>
<?= $form->field($model, 'user_id')->hiddenInput(['value' => (string) Yii::$app->user->identity->id])->label(FALSE) ?>
<div class="form-group">
    <label class="control-label col-sm-3">Câu trả lời</label>
    <div class="col-md-6 col-sm-9 col-xs-12 test-question">
        <?php
        if ($model->isNewRecord) {
            for ($i = 1; $i <= 4; $i++) {
                ?>
                <div class="radio" style="margin-bottom: 20px;">
                    <label class="col-md-12 col-sm-12 col-xs-12">
                        <input type="radio" name="TestQuestion[answers]" value="<?= $i ?>">
                        <input type="text" name="TestQuestion[questions][<?= $i ?>]" class="form-control col-lg-7">
                    </label>
                </div>
                <?php
            }
        } else {
            foreach ($model->questions as $i => $value) {
                ?>
                <div class="radio" style="margin-bottom: 20px;">
                    <label class="col-md-12 col-sm-12 col-xs-12">
                        <input type="radio" name="TestQuestion[answers]" value="<?= $i ?>" <?= ($i == $model->answers) ? 'checked' : '' ?>>
                        <input type="text" name="TestQuestion[questions][<?= $i ?>]" class="form-control col-lg-7" value="<?= $value ?>">
                    </label>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>

<?php
echo $form->field($model, 'category_id')->dropDownList($model->categoryList, ['prompt' => 'Chọn danh mục']);
?>
<div class="form-group">
    <?php
    echo $form->field($model, 'sector_id')->dropDownList($model->sectors, ['prompt' => 'Chọn lĩnh vực', 'multiple' => TRUE]);
    ?>
</div>
<div class="form-group">
    <div class="col-md-offset-3 col-md-6 col-sm-9 col-xs-12">
        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?=
$this->registerJs('
$("#testquestion-sector_id").select2({
      placeholder: "Lĩnh vực ngành nghề",
    maximumSelectionSize: 10
});

');
?>
<?= $this->registerJs('
$("#testquestion-category_id").on("change",function(){    
    $.ajax({
    url:"' . Yii::$app->urlManager->createUrl(["ajax/sector"]) . '",
   type:"POST",            
   data:"id="+$("#testquestion-category_id option:selected").val(),
   dataType:"json",
   success:function(data){     
   $(".select2-selection__choice").remove();
         if(data){
         var html="";
         for (index = 0; index < data.length; ++index) {
         
         html += "<option value="+data[index].id+">"+data[index].name+"</option>";
}    
         } else{
              html = "<option>Chuyên mục này chưa có</option>";
         }
               $("#testquestion-sector_id").html(html);
       }
      });
    });

'); ?>