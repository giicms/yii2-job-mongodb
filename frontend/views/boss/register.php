<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Tạo một tài khoản boss';
$session = Yii::$app->session;
?>
<section>
    <div class="introduce">
        <div class="container">
            <div class="row">
                <div class="title-container">
                    <h3 class="text-center"><?= $this->title ?></h3>
                    <p class="text-center">Bạn đang cần tìm việc? <?= Html::a('Tạo một tài khoản nhân viên', ['membership/register']) ?></p>
                </div>
                <!-- introduce item -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-register">
                        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                        <?= yii\authclient\widgets\AuthChoice::widget([
                             'baseAuthUrl' => ['site/registerboss']
                        ]) ?>
                        <div class="line-text"><span>hoặc</span></div>
                        <?php 
                            if($session->get('active') && $session->get('email')){ 
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
                            if($session->get('email') && $session->get('register')){ 
                                echo'<div class="alert alert-success">
                                        <strong><i class="fa fa-exclamation-circle"></i></strong> 
                                        Đã kết nối với tài khoản Facebook của bạn, vui lòng nhập đầy đủ thông tin cá nhân để hòan thành đăng ký.
                                    </div>';
                                echo '';
                                echo $this->registerJs('$(document).ready(function(){ $("#boss-phone").focus();})'); 
                            }                           
                        ?>
                        <?= $form->field($model, 'name', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('name'), 'value'=>$session->get('name')]])->label(FALSE) ?>
                        <?= $form->field($model, 'phone', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('phone')]])->label(FALSE) ?>
                        <?= $form->field($model, 'email', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('email'), 'value'=>$session->get('email')]])->label(FALSE) ?>
			            <?= $form->field($model, 'fbid', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('fbid'), 'value'=>$session->get('fbid'), 'type'=>'hidden']])->label(FALSE) ?>
			            <?= $form->field($model, 'password', ['template' => '{input}{hint}{error}<p class="help-block alert-error-box"></p>'])->passwordInput(['class' => 'form-control pass-input', 'placeholder' => $model->getAttributeLabel('password')])->label(FALSE) ?>
                        <?= $form->field($model, 'password_repeat', ['inputOptions' => ['placeholder' => $model->getAttributeLabel('password_repeat')]])->passwordInput()->label(FALSE) ?>
                        <?= $form->field($model, 'questions', ['template' => '<div class="form-group"><div class="select">{input}</div>{hint}{error}</div>'])->dropDownList($model->questionList, ['prompt' => 'Bạn biết đến Giaonhanviec.com từ đâu?'])->label(FALSE);?>
                        <?= $form->field($model, 'email_active')->checkbox() ?>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-blue">Đăng ký</button>
                        </div>
                        <div class="form-group text-center ">
                            Khi tạo tài khoản tại Giaonhanviec.com, bạn đã đồng ý với<br> <a href="#">Điều khoản sử dụng</a> và <a href="#">chính sách bảo mật</a> của chúng tôi.
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>    
                <!-- introduce item -->

                <!-- introduce item -->


            </div>
        </div>
    </div>
</section>


<!-- kiem tra tieng viet cho mat khau -->
<?=$this->registerJs('
    $(document).ready(function(){
        $(".pass-input").change(function(){
            var data = $(this).val();
            var str = /à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ  |ặ|ẳ|ẵ|è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|ì|í|ị|ỉ|ĩ|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ  |ợ|ở|ỡ|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|ỳ|ý|ỵ|ỷ|ỹ|đ/;
            if (str.test(data)) {
                $(this).parent().addClass("alert-error");
                $(this).focus();
                $(".alert-error-box").html("Mật khẩu khổng được viết tiếng việt");
            }
            else {
		$(this).parent().removeClass("alert-error");
                $(".alert-error-box").html("");
            }
        });
        return false;
    })
');?>
