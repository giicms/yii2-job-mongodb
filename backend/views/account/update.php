<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\UserGroup;

/* @var $this yii\web\View */
/* @var $model common\models\Account */

$this->title = 'Cập nhật thông tin cá nhân: ' . ' ' . $profile->name;
if ((string) Yii::$app->user->identity->id == $profile->id)
    $this->params['breadcrumbs'][] = ['label' => 'Thông tin cá nhân', 'url' => ['profile']];
else
    $this->params['breadcrumbs'][] = ['label' => 'Quản lý account', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Cập nhật';
?>
<div class="account-create">
    <div class="page-title">
        <div class="title_left">
            <h3>Cập nhật thông tin cá nhân</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= $profile->name ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>     
                            <?= Html::a('Thông tin', ['view', 'id' => $profile->id], ['class' => 'btn btn-primary']) ?>
                        </li>
                        <li>     
                            <?= Html::a('Thay đổi mật khẩu', ['changepassword', 'id' => $profile->id], ['class' => 'btn btn-danger']) ?>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
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
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Hình ảnh đại diện</label>
                        <div class="col-md-6 col-sm-9 col-xs-12 profile-avatar">
                            <div class="row">
                                <div class="col-md-5 col-sm-6 col-xs-12">
                                    <div id="image_preview">
                                        <?php
                                        if (!empty($profile->avatar))
                                        {
                                            echo '<img src="' . $profile->avatar . '" alt="' . $profile->name . '" >';
                                        }
                                        else
                                        {
                                            echo '<img src="/images/icon/avatar.png" alt="' . $profile->name . '">';
                                        }
                                        ?>
                                    </div>
                                </div>	
                                <input id="fieldID" class="form-control" name="Profile[avatar]" type="hidden" value="<?= $profile->avatar; ?>" >
                                <div class="col-md-2 col-sm-2 col-xs-3 btn-upload">
                                    <a href="/filemanager/dialog.php?type=1&field_id=fieldID&akey=<?= (string) $profile->id ?>" class="btn iframe-btn btn-success" type="button"><i class="fa fa-upload"></i></a>
                                </div>
                            </div>

                            <?php
                            /*
                              echo \kato\DropZone::widget([
                              'options' => [
                              'maxFilesize' => '2',
                              'url' => '/upload/image'
                              ],
                              'clientEvents' => [
                              'complete' => "function(data){ console.log(data); $('.dz-message').hide(); $('#myDropzone').append('<div class=dz-delete><input type=hidden name=Profile[avatar] id=\"profile-avatar\" value='+data.xhr.response+'><a class=\"delete-img btn btn-danger\" href=\"javascript:void(0)\">Xóa</a></div>')}",
                              'removedfile' => "function(file){alert(file.name + ' is removed')}"
                              ],
                              ]); */
                            ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'name')->textInput(['value' => $profile->name]) ?>
                    <?= $form->field($model, 'username')->textInput(['value' => $profile->username]) ?>
                    <?= $form->field($model, 'phone')->textInput(['value' => $profile->phone]); ?>
                    <?= $form->field($model, 'email')->textInput(['value' => $profile->email]); ?>
                    <?= $form->field($model, 'address')->textInput(['value' => $profile->address]) ?>
                    <?= $form->field($model, 'secret', ['template' => '{label}<div class="col-md-4 col-sm-6 col-xs-8">{input}{hint}{error}</div><div class="col-md-2 col-sm-4 col-xs-6"><a href="javascript:void(0)" class="btn btn-default reset-secret">Reset</a></div>'])->textInput(['value' => $profile->secret]) ?>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-9 col-xs-12 col-md-offset-3">
                            <img id="qrcode" src="<?= $ga->getQRCodeGoogleUrl($profile->username, $profile->secret) ?>">
                        </div>
                    </div>

                    <?=
                            $form->field($model, 'category', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><div class="row">{input}</div>{hint}{error}</div>'])
                            ->checkboxList($model->categories, [
                                'item' => function($index, $label, $name, $checked, $value)
                                {

                                    if ($label['active'] == 1)
                                        $check = 'checked';
                                    else
                                        $check = '';
                                    $return = '<div class="col-md-3 col-sm-6 col-xs-12"><div class="checkbox"><label>';
                                    $return .= '<input type="checkbox" ' . $check . ' name="' . $name . '" value="' . $value . '">' . $label['name'];
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

                                    if ($label['active'] == 1)
                                        $check = 'checked';
                                    else
                                        $check = '';
                                    $return = '<div class="col-md-3 col-sm-6 col-xs-12"><div class="checkbox"><label>';
                                    $return .= '<input type="checkbox" ' . $check . ' name="' . $name . '" value="' . $value . '">' . $label['name'];
                                    $return .='</label></div></div>';
                                    return $return;
                                }
                            ])->label();
                    ?>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-4">
                            <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>



                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (!empty($profile->avatar) && file_exists(Yii::$app->params['file'] . 'thumbnails/' . $profile->avatar))
{
    echo $this->registerJs('
    $(".dz-message").hide();
    $("#previews").html("<div class=\'dz-preview dz-processing dz-image-preview dz-success dz-complete\'><div class=\'dz-image\'><img src=\'' . Yii::$app->info->setting('url_file') . 'thumbnails/' . $profile->avatar . '\'></div></div>");
    $("#myDropzone").append("<div class=\"dz-delete\"><input type=\"hidden\" name=\"Profile[avatar]\" id=\"profile-avatar\" value=' . $profile->avatar . '><a class=\"delete-img btn btn-danger\" href=\"javascript:void(0)\">Xóa</a></div>");
        ');
}
?>
<?= $this->registerJs('
          $(document).on("click", ".delete-img", function (event){
          var file = $("#profile-avatar").val();
            $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["upload/remove"]) . '", data: {file: file}, success: function (data) {
                if(data =="ok"){
                      $(".dz-message").show();
                        $(".dz-delete").remove();
                        $("#previews").html("");
                        }
                }
            });
     return false;
});
');
?>

