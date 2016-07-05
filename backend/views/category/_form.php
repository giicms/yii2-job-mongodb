<?php

use yii\helpers\Html;
use common\models\BlogCategory;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>


<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'icon')->textInput() ?>
<?= $form->field($model, 'description')->textarea() ?>
<?= $form->field($model, 'order')->textInput(['type' => 'number', 'min' => 1]) ?>
<?= $form->field($model, 'parent')->dropDownList($model->getCategories(), ['prompt' => 'Chọn danh mục']) ?>
<div class="form-group">
    <div class="col-md-offset-3 col-md-6 col-sm-9 col-xs-12">
        <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

