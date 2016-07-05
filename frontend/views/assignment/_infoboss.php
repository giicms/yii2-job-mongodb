
<div class="well profile-member">
    <h4 class="title-box"><strong>Thông tin khách hàng </strong></h4>
    <div class="info">
        <div class="profile">
            <img width="100" class="avatar img-circle" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/<?= !empty($job->user->avatar) ? '150-' . $job->user->avatar : "avatar.png" ?>">
        </div>
        <div class="profile-content text-left">
            <h5><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $job->user->slug) ?>"><b><?= $job->user->name ?></b></a></h5>
            <p>
                Đánh giá: 
                <span class="star text-blue">
                    <?=$job->user->getStar($job->user->rating);?>
                </span> <?=$job->user->getCountReview($job->user->_id);?><i class="fa fa-user"></i>
            </p>
            <p><i class="fa fa-map-marker"></i> <?= $job->user->location->name ?>, <?= $job->user->location->city->name ?></p>
        	<a href="<?= Yii::$app->urlManager->createAbsoluteUrl('/tin-nhan/' . $job->user->slug) ?>" class="btn btn-blue contact">Liên hệ</a></div>
    </div>
    <p><b><?= $job->user->countbossjob ?> việc làm đã đăng </b></p>
    <p><b><?= $job->user->countbossassign ?></b> việc đã giao </p>
    <p class="text-right" style="margin: 10px 0 0"><a href="#"><small>Xem chi tiết</small></a></p>

</div>    
