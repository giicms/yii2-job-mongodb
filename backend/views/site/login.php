<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng nhập';
//$ga = new GoogleAuthenticator();
////$secret = $ga->createSecret();
//$secret = $ga->createSecret();
//echo "Secret is: " . $secret . "\n\n";
//$qrCodeUrl = $ga->getQRCodeGoogleUrl('adminstrator', $secret);
//echo '<img src="' . $qrCodeUrl . '">';
//echo "Google Charts URL for the QR-Code: " . $qrCodeUrl . "\n\n";
//$oneCode = $ga->getCode($secret);
//echo "Checking Code '$oneCode' and Secret '$secret':\n";
//$checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
//if ($checkResult)
//{
//    echo 'OK';
//}
//else
//{
//    echo 'FAILED';
//}
?>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
<h1>ĐĂNG NHẬP</h1>
<?= $form->field($model, 'username')->textInput(['placeholder' => 'Tên đăng nhập'])->label(false) ?>
<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Nhập mật khẩu'])->label(false) ?>
<?= $form->field($model, 'code')->textInput(['placeholder' => 'Nhập mã code'])->label(false) ?>
<div class="form-group">
    <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    <a class="reset_pass" href="/site/forgetpassword">Quên mật khẩu?</a>
</div>
<div class="clearfix"></div>
<div class="separator">
    <div>
        <h1><img src="/images/giaonhanviec.png" alt="giaonhanviec" style="width:250px;"></h1>

        <p>©2015 All Rights Reserved. Privacy and Terms</p>
    </div>
</div>
<?php ActiveForm::end(); ?>