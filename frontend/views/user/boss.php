<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Hồ sơ cá nhân của ' . $model->name;
?>
<section>
    <div class="introduce profile-member">
        <div class="container">
            <?php
            if (!empty($userbid)) {
                echo '<div class="alert alert-success options">';
                echo $userbid->owner->name . ' đã book bạn, bạn có đồng ý không';
                echo '<input type="hidden" id="userbid" value="' . $userbid->id . '">';
                echo '<a href="javascript:void(0)" role="accept"> Đồng ý </a>';
                echo '<a href="javascript:void(0)" role="cancel" class="text-danger"> Hủy bỏ </a>';
                echo '</div>';
            }
            ?>
            <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <div class="profile-item">
                        <div class="profile">
                            <img class="img-circle avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($model->avatar) ? '150-' . $model->avatar : "avatar.png" ?>">
                            <div class="num-review">
                                <h5>Đánh giá: </h5> <span><?= $model->getPoint($model->_id) ?></span>
                            </div>
                        </div>
                        <div class="profile-content">
                            <ul class="list-unstyled text-left">
                                <li><h5><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['view', 'id' => (string) $model->_id]) ?>"><b><?= $model->name ?></b></a><small> - Hoạt động cách đây <?= Yii::$app->convert->time($model->lastvisit) ?></small></h5></li>
                                <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('/tin-nhan/' . $model->slug) ?>" class="btn btn-blue contact" style="float: none">Liên hệ</a> </li>
                                <li>
                                    <?php
                                    if (!empty($model->bookboss))
                                        echo '<p>Book nhân viên: <label class="text-danger">' . $model->bookboss . '</label></p>';
                                    ?>
                                </li>
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
                                <li><b><?= count($job) ?></b> việc làm đã đăng</li>
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

                            <?php
                            if (!empty($job)) {
                                echo '<h4 class="title-box">Các công việc đã đăng và đánh giá ('.count($job).')</h4>';
                                foreach ($job as $value) {
                                    ?>
                                    <div class="review-item">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <b class="text-blue"><?= $value->name ?></b></br>
														<?php if(!empty($value->assignment->findComment($value->owner))){?>
                                                        <small><?=$model->getStar($value->assignment->findComment($value->owner)->rating);?></small></br>
                                                        <i style="color:#989898"><?=$value->assignment->findComment($value->owner)->comment;?></i> - 
                                                        <small>
                                                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/'.$value->findUser($value->assignment->findComment($value->owner)->actor)->slug) ?>"><b><?= $value->findUser($value->assignment->findComment($value->owner)->actor)->name; ?></b></a>
                                                        </small>
														<?php }?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>    
                                        <?php
                                    }
                                }
                                ?>

                            <h4 class="title-box">Đánh giá nhân viên</h4>
                            <div class="row review-box">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <div class="text-blue average ">
                                        <?= $model->getPoint($model->_id); ?>
                                    </div>
                                    <div class="rating-star text-center">
                                        <span class="star text-yellow">
                                            <?= $model->getRating($model->_id); ?>
                                        </span>
                                    </div>
                                    <div class="total">
                                        <i class="fa fa-user"></i> <?= $model->getCountReview($model->_id); ?> Lượt đánh giá 
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12 detail-rating">
                                    <ul class="list-unstyled">
                                        <?php
                                        foreach ($model->getProgress($model->_id) as $key => $value) {
                                            if (($model->getCountReview($model->_id)) > 0) {
                                                $percent = round(($value / $model->getCountReview($model->_id)) * 100, 2);
                                            } else {
                                                $percent = 0;
                                            }
                                            echo '<li>
                                                        <div class="tit-rating">
                                                            <i class="fa fa-star"></i> ' . $key . ' 
                                                        </div>
                                                        <div class="progress lev-' . $key . ' ">
                                                            <div style="width: ' . $percent . '%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar bg-success">
                                                                ' . number_format($value, 0, '', ',') . '
                                                            </div> 
                                                        </div>
                                                    </li>';
                                        };
                                        ?>
                                    </ul>
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
<?= $this->registerCss('
        .contact{
        width: auto !important;
        padding: 5px 10px !important;
    }
 ') ?>
<?= $this->registerJs("$(document).on('click', '.options a', function (event){
        event.preventDefault();
        var id = $('#userbid').val();
        var role = $(this).attr('role');
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl(["ajax/userbidstatus"]) . "',
            type: 'post',
            data: {id:id,role:role},
            success: function(data) {
                if(data=='ok'){
                $('.options').remove();
}
            }
        });

});") ?>