<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Quên mật khẩu';
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'email')->textInput(['placeholder' => 'Nhập địa chỉ email']) ?>
<div class="form-group">
    <?= Html::submitButton('Gởi', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
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