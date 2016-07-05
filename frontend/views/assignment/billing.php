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
                    <h4 class="title-box">Thông tin thanh toán</h4>
                    <div class="table-responsive payment">
                        <table class="table table-bordered">
                            <thead>
                            <th>Công việc cần thanh toán</th>
                            <th>Thanh toán lần 1</th>
                            <th>Thanh toán lần 2</th>
                            <th>Tổng cộng phải thanh toán</th>
                            </thead>
                            <tbody>
                            <td>
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <b>Tiêu đề công việc:</b>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <p><a href="#"><?= $job->name ?></a></p>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <b>Thuộc danh mục công việc:</b>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <p><?= $job->category->name ?></p>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <b>Chi phí dự án: </b>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <p><?= number_format($bid->price, 0, '', '.'); ?> VNĐ</p>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <b>Thời gian hoàn tất:</b>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <p><?= date('d/m/Y', $bid->period) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td><p class="text-blue"><b><?= number_format($bid->price * 40 / 100, 0, '', '.') ?> VNĐ</b></p><p> (Đã thanh toán)</p></td>
                            <td><p class="text-blue"><b><?= number_format($bid->price * 60 / 100, 0, '', '.') ?> VNĐ</b></p></td>
                            <td><p class="text-blue"><b><?= number_format($bid->price, 0, '', '.') ?> VNĐ</b></p></td>
                            </tbody>
                        </table>
                    </div>
                    <h4 class="title-box">Phương thức thanh toán<small class="pull-right"><a href="#">Xem hướng dẫn</a></small></h4>
                </div>

                <div class="col-md-6 col-sm-3 col-xs-12">
                    <div class="radio">
                        <label>
                            <input type="radio" name="Assignment[payment]" value="1" >
                            Thẻ ATM ngân hàng nội địa (miễn phí)
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="Assignment[payment]" value="2">
                            Thẻ VISA/Master Card (miễn phí)
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" checked name="Assignment[payment]" value="3">
                            Nhân viên thu tiền khi giao dịch
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="Assignment[payment]" value="4">
                            Chuyển khoản ngân hàng
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="Assignment[payment]" value="5">
                            Bảo kim
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="Assignment[payment]" value="6">
                            Ngân lượng
                        </label>
                    </div>
                </div>
                <div class="col-md-6 col-sm-9 col-xs-12">
                    <div class="well">
                        <i class="icon icon-onepay"></i>
                        <p>
                            Thanh toán bằng thẻ tín dụng Visa hoặc MasterCard có hỗ trợ tính năng bảo mật 
                            Verified By Visa & MasterCard SecureCode
                        </p>
                        <div class="item-card">
                            <i class="icon icon-visa"></i>
                            <i class="icon icon-mestacard"></i>
                            <i class="icon icon-visa-verified"></i>
                            <i class="icon icon-mestacard-sourecode"></i>
                        </div>
                        <p>Giao dịch được thanh toán bằng VNĐ thông qua cổng <span class="color">OnePay</span>, an toàn và bảo mật</p>
                    </div>
                </div>
                <?php if (Yii::$app->session->hasFlash('success')) { ?>
                <div class="row">
                    <div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                        <?= Yii::$app->session->getFlash('success') ?>
                    </div>
                    </div>
                </div>    
                <?php } else { ?>
                    <button type="submit" class="btn btn-blue">Thanh toán chi phí </button>
                    <?php } ?>
                    <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</section>