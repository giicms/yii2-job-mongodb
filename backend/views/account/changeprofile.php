<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Account */

$this->title = 'Cập nhật thông tin cá nhân: ' . ' ' . $profile->name;
$this->params['breadcrumbs'][] = ['label' => 'Thông tin cá nhân', 'url' => ['profile']];

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
                    <ul class="list-unstyled navbar-right panel_toolbox">
                        <li>     
                            <?= Html::a('Thông tin', ['profile'], ['class' => 'btn btn-primary']) ?>
                        </li>
                        <li>     
                            <?= Html::a('Thay đổi mật khẩu', ['changepassword', 'id' => $profile->id], ['class' => 'btn btn-danger']) ?>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">


                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>  
                    <div class="form-group">
                        <label class="col-md-2 col-sm-4 col-xs-12 control-label">Hình ảnh đại diện</label>
                        <div class="col-md-6 col-sm-4 col-xs-12 profile-avatar">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
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
                            </div>    
                            <div class="row">    	
                                <div class="col-md-3 col-sm-3 col-xs-9 input-avatar">
                                    <input id="fieldID" class="form-control" name="Profile[avatar]" value="<?= $profile->avatar; ?>" >
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-3 btn-upload">
                                    <a href="/filemanager/dialog.php?type=1&field_id=fieldID&akey=<?= (string) $profile->id ?>" class="btn iframe-btn btn-success" type="button"><i class="fa fa-upload"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= $form->field($model, 'name', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $profile->name]) ?>
                    <?= $form->field($model, 'username', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $profile->username]) ?>
                    <?= $form->field($model, 'phone', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $profile->phone]); ?>
                    <?= $form->field($model, 'email', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $profile->email]); ?>
                    <?= $form->field($model, 'address', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $profile->address]) ?>
                    <?= $form->field($model, 'secret', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-4 col-sm-6 col-xs-8">{input}{hint}{error}</div><div class="col-md-2 col-sm-4 col-xs-6"><a href="javascript:void(0)" class="btn btn-default reset-secret">Reset</a></div>'])->textInput(['value' => $profile->secret]) ?>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-4">
                            <img id="qrcode" src="<?= $ga->getQRCodeGoogleUrl($profile->username, $profile->secret) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-4">
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