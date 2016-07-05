
<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Cam kết làm việc';
?>
<section>
    <div class="introduce commitments">
        <div class="container">
            <?php $form = ActiveForm::begin(); ?>    
            <div class="row">
                <div class="col-lg-12">
                    <div class="row-steps">
                        <div class="steps col-md-12- col-sm-12 col-xs-12">
                            <ul class="list-unstyled">
                                <li class="step-done step_1 col-md-3 col-sm-3 col-xs-6">
                                    <span>1</span>
                                    <div>Đăng việc</div>
                                </li>
                                <li class="step-done step_2 col-md-3 col-sm-3 col-xs-6">
                                    <span>2</span>
                                    <div>Chọn nhân viên</div>
                                </li>
                                <li class="step-current step_3 col-md-3 col-sm-3 col-xs-6">
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
                        <h3><?= $this->title ?></h3>
                    </div>
                </div>
                <!-- introduce item -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Tiêu đề công việc</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p><?= $job->name ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Thuộc danh mục công việc</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p><?= $job->category->name ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Mô tả công việc</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p><?= $job->description ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Loại hình công việc</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p>                  
                                <?php
                                if ($job->project_type == common\models\Job::WORK_HOURS) {
                                    echo 'Làm việc theo giờ';
                                } else {
                                    echo 'Làm việc theo gói';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>Ngân sách cho dự án</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p>                <?php
                                if ($job->project_type == common\models\Job::WORK_HOURS) {
                                    echo number_format($model->bid->price, 0, '', '.').' VNĐ';
                                } else {
                                    echo 'cập nhật gói';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <b>File đính kèm</b>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <p>            <?php
                                if (isset($job->file))
                                    echo 1;
                                else
                                    echo 0
                                    ?> File đính kèm</p>
                        </div>
                    </div>

                </div>    
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="profile-item no-border">
                        <h4 class="title-box">Thông tin người thuê</h4>
                        <div class="profile">
                            <img class="img-circle avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($job->user->avatar) ? '150-' . $job->user->avatar : "avatar.png" ?>">
                        </div>
                        <div class="profile-content">
                            <ul class="list-unstyled">
                                <li><h5><a href="/user/<?= (string) $job->user->_id ?>"><b><?= $job->user->name ?></b></a></h5></li>
                                <li><i class="fa fa-map-marker"></i> <b><?= $job->user->address . ', ' . $job->user->location->name . ', ' . $job->user->location->city->name ?></b></li>
                            </ul>

                        </div>


                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="profile-item no-border">
                        <h4 class="title-box">Thông tin người làm việc</h4>
                        <div class="profile">
                            <img class="img-circle avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($bid->user->avatar) ? '150-' . $bid->user->avatar : "avatar.png" ?>">
                        </div>
                        <div class="profile-content">
                            <ul class="list-unstyled">
                                <li><h5><a href="/profile/<?= (string) $bid->user->_id ?>"><b><?= $bid->user->name ?></b></a><small> - Hoạt động cách đây <?= Yii::$app->convert->time($bid->user->lastvisit) ?></small></h5></li>
                                <li><b><?= $bid->user->findcategory->name ?></b></li>
                                <li>Cấp độ: <b><?= $bid->user->findlevel->name ?></b></li>
                                <li><i class="fa fa-map-marker"></i> <b><?= $bid->user->location->name . ', ' . $bid->user->location->city->name ?></b> - <small>Test năng lực: <?= $bid->user->getTestpoint($bid->user->id); ?></small></li>

                            </ul>

                        </div>


                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="title-box"><b>Điều khoản cam kết</b></h4>
                    <p class="well no-radius">
                        Dignissim lorem dictumst aenean. Mauris ut aliquam tempor odio duis pellentesque nec placerat non a tincidunt ac aenean scelerisque, purus nascetur nisi aenean tincidunt arcu ac non velit vut parturient, porttitor cras ultrices cum integer est, odio auctor aliquam ut. Elit sed, aenean arcu lundium lectus egestas urna mus ac.
                        Lectus mattis parturient? In tincidunt rhoncus et turpis? In, urna massa! Natoque tortor. Risus eros arcu placerat penatibus a sit penatibus elementum hac tincidunt. Massa tristique porta integer ut, ut, est mauris ut enim tempor? Cras tincidunt, sagittis eros! Purus nec in tempor, enim, eros, turpis placerat sed? Purus.
                        Mattis in cum? Lacus nec duis integer, turpis et, augue? Mus? Quis auctor ridiculus a platea. Facilisis integer elementum? Adipiscing? Aliquam pulvinar, non amet, augue, facilisis, augue mus dictumst? Adipiscing urna. Et turpis! Tristique augue velit lacus a a? A vut aenean a, urna adipiscing non urna tempor dapibus.
                        Mattis in cum? Lacus nec duis integer, turpis et, augue? Mus? Quis auctor ridiculus a platea. Facilisis integer elementum? Adipiscing? Aliquam pulvinar, non amet, augue, facilisis, augue mus dictumst? Adipiscing urna. Et turpis! Tristique augue velit lacus a a? A vut aenean a, urna adipiscing non urna tempor dapibus.
                        Mattis in cum? Lacus nec duis integer, turpis et, augue? Mus? Quis auctor ridiculus a platea. Facilisis integer elementum? Adipiscing? Aliquam pulvinar, non amet, augue, facilisis, augue mus dictumst? Adipiscing urna. Et turpis! Tristique augue velit lacus a a? A vut aenean a, urna adipiscing non urna tempor dapibus.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <?= $form->field($model, 'terms')->checkbox() ?>
                    <div class="form-group">
                        <div class="">
                            <?php if (Yii::$app->session->hasFlash('success')) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= Yii::$app->session->getFlash('success') ?>
                                </div>
                            <?php } else { ?>
                                <div class="submit-form-boss">
                                    <button type="submit" class="btn btn-blue" style="margin:0;">Cam kết làm việc</button>
                                </div>
                                <?php
                            }
                            ?>
               
                        </div>
                    </div>

                </div>

            </div>
            <?php ActiveForm::end(); ?>
        </div>
</section>
<!-- End introduce -->