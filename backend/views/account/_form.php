<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\UserGroup;

/* @var $this yii\web\View */
/* @var $model common\models\User */
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
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'phone') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'address') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password_repeat')->passwordInput() ?>
<?= $form->field($model, 'secret', ['template' => '{label}<div class="col-md-4 col-sm-6 col-xs-8">{input}{hint}{error}</div><div class="col-md-2 col-sm-4 col-xs-6"><a href="javascript:void(0)" class="btn btn-default reset-secret">Reset</a></div>'])->textInput(['value' => $ga->createSecret()]) ?>
<?=
        $form->field($model, 'category', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><div class="row">{input}</div>{hint}{error}</div>'])
        ->checkboxList($model->categories, [
            'item' => function($index, $label, $name, $checked, $value)
            {
                $return = '<div class="col-md-3 col-sm-6 col-xs-12"><div class="checkbox"><label>';
                $return .= '<input type="checkbox" name="' . $name . '" value="' . $value . '">' . $label['name'];
                $return .='</label></div></div>';
                return $return;
            }
        ])->label();
?>
<?=
        $form->field($model, 'role', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><div class="row">{input}</div>{hint}{error}</div>'])
        ->checkboxList($model->auth, [
            'item' => function($index, $label, $name, $checked, $value)
            {
                $return = '<div class="col-md-3 col-sm-6 col-xs-12"><div class="checkbox"><label>';
                $return .= '<input type="checkbox" name="' . $name . '" value="' . $value . '">' . $label['name'];
                $return .='</label></div></div>';
                return $return;
            }
        ])->label();
?>


<div class="form-group">
    <div class="col-md-offset-3 col-md-4">
        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>


<?php
if (!empty($model->avatar) && file_exists(Yii::$app->params['file'] . 'thumbnails/' . $model->avatar))
{
    echo $this->registerJs('
    $(".dz-message").hide();
    $("#previews").html("<div class=\'dz-preview dz-processing dz-image-preview dz-success dz-complete\'><div class=\'dz-image\'><img src=\'' . Yii::$app->params['url_file'] . 'thumbnails/' . $model->avatar . '\'></div></div>");
    $("#myDropzone").append("<div class=\"dz-delete\"><input type=\"hidden\" name=\"Profile[]\" id=\"avatar\" value=' . $model->avatar . '><a class=\"delete-img btn btn-danger\" href=\"javascript:void(0)\">Xóa</a></div>");

    
');
}
?>
<?php
echo $this->registerJs('
     $("document").ready(
      $("input[name=role]").change(function(){
     var role = $(this).val();
     var url = "' . Yii::$app->urlManager->createUrl(["ajax/permission"]) . '";
 $.ajax({
   url:url+"/"+role,
   type:"GET",
   success:function(data){    
          if(data){
         var html="<div>";
         for (index = 0; index < data.length; ++index) {
         if(data[index].parent =="null"){
         var parent = "parentall "+data[index].class;
          html += "</div><div class=\"col-md-3\"><div class=\"col-md-3\"><div class=\"checkbox\"><label><input class=\'"+parent+"\' type=\"checkbox\" name=\"childs[]\" data="+data[index].class+" value="+data[index].name+">"+data[index].description+"</label></div></div>";
          }else{ 
         var parent = "parentitem "+data[index].class+"_item";
                 html += "<div class=\"col-md-3\"><div class=\"checkbox\"> &nbsp;&nbsp;&nbsp; <label><input class=\'"+parent+"\' type=\"checkbox\" name=\"childs[]\" data="+data[index].class+" value="+data[index].name+">"+data[index].description+"</label></div></div>";
         }
        
         
} 
  $(".permission").html(html);
       } 
   }
       
      });
})
            );'
)
?>
<?= $this->registerJs('
   $(document).on("change", ".parentall", function (event){
        var data = $(this).attr("data");
        $("."+data+"_item").prop("checked", $(this).prop("checked")); 
    });
       $(document).on("change", ".parentitem", function (event){
        var data = $(this).attr("data");
        $("."+data).prop("checked", true);
    });
') ?>
<?= $this->registerJs('
          $(document).on("click", ".reset-secret", function (event){
          var username = $("#signup-username").val();
            $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["ajax/qrcode"]) . '", data: {username: username}, success: function (data) {
                if(data){
                    $("#signup-secret").val(data.secret);
                    }
                }
            });
     return false;
});
');
?>