<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Skills */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="skills-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>  

    <?= $form->field($model, 'name', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'description', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">{label}</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->textarea() ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => (string) Yii::$app->user->identity->id])->label(FALSE) ?>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-4">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
