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

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Assignment;

$this->title = 'Xác nhận yêu cầu';
?>
<section>
    <div class="introduce progress-work">
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
                                <li class="step-current step_3">
                                    <span>3</span>
                                    <div>Cam kết & làm việc</div>
                                </li>
                                <li class="step_4">
                                    <span>4</span>
                                    <div>Thanh toán & nghiệm thu</div>
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

                <!-- button book -->
                <div class="col-md-4 col-sm-12 col-xs-12 profile-member">
                    <div class="profile-content">
                        <h4 class="title-box"><strong>Chào giá của nhân viên</strong></h4>
                        <p><strong><i class="fa fa-usd fa-2"></i> Chào giá: <?= number_format($model->bid->price, 0, '', '.') ?> VNĐ</strong></p>
                        <p><strong><i class="fa fa-calendar"></i> Thời gian hoàn tất:</strong> <?= date('d/m/Y', $model->bid->period) ?></p>
                    </div>
                </div>
                <!-- End button book -->

                <div class="col-md-8 col-sm-12 col-xs-12">    

                    <!-- TAB progress of work -->
                    <div class="list-project">
                        <div class="well">                         
                            <h4>Mô tả chi tiết công việc</h4>
                            <div class="description">
                                <div><?= $job->description ?></div>
                                <?php if($model->status_boss== Assignment::STATUS_JOB){?>
                                <p><a href="javascript:void(0)" class="change-desc btn btn-blue"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa mô tả</a></p>
                                <?php }?>
                            </div>
                            <?php if($model->status_boss==Assignment::STATUS_JOB){?>
                            <?php $form = ActiveForm::begin(['id' => 'description', 'options' => ['style' => 'display:none']]); ?> 
                            <?= $form->field($job, '_id')->hiddenInput()->label(FALSE); ?>
                            <?= $form->field($job, 'description')->textarea(['stype' => 'min-height:400px'])->label(FALSE); ?>
                            <div class="form-group">
                                <button type="submit" class="btn btn-blue">Lưu thay đổi </button>
                            </div>
                            <?php ActiveForm::end(); ?>
                            <?php }?>
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
                            <!-- End timeline -->

                            <!--                            <hr>
                                                        <div class="comment scroll" style="max-height: 500px">
                                                            <div class="comment-list" id="setInterval-<?= $bid->actor ?>">
                                                          
                                                            </div>
                                                        </div>
                            
                                                         text message 
                                                        <div class="text-message">
                                                            <form class="comment-form form-horizontal" id="formMessages">
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12">
                            
                                                                        <div class="form-group">
                                                                            <textarea class="form-control auto-height" id="commentMessage" name="content" style="height: 50px;" placeholder="Viết tin nhắn..."></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>-->
                        </div>
                        <!-- End xac nhan yeu cau -->

                    </div>    
                    
                    <?php $form = ActiveForm::begin(); ?> 
                    <?= $form->field($model, 'job_id')->hiddenInput()->label(FALSE); ?>
                    <?php if($model->status_boss==Assignment::STATUS_CONFIRM){ ?>
                        <div class="alert alert-danger" role="alert">
                            Bạn đã gửi môt tả yêu cầu công việc, Hãy chờ nhân viên xác nhận yêu cầu công việc của bạn 
                        </div>
                    <?php } else { ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <p>Hãy kiểm tra và mô tả chi tiết yêu cầu công việc của bạn và gửi yêu cầu tới nhân viên</p>
                                <div class="submit-form-boss">
                                    <!-- <a href="javascript: history.go(1)">Quay lại</a> -->
                                    <button type="submit" class="btn btn-blue">Gửi yêu cầu công việc</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php ActiveForm::end(); ?>

                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">

                    <h4><strong>Nhân viên đang làm việc</strong></h4>
                    <div class="well no-radius">
                        <div class="info">
                            <div class="profile">
                                <img width="100" class="avatar img-circle" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/150-<?= $model->bid->user->avatar ?>">
                            </div>
                            <div class="profile-content text-left">
                                <h5><a href="/user/<?= (string) $model->bid->user->_id ?>"><b><?= $model->bid->user->name ?></b></a></h5>
                                <p><b><?= $model->bid->user->findcategory->name ?></b></p>
                                <p>Nhân viên chuyên nghiệp</p>
                                <p><i class="fa fa-map-marker"></i> <?= $model->bid->user->address ?></p>
                            </div>
                        </div>
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
                        <p><b>56</b> việc làm đã nhận</p>
                        <p><b>100%</b> công việc hoàn thành</p>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">  
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('tin-nhan/' . $model->user->slug) ?>" target="_blank" class="btn btn-blue">Liên hệ</a>
                            </div>
                        </div>
                        <hr>
                        <h4>Tiến độ thực hiện công viêc</h4>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                            </div> 
                        </div>
                        <p style="margin: 10px 0">100% hoàn tất<a href="#" class="pull-right"><small>Xem chi tiết</small></a></p>
                        <div>
                            <p><b>Trạng thái: </b>hoàn tất</p>
                            <p><b>Trao đổi: </b> có 5 trao đổi mới</p>
                            <p><b>Duyệt dự án: </b> 0 đề nghị</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End introduce -->

<?= $this->registerJs('$("#DateCountdown").TimeCircles();    tinymce.init({selector:"textarea"})') ?>

<?= $this->registerJs("$(document).on('keypress', '#commentMessage', function (event) {
    var code = (event.keyCode ? event.keyCode : event.which);
    if (code == '13' && !event.shiftKey)
    {
            $.ajax({
                type: 'POST',
                        url: '" . Yii::$app->urlManager->createUrl(["messages/create"]) . "',
                      data: $('form#formMessages').serialize(),
                cache: false,
                success: function (data) {
             //$('#message-tmpl').tmpl(data).appendTo('.comment .mCustomScrollBox .mCSB_container');
             $('#commentMessage').val('');
                }
            });
     
    }
});") ?>
<?=
$this->registerJs("$(document).ready(function()
{
var user_id = '" . $bid->actor . "';
    var refreshId = setInterval( function() 
    {
       $('#setInterval-'+user_id).load('/messages/item?user_id=" . $bid->actor . "&job_id=" . (string) $job->_id . "');
    }, 500);
});
")
?>
<?= $this->registerJs('$(".change-desc").click(function(){
        $(".description").hide();
         $("#description").show();
    });') ?>
<?= $this->registerJs("$(document).on('submit', '#description', function (event){
        event.preventDefault();
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["job/description"]) . "',
            type: 'post',
            data: $('form#description').serialize(),
            success: function(data) {
                if(data){
                    $('.description').show();
                    $('#description').hide();
                    $('.description div').html(data.description);
                }
            }
        });

});") ?>