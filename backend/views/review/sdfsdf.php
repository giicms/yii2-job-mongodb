<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Review */

$this->title = $model->_id;
$this->params['breadcrumbs'][] = ['label' => 'Reviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="title-container">
                <h3>Đánh giá thành viên</h3>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php 
                var_dump($user); exit;
                    if(!empty($user)){
                    if($user->role == User::ROLE_BOSS){
                ?>
                <div class="info">
                    <div class="profile">
                        <img width="100" class="avatar img-circle" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/150-<?= $user->avatar ?>">
                    </div>
                    <div class="profile-content">
                        <div class="text-left">
                            <h5><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $user->slug) ?>"><b><?= $user->name ?></b></a></h5>
                            <p>
                                Đánh giá: 
                                <span class="star text-blue">
                                    <?=$user->getRating($user->_id);?>
                                </span> <?=$user->getPoint($user->_id);?>
                            </p>
                            <p><i class="fa fa-map-marker"></i><?= $user->location->name . ', ' . $user->location->city->name ?></p>
                        </div>
                    </div>
                </div>
                <?php } else{ ?>
                                                
                <div class="info">
                    <div class="profile">
                        <img width="100" class="avatar img-circle" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/150-<?= $user->avatar ?>">
                    </div>
                    <div class="profile-content">
                        <div class="text-left">
                            <h5><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $user->slug) ?>"><b><?= $user->name ?></b></a></h5>
                            <p><b><?= $user->findcategory->name ?></b></p>
                            <p><?= !empty($user->findlevel->name) ? $user->findlevel->name : "" ?></p>
                            <p><i class="fa fa-map-marker"></i> <?= $user->location->name . ', ' . $user->location->city->name ?></p>
                        </div>    
                    </div>
                </div>                                  
                <?php }}?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="average">
                    <?=$user->getPoint($user->_id);?>
                </div>
                <div class="rating-star text-center">
                    <span class="star text-yellow">
                        <?=$user->getRating($user->_id);?>
                    </span>
                </div>
                <div class="total">
                    <i class="fa fa-user"></i> <?=$user->getCountReview($user->_id);?> Lượt đánh giá 
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 detail-rating">
                <ul class="list-unstyled">
                    <?php foreach ($user->getProgress($user->_id) as $key => $value) {
                        if(($user->getCountReview($user->_id)) >0){
                            $percent = round(($value/$user->getCountReview($user->_id))*100, 2);
                        }else{
                            $percent = 0;
                        }
                        echo '<li>
                                <div class="tit-rating">
                                    <i class="fa fa-star"></i> '.$key.' 
                                </div>
                                <div class="progress lev-'.$key.' ">
                                    <div style="width: '.$percent.'%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" class="progress-bar bg-success">
                                        '.number_format($value, 0, '', ',').'
                                    </div> 
                                </div>
                            </li>';
                        };?>
                </ul>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 ralated-review">
            <ul class="list-unstyled">
                <?php 
                if(!empty($comment)){
                    foreach ($comment as $key => $value) {
                ?>
                <li>
                    <div class="images">
                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $value->user->slug) ?>">
                            <img class="img-circle avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/60-<?= $value->user->avatar ?>">
                        </a>
                    </div>
                    <div class="rated-star">
                        <span class="star text-yellow">
                            <?=$user->getStar($value->rating);?>
                        </span><br>
                        <span class="rating-date"><?=date('d-m-Y', $value->created_at);?></span>
                    </div>
                    <p><?=$value->comment?></p>
                </li>
                <?php }} ?>
            </ul>
        </div>
    </div>
</div>
