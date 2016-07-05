<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Tạo mới mật khẩu';
?>

<?php $form = ActiveForm::begin(); ?>
<h1>TẠO MẬT KHẨU MỚI</h1>
<?php if (Yii::$app->session->hasFlash('success')) { ?>
    <div class="alert alert-success" role="alert">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php } ?>
<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Nhập mật khẩu'])->label(FALSE) ?>
<?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => 'Nhập lại mật khẩu'])->label(FALSE) ?>
<div class="form-group">
    <?= Html::submitButton('Tạo mới mật khẩu', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    <a class="reset_pass" href="/site/login">Quay lại?</a>
</div>
<div class="clearfix"></div>
<div class="separator">
    <div>
        <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Giao nhận việc!</h1>

        <p>©2015 All Rights Reserved. Privacy and Terms</p>
    </div>
</div>
<?php ActiveForm::end(); ?>