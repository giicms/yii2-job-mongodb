<?php 
use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<!-- introduce -->
        <section>
            <div class="introduce progress-work">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12 list-project review-box">    
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="title-container">
                                            <h3>Đánh giá thành viên</h3>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php 
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
                                    <div class="col-md-12 col-sm-12 col-xs-12 rating-box">
                                        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                                        <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h4>
                                                Gửi đánh giá của bạn về 
                                                <?php if(!empty($user)){?>
                                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $user->slug) ?>">
                                                    <?=$user->name ?>
                                                </a>
                                                <?php }?>
                                                
                                            </h4>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            <strong>Bình chọn</strong>
                                        </div>
                                        <div class="rating-star col-md-10 col-sm-10 col-xs-12">
                                            <?php
                                                echo $form->field($model, 'rating', ['template' => '<div class="form-group">{input}{hint}{error}</div>'])->dropDownList(['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'])->label(FALSE);
                                            ?>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            <strong>Nhận xét</strong>
                                        </div>
                                        <div class="text-review col-md-10 col-sm-10 col-xs-12">
                                            <?= $form->field($model, 'comment',['template' => '{input}{hint}{error}'])->textarea(['placeholder'=>'Viết nhận xét...']) ?>
                                            <?= $form->field($model, 'owner', ['inputOptions' => ['type' => 'hidden', 'value'=>$user->_id]])->label(FALSE);?>
                                            <button type="submit" class="btn btn-blue">Gửi</button>
                                        </div>
                                        <?php ActiveForm::end(); ?> 
                                        <div class="col-md-12 col-sm-12 col-xs-12"><hr></div>
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
                                            <?php
                                                }}
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="well">
                                <h4>Những thành viên được đánh giá cao</h4>
                                <?php 
                                foreach ($bestmember as $key => $value) { ?>
                                    <!-- member item -->
                                    <div class="member-request profile-item">
                                        <div class="profile">
                                            <img width="100" class="img-circle avatar" src="<?= Yii::$app->params['url_file'] ?>/thumbnails/150-<?= $value->avatar ?>">
                                        </div>
                                        <div class="profile-content">
                                            <ul class="list-unstyled">
                                                <li><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('user/' . $value->slug) ?>"><b><?= $value->name ?></b></a></li>
                                                <li><?= !empty($value->findlevel->name) ? $value->findlevel->name : "" ?></li>
                                                <li>100% công việc hoàn thành </li>
                                                <li>Đánh giá: 
                                                    <span class="star text-blue">
                                                        <?=$user->getRating($value->_id);?>
                                                    </span>
                                                    <?=$user->getCountReview($value->_id)?><i class="fa fa-user"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- End member item -->
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End introduce -->

<?=$this->registerJs("
$(function() {
      $('#review-rating').barrating({
            theme: 'fontawesome-stars',
            showSelectedRating: true,
            initialRating: null

        });
   });
")?>        
