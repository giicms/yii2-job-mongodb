<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">
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
    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'description')->textarea() ?>
    <?= $form->field($model, 'ruleName')->textInput() ?>
    <?= $form->field($model, 'data')->textarea() ?>
    <div class="form-group">
        <div class="col-md-offset-3 col-md-6 col-sm-9 col-xs-12">
            <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
