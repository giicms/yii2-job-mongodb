<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Review */

$this->params['breadcrumbs'][] = ['label' => 'Reviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>
                QUẢN LÝ ĐÁNH GIÁ
            </h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Chi tiết đánh giá thành viên</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row review-box">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php 
                        if(!empty($user)){
                        if($user->role == User::ROLE_BOSS){
                    ?>
                    <div class="info">
                        <div class="profile">
                            <img width="100" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/150-<?= $user->avatar ?>">
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
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 ralated-review">
            <table id="tableNotexport" class="table table-striped responsive-utilities jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                        <th>Stt</th>
                        <th>Reviewer</th>
                        <th>Nhận xét</th>
                        <th>Công việc</th>
                        <th class=" no-link last"><span class="nobr">Action</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(!empty($comment)){
                        foreach ($comment as $key => $value) {
                            if($value->user->role == 'boss'){ $link = 'boss';}else{ $link = 'member';}
                    ?>
                    <tr>
                        <td><?=$key+1?></td>
                        <td>
                            <div class="images">
                                <a href="/<?=$link?>/view/<?=$value->user->_id?>">
                                    <img class="img-circle avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/60-<?= $value->user->avatar ?>">
                                </a>
                            </div>
                            <div class="rated-star">
                                <span class="star text-yellow">
                                    <?=$user->getStar($value->rating);?>
                                </span><br>
                                <span class="rating-date"><?=date('d-m-Y', $value->created_at);?></span>
                            </div>
                        </td>
                        <td>
                            <p><?=$value->comment?></p>
                        </td>
                        <td><a href="/job/view/<?=$value->findAssignment->job->_id?>"><?=$value->findAssignment->job->name?></a></td>
                        <td><a href="#" title="Khóa"><i class="fa fa-eye"></i></a></td>
                    </tr>
                    <?php }}?>    
                </tbody>
            </table>
        </div>
    </div>
</div>            

