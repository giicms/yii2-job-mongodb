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
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left']]); ?>  
                    <?= $form->field($model, 'name', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('name') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput() ?>
                    <?= $form->field($model, 'phone', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('phone') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput() ?>
                    <?= $form->field($model, 'email', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('email') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput() ?>
                    <?= $form->field($model, 'password', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('password') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->passwordInput() ?>
                    <?= $form->field($model, 'password_repeat', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('password_repeat') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->passwordInput() ?>
                    <?= $form->field($model, 'category', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('category') . '</label><div class="col-md-6 col-sm-9 col-xs-12"><div class="select">{input}</div>{hint}{error}</div>'])->dropDownList($model->categoryList, ['prompt' => 'Chọn danh mục']) ?>
                    <?= $form->field($model, 'sector', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('sector') . '</label><div class="col-md-6 col-sm-9 col-xs-12"><div class="select">{input}</div>{hint}{error}</div>'])->dropDownList([], ['prompt' => 'Chọn lĩnh vực', 'multiple' => TRUE]); ?>
                    <?= $form->field($model, 'questions', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('questions') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}</div>{hint}{error}</div>'])->dropDownList($model->questionList, ['prompt' => 'Bạn biết đến Giaonhanviec.com từ đâu?'])?>

                    <?= $form->field($model, 'email_active', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label"></label><div class="col-md-6 col-sm-9 col-xs-12"><div class="select">{input}</div>{hint}{error}</div>'])->checkbox() ?>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-8 col-xs-12 col-md-offset-3">
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