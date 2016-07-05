<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Assignment;

$this->title = 'Duyệt công việc';
?>
<style>
    .disabledTab{
        pointer-events: none;
    }
</style>

<section>
    <div class="introduce progress-work">
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
                                <li class="step-done step_4 col-md-3 col-sm-3 col-xs-6">
                                    <span>4</span>
                                    <div>Thanh toán & nghiệm thu</div>
                                </li>
                                <div class="clear-fix"></div>    
                            </ul>
                            <div class="clear-fix"></div>    
                        </div>
                        <div class="clear-fix"></div>  
                    </div>
                </div>
                <!-- introduce item -->

            </div>

            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <h2 class="job-title text-blue"><?= $job->name ?></h2>
                    <p><label class="button"><?= $job->category->name ?></label> Đăng cách đây <?= Yii::$app->convert->time($job->created_at) ?></p>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p>Hạn nhận chào giá: <b><?= date('d/m/Y', $job->deadline) ?></b></p>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p>
                                Ngân sách dự kiến
                                <b>    <?php
                                    if ($job->project_type == common\models\Job::WORK_HOURS) {
                                        echo number_format($job->price, 0, '', '.') . ' VNĐ';
                                    } else {
                                        echo $job->budget->name;
                                    }
                                    ?>
                                </b>
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p><b><?= count($job->getBId()) ?> </b>Nhân viên book việc </p>
                        </div>
                    </div> 
                </div>
                <!-- button book -->
                <div class="col-md-4 col-sm-12 col-xs-12 profile-member">
                    <?php
                    if (($model->status_boss == Assignment::STATUS_COMPLETE)&&($model->status_boss == Assignment::STATUS_REVIEW)) {
                        echo '<button class="btn btn-success">Công việc đã kết thúc</button>';
                    }
                    ?>
                </div>
                <!-- End button book -->
                <div class="col-md-8 col-sm-12 col-xs-12">    
                    <?php
                    $deposit = $job->category->deposit;
                    //khong can dat coc, thanh toan 100% khi ket thuc
                    if ($deposit == 0 || empty($deposit)) {
                        //da xac nhan hoan thanh
                        if ($model->status_boss >= Assignment::STATUS_REQUEST) {
                            if (($model->status_boss >= Assignment::STATUS_REQUEST) && ($model->status_boss < Assignment::STATUS_COMPLETE)) {
                                ?>
                                <div class="info-payment">
                                    <div class="alert alert-success">
                                        <ul>
                                            <li>Công việc đã hoàn thành. Hãy thanh toán khoản để nghiệm thu công việc.</li>
                                            <li>Vui lòng điền mã số công việc của bạn khi chuyển khoản: <span style="font-size:18px;font-weight:500;" class="text-blue"><?= $model->job->job_code ?></span>.</li>
                                        </ul>
                                        <p><small><?= Html::a('Tiền nạp vào công việc được sử dụng như thế nào?', ['page/index', 'slug' => 'quan-ly-tien-cong-viec'], ['target' => '_blank']); ?></small></p>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="well">
                                <h4 class="title-box">Thông tin thanh toán</h4>
                                <div class="table-responsive payment">
                                    <table class="table table-bordered">
                                        <thead>
                                        <th style="width:57%">Công việc cần thanh toán</th>
                                        <th>Thanh toán</th>
                                        </thead>
                                        <tbody>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <b>Tiêu đề công việc:</b>
                                                </div>
                                                <div class="col-md-7 col-sm-6 col-xs-12">
                                                    <p><a target="_blank" href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a></b>
                                                </div>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <b>Danh mục:</b>
                                                </div>
                                                <div class="col-md-7 col-sm-6 col-xs-12">
                                                    <p><?= $job->category->name ?></p>
                                                </div>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <b>Chi phí dự án: </b>
                                                </div>
                                                <div class="col-md-7 col-sm-6 col-xs-12">
                                                    <p><?= number_format($bid->price, 0, '', '.'); ?> VNĐ</p>
                                                </div>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <b>Thời gian hoàn tất:</b>
                                                </div>
                                                <div class="col-md-7 col-sm-6 col-xs-12">
                                                    <p><?= $model->bid->period; ?> ngày</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-blue"><?= number_format($bid->price, 0, '', '.') ?> VNĐ</p>
                                            <p>
                                                <?php
                                                if ($model->status_boss < Assignment::STATUS_PAYMENT) {
                                                    echo '(Chưa thanh toán)';
                                                } else {
                                                    echo '(Đã thanh toán)';
                                                    echo date('d/m/Y', $model->paymentday->updated_at);
                                                }
                                                ?>
                                            </p>
                                        </td>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if ($model->status_boss < Assignment::STATUS_COMPLETE) { ?>
                                    <h4 class="title-box">Phương thức thanh toán</h4>
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
                                <?php } ?>
                            </div>
                            <?php
                        }
                    }
                    // phai dat coc truoc, va thanh toan khi ket thuc
                    if ($deposit > 0 && $deposit < 100) {
                        ?>

                        <!-- THONG BAO DAT COC / THANH TOAN -->
                        <?php
                        //da giao viec
                        if ($model->status_boss == Assignment::STATUS_GIVE) {
                            ?>
                            <div class="info-payment">
                                <div class="alert alert-success">
                                    <ul>
                                        <li>Công việc đã sẵn sàng. Hãy đặt cọc để bắt đầu công việc.</li>
                                        <li>Vui lòng điền mã số công việc của bạn khi chuyển khoản: <span style="font-size:18px;font-weight:500;" class="text-blue"><?= $model->job->job_code ?></span>.</li>
                                    </ul>
                                    <p><small><?= Html::a('Tiền nạp vào công việc được sử dụng như thế nào?', ['page/index', 'slug' => 'quan-ly-tien-cong-viec'], ['target' => '_blank']); ?></small></p>
                                </div>
                            </div>
                        <?php } if ($model->status_boss == Assignment::STATUS_REQUEST) { ?>
                            <div class="info-payment">
                                <div class="alert alert-success">
                                    <ul>
                                        <li>Công việc đã hoàn thành. Hãy thanh toán khoản để nghiệm thu công việc.</li>
                                        <li>Vui lòng điền mã số công việc của bạn khi chuyển khoản: <span style="font-size:18px;font-weight:500;" class="text-blue"><?= $model->job->job_code ?></span>.</li>
                                    </ul>
                                    <p><small><?= Html::a('Tiền nạp vào công việc được sử dụng như thế nào?', ['page/index', 'slug' => 'quan-ly-tien-cong-viec'], ['target' => '_blank']); ?></small></p>
                                </div>
                            </div>
                        <?php } ?>


                        <div class="well">
                            <h4 class="title-box">Thông tin thanh toán</h4>
                            <div class="table-responsive payment">
                                <table class="table table-bordered">
                                    <thead>
                                    <th style="width:57%">Công việc cần thanh toán</th>
                                    <th>Thanh toán lần 1</th>
                                    <th>Thanh toán lần 2</th>
                                    <th>Tổng cộng</th>
                                    </thead>
                                    <tbody>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <b>Tiêu đề công việc:</b>
                                            </div>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <p><a target="_blank" href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a></b>
                                            </div>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <b>Danh mục:</b>
                                            </div>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <p><?= $job->category->name ?></p>
                                            </div>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <b>Chi phí dự án: </b>
                                            </div>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <p><?= number_format($bid->price, 0, '', '.'); ?> VNĐ</p>
                                            </div>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <b>Thời gian hoàn tất:</b>
                                            </div>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <p><?= $model->bid->period; ?> ngày</p>
                                            </div>
                                        </div>
                                    </td>
                                    <input type="hidden" name="Assignment[price_deposit]" value="<?= $bid->price * 40 / 100 ?>">
                                    <td>
                                        <p class="text-blue">
                                            <?php
                                            if ($model->status_boss < Assignment::STATUS_DEPOSIT) {
                                                echo number_format($model->bid->price * $model->bid->job->category->deposit / 100, 0, '', '.') . 'VNĐ (' . $model->bid->job->category->deposit . '%)';
                                            }
                                            ?>
                                            <?php
                                            if ($model->status_boss >= Assignment::STATUS_DEPOSIT) {
                                                echo number_format($model->deposit->value, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>
                                        </p>
                                        <?php
                                        if ($model->status_boss < Assignment::STATUS_DEPOSIT) {
                                            echo '<p>(Chưa đặt cọc)</p>';
                                        }
                                        ?>
                                        <?php
                                        if ($model->status_boss >= Assignment::STATUS_DEPOSIT) {
                                            echo '<p>(Đã đặt cọc)</p>';
                                            echo date('d/m/Y', $model->depositday->updated_at);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <p class="text-blue">
                                            <?php if ($model->status_boss < Assignment::STATUS_DEPOSIT) { ?>
                                                <?= number_format($model->bid->price * (100 - ($model->bid->job->category->deposit)) / 100, 0, '', '.') ?>VNĐ (<?= 100 - $model->bid->job->category->deposit ?>%)
                                            <?php }if ($model->status_boss >= Assignment::STATUS_DEPOSIT) { ?>
                                                <?= number_format($model->bid->price - $model->deposit->value, 0, '', '.') ?>VNĐ
                                            <?php } ?>
                                        </p>
                                        <?php
                                        if ($model->status_boss < Assignment::STATUS_PAYMENT) {
                                            echo '<p>(Chưa thanh toán)</p>';
                                        }
                                        ?>
                                        <?php
                                        if ($model->status_boss >= Assignment::STATUS_PAYMENT) {
                                            echo '<p>(Đã thanh toán)</p>';
                                            echo date('d/m/Y', $model->paymentday->updated_at);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <p class="text-blue"><?= number_format($bid->price, 0, '', '.') ?> VNĐ</p>
                                    </td>
                                    </tbody>
                                </table>
                            </div>
                            <?php if ($model->status_boss < Assignment::STATUS_COMPLETE) { ?>
                                <h4 class="title-box">Phương thức thanh toán</h4>
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
                            <?php } ?>
                        </div>
                        <?php
                    }
//phai thanh toan 100% truoc khi lam viec
                    if ($deposit == 100) {
                        ?>
                        <div class="info-payment">
                            <div class="alert alert-success">
                                <ul>
                                    <li>Công việc đã được giao. Hãy thanh toán bắt đầu công việc.</li>
                                    <li>Vui lòng điền mã số công việc của bạn khi chuyển khoản: <span style="font-size:18px;font-weight:500;" class="text-blue"><?= $model->job->job_code ?></span>.</li>
                                </ul>
                                <p><small><?= Html::a('Tiền nạp vào công việc được sử dụng như thế nào?', ['page/index', 'slug' => 'quan-ly-tien-cong-viec'], ['target' => '_blank']); ?></small></p>
                            </div>
                        </div>
                        <div class="well">
                            <h4 class="title-box">Thông tin thanh toán</h4>
                            <div class="table-responsive payment">
                                <table class="table table-bordered">
                                    <thead>
                                    <th style="width:57%">Công việc cần thanh toán</th>
                                    <th>Thanh toán</th>
                                    </thead>
                                    <tbody>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <b>Tiêu đề công việc:</b>
                                            </div>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <p><a target="_blank" href="<?= Yii::$app->urlManager->createAbsoluteUrl('cong-viec/' . $job->slug . '/' . (string) $job->_id) ?>"><b><?= $job->name ?></b></a></b>
                                            </div>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <b>Danh mục:</b>
                                            </div>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <p><?= $job->category->name ?></p>
                                            </div>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <b>Chi phí dự án: </b>
                                            </div>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <p><?= number_format($bid->price, 0, '', '.'); ?> VNĐ</p>
                                            </div>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <b>Thời gian hoàn tất:</b>
                                            </div>
                                            <div class="col-md-7 col-sm-6 col-xs-12">
                                                <p><?= $model->bid->period; ?> ngày</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-blue"><?= number_format($bid->price, 0, '', '.') ?> VNĐ</p>
                                        <p>
                                            <?php
                                            if ($model->status_boss < Assignment::STATUS_DEPOSIT) {
                                                echo '(Chưa thanh toán)';
                                            } else {
                                                echo '(Đã thanh toán)';
                                                echo date('d/m/Y', $model->depositday->updated_at);
                                            }
                                            ?>
                                        </p>
                                    </td>
                                    </tbody>
                                </table>
                            </div>
                            <?php if ($model->status_boss < Assignment::STATUS_COMPLETE) { ?>
                                <h4 class="title-box">Phương thức thanh toán</h4>
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
                            <?php } ?>
                        </div>
                        <?php
                    }
                    ?>



                    <div class="x_panel tile">
                        <div class="x_title">
                            <h2>Mô tả công việc</h2>
                            <ul class="nav navbar-right panel_toolbox text-right">
                                <li class="pull-right"><a class="collapse-link"  ><i data-toggle="collapse" data-target="#jobcontent" class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div id="jobcontent" class="x_content collapse in">
                            <?= $job->description ?>
                        </div>
                    </div> 


                    <!-- chao gia -->
                    <div class="x_panel tile">
                        <div class="x_title">
                            <h2>Danh sách chào giá</h2>
                            <ul class="nav navbar-right panel_toolbox text-right">
                                <li class="pull-right"><a class="collapse-link"  ><i data-toggle="collapse" data-target="#booklist" class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div id="booklist" class="x_content collapse in">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr><th>Nhân viên</th><th></th><th class="text-right" >Thành tựu</th><th class="text-right" >Thời gian book</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($job->getBid())) {
                                            foreach ($job->getBid() as $value) {
                                                ?>
                                                <tr>
                                                    <td style="width: 15%">
                                                        <div class="info">
                                                            <div class="profile text-center">
                                                                <img class="avatar img-circle" width="100" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= !empty($value->user->avatar) ? '150-' . $value->user->avatar : "avatar.png" ?>">
																<a href="<?= Yii::$app->urlManager->createAbsoluteUrl('/tin-nhan/' . $value->user->slug) ?>" class="btn btn-blue contact">Liên hệ</a>
															</div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 25%">
                                                        <div class="info">
                                                            <p><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $value->user->slug) ?>"><b><?= $value->user->name; ?></b></a></p>
                                                            <p><b><?= !empty($value->user->findcategory->name) ? $value->user->findcategory->name : ""; ?></b></p>
                                                            <p><i class="fa fa-map-marker"></i> <b><?= $value->user->location->name ?>, <?= $value->user->location->city->name ?></b></p>
                                                        </div>
                                                    </td>
                                                    <td class="text-right" style="width: 35%">
                                                        <p><b><?= $value->user->findlevel->name ?></b></p>
                                                        <p><b><?= $value->user->countjobdone ?></b> việc đã hoàn thành</p>
                                                        <p>
                                                            Đánh giá: 
                                                            <span class="star text-blue">
                                                                <?= $value->user->getStar($value->user->rating); ?>
                                                            </span> <?= $value->user->getCountReview($value->user->_id); ?><i class="fa fa-user"></i>
                                                        </p>
                                                    </td>
                                                    <td class="text-right" style="width: 25%">
                                                        <h3 class="text-blue"><?= number_format($value->price, 0, '', '.') ?></h3>
                                                        <p class="text-gray"><?= $value->period ?> ngày</p>
                                                        <p>
                                                            <?php
                                                            if ($value->_id == $model->bid->_id) {
                                                                echo ' <button class="btn btn-red">ĐÃ GIAO VIỆC</button>  ';
                                                            }
                                                            ?> 
                                                        </p>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>  
                    <!-- End / chao gia -->    

                    <!-- tin nhan -->
                    <!--                    <div class="x_panel tile">
                                            <div class="x_title">
                                                <h2>Tin nhắn</h2>
                                                <ul class="nav navbar-right panel_toolbox text-right">
                                                    <li class="pull-right"><a class="collapse-link"  ><i data-toggle="collapse" data-target="#messagebox" class="fa fa-chevron-up"></i></a></li>
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div id="messagebox" class="x_content collapse in">
                                                cập nhật nội dung tin nhắn
                                            </div>
                                        </div> -->
                    <!--End / tin nhan -->  
                </div>

                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="well profile-member">
                        <h4 class="title-box"><strong>Thông tin công việc</strong></h4>
                        <ul class="list-unstyled">
                            <li class="row">
                                <div class="col-sm-5 col-xs-5">ID công việc</div>
                                <div class="col-sm-7 col-xs-7"><?= $job->job_code; ?></div>
                            </li>
                            <li class="row">
                                <div class="col-sm-5 col-xs-5">Ngày đăng</div>
                                <div class="col-sm-7 col-xs-7"><?= date('d/m/y H:i', $job->created_at); ?></div>
                            </li>
                            <li class="row">
                                <div class="col-sm-5 col-xs-5">Hạn chào giá</div>
                                <div class="col-sm-7 col-xs-7"><?= date('d/m/y', $job->deadline); ?></div>
                            </li>
                            <li class="row">
                                <div class="col-sm-5 col-xs-5">Địa điểm</div>
                                <div class="col-sm-7 col-xs-7"><?php
                                    if ($job->work_location == 1) {
                                        echo 'Toàn quốc';
                                    } else {
                                        echo $job->address . ', ' . $job->local->name . ', ' . $job->local->city->name;
                                    }
                                    ?></div>
                            </li>
                            <li class="row">
                                <div class="col-sm-5 col-xs-5">Ngân sách</div>
                                <div class="col-sm-7 col-xs-7"><?php
                                    if (!empty($model)) {
                                        echo number_format($model->bid->price, 0, '', '.');
                                    } else {
                                        echo '...';
                                    }
                                    ?> VNĐ</div>
                            </li>
                            <?php
                            if ($model->status_boss < Assignment::STATUS_COMPLETE) {
                                $deposit = $job->category->deposit;
                                if (!empty($deposit) || $deposit > 0) {
                                    ?>
                                    <li class="row">
                                        <div class="col-sm-5 col-xs-5">Đặt cọc</div>
                                        <div class="col-sm-7 col-xs-7">
                                            <?php
                                            if ($model->status_boss < Assignment::STATUS_DEPOSIT) {
                                                echo number_format($model->bid->price * $model->bid->job->category->deposit / 100, 0, '', '.') . 'VNĐ (' . $model->bid->job->category->deposit . '%)';
                                            }
                                            ?>
                                            <?php
                                            if ($model->status_boss >= Assignment::STATUS_DEPOSIT) {
                                                echo number_format($model->deposit->value, 0, '', '.') . 'VNĐ';
                                            }
                                            ?>

                                            <p>
                                                <?php
                                                if ($model->status_boss < Assignment::STATUS_DEPOSIT) {
                                                    echo '<b>(Chưa đặt cọc</b>)';
                                                }
                                                ?>
                                                <?php
                                                if ($model->status_boss >= Assignment::STATUS_DEPOSIT) {
                                                    echo '<b>(Đã đặt cọc)</b>';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </li>
                                    <li class="row">
                                        <div class="col-sm-5 col-xs-5">Thanh toán</div>
                                        <div class="col-sm-7 col-xs-7">
                                            <?php if ($model->status_boss < Assignment::STATUS_DEPOSIT) { ?>
                                                <?= number_format($model->bid->price * (100 - ($model->bid->job->category->deposit)) / 100, 0, '', '.') ?>VNĐ (<?= 100 - $model->bid->job->category->deposit ?>%)
                                            <?php }if ($model->status_boss >= Assignment::STATUS_DEPOSIT) { ?>
                                                <?= number_format($model->bid->price - $model->deposit->value, 0, '', '.') ?>VNĐ
                                            <?php } ?>

                                            <p>
                                                <?php
                                                if ($model->status_boss < Assignment::STATUS_PAYMENT) {
                                                    echo '<b>(Chưa thanh toán</b>)';
                                                }
                                                ?>
                                                <?php
                                                if ($model->status_boss >= Assignment::STATUS_PAYMENT) {
                                                    echo '<b>(Đã thanh toán)</b>';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </li>
                                    <?php
                                } else {
                                    
                                }
                            }
                            ?>
                            <?php if ($model->status_boss >= Assignment::STATUS_COMMITMENT) { ?>
                                <li class="row">
                                    <div class="col-sm-5 col-xs-5">Ngày bắt đầu</div>
                                    <div class="col-sm-7 col-xs-7"><?= date('d/m/Y', $model->startday); ?></div>
                                </li>
                            <?php } ?>
                            <?php if (($model->status_boss == Assignment::STATUS_COMPLETE)&&($model->status_boss == Assignment::STATUS_REVIEW)) { ?>
                                <li class="row">
                                    <div class="col-sm-5 col-xs-5">Ngày kết thúc</div>
                                    <div class="col-sm-7 col-xs-7"><?= date('d/m/Y', $model->endday); ?></div>
                                </li>
                            <?php } ?>
                            <li class="row">
                                <div class="col-sm-5 col-xs-5">Trạng thái</div>
                                <div class="col-sm-7 col-xs-7"><?= $job->getStatus($job->_id); ?></div>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
<?= $this->registerJs("$(document).ready(function(){
    $('.tab-payment .methodpayment').click(function() {
        var div = $(this).attr('id');
        $('.selected').removeClass( 'selected' );
        $( this ).parent().addClass( 'selected' );
    });
});") ?>