<?php
echo $this->registerJs('
     $("document").ready(
      $("input[name=role]").change(function(){
     var role = $(this).val();
     var url = "' . Yii::$app->urlManager->createUrl(["ajax/permission"]) . '";
 $.ajax({
   url:url+"/"+role+"?user=' . (string) $profile->id . '",
   type:"GET",
   success:function(data){    
                if(data){
         var html="";
     for (index = 0; index < data.length; ++index) {
         if(data[index].checked == 1){
         var checked = "checked";
         } else {
         var checked ="";
         }
         if(data[index].parent =="null"){
         var parent = "parentall "+data[index].class;
          html += "</div><div class=\"col-md-3\"><div class=\"col-md-12\"><div class=\"checkbox\"><label><input class=\'"+parent+"\' "+checked+" type=\"checkbox\" name=\"childs[]\" data="+data[index].class+" value="+data[index].name+">"+data[index].description+"</label></div></div>";
          }else{ 
         var parent = "parentitem "+data[index].class+"_item";
                 html += "<div class=\"col-md-12\"><div class=\"checkbox\"> &nbsp;&nbsp;&nbsp; <label><input class=\'"+parent+"\' "+checked+" type=\"checkbox\" name=\"childs[]\" data="+data[index].class+" value="+data[index].name+">"+data[index].description+"</label></div></div>";
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
<?= $this->registerJs("
	$('.iframe-btn').fancybox({
	  'width'	: 880,
	  'height'	: 570,
	  'type'	: 'iframe',
	  'autoScale'   : false
      });
	$(function() {
		$('#fieldID').observe_field(1, function( ) {
			$('#image_preview').html('<img src='+this.value+'>');
		});
	});
"); ?>
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
          var username = $("#profile-username").val();
            $.ajax({type: "POST", url:"' . Yii::$app->urlManager->createUrl(["ajax/qrcode"]) . '", data: {username: username}, success: function (data) {
                if(data){
                    $("#profile-secret").val(data.secret);
                    $("#qrcode").attr("src",data.src);
                    }
                }
            });
     return false;
});
');
?>