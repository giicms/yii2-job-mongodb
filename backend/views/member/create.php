<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Thêm mới nhân viên';
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
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => '']]); ?>  
                    <?= $form->field($model, 'name', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div></div>'])->textInput() ?>
                    <?= $form->field($model, 'phone', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div></div>'])->textInput() ?>
                    <?= $form->field($model, 'email', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div></div>'])->textInput() ?>
                    <?= $form->field($model, 'password', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div></div>'])->passwordInput() ?>
                    <?= $form->field($model, 'password_repeat', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div></div>'])->passwordInput() ?>
                    <?= $form->field($model, 'category', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12"><div class="select">{input}</div>{hint}{error}</div></div>'])->dropDownList($model->categoryList, ['prompt' => 'Chọn danh mục']) ?>
                    <?= $form->field($model, 'sector', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12"><div class="select">{input}</div>{hint}{error}</div></div>'])->dropDownList([], ['prompt' => 'Chọn lĩnh vực', 'multiple' => TRUE]); ?>
                    <?= $form->field($model, 'questions', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}</div>{hint}{error}</div></div>'])->dropDownList($model->questionList, ['prompt' => 'Bạn biết đến Giaonhanviec.com từ đâu?'])?>
                    <?= $form->field($model, 'email_active', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12"><div class="select">{input}</div>{hint}{error}</div></div>'])->checkbox() ?>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-8 col-xs-12">
                            <?= Html::submitButton('Thêm mới', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>


                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('
$("#membership-category").on("change",function(){    
 $.ajax({
   url:"' . Yii::$app->urlManager->createUrl(["member/sector"]) . '",
   type:"POST",            
   data:"id="+$("#membership-category option:selected").val(),
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
               $("#membership-sector").html(html);
       } 
      });
    });
    $("#membership-sector").select2({
      placeholder: "Chọn những lĩnh vực ngành nghề",
    maximumSelectionSize: 5
});
');
?>