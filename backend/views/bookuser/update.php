<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Cập nhật nhân viên: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => (string) $model->_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Cập nhật nhân viên</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= $user->name ?></h2>
                    <ul class="nav navbar-right panel_toolbox">

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left']]); ?>  
                    <?= $form->field($model, 'name', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $user->name]) ?>
                    <?= $form->field($model, 'email', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $user->email]) ?>
                    <?= $form->field($model, 'phone', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $user->phone]) ?>
                    <?= $form->field($model, 'cmnd', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $user->cmnd]) ?>
                    <?= $form->field($model, 'address', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $user->address]) ?>
                    <?= $form->field($model, 'city', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-8 col-xs-12"><div class="select">{input}</div>{hint}{error}</div>'])->dropDownList($model->arrayCity, ['prompt' => 'Chọn tỉnh / thành phố']); ?>
                    <?= $form->field($model, 'district', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-8 col-xs-12"><div class="select">{input}</div>{hint}{error}</div>'])->dropDownList($district, ['prompt' => 'Chọn quận / huyện']); ?>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-8 col-xs-12 col-md-offset-3">
                            <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>


                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->registerJs('
$("#membershipinfo-city").on("change",function(){    
 $.ajax({
   url:"' . Yii::$app->urlManager->createUrl(["member/district"]) . '",
   type:"POST",            
   data:"id_city="+$("#membershipinfo-city option:selected").val(),
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
               $("#membershipinfo-district").html(html);
       } 
      });
    });
');
?>