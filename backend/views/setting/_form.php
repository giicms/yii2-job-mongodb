<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */
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
<?= $form->field($model, 'key')->textInput() ?>
<?= $form->field($model, 'value')->textInput() ?>
<?= $form->field($model, 'description')->textarea() ?>
<?= $form->field($model, 'content')->textarea() ?>

<div class="form-group">
    <div class="col-md-offset-3 col-md-6 col-sm-9 col-xs-12">
        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?= $this->registerJs('
    tinymce.init({selector:"#setting-content",
      height: 400,
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code fullscreen",
    "insertdatetime media table contextmenu paste code"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
//    imageupload_url: "/my/uploader/path", // PHP (or other server side script)
//    plugins: "imageupload", // and your other plugins
//    toolbar1: "imageupload", // and your others
  content_css: [
    "//www.tinymce.com/css/codepen.min.css"
  ]})
');
?>