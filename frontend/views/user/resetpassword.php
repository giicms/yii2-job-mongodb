<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<section>

    <div class="introduce profile-container">
        <div class="container">
            <div class="title-container">
                <h3>Đặt lại mật khẩu đăng nhập</h3>
            </div>
            <div class="box-content">
		<?php 
                    if($add==1){
                        echo '<div class="alert alert-success">
                                <i class="fa fa-exclamation-circle"></i>Email đã tự động đăng ký thành công
                            </div>';
                    }
                ?>
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                    <label>Mật khẩu mới:</label>
                    <?= $form->field($model, 'password', ['template' => '<div class="row"><div  class="col-md-4 col-sm-6 col-xs-12">{input}{hint}{error}</div></div>'])->passwordInput(['class' => 'form-control']) ?>
                    <label>Xác nhận mật khẩu:</label>
                    <?= $form->field($model, 'password_rep', ['template' => '<div class="row"><div  class="col-md-4 col-sm-6 col-xs-12">{input}{hint}{error}</div></div>'])->passwordInput(['class' => 'form-control']) ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-blue">Thay đổi mật khẩu</button>
                    </div>
                <?php ActiveForm::end(); ?> 
            </div>
        </div>
    </div>
</section>
