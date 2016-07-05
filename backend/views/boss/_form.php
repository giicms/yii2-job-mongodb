<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-label-left']]); ?>  
<?= $form->field($model, 'name', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $user->name]) ?>
<?= $form->field($model, 'address', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div  class="col-md-6 col-sm-8 col-xs-12">{input}{hint}{error}</div>'])->textInput(['value' => $user->address]) ?>
<?= $form->field($model, 'city', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-8 col-xs-12"><div class="select">{input}</div>{hint}{error}</div>'])->dropDownList($model->arrayCity, ['prompt' => 'Chọn tỉnh / thành phố']); ?>
<?= $form->field($model, 'district', ['template' => '<label class="col-md-3 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-8 col-xs-12"><div class="select">{input}</div>{hint}{error}</div>'])->dropDownList($district, ['prompt' => 'Chọn quận / huyện']); ?>

<div class="form-group">
    <div class="col-md-offset-3">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>


