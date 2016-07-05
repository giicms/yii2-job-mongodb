<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đánh giá boss';
?>
<section>
    <div class="introduce progress-work">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row-steps">
                        <div class="steps col-md-12- col-sm-12 col-xs-12">
                            <ul class="list-unstyled">
                                <li class="step-done step_1 col-md-4 col-sm-4 col-xs-12">
                                    <span>1</span>
                                    <div>Book việc</div>
                                </li>
                                <li class="step-done step_2 col-md-4 col-sm-4 col-xs-12">
                                    <span>2</span>
                                    <div>Cam kêt & làm việc</div>
                                </li>
                                <li class="step-done step_3 col-md-4 col-sm-4 col-xs-12">
                                    <span>3</span>
                                    <div>Hoàn thành & nghiệm thu</div>
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

                <div class="col-md-8 col-sm-12 col-xs-12 list-project review-box">    
                    <div class="tab-content">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <ul class="list-unstyled">
                                    <li class="row marginbottom-x">
                                    <lable class="col-lg-6"><b>Tiêu chí đánh giá</b></lable>
                                    <div class="col-lg-6">0..................5..................10</div>
                                    </li>
                                    <li class="row">
                                    <lable class="col-lg-6">Đăng giá tiền</lable>
                                    <div class="col-lg-6 review">
                                        <div class="progress-review">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                    <span class="sr-only">60% Complete</span>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <b>7.0</b>
                                        </div>
                                    </div>
                                    </li>
                                    <li class="row">
                                    <lable class="col-lg-6">Vị trí</lable>
                                    <div class="col-lg-6 review">
                                        <div class="progress-review">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                    <span class="sr-only">60% Complete</span>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <b>7.0</b>
                                        </div>
                                    </div>
                                    </li>
                                    <li class="row">
                                    <lable class="col-lg-6">Thái độ phục vụ</lable>
                                    <div class="col-lg-6 review">
                                        <div class="progress-review">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                    <span class="sr-only">60% Complete</span>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <b>7.0</b>
                                        </div>
                                    </div>
                                    </li>
                                    <li class="row">
                                    <lable class="col-lg-6">Điều kiện vệ sinh khách sạn</lable>
                                    <div class="col-lg-6 review">
                                        <div class="progress-review">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                    <span class="sr-only">60% Complete</span>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <b>7.0</b>
                                        </div>
                                    </div>
                                    </li>
                                    <li class="row">
                                    <lable class="col-lg-6">Tiêu chuẩn / chất lượng phòng</lable>
                                    <div class="col-lg-6 review">
                                        <div class="progress-review">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                    <span class="sr-only">60% Complete</span>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <b>7.0</b>
                                        </div>
                                    </div>
                                    </li>
                                    <li class="row">
                                    <lable class="col-lg-6">Thức ăn / Bữa ăn</lable>
                                    <div class="col-lg-6 review">
                                        <div class="progress-review">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                    <span class="sr-only">60% Complete</span>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="pull-right">
                                            <b>7.0</b>
                                        </div>
                                    </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="review-point">
                                    <h4 class="color">HÀI LÒNG</h4>
                                    <span>7.0</span>
                                </div>
                            </div>
                        </div>
                        <h4><strong>Viết nhận xét </strong></h4>
                        <!-- text message -->
                        <div class="text-message">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="comment-form form-horizontal">
                                        <div class="">
                                            <textarea class="form-control" style="height: 55px;" placeholder="Viết tin nhắn..."></textarea>
                                        </div>
                                        <div class="select-item text-right">
                                            <button type="submit" class="btn btn-blue pull-right">Gửi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End text message --> 
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">

                    <div class="well no-radius">
                        <div class="info">
                            <div class="profile">
                                <img width="100" class="avatar img-circle" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($bid->job->user->avatar) ? '60-' . $bid->job->user->avatar : "avatar.png" ?>">
                            </div>
                            <div class="profile-content text-left">
                                <h5><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['boss/user', 'id' => $bid->job->owner]) ?>"><b><?= $bid->job->user->name ?></b></a></h5>
                                <p>
                                    Đánh giá: 
                                    <span class="star text-blue">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </span> 5.0
                                </p>
                                <p><i class="fa fa-map-marker"></i> <?= $bid->job->user->location->name ?>, <?= $bid->job->user->location->city->name ?></p>
                            </div>
                        </div>
                        <p><b><?= $countjob ?> việc làm đã đăng </b></p>
                        <p><?= $countassignment ?> việc đã giao </p>
                        <p><b>22.000.000 VND đã chi </b></p>
                        <p>tiền thanh toán cho nhân viên </p>
                        <hr>
                        <h4>Tiến độ thực hiện công viêc</h4>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                100% Complete
                            </div> 
                        </div>
                        <p style="margin: 10px 0">100% hoàn tất<a href="#" class="pull-right"><small>Xem chi tiết</small></a></p>
                        <div>
                            <p><b>Trạng thái: </b>hoàn tất</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
