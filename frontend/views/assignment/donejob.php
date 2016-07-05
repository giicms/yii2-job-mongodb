<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Thanh toán chi phí';
?>
<section>
    <div class="introduce commitments">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row-steps">
                        <div class="steps col-md-12- col-sm-12 col-xs-12">
                            <ul class="list-unstyled">
                                <li class="step-done step_1">
                                    <span>1</span>
                                    <div>Đăng việc</div>
                                </li>
                                <li class="step-done step_2">
                                    <span>2</span>
                                    <div>Chọn nhân viên</div>
                                </li>
                                <li class="step-done step_3">
                                    <span>3</span>
                                    <div>Xác nhận</div>
                                </li>
                                <li class="step-done step_4">
                                    <span>4</span>
                                    <div>Cam kết</div>
                                </li>
                                <li class="step-done step_5">
                                    <span>5</span>
                                    <div>Đặt cọc </div>
                                </li>
                                <li class="step-done step_6">
                                    <span>6</span>
                                    <div>Làm việc</div>
                                </li>
                                <li class="step-current step_7">
                                    <span>7</span>
                                    <div>Hoàn tất</div>
                                </li>
                                <div class="clear-fix"></div>    
                            </ul>
                            <div class="clear-fix"></div>    
                        </div>
                    </div>
                </div>
                <!-- introduce item -->

            </div>

            <div class="row">
                <?php
                $form = ActiveForm::begin();
                echo $form->field($model, '_id')->hiddenInput()->label(FALSE);
                ?>    
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="well no-radius">
                        <h3 class="text-blue">Chúc mừng! Công việc của bạn đã được hoàn tất</h3>
                        <h4><b>Chi tiết công việc của bạn:</b></h4>
                        <p><?= $job->description ?></p>
                        <p><b>File bàn giao:</b> <a href="#"><b>File 1</b></a>  <a href="#"><b>File 2</b></a></p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>