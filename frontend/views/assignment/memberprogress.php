<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Assignment;
use common\models\User;

$this->title = 'Tiến độ làm việc';
?>
<style>
    .disabledTab{
        pointer-events: none;
    }
    .is-countdown {
        border: 1px solid #ccc;
        background-color: #eee;
    }
    .progress-work .the-time .count label span { width:100% !important;}
    .circles{
        float: left;
        width: 25%;
        margin: 0;
        padding: 0;
    }
    .circles span{
        font-size: 60px;
        font-weight: bold;
        color: #02a8df;
        line-height: 30px;
    }
    .circles h4{
        font-size: 14px;
        color: #02a8df;
    }
</style>

<section>
    <div class="introduce progress-work">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row-steps">
                        <div class="step-nv steps col-md-12- col-sm-12 col-xs-12">
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


                <div class="col-md-8 col-sm-12 col-xs-12">
                    <h2 class="job-title text-blue"><?= $job->name ?></h2>
                    <p><label class="button"><?= $job->category->name ?></label> Đăng cách đây <?= Yii::$app->convert->time($job->created_at) ?></p>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 profile-member">
                    <?php
                    if ($model->status_boss == Assignment::STATUS_COMPLETE) {
                        echo '<button class="btn btn-success">Công việc đã kết thúc</button>';
                    }
                    ?>
                    <?php
                    $form = ActiveForm::begin(['id' => 'formMessages']);
                    echo $form->field($model, '_id')->hiddenInput()->label(FALSE);
                    ?>
                    <?php if ($model->status_member == Assignment::STATUS_REQUEST && $model->status_boss < Assignment::STATUS_REQUEST) { ?>
                        <div class="alert alert-danger" role="alert">
                            <p>Chờ khách hàng xác nhận hoàn thành</p>
                        </div>
                    <?php } if ($model->status_member < Assignment::STATUS_REQUEST) { ?>
                        <button type="submit" class="btn btn-blue " style="width:100%">Xác nhận hoàn thành công việc</button>
                    <?php } if ($model->status_member == Assignment::STATUS_REQUEST && $model->status_boss == Assignment::STATUS_REQUEST) { ?>
                        <div class="alert alert-danger" role="alert">
                            <p>Khách hàng đã chấp nhận hoàn thành công việc, Chờ nghiệm thu và kết thúc công việc.</p>
                        </div>
                    <?php } ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="col-md-8 col-sm-12 col-xs-12"> 
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
                            <h2>Chào giá của bạn</h2>
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
                                        <?php if (!empty($bid)) { ?>
                                            <tr>
                                                <td style="width: 15%">
                                                    <div class="info">
                                                        <div class="profile">
                                                            <img class="avatar img-circle" width="100" src="<?= Yii::$app->params['url_file'] ?>thumbnails/<?= !empty($bid->user->avatar) ? '150-' . $bid->user->avatar : "avatar.png" ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 25%">
                                                    <div class="info">
                                                        <p><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $bid->user->slug) ?>"><b><?= $bid->user->name; ?></b></a></p>
                                                        <p><b><?= !empty($bid->user->findcategory->name) ? $bid->user->findcategory->name : ""; ?></b></p>
                                                        <p><i class="fa fa-map-marker"></i> <b><?= $bid->user->location->name ?>, <?= $bid->user->location->city->name ?></b></p>
                                                    </div>
                                                </td>
                                                <td class="text-right" style="width: 35%">
                                                    <p><b><?= $bid->user->findlevel->name ?></b></p>
                                                    <p><b><?= $bid->user->countjobdone ?></b> việc đã hoàn thành</p>
                                                    <p>
                                                        Đánh giá: 
                                                        <span class="star text-blue">
                                                            <?= $bid->user->getStar($bid->user->rating); ?>
                                                        </span> <?= $bid->user->getCountReview($bid->user->_id); ?><i class="fa fa-user"></i>
                                                    </p>
                                                </td>
                                                <td class="text-right" style="width: 25%">
                                                    <h3 class="text-blue"><?= number_format($bid->price, 0, '', '.') ?></h3>
                                                    <p class="text-gray"><?= $bid->period ?> ngày</p>
                                                    <p>
                                                        <button class="btn btn-red">ĐÃ GIAO VIỆC</button>   
                                                    </p>
                                                </td>
                                            </tr>
                                        <?php } ?>
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
                                            <?= number_format($model->bid->price - $model->deposit->value, 0, '', '.') ?>VNĐ (<?= 100 - ($model->deposit->value / $model->bid->price * 100) ?>%)
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
                            ?>
                            <li class="row">
                                <div class="col-sm-5 col-xs-5">Trạng thái</div>
                                <div class="col-sm-7 col-xs-7"><?= $job->getStatus($job->_id); ?></div>
                            </li>
                        </ul>
                    </div>
                    <?= $this->render('_infoboss', ['job' => $job, 'countjob' => $countjob, 'countassignment' => $countassignment, 'bid' => $bid, 'created_at' => $created_at]) ?>
                </div> 
            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
<?= $this->registerJs('$("#DateCountdown").TimeCircles();') ?>

