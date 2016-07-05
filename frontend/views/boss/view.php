<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Hồ sơ cá nhân của ' . $user->name;
?>
<section>
    <div class="introduce profile-member">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <div class="profile-item">
                        <div class="profile">
                            <img class="img-circle avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($user->avatar) ? '150-' . $user->avatar : "avatar.png" ?>">
                            <div class="num-review">
                                <h5>Đánh giá: </h5> <span>5.0</span>
                            </div>
                        </div>
                        <div class="profile-content">
                            <ul class="list-unstyled text-left">
                                <li><h5><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['view', 'id' => (string) $user->_id]) ?>"><b><?= $user->name ?></b></a><small> - Hoạt động cách đây <?= Yii::$app->convert->time($user->created_at) ?></small></h5></li>

                            </ul>
                        </div>
                    </div>
                </div>  

                <div class="col-md-3 col-sm-4 col-xs-12 sidebar-profile ">
                    <div class="profile-item no-border">
                        <div class="profile-content">

                            <h4 class="title-box">Kinh nghiệm làm việc</h4>
                            <ul class="list-unstyled">
                                <li><b>31</b> đánh giá</li>
                                <li><b>56</b> việc làm đã nhận</li>
                                <li><b>100%</b> công việc đã hoàn thành</li>

                            </ul>
                            <h4 class="title-box">Thời gian có thể làm việc</h4>
                            <ul class="list-unstyled">
                                <li><i>✔</i> <b>Sẵng sàng làm việc</b></li>
                                <li><i>✔</i> <b>Toàn thời gian cố định</b></li>
                                <li><i>✔</i> <b>Phản hồi trong 24h</b></li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 col-sm-8 col-xs-12">    
                    <div class="profile-item">
                        <div class="profile-content">

                            <h4 class="title-box">Các công việc đã đăng và đánh giá (<?= count($job) ?>)</h4>
                            <?php
                            if (!empty($job)) {
                                foreach ($job as $value) {
                                    ?>
                                    <div class="review-item">
                                        <div class="row">
                                            <div class="col-md-9 col-sm-8 col-xs-12">
                                                <h4 class="text-blue"><?= $value->name ?></h4>
                                                <p><?=$value->name?></p>
                                            </div>
                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <ul class="text-right list-unstyled">
                                                    <li class="review">
                                                        <div class="progress-review">
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                                                    <span class="sr-only">60% Complete</span>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <b>4.0</b>
                                                    </li>
                                                    <li><b>15.000.000 VNĐ</b></li>
                                                    <li>Giá cố định</li>
                                                    <li>12/2014</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>

                            <h4 class="title-box">Đánh giá nhân viên</h4>
                            <div class="row">
                                <div class="col-md-8 col-sm-7 col-xs-12">
                                    <ul>
                                        <li class="row">
                                            <div class="col-lg-5"><h4>Tiêu chí đánh giá</h4></div>
                                            <div class="col-lg-7"><h4>0......................5........................10</h4></div>
                                        </li>
                                        <li class="row">
                                            <div class="col-lg-5">Đăng giá tiền</div>
                                            <div class="col-lg-7 review">
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
                                            <div class="col-lg-5">Vị trí</div>
                                            <div class="col-lg-7 review">
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
                                            <div class="col-lg-5">Thái độ phục vụ</div>
                                            <div class="col-lg-7 review">
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
                                            <div class="col-lg-5">Điều kiện vệ sinh khách sạn</div>
                                            <div class="col-lg-7 review">
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
                                            <div class="col-lg-5">Tiêu chuẩn / chất lượng phòng</div>
                                            <div class="col-lg-7 review">
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
                                            <div class="col-lg-5">Thức ăn / Bữa ăn</div>
                                            <div class="col-lg-7 review">
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
                                <div class="col-md-4 col-sm-5 col-xs-12">
                                    <div class="review-point">
                                        <h4 class="color">HÀI LÒNG</h4>
                                        <span>7.0</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</section>
