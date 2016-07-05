<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<section>
	<div class="introduce profile-container">
		<div class="container">
			<div class="title-container">
	            <h3>Quên mật khẩu đăng nhập</h3>
	        </div>
            <div class="box-content">
            	<div class="alert alert-success">
                    <i class="fa fa-exclamation-circle"></i> Giaonhanviec sẽ gửi một email hướng dẫn cách tạo mật khẩu mới về địa chỉ email bạn đăng ký. Vui lòng kiểm tra email của bạn sau khi thay đổi mật khẩu
                </div>
                <p>Vui lòng nhập vào địa chỉ email mà bạn đã đăng ký với giaonhanviec.com</p>
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                    <?= $form->field($model, 'email', ['template' => '<div class="row"><div  class="col-md-4 col-sm-6 col-xs-12">{input}{hint}{error}</div></div>'])->textInput(['class' => 'form-control']) ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-blue">Thay đổi mật khẩu</button>
                    </div>
                <?php ActiveForm::end(); ?> 
	        </div>
		</div>
	</div>
</section>