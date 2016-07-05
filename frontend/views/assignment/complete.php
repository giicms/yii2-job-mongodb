<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Hoàn thành công việc';
?>

<section>
    <div class="introduce progress-work">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row-steps">
                        <div class="step-nv steps col-md-12- col-sm-12 col-xs-12">
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
                                    <div>Làm việc</div>
                                </li>
                                <li class="step-done step_6">
                                    <span>6</span>
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
                <?= $this->render('_infojob', ['job' => $job, 'model' => $model, 'bid' => $bid]) ?>
                <div class="col-md-4 col-sm-12 col-xs-12 profile-member">
                    <div class="profile-content">
                        <h4 class="title-box"><strong>Thông tin book việc của bạn </strong></h4>
                        <p><strong><i class="fa fa-usd fa-2"></i> Chào giá: <?= number_format($model->bid->price, 0, '', '.') ?></strong></p>
                        <p><strong><i class="fa fa-calendar"></i> Thời gian hoàn tất:</strong> <?= date('d/m/Y', $bid->period) ?></p>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 col-xs-12">    

                    <!-- TAB progress of work -->
                    <div class="list-project">
                        <ul class="nav nav-tabs">
                            <li class="step-done"><a data-toggle="tab">Tiến độ làm việc</a></li>
                            <li class="step-done"><a data-toggle="tab">Hoàn thành công việc</a></li>
                        </ul>
                        <div class="tab-content">

                            <!-- duyet cong viec -->
                            <div class="tab-pane fade in active ">
                                <h3 class="text-center text-blue">Chúc mừng! Công việc của bạn đã được hoàn tất</h3>
                                <p></p>
                                <h4><strong>Chi tiết công việc</strong></h4>
                                <?= $job->description ?>
                                <hr>
                                <strong>File bàn giao: </strong> <a href="#"><strong>File 1</strong></a>
                              
                            </div>

                        </div>    
                    </div>
                </div>
                <?= $this->render('_infoboss', ['job' => $job, 'countjob' => $countjob, 'countassignment' => $countassignment, 'bid' => $bid, 'created_at' => $created_at]) ?>
            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
