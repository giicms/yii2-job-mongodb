<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\BlogCategory;

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
                    'wrapper' => ' col-md-6 col-sm-9 col-xs-12',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]);
?> 
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'alias')->textInput() ?>
        <?= $form->field($model, 'description')->textarea() ?>
        <?= $form->field($model, 'note')->textarea() ?>
        <?= $form->field($model, 'content')->textarea(['class' => 'text-editor']) ?>
        <?= $form->field($model, 'keywords')->textarea() ?>
        <?= $form->field($model, 'meta')->textarea() ?>
        <div class="form-group">
            <label class="control-label col-sm-3">Hình ảnh</label>
            <div class="col-md-6 col-sm-9 col-xs-12 profile-avatar">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div id="image_preview">
                            <?php
                            if (!empty($model->thumbnail)) {
                                echo '<img src="' . $model->thumbnail . '" alt="' . $model->name . '" >';
                            }
                            ?>
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-9 input-avatar">
                        <input id="fieldID" class="form-control" name="Page[avatar]" value="<?= $model->thumbnail; ?>" >
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-3 btn-upload">
                        <a href="/filemanager/dialog.php?type=1&field_id=fieldID&akey=<?= (string) $model->id ?>" class="btn iframe-btn btn-success" type="button"><i class="fa fa-upload"></i></a>
                    </div>
                </div>
            </div>
        </div>    
        <div class="form-group">
                <div class="col-sm-offset-3 col-md-4 col-sm-6 col-xs-12">
                    <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    <button type="reset" class="btn btn-blue">Reset</button>
                </div>
        </div>

<?php ActiveForm::end(); ?>

<?= $this->registerJs('
          $(document).on("click", ".delete-img", function (event){
          var file = $("#page-thumbnail").val();
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
if (!empty($model->thumbnail) && file_exists(Yii::$app->params['file'] . 'thumbnails/' . $model->thumbnail)) {
    echo $this->registerJs('
    $(".dz-message").hide();
    $("#previews").html("<div class=\'dz-preview dz-processing dz-image-preview dz-success dz-complete\'><div class=\'dz-image\'><img src=\'' . Yii::$app->params['url_file'] . 'thumbnails/' . $model->thumbnail . '\'></div></div>");
    $("#myDropzone").append("<div class=\"dz-delete\"><input type=\"hidden\" name=\"thumbnail\" id=\"page-thumbnail\" value=' . $model->thumbnail . '><a class=\"delete-img btn btn-danger\" href=\"javascript:void(0)\">Xóa</a></div>");
        ');
}
?>
