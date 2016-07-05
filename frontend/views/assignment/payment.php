
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đặt cọc thanh toán';
?>
<section>
    <div class="introduce commitments">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row-steps">
                        <div class="steps-boss steps col-md-12- col-sm-12 col-xs-12">
                            <ul class="list-unstyled">
                                <li class="step-done step_1 col-md-3 col-sm-3 col-xs-6">
                                    <span>1</span>
                                    <div>Đăng việc</div>
                                </li>
                                <li class="step-done step_2 col-md-3 col-sm-3 col-xs-6">
                                    <span>2</span>
                                    <div>Chọn nhân viên</div>
                                </li>
                                <li class="step-done step_3 col-md-3 col-sm-3 col-xs-6">
                                    <span>3</span>
                                    <div>Cam kết & làm việc</div>
                                </li>
                                <li class="step_4 col-md-3 col-sm-3 col-xs-6">
                                    <span>4</span>
                                    <div>Thanh toán & nghiệm thu</div>
                                </li>
                                <div class="clear-fix"></div>    
                            </ul>
                            <div class="clear-fix"></div>    
                        </div>
                    </div>
                    <div class="title-container">
                        <h3 style="margin-bottom:15px;"><?= $this->title ?> </h3>
                    </div>
                </div>
                <!-- introduce item -->

            </div> 
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="info-payment">
                        <div class="alert alert-success">
                            <ul>
                                <li>Công việc đã được giao. Hãy nạp tiền để công việc được bắt đầu.</li>
                                <li>Vui lòng điền mã số công việc của bạn khi chuyển khoản: <span style="font-size:18px;font-weight:500;" class="text-blue"><?=$model->job->job_code?></span>.</li>
                            </ul>
                        <p><small><?= Html::a('Tiền nạp vào công việc được sử dụng như thế nào?', ['page/index', 'slug' => 'quan-ly-tien-cong-viec'], ['target'=> '_blank']); ?></small></p>
                        </div>
                        
                    </div>
                    
                    <h4 class="title-box">Thông tin thanh toán</h4>
                    <div class="table-responsive payment">
                        <table class="table table-bordered">
                            <thead>
                            <th style="width:57%">Công việc cần thanh toán</th>
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
                                        <p><a target="_blank" href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a></b>
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
                                        <p><?=$model->bid->period; ?> ngày</p>
                                    </div>
                                </div>
                            </td>
                            <input type="hidden" name="Assignment[price_deposit]" value="<?= $bid->price * 40 / 100 ?>">
                            <td><p class="text-blue"><b><?= number_format($bid->price * $bid->job->category->deposit / 100, 0, '', '.') ?> VNĐ</b></p><p> (Đặt cọc trước <?=$bid->job->category->deposit?>%)</p></td>
                            <td><p class="text-blue"><b><?= number_format($bid->price * (100 - ($bid->job->category->deposit)) / 100, 0, '', '.') ?> VNĐ</b></p></td>
                            <td><p class="text-blue"><b><?= number_format($bid->price, 0, '', '.') ?> VNĐ</b></p></td>
                            </tbody>
                        </table>
                    </div>
                    <h4 class="title-box">Phương thức thanh toán<small class="pull-right"><a href="#">Xem hướng dẫn</a></small></h4>
                </div>

                <div class="col-md-6 col-sm-3 col-xs-12">
                    <div class="tab-payment">
                        <ul>
                            <li>
                                <a href="javascript:;" id="tabone" class="methodpayment">Cách 1: Chuyển khoản ngân hàng <i class="fa fa-angle-down"></i></a>
                                <div class="tabone tab-methodpayment">
                                    <div class="post-content">
                                        <p>Ngân hàng: <b>Ngân hàng thương mại cổ phần Ngoại Thương - Vietcombank</b></p>
                                        <p>Chủ tài khoản: <b>Trần Ngọc Tuân</b></p>
                                        <p>Số tài khoản: <b>0011004141791</b></p>
                                        <p>Chi nhánh: <b>Sở giao dịch Hà Nội - Ngân hàng TMCP Ngoại Thương Vietcombank</b></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;" id="tabtwo" class="methodpayment">Cách 2: Nạp tiền trực tiếp tại Giaonhanviec <i class="fa fa-angle-down"></i></a>
                                <div class="tabtwo tab-methodpayment">
                                    <div class="post-content">
                                        <p><b>Công ty TNHH GIAO NHẬN VIỆC</b></p>
                                        <p>SDT:<b> 0511 3 456 789</b></p>
                                        <p>Email:<b> info@giaonhanviec.com</b>
                                        </p>Địa chỉ:<b> 35 Lê Văn Hưu, P.Mỹ An, Q.Ngũ Hành Sơn, Tp.Đà Nẵng</b></p>
                                    </div>
                                </div>
                            </li>
                        </ul>
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

                <div class="col-sm-12">
                    
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->registerJs("$(document).ready(function(){
    $('.tab-payment .methodpayment').click(function() {
        var div = $(this).attr('id');
        $('.selected').removeClass( 'selected' );
        $( this ).parent().addClass( 'selected' );
    });
});") ?>

