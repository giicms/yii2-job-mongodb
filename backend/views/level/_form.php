<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\City */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'icon')->textInput() ?>
<?= $form->field($model, 'count_job')->textInput() ?>
<?= $form->field($model, 'count_bid')->textInput() ?>
<?= $form->field($model, 'order')->textInput() ?>
<?= $form->field($model, 'review')->textInput() ?>
<?= $form->field($model, 'rating')->textInput() ?>
<div class="form-group">
    <div class="<?= !empty($action) ? "col-md-offset-4 col-md-4" : "col-md-offset-3 col-md-3" ?>">
        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
