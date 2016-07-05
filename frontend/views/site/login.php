<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng nhập';
$session = Yii::$app->session;
?>

<section>
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="title-container text-center">
                    <h3>Đăng nhập tài khoản của bạn</h3>
                </div>
                <!-- form-login -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-login">
                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
			<?= yii\authclient\widgets\AuthChoice::widget([
                             'baseAuthUrl' => ['site/auth']
                        ]) ?>
                        
                        <div class="line-text"><span>hoặc</span></div>
			<?php 
                        //$session->destroy();
                            if($session->get('email') && $session->get('login')){ 
                                echo'<div class="alert alert-danger">
                                        <strong><i class="fa fa-exclamation-circle"></i></strong> 
                                        Tài khoản không tồn tại trong hệ thống, hãy Đăng ký để trở thành thành viên của Giaonhanviec.
                                        <div class="row register_box" style="width:100%;">
                                            <div class="col-sm-6 col-xs-12">
                                                <a href="/tao-tai-khoan-boss">
                                                    <div class="btn-register">
                                                        <button class="btn btn-boss" type="button" style="padding:5px 40px">Đăng ký boss</button>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <a href="/tao-tai-khoan-nhan-vien">
                                                    <div class="btn-register">
                                                        <button class="btn btn-nhanvien" type="button" style="padding:5px 25px">Đăng ký nhân viên</button>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>';
                                echo '';
                            }
			    else if($session->get('active') && $session->get('email')){
                                echo'<div class="alert alert-danger text-center">
                                        <strong><i class="fa fa-exclamation-circle"></i></strong> 
                                        Tài khoản email '.$session->get('email').' chưa được kích hoạt
                                        <div class="register_box" style="width:100%;">
                                            <a href="/kich-hoat-email">
                                                <div class="btn-register">
                                                    <button class="btn btn-boss" type="button" style="padding:5px 40px">Kích hoạt tài khoản</button>
                                                </div>
                                            </a>
                                        </div>
                                    </div>';
                            }
                            else if($session->get('email')){ 
                                echo '<div class="alert alert-danger"><strong><i class="fa fa-exclamation-circle"></i></strong>Thông tin Email đã được sử dụng, hãy nhập mật khẩu đã đăng ký để đồng bộ với tài khoản facbook của bạn.</div>';
                                echo $this->registerJs('$(document).ready(function(){ $("#loginform-password").focus();})'); 
                            }
                        ?>
                        <?= $form->field($model, 'username', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('username'),'value'=>$session->get('email')]])->label(false) ?>

                        <?= $form->field($model, 'password', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('password')]])->passwordInput()->label(false) ?>
                        <div class="form-group">
                            <button type="submit" class="btn btn-blue">Đăng nhập</button>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 remember-check">
                                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="checkbox">
					<?= Html::a('Bạn quên mật khẩu', ['user/fogotpassword']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>    
                <!-- End form-login -->
            </div>
        </div>
    </div>
</section>
