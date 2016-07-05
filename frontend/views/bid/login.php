<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="form-login">
    <?php
    $form = ActiveForm::begin([
                'action' => '/site/login',
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-12',
                        'wrapper' => ' col-md-12 col-sm-12 col-xs-12',
                        'error' => '',
                        'hint' => '',
                    ],
                ],
    ]);
    ?> 

    <?= $form->field($login, 'username', ['inputOptions' => ['placeholder' => $login->getAttributeLabel('username')]])->textInput()->label(false) ?>
    <?= $form->field($login, 'password', ['inputOptions' => ['placeholder' => $login->getAttributeLabel('password')]])->passwordInput()->label(false) ?>
    <div class="form-group">
        <button id="submitInvited" type="submit" class="btn btn-default btn-blue">ĐĂNG NHẬP</button>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="line-text"><span style="left:15%;">BẠN CHƯA CÓ TÀI KHOẢN</span></div>
    <div class="form-group">
        <?= Html::a('ĐĂNG KÝ NHÂN VIÊN', ['membership/register'], ['class' => 'btn btn-blue', 'style' => 'font-weight:500']); ?>
    </div>
    <div class="clear-fix"></div>
</div>