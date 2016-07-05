<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Thêm mới boss';
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
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12"> <label class="control-label">Đây là khách hàng</label></div>
                            <div class="col-md-6 col-sm-9 col-xs-12">
                                <div class="radio">

                                    <label class="radio-inline">
                                        <input type="radio" name="Boss[boss_type]" checked id="client-0" value="0"> Cá nhân
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="Boss[boss_type]" id="client-1" value="1"> Công ty
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="company" style="display:none">
                        <?= $form->field($model, 'company_name', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div></div>'])->textInput(['value' => 0]) ?>
                        <?= $form->field($model, 'company_code', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div></div>'])->textInput(['value' => 0]) ?>
                    </div>
                    <?= $form->field($model, 'address', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div></div>'])->textInput() ?>
                    <?= $form->field($model, 'city', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12"><div class="select">{input}</div>{hint}{error}</div></div>'])->dropDownList($model->cityList, ['prompt' => 'Chọn tỉnh/thành']) ?>
                    <?= $form->field($model, 'district', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12"><div class="select">{input}</div>{hint}{error}</div></div>'])->dropDownList([], ['prompt' => 'Chọn quận/huyện']) ?>
                    <?= $form->field($model, 'password', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div></div>'])->passwordInput() ?>
                    <?= $form->field($model, 'password_repeat', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div></div>'])->passwordInput() ?>
                    <?= $form->field($model, 'questions', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12">{input}</div>{hint}{error}</div></div>'])->dropDownList($model->questionList, ['prompt' => 'Bạn biết đến Giaonhanviec.com từ đâu?']) ?>

                    <?= $form->field($model, 'email_active', ['template' => '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12">{label}</div><div class="col-md-6 col-sm-9 col-xs-12"><div class="select">{input}</div>{hint}{error}</div></div>'])->checkbox() ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 col-sm-8 col-xs-12">
                                <?= Html::submitButton('Thêm mới', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>    
                    </div>

                    <?php ActiveForm::end(); ?>


                </div>
            </div>
        </div>
    </div>

<?=
$this->registerJs('
     $("document").ready(
                function(){
                    $("input:radio").click(
                        function(){
                            if($(this).val()==0){
                                    document.getElementById("company").style.display="none";
                                    $("#boss-company_name").val(0);
                                    $("#boss-company_code").val(0);
                                }else {
                                    document.getElementById("company").style.display="block";
                                    $("#boss-company_name").val("");
                                    $("#boss-company_code").val("");
                                }
                   
                        }
                    );  
                }
            );');
?>
<?= $this->registerJs('
$("#boss-city").on("change",function(){    
 $.ajax({
   url:"' . Yii::$app->urlManager->createUrl(["boss/district"]) . '",
   type:"POST",            
   data:"id_city="+$("#boss-city option:selected").val(),
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
               $("#boss-district").html(html);
       } 
      });
    });
');
?>