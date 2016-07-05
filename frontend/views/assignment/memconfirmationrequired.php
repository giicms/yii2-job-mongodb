<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Xác nhận yêu cầu';
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

                <?= $this->render('_infojob', ['job' => $job, 'model' => $model, 'bid' => $bid]) ?>
                <div class="col-md-4 col-sm-12 col-xs-12 profile-member">
                    <div class="profile-content">
                        <h4 class="title-box"><strong>Thông tin book việc của bạn </strong></h4>
                        <p><strong><i class="fa fa-usd fa-2"></i> Chào giá: <?= number_format($model->bid->price, 0, '', '.') ?></strong></p>
                        <p><strong><i class="fa fa-calendar"></i> Thời gian hoàn tất:</strong> <?= $model->bid->period ?> ngày</p>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 col-xs-12">    

                    <!-- TAB progress of work -->
                    <div class="list-project">

                        <div class="well">
                            <?php
                            $form = ActiveForm::begin(['id' => 'formMessages']);
                            echo $form->field($model, '_id')->hiddenInput()->label(FALSE);
                            ?>    
                            <!-- timeline -->
                            <h4>Chi tiết công việc</h4>
                            <p><?= $job->description ?></p>
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
                            <div>
                                <p>Kỹ năng nhân viên
                                    <?php
                                    foreach ($job->skills as $value) {

                                        $skill = $job->getSkillname($value);
                                        echo ' <span class="button">' . $skill['name'] . '</span> ';
                                    }
                                    ?>
                                </p>
                            </div>
                            <!--comment-->


                        </div>    
                        <?php if (Yii::$app->session->hasFlash('success')) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= Yii::$app->session->getFlash('success') ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <button class="btn btn-blue " style="width:100%">Xác nhận yêu cầu </button>

                            </div>

                        <?php } ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
                <?= $this->render('_infoboss', ['job' => $job, 'countjob' => $countjob, 'bid' => $bid, 'created_at' => $created_at, 'countassignment' => $countassignment]) ?>
            </div>
        </div>
    </div>
</section>
<!-- End introduce -->
<?= $this->registerJs('$("#DateCountdown").TimeCircles();') ?>
