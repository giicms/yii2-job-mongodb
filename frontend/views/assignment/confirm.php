<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Xác nhận yêu cầu làm việc';
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
                                    <div>Book việc</div>
                                </li>
                                <li class="step-done step_2">
                                    <span>2</span>
                                    <div>Chọn nhân viên</div>
                                </li>
                                <li class="step-current step_3">
                                    <span>3</span>
                                    <div>Xác nhận</div>
                                </li>
                                <li class="step_4">
                                    <span>3</span>
                                    <div>Cam kết</div>
                                </li>
                                <li class="step_5">
                                    <span>4</span>
                                    <div>Làm việc</div>
                                </li>
                                <li class="step_6">
                                    <span>5</span>
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
                            <li class="step-done active"><a data-toggle="tab" href="#sectionA">Xác nhận yêu cầu</a></li>
                            <li class="step-current "><a data-toggle="tab" href="#sectionB">Tiến độ làm việc</a></li>
                            <li class="step-last"><a data-toggle="tab" href="#sectionC">Duyệt công việc</a></li>
                        </ul>
                        <div class="tab-content">
                            <?php $form = ActiveForm::begin(['id' => 'formJob']); ?>    
                            <?= $form->field($model, '_id')->hiddenInput()->label(FALSE) ?>
                            <!-- xac nhan yeu cau -->
                            <div id="sectionA" class="tab-pane fade in active">

                                <div class="well boss-job">
                                    <h4>Chi tiết công việc</h4>
                                    <p>
                                        <?= $job->description ?> 
                                    </p>
                                    <p>
                                        <?php
                                        if (!empty($job->file)) {
                                            ?>
                                            <i class="fa fa-paperclip fa-2x"></i> 
                                            <a href="<?= $job->file[0] ?>"><strong>Mở file đính kèm</strong></a>
                                            <?php
                                        }
                                        ?>
                                    </p>
                                </div>

                                <!-- End text message -->



                            </div>

                        </div>    
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">   
                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $job->user->slug) ?>" target="_blank" class="btn btn-blue pull-right">Liên hệ</a>
                        </div>
                    </div>
                    <p class="text-center">Khách hàng đã giao việc cho bạn</p>
                    <?php if (Yii::$app->session->hasFlash('success')) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-12 col-sm-12 col-xs-12"><button class="btn btn-blue " style="width:100%" type="submit">Xác nhận yêu cầu </button></div>
                        <?php } ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <?= $this->render('_infoboss', ['job' => $job, 'countjob' => $countjob, 'countassignment' => $countassignment]) ?>
                </div>
            </div>
        </div>
    </section>
    <?= $this->render('_tabjs', ['job' => $job]) ?>